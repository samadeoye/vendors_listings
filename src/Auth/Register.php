<?php
namespace Lamba\Auth;

use Exception;
use Lamba\Crud\Crud;
use Lamba\User\User;

class Register
{
    static $table = DEF_TBL_USERS;
    public static function registerUser()
    {
        $fname = stringToUpper(trim($_REQUEST['fname']));
        $lname = stringToUpper(trim($_REQUEST['lname']));
        $email = strtolower(trim($_REQUEST['email']));
        $password1 = trim($_REQUEST['password1']);
        $password2 = trim($_REQUEST['password2']);

        if ($password1 != $password2)
        {
            getJsonRow(false, 'Passwords do not match');
        }

        //check if a user exists with the same email
        if (User::checkIfUserExists('email', $email))
        {
            throw new Exception('A user already exists with this email');
        }

        //proceed to register
        //status will be 0 by default - to set as 1 after payment
        $id = getNewId();
        $data = [
            'id' => $id,
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'password' => md5($password1),
            'cdate' => time()
        ];
        if (Crud::insert(self::$table, $data))
        {
            $rs = Crud::select(
                self::$table,
                [
                    'columns' => getUserSessionFields(),
                    'where' => [
                        'id' => $id
                    ]
                ]
            );
            $_SESSION['user'] = $rs;
        }
        else
        {
            throw new Exception('An error occured');
        }
    }
}