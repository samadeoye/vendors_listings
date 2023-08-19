<?php
session_start();

$isProductionServer = $isLocal = false;

require_once 'constants.php';

$httpHost = $_SERVER['HTTP_HOST'];
$httpFolderPath = '/';
if($httpHost == SITE_DOMAIN)
{
    $isProductionServer = true;
    //$httpFolderPath = '/api';
    $httpHost = 'https://'.$httpHost;
}
else
{
    //LOCAL
    $httpFolderPath = 'lamba/';
    $isLocal = true;
    $httpHost = 'http://'.$httpHost;
}
$fullPathUrl = $httpHost .'/'. $httpFolderPath;
define('DEF_FULL_BASE_PATH_URL', $fullPathUrl);
define('DEF_IS_PRODUCTION', $isProductionServer);
define('DEF_IS_LOCAL', $isLocal);

if(DEF_IS_LOCAL)
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

define('DEF_DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] .'/'. $httpFolderPath);

require_once DEF_DOC_ROOT.'vendor/autoload.php';
require_once 'functions.php';
require_once 'connect.php';

if(isset($_SESSION['user']))
{
    $arUser = getUserSession();
    $userId = $arUser['id'];
}

$arAdditionalCSS = $arAdditionalJs = $arAdditionalJsOnLoad = [];