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
        $catalogue = new Catalogue();
        $result = $catalogue->connection();
        $result = $catalogue->authenticateUser($_SESSION['name'] ,$_SESSION['password'] );
        $filName = $_FILES['SMLD']['name'];
        $doc_name = $filName;
        $dt_id = 'SMLD';
        $res9 = $catalogue->CreateGFSSupplierDocFileID($doc_name,$dt_id);
        print_r($res9);
        $main_folder = $res9->result_set->main_folder;
        $sub_folder = $res9->result_set->sub_folder;
        $gfs_filename = $res9->result_set->gfs_filename;

        $ftp_server = FTP_SERVER_IP;
        $ftp_user_name = FTP_USER_NAME;
        $ftp_user_pass = FTP_USER_PASS;

        if($_FILES['SMLD']['name']!='')
        {

            $size=$_FILES['SMLD']['size'];
            $type=$_FILES['SMLD']['type'];
            if($size<=2000000)
            {
                $file=$_FILES['SMLD']['name'];
                $temp_name=$_FILES['SMLD']['tmp_name'];
                //$path=$_SERVER['DOCUMENT_ROOT']."/Proclaim/supTCP4/Temp/".$file ;
                //$path=$_SERVER['DOCUMENT_ROOT']."/bbb/Supplies/supTCP4/Temp/".$file ;

                //move_uploaded_file($temp_name,$path);

                $conn_id = ftp_connect($ftp_server);
                $login_result = @ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                if($login_result)
                {

                    ftp_pasv($conn_id, true);

                    if(!@ftp_chdir($conn_id, $main_folder)) {

                        ftp_mkdir($conn_id, $main_folder);
                        ftp_chdir($conn_id, $main_folder);
                    }

                    if(!@ftp_chdir($conn_id, $sub_folder)) {

                        ftp_mkdir($conn_id, $sub_folder);
                        ftp_chdir($conn_id, $sub_folder);
                    }


                    $filen = $file;
                    $file = $temp_name ;
                    $remote_file = $filen;

                    $ret = ftp_nb_put($conn_id, $remote_file, $file, FTP_BINARY, FTP_AUTORESUME);
                    while(FTP_MOREDATA == $ret) {
                        $ret = ftp_nb_continue($conn_id);
                    }

                    if($ret == FTP_FINISHED) {
                       echo "File '" . $remote_file . "' uploaded successfully.";
                    } else {
                        echo "Failed uploading file '" . $remote_file . "'.";
                    }
                } else {
                    echo "Cannot connect to FTP server at " . $ftp_server;
                }

            }

        }
        die;

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