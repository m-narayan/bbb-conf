<?php
    session_start();
    include 'include/db.php';
    require_once('classes/Authorization.php');
    require_once('classes/DBAccess.php');

    $auth_right = new Authorization();
    if(!$auth_right->checkAccessRight()) {
        header('Location: index.php');
    }

    include 'check.php';

    $dbAccess= new DBAccess();
    $dbAccess->deleteServer($_GET['id']);

    header("location: server.php");

?>

