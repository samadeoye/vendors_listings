<?php
session_start();

$httpHost = $_SERVER['HTTP_HOST'];
$httpFolderPath = '';
$isProductionServer = true;
$isLocal = false;
if ($httpHost == 'localhost')
{
    //LOCAL
    $httpFolderPath = '/woara';
    $httpHost = 'http://'.$httpHost;
    $isProductionServer = false;
    $isLocal = true;
}
else
{
    //PRODUCTION
    $httpHost = 'https://'.$httpHost;
}
define('DEF_ROOT_PATH', $httpFolderPath);
define('DEF_FULL_ROOT_PATH', $httpHost.$httpFolderPath);
define('DEF_IS_PRODUCTION', $isProductionServer);
define('DEF_IS_LOCAL', $isLocal);

if(DEF_IS_LOCAL)
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

define('DEF_DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] .'/'. $httpFolderPath . '/');

require_once DEF_DOC_ROOT.'vendor/autoload.php';
require_once DEF_DOC_ROOT.'inc/functions.php';
require_once DEF_DOC_ROOT.'inc/constants.php';
require_once DEF_DOC_ROOT.'inc/connect.php';

if(isset($_SESSION['user']))
{
    $arUser = getUserSession();
    $userId = $arUser['id'];
}

$arAdditionalCSS = $arAdditionalJs = $arAdditionalJsScripts = $arAdditionalJsOnLoad = [];