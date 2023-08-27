<?php
namespace Lamba\SendMail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMail
{
    static $isSent = false;
    public static function sendMail($arParams)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try
        {
            //Server settings
            /*
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'mail.woara.ng';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'info@woara.ng';
            $mail->Password   = 'InfoWoAraLive!@#123';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            */
            
            $mail->isMail();

            $mailTo = $arParams['mailTo'];
            $toName = $arParams['toName'];
            $mailFrom = $arParams['mailFrom'];
            $fromName = $arParams['fromName'];
            $subject =  (array_key_exists('subject', $arParams)) ? $arParams['subject'] : 'Mail From '.SITE_NAME;
            $body =  (array_key_exists('body', $arParams)) ? $arParams['body'] : '';
            $bodyHtml =  (array_key_exists('bodyHtml', $arParams)) ? $arParams['bodyHtml'] : '';
            $addReplyTo = (array_key_exists('addReplyTo', $arParams)) ? $arParams['addReplyTo'] : false;
            $isHtml = (array_key_exists('isHtml', $arParams)) ? $arParams['isHtml'] : false;
            $arCC = (array_key_exists('arCC', $arParams)) ? $arParams['arCC'] : [];
            $arBCC = (array_key_exists('arBCC', $arParams)) ? $arParams['arBCC'] : [];
            $arAttachments = (array_key_exists('arAttachments', $arParams)) ? $arParams['arAttachments'] : [];
            
            //Recipients
            $mail->setFrom($mailFrom, $fromName);
            $mail->addAddress($mailTo, $toName);
            if ($addReplyTo)
            {
                $mail->addReplyTo($mailFrom, $fromName);
            }
            if (count($arCC) > 0)
            {
                foreach($arCC as $ccEmail)
                {
                    $mail->addCC($ccEmail);
                }
            }
            if (count($arBCC) > 0)
            {
                foreach($arBCC as $bccEmail)
                {
                    $mail->addBCC($bccEmail);
                }
            }

            //Attachments
            if (count($arAttachments) > 0)
            {
                foreach($arAttachments as $attachment)
                {
                    $mail->addAttachment($attachment);//full path e.g /var/tmp/file.tar.gz
                }
            }

            //Content
            if ($isHtml)
            {
                $mail->isHTML(true);
                if ($bodyHtml == '')
                {
                    $mail->AltBody = $body;
                    $body = $bodyHtml;
                }
            }
            else
            {
                $mail->AltBody = $body;
            }
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            self::$isSent = true;
        }
        catch (Exception $e)
        {
            self::$isSent = false;
            throw new Exception('Message could not be sent');
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    public static function sendDefaultMail($arParams)
    {
        try
        {
            $mailTo = $arParams['mailTo'];
            $mailFrom = $arParams['mailFrom'];
            $fromName = $arParams['fromName'];
            $subject =  (array_key_exists('subject', $arParams)) ? $arParams['subject'] : 'Mail From '.SITE_NAME;
            $body = $arParams['body'];

            
            $emailHeaders = "From: $fromName <$mailFrom>";

            if (mail($mailTo, $subject, $body, $emailHeaders))
            {
                self::$isSent = true;
            }
            else
            {
                throw new Exception('An error occured. Please try again.');
            }
        }
        catch(Exception $e)
        {
            self::$isSent = false;
            getJsonRow(false, 'An error occured');
        }
    }
}