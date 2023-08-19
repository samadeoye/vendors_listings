<?php
require_once 'utils.php';
use Lamba\Param\Param;

$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
if ($action == '')
{
    getJsonRow(false, 'Invalid request!');
}

$params = Param::getRequestParams($action);
doValidateApiParams($params);

try
{
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
            Lamba\User\User::updateUser();
        break;
    }

    $db->commit();
    if ($action == 'updateprofile')
    {
        $data = [
            'status' => true,
            'data' => $_SESSION['user']
        ];
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