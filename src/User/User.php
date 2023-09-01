<?php
namespace Lamba\User;

use Exception;
use Lamba\Crud\Crud;
use Lamba\Image\Image;
use Lamba\SendMail\SendMail;

class User
{
    static $table = DEF_TBL_USERS;
    static $tablePasswordReset = DEF_TBL_PASSWORD_RESET;
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
            $newPassword = md5($newPassword);
            $data = [
                'password' => $newPassword,
                'mdate' => time()
            ];
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
                $rs = array_merge($rs, ['password' => $newPassword]);
                $_SESSION['user'] = $rs;
            }
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
            if ($logoFileName == '' && $rs['logo'] == '')
            {
                $data['logo'] = 'dummy.jpg';
            }
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
        $currentDate = time();
        return Crud::select(
            self::$table,
            [
                'columns' => $fields,
                'where' => [
                    //'paid' => 1,
                    'expression' => "expiry_date > {$currentDate}",
                    'deleted' => 0
                ],
                'return_type' => 'all'
            ]
        );
    }

    public static function getPaidUserIds($businessTypeId='')
    {
        $currentDate = time();
        $arWhere = [
            //'paid' => 1
            'expression' => "expiry_date > {$currentDate}"
        ];
        if (strlen($businessTypeId) == 36)
        {
            $arWhere['business_type_id'] = $businessTypeId;
        }
        $arWhere['deleted'] = 0;

        $rs = Crud::select(
            self::$table,
            [
                'columns' => 'id',
                'where' => $arWhere,
                'return_type' => 'all'
            ]
        );
        $arIds = [];
        foreach($rs as $r)
        {
            $arIds[] = $r['id'];
        }
        return $arIds;
    }

    public static function checkIfUserHasActiveSubscription()
    {
        global $userId;

        $rs = self::getUser($userId, ['expiry_date']);
        if ($rs)
        {
            if ($rs['expiry_date'] > time())
            {
                return true;
            }
        }
        return false;
    }

    public static function getUserAddress($street, $city, $state)
    {
        $ar = [];
        if (strlen($street) > 0)
        {
            $ar[] = $street;
        }
        if (strlen($city) > 0)
        {
            $ar[] = $city;
        }
        if (strlen($state) > 0)
        {
            $ar[] = $state;
        }

        $address = '';
        if (count($ar) > 0)
        {
            $address = implode(', ', $ar);
        }
        return $address;
    }

    public static function verifyEmailForPasswordReset()
    {
        $email = strtolower(trim($_REQUEST['email']));

        $rs = Crud::select(
            self::$table,
            [
                'columns' => 'fname, lname',
                'where' => [
                    'email' => $email
                ]
            ]
        );
        if ($rs)
        {
            //send password reset email
            $id = getNewId();
            $name = $rs['fname'] .' '. $rs['lname'];
            $siteName = SITE_NAME;
            $siteUrl = SITE_URL;

            /*
            $body = "Dear {$rs['fname']},\n";
            $body .= "Use the link below to complete your password reset on {$siteName}.\n";
            $body .= "Use the link below to complete your password reset on {$siteName}.\n";
            $body .= "<a href='resetpassword?id={$id}'>Reset Password</a>";
            */

            $body = <<<EOQ
                Dear {$rs['fname']},<br>
                Use the link below to complete your password reset on {$siteName}.<br>
                <a href="{$siteUrl}/resetpassword?token={$id}">Reset Password</a>

EOQ;

            $arParams = [
                'mailTo' => $email,
                'toName' => $name,
                'mailFrom' => SITE_MAIL_FROM_EMAIL,
                'fromName' => SITE_MAIL_FROM_NAME,
                'isHtml' => true,
                'bodyHtml' => $body
            ];
            SendMail::sendMail($arParams);
            if (SendMail::$isSent)
            {
                $data = [
                    'id' => $id,
                    'email' => $email,
                    'cdate' => time()
                ];
                Crud::insert(self::$tablePasswordReset, $data);
            }
            else
            {
                throw new Exception('An error occured. Please try again.');
            }
        }
        else
        {
            throw new Exception('This email does not exist on the system');
        }
    }

    public static function resetPassword()
    {
        $token = trim($_REQUEST['token']);
        $password = trim($_REQUEST['password']);
        $passwordConfirm = trim($_REQUEST['password_confirm']);

        if ($password != $passwordConfirm)
        {
            throw new Exception('Passwords do not match!');
        }

        $rs = Crud::select(
            self::$tablePasswordReset,
            [
                'columns' => 'email',
                'where' => [
                    'id' => $token
                ],
                'order' => 'cdate DESC',
                'limit' => 1
            ]
        );

        if ($rs)
        {
            Crud::update(
                self::$table,
                ['password' => md5($password)],
                ['email' => $rs['email']]
            );
            //delete password reset log
            Crud::delete(self::$tablePasswordReset, ['email' => $rs['email']]);
        }
        else
        {
            throw new Exception('Token is invalid. Please click the link from your email.');
        }
    }
}