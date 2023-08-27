<?php
namespace Lamba\Listing;

use Lamba\BusinessType\BusinessType;
use Lamba\Crud\Crud;
use Lamba\User\User;

class ListingSearch extends Listing
{
    public static function getListingsPaginationData()
    {
        $query = trim($_REQUEST['query']);
        $categoryId = trim($_REQUEST['categoryId']);
        $businessTypeId = trim($_REQUEST['businessTypeId']);
        $page = isset($_REQUEST['page']) ? doTypeCastInt($_REQUEST['page']) : 1;
        //if categoryId is passed, we disregard the business type sent from the filter form
        if (strlen($categoryId) == 36)
        {
            $businessTypeId = $categoryId;
        }

        $pagination = self::getListingsPagination($query, $businessTypeId, $page);
        $list = self::getListingsContent($query, $businessTypeId, $page);

        $data = [
            'pagination' => $pagination,
            'list' => $list
        ];

        self::$data = [
            'status' => true,
            'data' => $data
        ];
    }

    public static function getPaidListings($query='', $businessTypeId='', $page=1, $arFields=['*'])
    {
        $rs = [];
        $arWhere = self::getCommonQueryWhere($query, $businessTypeId);
        if (count($arWhere) > 0)
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
                'where' => $arWhere,
                'return_type' => 'all',
                'order' => 'cdate ASC',
            ];
            if($limit != '')
            {
                $data['limit'] = $limit;
            }

            $rs = Crud::select(
                self::$table,
                $data
            );
        }
        return $rs;
    }
    public static function getListingsContent($query='', $businessTypeId='', $page=1)
    {
        $rs = self::getPaidListings($query, $businessTypeId, $page);
        if (count($rs) == 0)
        {
            return 'No listing yet';
        }
        $output = '';
        foreach($rs as $r)
        {
            $rs = User::getUser($r['user_id'], ['business_name', 'phone', 'email']);
            $rsx = BusinessType::getBusinessType($r['category_id'], ['name']);
            $businessType = $rsx['name'];
            $coverImgFileName = !empty($r['cover_img']) ? $r['cover_img'] : 'dummy.jpg';
            $shortDesc = !empty($r['short_desc']) ? $r['short_desc'] : substr($r['full_desc'], 0, 200).'...';
            $output .= <<<EOQ
            <div class="col-lg-12 col-md-12">
                <div class="utf_listing_item-container list-layout">
                    <a href="listing?id={$r['id']}" class="utf_listing_item">
                        <div class="utf_listing_item-image"> 
                            <img src="images/woara/users/{$coverImgFileName}" alt="">
                        </div>
                        <div class="utf_listing_item_content">
                            <div class="utf_listing_item-inner">
                                <h3> {$r['title']} </h3>
                                <p class="myBadge btnPrimary"> <i class="sl sl-icon-layers"></i> {$businessType} </p>
                                <span><i class="fa fa-home"></i> {$rs['business_name']} </span>
                                <span><i class="fa fa-phone"></i> {$rs['phone']} </span>
                                <span><i class="fa fa-envelope"></i> {$rs['email']} </span>
                                <p> {$shortDesc} </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
EOQ;
        }

        return $output;
    }
    public static function getCommonQueryWhere($query='', $businessTypeId='')
    {
        $arPaidUserIds = self::getPaidUserIds($businessTypeId);
        if (count($arPaidUserIds) > 0)
        {
            $userIds = "'" . implode ("', '", $arPaidUserIds) . "'";
            $expression = 'user_id IN ('.$userIds.')';
            if ($query != '')
            {
                $expression .= ' AND (title LIKE "%'.$query.'%" OR short_desc LIKE "%'.$query.'%" OR full_desc LIKE "%'.$query.'%")';
            }
            $arWhere = [
                'expression' => $expression,
                'deleted' => 0
            ];
            return $arWhere;
        }
        return [];
    }
    public static function getListingsTotal($query='', $businessTypeId='')
    {
        $arWhere = self::getCommonQueryWhere($query, $businessTypeId);
        if (count($arWhere) > 0)
        {
            $rsTotal = Crud::select(
                self::$table,
                [
                    'columns' => 'COUNT(id) AS total',
                    'where' => $arWhere
                ]
            );
            return doTypeCastInt($rsTotal['total']);
        }
        return 0;
    }
    public static function getListingsPagination($query='', $businessTypeId='', $page=1)
    {
        $total = self::getListingsTotal($query, $businessTypeId);
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
        <nav class="pagination" id="listingsPagination">
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
}