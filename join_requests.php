<?php
    session_start();
    include 'include/db.php';
    require_once('classes/Authorization.php');
    require_once('include/bbb-api.php');
    require_once('classes/DBAccess.php');

    $auth_right = new Authorization();
    if(!$auth_right->checkAccessRight()) {
        header('Location: index.php');
    }

    $dbAccess= new DBAccess();
    $result=$dbAccess->getJoinRequests($_SESSION['owner_id']);

?>

<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8" /> 
        <title>Conference</title>
        <!--     Cascading Style Sheet --> 
        <link rel="stylesheet" type="text/css" href="css/Style.css"/>
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.alerts.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/rhd.css"/>  


    </head>
    <?php

        if (!isset($_COOKIE['user_name'])) {

            // header('Location: authentication.php');
            // exit();
        } else {
            //setcookie("user_name", "", time() - 3600);
        }

    ?>
    <body onLoad="changeHashOnLoad();" >
        <?php include_once 'assets/main/HeaderNew.php'; ?>

        <?php include_once 'assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
            <br>
            <h3 style="text-align: center;">Directory</h3>
            <table align="center" class="rightform" border="1">
            <tr><th>User</th><th>Name</th><th>Welcome Message</th><th>Speaker</th><th>Topic</th><th>Date</th><th>Duration</th><th>Action</th></tr>
            <?php
                while($row=mysql_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>".$row['full_name']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['welcome_msg']."</td>";
                    echo "<td>".$row['speaker']."</td>";
                    echo "<td>".$row['topic']."</td>";
                    echo "<td>".$row['meeting_date']."</td>";
                    echo "<td>".$row['duration']."</td>";
//                    if($meeting->checkEnrollment($row['id'],$_SESSION['owner_id'])){
//                        echo "<td><a href='deenroll.php?meeting_id=".$row['id']."'>DeEnroll</a></td>";
//                    }else{
                        echo "<td><a href='enroll.php?meeting_id=".$row['id']."'>Enroll</a></td>";
//                    }

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

