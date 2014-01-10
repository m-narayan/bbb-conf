<?php
    session_start();
    require_once '../../include/db.php';
    require_once('../../classes/Authorization.php');
    require_once('../../include/bbb-api.php');
    require_once('../../classes/DBAccess.php');
    require_once('../../classes/Meeting.php');

    $auth_right = new Authorization();
    if(!$auth_right->checkAccessRight()) {
        header('Location: ../../index.php');
    }

    $dbAccess= new DBAccess();
    $result=$dbAccess->enrolledConferences($_SESSION['owner_id']);

?>

<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="refresh" content="60" />
        <title>Conference</title>
        <!--     Cascading Style Sheet --> 
        <link rel="stylesheet" type="text/css" href="../../css/Style.css"/>
        <link rel="stylesheet" type="text/css" href="../../css/rhd.css"/>
        <link rel="icon" href="../../images/favicon.ico" type="image/x-icon" /

        <?php include_once '../../assets/main/tipsy.php'; ?>


    </head>
    <body>
        <?php include_once '../../assets/main/HeaderNew.php'; ?>

        <?php include_once '../../assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
            <div class="RightTextCntr">
                <div class="contentCntrTab">


                    <div class="internalManuBar" ><h3 style="text-align: center;">Enrolled Conference</h3>
                    </div>
                    <div class="internalDataGridBar">
                        <div class="Tmenu_bgBigCatalogue" style="width:97%;">
                            <div class="menuBG1" style="text-align:left; width:8%;">User</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Name</div>
                            <div class="menuBG1" style="text-align:left; width:15%;">Welcome Message</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Speaker</div>
                            <div class="menuBG1" style="text-align:left; width:8%;">Topic</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Date</div>
                            <div class="menuBG1" style="text-align:left; width:8%;">Duration</div>
                            <div class="menuBG1" style="text-align:left; width:7%;">DeEnroll</div>
                            <div class="menuBG1" style="text-align:left; width:5%;">Join</div>
                            <div class="menuBG1" style="text-align:left; width:5%;border: none;">Recordings</div>

                        </div>
                        <div id="crDate">
                            <?php
                            $sl = 1;
                            $meeting=new Meeting();
                            while($row=mysql_fetch_array($result)){
                            $period=array("Weekly","Monthly");
                            if ($sl % 2 == 1) {
                                echo "<div id='pag'>";
                            }else{
                                echo "<div id='pag1'>";
                            }
                            ?>
                            <div class='user' style='width:10%;' ><?php echo $row['full_name'];?></div>
                            <div class='name' style='width:11%;' ><a href='confdetail.php?id=<?php echo $row['id']?>' ><?php echo $row['name'];?></a></div>
                            <div class='message'  style='width:15%;' ><?php echo $row['welcome_msg']; ?></div>
                            <div class='speaker' style='width:11%;'><?php echo $row['speaker'];?></div>
                            <div class='topic'  style='width:9%;' ><?php echo $row['topic'];?></div>
                            <div class='date'  style='width:11%;' ><?php echo $dbAccess->fromDBDate($row['meeting_date'])." ". $row['meeting_time']; ?></div>
                            <div class='duration' style='width:9%;' ><?php echo $row['duration'];?></div>
                            <div class='action' style='width:7%;'>
                                <a href='deenroll.php?meeting_id=<?php echo $row['id']?>'>DeEnroll</a>
                              </div>

                               <?php
                               $status=$meeting->isMeetingRunning($row['id']);
                                if($status=="true"){
                                echo "<div class='action' style='width:6%;'><a target='_blank' href='getJoinMeetingUrlAttendee.php?id=".$row['id']."'>Join</a></div>";
                                }else{
                                echo "<div class='action' style='width:6%;'>Not Running</div>";
                                }
                                 ?>
                            <div class='action' style='width:11%;'><a target='_blank' href='getRecordings.php?id=<?php echo $row['id']?>'>View</a></div>

                    </div>

                    <?php
                    ++$sl;

                    } ?>

                </div>

        </div>
                </div>
            </div>
        <?php include_once '../../assets/main/FooterNew.php'; ?>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
    </body>
    </html>

