<?php
    session_start();
    require_once '../../include/db.php';
    require_once('../../classes/Authorization.php');
    require_once('../../classes/DBAccess.php');

    $auth_right = new Authorization();
    if(!$auth_right->checkAccessRight()) {
        header('Location: index.php');
    }

    require_once 'check.php';

    $dbAccess= new DBAccess();
    $dbAccess->deleteServer($_GET['id']);

    header("location: server.php");

?>

