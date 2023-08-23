<?php
namespace Lamba\User;

use Exception;
use Lamba\Crud\Crud;
use Lamba\Image\Image;

class User
{
    static $table = DEF_TBL_USERS;
    static $data = [];
    public static function getUser($id, $arFields=['*'])
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
    public static function checkIfUserExists($field, $value)
    {
        $rs = Crud::select(
            self::$table,
            [
                'columns' => 'id',
                'where' => [
                    $field => $value
                ]
            ]
        );
        if ($rs)
        {
            return true;
        }
        return false;
    }
    public static function changePassword()
    {
        global $userId;

        $currentPassword = trim($_REQUEST['current_password']);
        $newPassword = trim($_REQUEST['new_password']);
        $confirmPassword = trim($_REQUEST['confirm_password']);
        $userPassword = $_SESSION['user']['password'];

        if ($newPassword != $confirmPassword)
        {
            throw new Exception('Passwords do not match');
        }
        elseif ($userPassword != md5($currentPassword))
        {
            throw new Exception('Old password is incorrect');
        }
        else
        {
            $data = [
                'password' => md5($newPassword),
                'mdate' => time()
            ];
            Crud::update(
                self::$table,
                $data,
                [
                    'id' => $userId
                ]
            );
        }
    }
    public static function updateUser()
    {
        global $userId;

        $fname = stringToUpper(trim($_REQUEST['fname']));
        $lname = stringToUpper(trim($_REQUEST['lname']));
        $phone = trim($_REQUEST['phone']);
        $businessName = stringToUpper(trim($_REQUEST['business_name']));
        $businessTypeId = stringToUpper(trim($_REQUEST['business_type_id']));
        $businessInfo = trim($_REQUEST['business_info']);
        $addressStreet = trim($_REQUEST['address_street']);
        $addressCity = stringToUpper(trim($_REQUEST['address_city']));
        $addressState = stringToUpper(trim($_REQUEST['address_state']));
        $facebook = trim($_REQUEST['facebook']);
        $instagram = trim($_REQUEST['instagram']);
        $twitter = trim($_REQUEST['twitter']);
        //process images
        $logoFileSize = $_FILES['logo']['size'];
        $coverImgFileSize = $_FILES['cover_img']['size'];
        
        $logoFileName = $coverImgFileName = '';
        if ($logoFileSize > 0)
        {
            Image::$field = 'logo';
            $logoFileName = Image::uploadImage();
            if ($logoFileName == '')
            {
                throw new Exception('An error occured while processing your logo file');
            }
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

        $data = [
            'fname' => $fname,
            'lname' => $lname,
            'phone' => $phone,
            'business_name' => $businessName,
            'business_type_id' => $businessTypeId,
            'business_info' => $businessInfo,
            'address_street' => $addressStreet,
            'address_city' => $addressCity,
            'address_state' => $addressState,
            'facebook' => $facebook,
            'instagram' => $instagram,
            'twitter' => $twitter
        ];
        if ($logoFileName != '')
        {
            $data['logo'] = $logoFileName;
        }
        if ($coverImgFileName != '')
        {
            $data['cover_img'] = $coverImgFileName;
        }
        $update = Crud::update(
            self::$table,
            $data,
            [
                'id' => $userId
            ]
        );
        if ($update)
        {
            $rs = $_SESSION['user'];
            $rs = array_merge($rs, $data);
            $_SESSION['user'] = $rs;

            $data = [
                'status' => true,
                'data' => $_SESSION['user']
            ];
            self::$data = $data;
        }
    }

    public static function getPaidUsersInfo($arFields=['*'])
    {
        $fields = is_array($arFields) ? implode(', ', $arFields) : $arFields;
        return Crud::select(
            self::$table,
            [
                'columns' => $fields,
                'where' => [
                    'paid' => 1,
                    'deleted' => 0
                ],
                'return_type' => 'all'
            ]
        );
    }

    public static function getPaidUserIds()
    {
        $rs = self::getPaidUsersInfo(['id']);
        $arIds = [];
        foreach($rs as $r)
        {
            $arIds[] = $r['id'];
        }
        return $arIds;
    }
}