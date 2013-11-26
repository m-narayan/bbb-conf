<?php
class Meeting {

    public function isMeetingRunning($id){
        $flag=false;
        $dbAccess= new DBAccess();
        $row=$dbAccess->getMeeting($id);

        $server=$dbAccess->getServer($row['server_id']);

        $bbb = new BigBlueButton();
        $bbb->setBBBUrlandSalt($server['url'],$server['salt']);

        if($row['meetingid']!=""){
            $result = $bbb->isMeetingRunningWithXmlResponseArray($row['meetingid']);
            $flag= $result['running'];
        }
        return $flag;
    }


    public function addMeeting($owner_id,$name,$welcome_msg,$meeting_date,$duration,$speaker,$topic) {

        //$_FILES['SMLD']['name'];

        $attendeePw=uniqid();
        $moderatorPw=uniqid();

        $dbAccess = new DBAccess();
        $row=$dbAccess->getRandomServer();
        $server_id=$row['id'];


        $dbAccess->addMeeting($server_id,$attendeePw,$moderatorPw,$owner_id,$name,$welcome_msg,$meeting_date,$duration,$speaker,$topic);

    }

    public function joinAsAttende($id){

        $dbAccess= new DBAccess();
        $row=$dbAccess->getMeeting($id);

        $server=$dbAccess->getServer($row['server_id']);

        $bbb = new BigBlueButton();
        $bbb->setBBBUrlandSalt($server['url'],$server['salt']);


        $joinParams = array(
            'meetingId' => $row['meetingid'], 				// REQUIRED - We have to know which meeting to join.
            'username' => $row['name'],		// REQUIRED - The user display name that will show in the BBB meeting.
            'password' => $row['attendee_password'],				// REQUIRED - Must match either attendee or moderator pass for meeting.
            'createTime' => '',				// OPTIONAL - string
            'userId' => '',					// OPTIONAL - string
            'webVoiceConf' => ''			// OPTIONAL - string
        );

        // Get the URL to join meeting:
        $itsAllGood = true;
        try {$result = $bbb->getJoinMeetingURL($joinParams);}
        catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            $itsAllGood = false;
        }

        if ($itsAllGood == true) {
            //Output results to see what we're getting:
            print_r($result);
        }
        return $result;
    }

    public function joinAsModerator($id){

        $dbAccess= new DBAccess();
        $row=$dbAccess->getMeeting($id);

        $server=$dbAccess->getServer($row['server_id']);

        $bbb = new BigBlueButton();
        $bbb->setBBBUrlandSalt($server['url'],$server['salt']);

        $meetingid=uniqid();

        $creationParams = array(
            'meetingId' => $meetingid,			// REQUIRED
            'meetingName' => $row['name'],	// REQUIRED
            'attendeePw' => $row['attendee_password'],		// Match this value in getJoinMeetingURL() to join as attendee.
            'moderatorPw' => $row['moderator_password'],		// Match this value in getJoinMeetingURL() to join as moderator.
            'welcomeMsg' => $row['welcome_msg'],		// ''= use default. Change to customize.
            'dialNumber' => '',		// The main number to call into. Optional.
            'voiceBridge' => '12345',	// 5 digit PIN to join voice bridge.  Required.
            'webVoice' => '',		// Alphanumeric to join voice. Optional.
            'logoutUrl' => LOGOUT_URL,		// Default in bigbluebutton.properties. Optional.
            'maxParticipants' => '-1',	// Optional. -1 = unlimitted. Not supported in BBB. [number]
            'record' => 'true',		// New. 'true' will tell BBB to record the meeting.
            'duration' => $row['duration'], //intval($duration),		// Default = 0 which means no set duration in minutes. [number]
            //'meta_category' => '',	// Use to pass additional info to BBB server. See API docs.
        );

        $preUploadXML = "<?xml version='1.0' encoding='UTF-8'?>";
        $preUploadXML=$preUploadXML."<modules><module name=\"presentation\">";
        $preUploadXML=$preUploadXML."<document url=\"http://106.187.45.141/sample.pdf\" />";
        $preUploadXML=$preUploadXML."</module></modules>";

        $itsAllGood = true;
        try {$result = $bbb->createMeetingWithXmlResponseArray($creationParams,$preUploadXML);}
        catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            $itsAllGood = false;
        }

        if ($itsAllGood == true) {
            // If it's all good, then we've interfaced with our BBB php api OK:
            if ($result == null) {
                // If we get a null response, then we're not getting any XML back from BBB.
                echo "Failed to get any response. Maybe we can't contact the BBB server.";
            }
            else {
                // We got an XML response, so let's see what it says:
                //print_r($result);
                if ($result['returncode'] == 'SUCCESS') {
                    // Then do stuff ...
                    // echo "<p>Meeting succesfullly created.</p>";
                }
                else {
                    echo "<p>Meeting creation failed.</p>";
                }
            }
        }
        $dbAccess->setMeetingId($row['id'],$meetingid);

        $joinParams = array(
            'meetingId' => $meetingid,
            'username' => $row['name'],
            'password' => $row['moderator_password'],
            'createTime' => '',
            'userId' => '',
            'webVoiceConf' => ''
        );

        $itsAllGood = true;
        try {$result = $bbb->getJoinMeetingURL($joinParams);}
        catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            $itsAllGood = false;
        }

        if ($itsAllGood == true) {
            //print_r($result);
        }
        return $result;
    }

    public function getRecordings($id){

        $dbAccess= new DBAccess();
        $row=$dbAccess->getMeeting($id);

        $server=$dbAccess->getServer($row['server_id']);

        $bbb = new BigBlueButton();
        $bbb->setBBBUrlandSalt($server['url'],$server['salt']);

        $recordingsParams = array(
            'meetingId' => $row['meetingid']
        );

        $itsAllGood = true;
        try {$result = $bbb->getRecordingsWithXmlResponseArray($recordingsParams);}
        catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            $itsAllGood = false;
        }

        if ($itsAllGood == true) {
            // If it's all good, then we've interfaced with our BBB php api OK:
            if ($result == null) {
                // If we get a null response, then we're not getting any XML back from BBB.
                echo "Failed to get any response. Maybe we can't contact the BBB server.";
            }
            else {
                // We got an XML response, so let's see what it says:
                //var_dump($result);
                if ($result['returncode'] == 'SUCCESS') {
                    // Then do stuff ...
                    //echo "<p>Meeting info was found on the server.</p>";
                }
                else {
                    echo "<p>Failed to get meeting info.</p>";
                }
            }
        }
        return($result);
    }
}
?>