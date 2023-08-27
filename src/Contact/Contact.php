<?php
namespace Lamba\Contact;

use Exception;
use Lamba\SendMail\SendMail;
use Lamba\Crud\Crud;

class Contact
{
    static $table = DEF_TBL_CONTACTS;
    public static function addContactMessage()
    {
        $fname = strToUpper(trim($_REQUEST['fname']));
        $lname = strToUpper(trim($_REQUEST['lname']));
        $fullName = $fname .' '. $lname;
        $email = strtolower(trim($_REQUEST['email']));
        $subject = strToUpper(trim($_REQUEST['subject']));
        $message = trim($_REQUEST['msg']);
        
        /*
        $body = "Name: {$fullName}\n";
        $body .= "Email: {$email}\n";
        if ($subject != '')
        {
            $body .= "Subject: {$subject}\n";
        }
        $body .= "Message: {$message}\n";
        */

        $arParams = [
            'mailTo' => SITE_MAIL_FROM_EMAIL,
            'toName' => SITE_MAIL_FROM_NAME,
            'mailFrom' => $email,
            'fromName' => $fullName,
            'body' => $message //$body
        ];
        if ($subject != '')
        {
            $arParams['subject'] = $subject;
        }

        SendMail::sendMail($arParams);
        if (SendMail::$isSent)
        {
            $data = [
                'id' => getNewId(),
                'fname' => $fname,
                'lname' => $lname,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
                'cdate' => time()
            ];
            Crud::insert(self::$table, $data);
        }
        else
        {
            throw new Exception('An error occured. Please try again.');
        }
    }
}