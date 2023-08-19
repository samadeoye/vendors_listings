<?php
namespace Lamba\Image;

use Exception;

class Image
{
    static $field;
    static $maxSize = 2 * DEF_MB;
    static $arExtensions = ['jpg', 'jpeg', 'png'];
    static $directory = 'images/lamba/users/';
    public static function uploadImage()
    {
        $imgFileName = $_FILES[self::$field]['name'];
        $imgFileSize = $_FILES[self::$field]['size'];
        $newFileName = '';

        if ($imgFileSize > 0)
        {
            $arFileExt = explode('.', $imgFileName);
            $fileExt = strtolower(end($arFileExt));
    
            if (!in_array($fileExt, self::$arExtensions))
            {
                $extensions = implode(', ', self::$arExtensions);
                throw new Exception("Invalid extension! Only {$extensions} are allowed");
            }
            elseif ($imgFileSize > self::$maxSize)
            {
                throw new Exception('The file size is too large');
            }
            else
            {
                $newFileName = uniqid().'.'.$fileExt;
                move_uploaded_file($_FILES[self::$field]['tmp_name'], DEF_DOC_ROOT.self::$directory.$newFileName);
            }
        }

        return $newFileName;
    }
}