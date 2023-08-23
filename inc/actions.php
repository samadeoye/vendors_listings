<?php
require_once 'utils.php';
use Lamba\Param\Param;
use Lamba\User\User;
use Lamba\Listing\Listing;

$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
if ($action == '')
{
    getJsonRow(false, 'Invalid request!');
}

$params = Param::getRequestParams($action);
doValidateApiParams($params);

try
{
    $data = [];
    $db->beginTransaction();

    switch($action)
    {
        case 'register':
            Lamba\Auth\Register::registerUser();
        break;
        case 'login':
            Lamba\Auth\Login::loginUser();
        break;
        case 'changepassword':
            Lamba\User\User::changePassword();
        break;
        case 'updateprofile':
            User::updateUser();
            $rs = User::$data;
            if (count($rs) > 0)
            {
                $data = $rs;
            }
        break;
        case 'addlisting':
            Lamba\Listing\Listing::addListing();
        break;
        case 'updatelisting':
            Lamba\Listing\Listing::updateListing();
        break;
        case 'getAppPaginationData':
            Listing::getAppListingPaginationData();
            $rs = Listing::$data;
            if (count($rs) > 0)
            {
                $data = $rs;
            }
        break;
        case 'getEditListingModalData':
            Listing::getEditListingModalData();
            $rs = Listing::$data;
            if (count($rs) > 0)
            {
                $data = $rs;
            }
        break;
    }

    $db->commit();
    if (count($data) > 0)
    {
        getJsonList($data);
    }
    getJsonRow(true, 'Operation successful!');
}
catch(Exception $ex)
{
	$db->rollBack();
	// $ex->getMessage();exit;
    getJsonRow(false, $ex->getMessage());
}