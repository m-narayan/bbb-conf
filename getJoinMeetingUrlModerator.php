<?php
include 'include/db.php';
require_once('classes/Authorization.php');
require_once('include/bbb-api.php');
require_once('classes/DBAccess.php');
require_once('classes/Meeting.php');

$auth_right = new Authorization();
if(!$auth_right->checkAccessRight()) {
    //header('Location: index.php');
}

$meeting=new Meeting();
$result=$meeting->joinAsModerator($_GET['id']);
header("location: $result");

?>