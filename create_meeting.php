<?php
    session_start();
    include 'include/db.php';
    require_once('classes/Authorization.php');
    require_once('include/bbb-api.php');
    require_once('classes/Meeting.php');
    require_once('classes/DBAccess.php');
    require_once('classes/Login.php');
    require_once('classes/Catalogue.php');


    $auth_right = new Authorization();
    if(!$auth_right->checkAccessRight()) {
        header('Location: index.php');
    }

    $meeting=new Meeting();
    $dbAccess = new DBAccess();


    if(isset($_POST['submit'])){
        $meeting_id=$meeting->addMeeting($_SESSION['owner_id'],$_POST['name'],$_POST['welcome_msg'],$_POST['meeting_date'],$_POST['duration'],$_POST['speaker'],$_POST['topic']);
//        if(isset($_POST['invitation_list'])){
//            $meeting->addInvitations($meeting_id,$_POST['invitation_list']);
//        }
    }

    $result=$dbAccess->getAllMeetings($_SESSION['owner_id']);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
    <head>
        <meta charset="utf-8" /> 
        <title>Conference</title>
        <!--     Cascading Style Sheet --> 
        <link rel="stylesheet" type="text/css" href="css/Style.css"/>
        <link rel="stylesheet" type="text/css" href="css/rhd.css"/>
        <link type="text/css" rel="stylesheet" href="css/calendar.css?random=20051112" media="screen"></LINK>
        <script type="text/javascript" src="js/validation.js"></script>

        <SCRIPT type="text/javascript" src="js/calendar.js?random=20060118"></script>



    </head>
    <?php

        if (!isset($_COOKIE['user_name'])) {

            // header('Location: authentication.php');
            // exit();
        } else {
            //setcookie("user_name", "", time() - 3600);
        }

    ?>
    <body>
        <?php include_once 'assets/main/HeaderNew.php'; ?>

        <?php include_once 'assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
            <br>
            <h3 style="text-align: center;">Create Conference</h3>


            <form method="post" enctype="multipart/form-data" action="" name="frm" onsubmit="return meeting('<?php echo $_SESSION['owner_id']; ?>');">
                <table align="center" class="rightform">
                    <tr><td>Name</td><td><input type="text" name="name"  size="40" maxlength="250"></td></tr>
                    <tr><td>Welcome Message</td><td><input type="text" name="welcome_msg"  size="40" maxlength="250"></td></tr>
                    <tr><td>Speaker</td><td><input type="text" name="speaker"  size="40" maxlength="250"></td></tr>
                    <tr><td>Topic</td><td><input type="text" name="topic"  size="40" maxlength="250"></td></tr>
<!--                    <tr><td>Invitation List</td>-->
<!--                        <td>-->
<!--                            <div style="height:100px;overflow-y: scroll">-->
<!--                            --><?php
//                            $users=$meeting->getAllUsers($_SESSION['owner_id']);
//                            while($row=mysql_fetch_array($users)){
//                                echo "<input type='checkbox' name='invitation_list[]' value='".$row['id']."' >".$row['full_name']."<br>";
//                            }
//                            ?>
<!--                            </div>-->
<!--                        </td>-->
<!--                    </tr>-->
                    <tr><td>Date</td>
                        <td>
                            <input type="text" value="<?php echo date("m/d/Y H:i"); ?>" readonly  name="meeting_date">
                            <a href="#" onclick="displayCalendar(document.frm.meeting_date,'mm/dd/yyyy hh:ii',this,true)" ><img src="images/cal.gif" /></a>
                        </td>
                    </tr>
                    <tr><td>Duration in Minutes</td>
                        <td>
                            <input type="text" name="duration" onkeypress="return isNumberKey(event)" size="5" maxlength="3">
                        </td>
                    </tr>
                    <tr><td>Presentation(Max 2MB)<br>Only PDF or PPT</td><td><input type="file" name="SMLD"  >
                            <?php
                            if($_SESSION['error']!=""){
                                echo $_SESSION['error'];
                            }
                            ?></td></tr>
                    <tr><td align="center" colspan="2">&nbsp;</td></tr>
                    <tr><td align="center" colspan="2"><input type="submit" name="submit" value="Save" class="Btn"></td></tr>
                </table>
            </form>
            <br>
            <table align="center" class="rightform" border="1">
            <tr><th>Name</th><th>Welcome Message</th><th>Speaker</th><th>Topic</th><th>Date</th><th>Duration</th><th>Start</th></tr>
            <?php
                while($row=mysql_fetch_array($result)){
                    echo "<tr>";
                    //echo "<td>".$row['meetingid']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['welcome_msg']."</td>";
                    echo "<td>".$row['speaker']."</td>";
                    echo "<td>".$row['topic']."</td>";
                    echo "<td>".$dbAccess->fromDBDate($row['meeting_date'])."&nbsp;".$row['meeting_time']."</td>";
                    echo "<td>".$row['duration']."</td>";
                    if($row['meeting_date']==date("Ymd"))
                        echo "<td><a target='_blank' href='getJoinMeetingUrlModerator.php?id=".$row['id']."'>Start Conference</a></td>";
                    else
                        echo "<td>&nbsp;</td>";
                    echo "</tr>";
                }
            ?>
            </table>
            <?php
                //print_r($response);
            ?>
        </div>
        <?php include_once 'assets/main/FooterNew.php'; ?>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
    </body>
    </html>

