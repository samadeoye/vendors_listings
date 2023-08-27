<?php
namespace Lamba\Listing;

use Exception;
use Lamba\Crud\Crud;
use Lamba\Image\Image;
use Lamba\User\User;
use Lamba\BusinessType\BusinessType;

class Listing
{
    static $table = DEF_TBL_LISTINGS;
    static $tableComments = DEF_TBL_LISTINGS_COMMENTS;
    static $data;
    static $appPerPage = 10;
    public static function checkIfListingExists($field, $value, $excludeId='')
    {
        $arWhere = [
            $field => $value
        ];
        if (strlen($excludeId) == 36)
        {
            $arWhere['expression'] = "id <> '{$excludeId}'";
        }
        $rs = Crud::select(
            self::$table,
            [
                'columns' => 'id',
                'where' => $arWhere
            ]
        );
        if ($rs)
        {
            return true;
        }
        return false;
    }
    public static function addListing()
    {
        global $arUser;

        $userId = $arUser['id'];

        $title = stringToUpper(trim($_REQUEST['title']));
        $shortDesc = trim($_REQUEST['short_desc']);
        $fullDesc = trim($_REQUEST['full_desc']);
        //process images
        $coverImgFileSize = $_FILES['cover_img']['size'];
        if ($coverImgFileSize == 0)
        {
            throw new Exception('Cover image is compulsory');
        }
        //multiple images
        $galleryNum = count($_FILES['gallery_img']['name']);
        if ($galleryNum > 3)
        {
            throw new Exception('Gallery must not exceed 3 images');
        }

        if ($coverImgFileSize > 0)
        {
            Image::$field = 'cover_img';
            $coverImgFileName = Image::uploadImage();
            if ($coverImgFileName == '')
            {
                throw new Exception('An error occured while processing your cover image file');
            }
        }

        Image::$field = 'gallery_img';
        Image::$isMultiple = true;
        Image::$multipleMaxFiles = 3;
        $arGalleryFileNames = Image::uploadImage();
        if (count($arGalleryFileNames) == 0)
        {
            throw new Exception('An error occured while processing your gallery files');
        }

        if (self::checkIfListingExists('title', $title))
        {
            throw new Exception('Duplicate title found');
        }

        $data = [
            'id' => getNewId(),
            'title' => $title,
            'category_id' => $arUser['business_type_id'],
            'user_id' => $userId,
            'short_desc' => $shortDesc,
            'full_desc' => $fullDesc,
            'cover_img' => $coverImgFileName,
            'gallery_img' => implode(',', $arGalleryFileNames)
        ];
        Crud::insert(self::$table, $data);
    }
    
    public static function updateListing()
    {
        $id = trim($_REQUEST['id']);
        $title = stringToUpper(trim($_REQUEST['title']));
        $shortDesc = trim($_REQUEST['short_desc']);
        $fullDesc = trim($_REQUEST['full_desc']);

        if (self::checkIfListingExists('title', $title, $id))
        {
            throw new Exception('Duplicate title found');
        }

        $data = [
            'title' => $title,
            'short_desc' => $shortDesc,
            'full_desc' => $fullDesc
        ];
        Crud::update(
            self::$table,
            $data,
            ['id' => $id]
        );
    }

    public static function deleteListing()
    {
        $id = trim($_REQUEST['id']);

        Crud::update(
            self::$table,
            ['deleted' => 1],
            ['id' => $id]
        );
    }

    public static function updateListingViews($id)
    {
        $rs = self::getListing($id, ['views']);
        Crud::update(
            self::$table,
            ['views' => $rs['views'] + 1],
            ['id' => $id]
        );
    }

    public static function getListing($id, $arFields=['*'])
    {
        $fields = is_array($arFields) ? implode(', ', $arFields) : $arFields;
        return Crud::select(
            self::$table,
            [
                'columns' => $fields,
                'where' => [
                    'id' => $id
                ]
            ]
        );
    }

    public static function getPaidUsersListings($arFields=['*'])
    {
        $fields = is_array($arFields) ? implode(', ', $arFields) : $arFields;
        $rs = [];
        $arPaidUserIds = User::getPaidUserIds();
        if (count($arPaidUserIds) > 0)
        {
            $userIds = "'" . implode ("', '", $arPaidUserIds) . "'";
            $rs = Crud::select(
                self::$table,
                [
                    'columns' => $fields,
                    'where' => [
                        'expression' => 'user_id IN ('.$userIds.')',
                        'deleted' => 0
                    ],
                    'return_type' => 'all',
                    'order' => 'cdate DESC'
                ]
            );
        }
        return $rs;
    }

    public static function getUserListings($page=1, $arFields=['*'])
    {
        global $userId;

        $fields = is_array($arFields) ? implode(', ', $arFields) : $arFields;

        $perPage = self::$appPerPage;
        if($page <= 1)
        {
            $limit = '0,'.$perPage;
        }
        else
        {
            $offset = doTypeCastDouble(($page - 1) * $perPage);
            $limit = $offset.','.$perPage;
        }
        $data = [
            'columns' => $fields,
            'where' => [
                'user_id' => $userId,
                'deleted' => 0
            ],
            'return_type' => 'all',
            'order' => 'cdate DESC',
        ];
        if($limit != '')
        {
            $data['limit'] = $limit;
        }

        return Crud::select(
            self::$table,
            $data
        );
    }
    public static function getAppUserListingsContent($page=1)
    {
        $rs = self::getUserListings($page);
        if (count($rs) == 0)
        {
            return 'No listing yet';
        }
        $output = '';
        foreach($rs as $r)
        {
            $coverImgFileName = !empty($r['cover_img']) ? $r['cover_img'] : 'dummy.jpg';
            $output .= <<<EOQ
            <li>
                <div class="utf_list_box_listing_item">
                    <div class="utf_list_box_listing_item-img"><a><img src="images/woara/users/{$coverImgFileName}" alt=""></a></div>
                    <div class="utf_list_box_listing_item_content">
                        <div class="inner">
                            <div class="margin-bottom-20">
                                <a href="#dialogEditListing" onclick="doOpenEditListingModal('{$r['id']}')" id="btnEditListing" class="myButton btnPrimary sign-in popup-with-zoom-anim"><i class="fa fa-pencil"></i> Edit</a>
                                <a id="btnDeleteListing" onclick="doOpenDeleteListingModal('{$r['id']}')" class="myButton btnDanger"><i class="fa fa-trash-o"></i> Delete</a>
                            </div>
                            <h3>{$r['title']}</h3>
                            <p class="text-bold">Short Description:<br>
                                <span> {$r['short_desc']} </span>
                            </p>
                            <p class="text-bold">Full Description:<br>
                                <span> {$r['full_desc']} </span>
                            </p>
                        </div>
                    </div>
                </div>
            </li>
EOQ;
        }

        return $output;
    }
    public static function getAppUserListingTotal()
    {
        global $userId;
        
        $rsTotal = Crud::select(
            self::$table,
            [
                'columns' => 'COUNT(id) AS total',
                'where' => [
                    'user_id' => $userId,
                    'deleted' => 0
                ],
            ]
        );
        return doTypeCastDouble($rsTotal['total']);
    }
    public static function getAppListingPaginationData()
    {
        $page = doTypeCastInt($_REQUEST['page']);
        $pagination = self::getAppUserListingPagination($page);
        $list = self::getAppUserListingsContent($page);

        $data = [
            'pagination' => $pagination,
            'list' => $list
        ];

        self::$data = [
            'status' => true,
            'data' => $data
        ];
    }
    public static function getAppUserListingPagination($page=1)
    {
        $total = self::getAppUserListingTotal();
        if ($total == 0)
        {
            return '';
        }
        //get last page
        $perPage = self::$appPerPage;
        $lastPage = ceil($total / $perPage);
        
        $prev = $page - 1;
        $next = $page + 1;

        $prevOnClick = "showPagination('{$prev}')";
        $nextOnClick = "showPagination('{$next}')";
        if ($page <= 1)
        {
            $prevOnClick = '';
        }
        if ($page >= $lastPage)
        {
            $nextOnClick = '';
        }

        $output = <<<EOQ
        <nav class="pagination" id="appListingPagination">
            <input type="hidden" name="currentPage" id="currentPage" value="{$page}">
            <ul>
            <li><a onclick="{$prevOnClick}"><i class="sl sl-icon-arrow-left"></i></a></li>
EOQ;
        for($i = 1; $i <= $lastPage; $i++)
        {
            $current = '';
            $onClick = "showPagination('{$i}')";
            if ($i == $page)
            {
                $current = 'current-page';
                $onClick = '';
            }
            $output .= <<<EOQ
            <li><a onclick="{$onClick}" class="{$current}">{$i}</a></li>
EOQ;
        }
        $output .= <<<EOQ
            <li><a onclick="{$nextOnClick}"><i class="sl sl-icon-arrow-right"></i></a></li>
            </ul>
        </nav>
EOQ;

        return $output;
    }

    public static function getEditListingModalData()
    {
        $id = trim($_REQUEST['id']);

        $rs = self::getListing($id);
        self::$data = [
            'status' => true,
            'data' => $rs
        ];
    }

    public static function addComment()
    {
        global $userId;

        $name = strToUpper(trim($_REQUEST['name']));
        $email = strtolower(trim($_REQUEST['email']));
        $message = trim($_REQUEST['msg']);
        $listingId = trim($_REQUEST['listing_id']);

        $data = [
            'id' => getNewId(),
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'listing_id' => $listingId,
            'user_id' => $userId,
            'cdate' => time()
        ];
        Crud::insert(self::$tableComments, $data);
    }

    public static function getListingComments($listingId, $page=1, $arFields=['*'])
    {
        $fields = is_array($arFields) ? implode(', ', $arFields) : $arFields;

        $perPage = self::$appPerPage;
        if($page <= 1)
        {
            $limit = '0,'.$perPage;
        }
        else
        {
            $offset = doTypeCastDouble(($page - 1) * $perPage);
            $limit = $offset.','.$perPage;
        }
        $data = [
            'columns' => $fields,
            'where' => [
                'listing_id' => $listingId,
                'status' => 1,
                'deleted' => 0
            ],
            'return_type' => 'all',
            'order' => 'cdate ASC',
        ];
        if($limit != '')
        {
            $data['limit'] = $limit;
        }

        return Crud::select(
            self::$tableComments,
            $data
        );
    }
    public static function getListingCommentContent($listingId, $page=1)
    {
        $rs = self::getListingComments($listingId, $page);
        if (count($rs) == 0)
        {
            return 'No comment yet.';
        }

        $output = '';
        foreach($rs as $r)
        {
            $cdate = getFormattedDate($r['cdate']);
            $output .= <<<EOQ
            <li>
                <div class="avatar"><img src="images/woara/dash_avatar.png" alt="" /></div>
                <div class="utf_comment_content">        
                    <div class="utf_by_comment">
                        {$r['name']} <span class="date"><i class="fa fa-clock-o"></i> {$cdate} </span>
                    </div>
                    <p>{$r['message']}</p>                                  
                </div>
            </li>
EOQ;
        }

        return $output;
    }
    public static function getListingCommentsTotal($listingId)
    {
        $rsTotal = Crud::select(
            self::$tableComments,
            [
                'columns' => 'COUNT(id) AS total',
                'where' => [
                    'listing_id' => $listingId,
                    'status' => 1,
                    'deleted' => 0
                ],
            ]
        );
        return doTypeCastDouble($rsTotal['total']);
    }
    public static function getListingCommentsPaginationData()
    {
        $listingId = trim($_REQUEST['listing_id']);
        $page = doTypeCastInt($_REQUEST['page']);
        $pagination = self::getListingCommentsPagination($listingId, $page);
        $list = self::getListingCommentContent($listingId, $page);

        $data = [
            'pagination' => $pagination,
            'list' => $list
        ];

        self::$data = [
            'status' => true,
            'data' => $data
        ];
    }
    public static function getListingCommentsPagination($listingId, $page=1)
    {
        $total = self::getListingCommentsTotal($listingId);
        if ($total == 0)
        {
            return '';
        }
        //get last page
        $perPage = self::$appPerPage;
        $lastPage = ceil($total / $perPage);
        
        $prev = $page - 1;
        $next = $page + 1;

        $prevOnClick = "showPagination('{$prev}')";
        $nextOnClick = "showPagination('{$next}')";
        if ($page <= 1)
        {
            $prevOnClick = '';
        }
        if ($page >= $lastPage)
        {
            $nextOnClick = '';
        }

        $output = <<<EOQ
        <nav class="pagination" id="listingReviewPagination">
            <input type="hidden" name="currentPage" id="currentPage" value="{$page}">
            <ul>
            <li><a onclick="{$prevOnClick}"><i class="sl sl-icon-arrow-left"></i></a></li>
EOQ;
        for($i = 1; $i <= $lastPage; $i++)
        {
            $current = '';
            $onClick = "showPagination('{$i}')";
            if ($i == $page)
            {
                $current = 'current-page';
                $onClick = '';
            }
            $output .= <<<EOQ
            <li><a onclick="{$onClick}" class="{$current}">{$i}</a></li>
EOQ;
        }
        $output .= <<<EOQ
            <li><a onclick="{$nextOnClick}"><i class="sl sl-icon-arrow-right"></i></a></li>
            </ul>
        </nav>
EOQ;

        return $output;
    }

    public static function getPaidUserIds($businessTypeId='')
    {
        return User::getPaidUserIds($businessTypeId);
    }
}