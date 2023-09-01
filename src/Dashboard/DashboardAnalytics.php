<?php
namespace Lamba\Dashboard;

use Lamba\Crud\Crud;

class DashboardAnalytics
{
    public static function getUserTotalListings()
    {
        global $userId;

        $rs = Crud::select(
            DEF_TBL_LISTINGS,
            [
                'columns' => 'COUNT(id) AS total',
                'where' => [
                    'user_id' => $userId,
                    'deleted' => 0
                ]
            ]
        );
        if ($rs)
        {
            return $rs['total'];
        }
        return 0;
    }

    public static function getUserTotalViews()
    {
        global $userId;

        $rs = Crud::select(
            DEF_TBL_LISTINGS,
            [
                'columns' => 'SUM(views) AS views',
                'where' => [
                    'user_id' => $userId,
                    'deleted' => 0
                ]
            ]
        );
        if ($rs)
        {
            return $rs['views'];
        }
        return 0;
    }

    public static function getUserTotalComments()
    {
        global $userId;

        $rs = Crud::select(
            DEF_TBL_LISTINGS_COMMENTS,
            [
                'columns' => 'COUNT(id) AS total',
                'where' => [
                    'user_id' => $userId,
                    'deleted' => 0
                ]
            ]
        );
        if ($rs)
        {
            return $rs['total'];
        }
        return 0;
    }
}