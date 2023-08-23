<?php
namespace Lamba\Image;

use Exception;

class Image
{
    static $field;
    static $maxSize = 2 * DEF_MB;
    static $arExtensions = ['jpg', 'jpeg', 'png'];
    static $directory = 'images/woara/users/';
    static $isMultiple = false;
    static $multipleMaxFiles = 2;
    public static function uploadImage()
    {
        if (self::$isMultiple)
        {
            $galleryNum = count($_FILES[self::$field]['name']);
            if ($galleryNum > self::$multipleMaxFiles)
            {
                throw new Exception('You cannot upload more than '.self::$multipleMaxFiles.' files');
            }
            $arMultiFiles = [];
            for($i = 0; $i < $galleryNum; $i++)
            {
                $imgFileSize = $_FILES[self::$field]['size'][$i];
                $imgFileName = $_FILES[self::$field]['name'][$i];
                $imgTmpFileName = $_FILES[self::$field]['tmp_name'][$i];
                $arMultiFiles[] = self::invokeUploadImage($imgFileSize, $imgFileName, $imgTmpFileName);
            }
            return $arMultiFiles;
        }
        else
        {
            $imgFileSize = $_FILES[self::$field]['size'];
            $imgFileName = $_FILES[self::$field]['name'];
            $imgTmpFileName = $_FILES[self::$field]['tmp_name'];
            return self::invokeUploadImage($imgFileSize, $imgFileName, $imgTmpFileName);
        }
    }
    public static function invokeUploadImage($imgFileSize, $imgFileName, $imgTmpFileName)
    {
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
                throw new Exception('The file is too large');
            }
            else
            {
                $newFileName = uniqid().'.'.$fileExt;
                move_uploaded_file($imgTmpFileName, DEF_DOC_ROOT.self::$directory.$newFileName);
            }
        }

        return $newFileName;
    }
}