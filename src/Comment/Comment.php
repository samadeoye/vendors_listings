<?php
namespace Lamba\Comment;

use Lamba\Crud\Crud;
use Lamba\Listing\Listing;

class Comment
{
    static $table = DEF_TBL_LISTINGS_COMMENTS;
    static $tableListing = DEF_TBL_LISTINGS;
    static $appPerPage = 10;
    static $data = [];

    public static function getUserListingComments($page=1, $arFields=['*'])
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
            'order' => 'cdate ASC',
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
    public static function getUserListingCommentContent($page=1)
    {
        $rs = self::getUserListingComments($page);
        if (count($rs) == 0)
        {
            return 'No comment yet.';
        }

        $output = '';
        foreach($rs as $r)
        {
            $cdate = getFormattedDate($r['cdate']);
            $rsx = Listing::getListing($r['listing_id'], ['title']);
            $listingTitle = $rsx['title'];
            $enableDisableLabel = 'Approve';
            $enableDisableBtnClass = 'btnSuccess';
            $enableDisableIconClass = 'check';
            $enableDisableAction = 'approve';
            $statusLabel = 'INACTIVE';
            $statusLabelClass = 'btnDanger';
            if ($r['status'] == 1)
            {
                $enableDisableLabel = 'Disapprove';
                $enableDisableBtnClass = 'btnDisable';
                $enableDisableIconClass = 'times';
                $enableDisableAction = 'disapprove';
                $statusLabel = 'ACTIVE';
                $statusLabelClass = 'btnSuccess';
            }
            $output .= <<<EOQ
            <li>
                <div class="utf_comment_content" style="padding-left:0px;">
                    <div class="utf_arrow_comment"></div>
                    <div class="utf_by_comment"> {$r['name']}
                        <div class="utf_by_comment-listing own-comment">on <a href="listing?id={$r['listing_id']}"> {$listingTitle} </a></div>
                        <span class="date"><i class="fa fa-clock-o"></i> {$cdate} </span>
                        <span class="myBadge {$statusLabelClass}" style="font-size:12px;"> {$statusLabel} </span>
                    </div>
                    <p> {$r['message']} </p>
                    <button class="myButton {$enableDisableBtnClass}" onclick="doOpenListingCommentApprovalModal('{$r['id']}', '{$enableDisableAction}')"> <i class="fa fa-{$enableDisableIconClass}"></i> {$enableDisableLabel} </button>
                    <button class="myButton btnDanger" onclick="doOpenListingCommentDeleteModal('{$r['id']}')"> <i class="fa fa-trash"></i> Delete </button>
                </div>
            </li>
EOQ;
        }

        return $output;
    }
    public static function getUserListingCommentsTotal()
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
    public static function getUserListingsCommentsPaginationData()
    {
        $page = doTypeCastInt($_REQUEST['page']);
        $pagination = self::getUserListingCommentsPagination($page);
        $list = self::getUserListingCommentContent($page);

        $data = [
            'pagination' => $pagination,
            'list' => $list
        ];

        self::$data = [
            'status' => true,
            'data' => $data
        ];
    }
    public static function getUserListingCommentsPagination($page=1)
    {
        $total = self::getUserListingCommentsTotal();
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

    public static function deleteComment()
    {
        $id = trim($_REQUEST['id']);

        Crud::update(
            self::$table,
            ['deleted' => 1],
            ['id' => $id]
        );
    }

    public static function enableDisableComment()
    {
        $id = trim($_REQUEST['id']);
        $actionType = trim($_REQUEST['actionType']);
        $status = ($actionType == 'approve') ? 1 : 0;

        Crud::update(
            self::$table,
            ['status' => $status],
            ['id' => $id]
        );
    }
}