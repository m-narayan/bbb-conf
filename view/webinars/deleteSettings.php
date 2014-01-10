<?php
    session_start();
    require_once '../../include/db.php';
    require_once('../../classes/Authorization.php');
    require_once('../../classes/DBAccess.php');

    require_once 'check.php';

    $dbAccess= new DBAccess();
    $dbAccess->deleteSettings($_GET['id']);

    header("location: settings.php");

?>

