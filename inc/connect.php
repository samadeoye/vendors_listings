<?php
if(DEF_IS_PRODUCTION)
{
    $serverName = "localhost";
    $dbName = "";
    $userName = "";
    $password = "";
}
else
{
    //LOCAL
    $serverName = "localhost";
    $dbName = "lamba";
    $userName = "root";
    $password = "";
}

try
{
    $db = new PDO("mysql:host=$serverName;dbname=$dbName", $userName, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    exit;
}
?>