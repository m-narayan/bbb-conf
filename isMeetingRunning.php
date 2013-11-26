<?php
include 'include/db.php';
require_once('include/bbb-api.php');
require_once('classes/DBAccess.php');
require_once('classes/Meeting.php');


$dbAccess= new DBAccess();
$row=$dbAccess->getMeeting($_GET['id']);

$server=$dbAccess->getServer($row['server_id']);

$bbb = new BigBlueButton();
$bbb->setBBBUrlandSalt($server['url'],$server['salt']);


$meetingId = $row['meetingid'];

// Get the URL to join meeting:
$itsAllGood = true;
try {$result = $bbb->isMeetingRunningWithXmlResponseArray($meetingId);}
	catch (Exception $e) {
		echo 'Caught exception: ', $e->getMessage(), "\n";
		$itsAllGood = false;
	}

if ($itsAllGood == true) {
	//Output results to see what we're getting:
    echo($result['running']);
}	
?>