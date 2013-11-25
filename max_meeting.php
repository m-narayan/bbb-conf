<?php
    include 'include/db.php';
    require_once('classes/DBAccess.php');

    $dbAccess = new DBAccess();
    echo $dbAccess->checkMaxMeeting($_GET['id']);

?>