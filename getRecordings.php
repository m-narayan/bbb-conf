<?php
include 'include/db.php';
require_once('classes/Authorization.php');
require_once('include/bbb-api.php');
require_once('classes/DBAccess.php');
require_once('classes/Meeting.php');

$meeting=new Meeting();
$result=$meeting->getRecordings($_GET['id']);
$url=$result[0]['playbackFormatUrl'];
header("location: $url");

?>

