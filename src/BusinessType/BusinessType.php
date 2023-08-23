<?php
namespace Lamba\BusinessType;

use Lamba\Crud\Crud;
use Lamba\user\User;

class BusinessType
{
    static $table = DEF_TBL_BUSINESS_TYPES;

    public static function getBusinessTypes($arFields=['*'])
    {
        $fields = is_array($arFields) ? implode(', ', $arFields) : $arFields;
        return Crud::select(
            self::$table,
            [
                'columns' => $fields,
                'where' => [
                    'deleted' => 0
                ],
                'return_type' => 'all',
                'order' => 'rank ASC'
            ]
        );
    }
    public static function getBusinessTypesWithCounts()
    {
        $ar = [];
        $rs = Crud::select(
            self::$table,
            [
                'columns' => 'id, name, img, 0 AS num',
                'where' => [
                    'deleted' => 0
                ],
                'return_type' => 'all',
                'order' => 'rank ASC'
            ]
        );
        if (count($rs) > 0)
        {
            foreach($rs as $r)
            {
                $rsx = Crud::select(
                    DEF_TBL_USERS,
                    [
                        'columns' => 'COUNT(id) AS num',
                        'where' => [
                            'business_type_id' => $r['id'],
                            'deleted' => 0
                        ]
                    ]
                );
                $r['num'] = $rsx['num'];
                $ar[] = $r;
            }
        }
        return $ar;
    }
    public static function getBusinessTypeDropdownOptions()
    {
        $rs = self::getBusinessTypes();
        $output = '';
        foreach($rs as $r)
        {
            $output .= <<<EOQ
            <option value="{$r['id']}">{$r['name']}</option>
EOQ;
        }

        return $output;
    }

    public static function getBusinessType($id, $arFields=['*'])
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
}