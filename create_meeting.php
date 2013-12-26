<?php
    session_start();
    include 'include/db.php';
    require_once('classes/Authorization.php');
    require_once('include/bbb-api.php');
    require_once('classes/Meeting.php');
    require_once('classes/DBAccess.php');
    include 'include/config.php';
    include 'include/config_supplier.php';
    require_once('classes/supplierLogin.php');
    require_once('classes/Catalogue.php');


    $auth_right = new Authorization();
    if(!$auth_right->checkAccessRight()) {
        header('Location: index.php');
    }

    $meeting=new Meeting();
    $dbAccess = new DBAccess();


    if(isset($_POST['submit'])){
        $meeting_id=$meeting->addMeeting($_SESSION['owner_id'],$_POST['name'],$_POST['welcome_msg'],$_POST['meeting_date'],$_POST['duration'],$_POST['speaker'],$_POST['topic']);
    }



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
    <head>
        <meta charset="utf-8" /> 
        <title>Conference</title>
        <!--     Cascading Style Sheet --> 
        <link rel="stylesheet" type="text/css" href="css/Style.css"/>
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="css/rhd.css"/>
        <link type="text/css" rel="stylesheet" href="css/calendar.css?random=20051112" media="screen"/>
        <link href="tabcontent/tabcontent.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/validation.js"></script>

        <SCRIPT type="text/javascript" src="js/calendar.js?random=20060118"></script>
        <?php include_once 'assets/main/tipsy.php'; ?>


        <script src="tabcontent/tabcontent.js" type="text/javascript"></script>
        <script>
            function openRecording(id){
                var winFeature ='location=no,toolbar=no,menubar=no,scrollbars=yes,resizable=yes';
                window.open('<?php echo $url; ?>','null',winFeature);
            }
        </script>


    </head>
    <body>
        <?php include_once 'assets/main/HeaderNew.php'; ?>

        <?php include_once 'assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
            <div class="RightTextCntr">
                <div class="contentCntrTab">
            <br>
            <h3 style="text-align: center;">Create Conference</h3>


            <form method="post" enctype="multipart/form-data" action="" name="frm" onsubmit="return meeting('<?php echo $_SESSION['owner_id']; ?>');">
                <table align="center" class="rightform">
                    <tr><td>Name</td><td><input type="text" name="name"  size="40" maxlength="250"></td></tr>
                    <tr><td>Welcome Message</td>
                        <td>
                            <textarea rows="5" cols="40" name="welcome_msg" ></textarea>
                        </td>
                    </tr>
                    <tr><td>Speaker</td><td><input type="text" name="speaker"  size="40" maxlength="250"></td></tr>
                    <tr><td>Topic</td><td><input type="text" name="topic"  size="40" maxlength="250"></td></tr>
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
                    <tr><td>Presentation(Max 2MB)<br>Only PDF or PPT</td><td>
                            <input onchange="fileSelectedChanged();" type="file" name="SMLD"  >
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

            <ul class="tabs">
                <li><a href="#view1">Today's Conference</a></li>
                <li><a href="#view2">Future Conference</a></li>
                <li><a href="#view3">Old Conference</a></li>
            </ul>
            <div class="tabcontents">
                <div id="view1">
                    <div class="internalManuBar" ><h3 style="text-align: center;">Today's Conference</h3>
                    </div>
                    <div class="internalDataGridBar">
                        <div class="Tmenu_bgBigCatalogue" style="width:97%;">
                            <div class="menuBG1" style="text-align:left; width:10%;">Name</div>
                            <div class="menuBG1" style="text-align:left; width:15%;">Welcome Message</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Speaker</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Topic</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Date</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Duration</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Start</div>
                            <div class="menuBG1" style="text-align:left; width:10%;border: none;">Recordings</div>
                        </div>
                        <div id="crDate">
                            <?php
                            $sl = 1;
                            $result=$dbAccess->getTodayMeetings($_SESSION['owner_id']);
                            while($row=mysql_fetch_array($result)){
                            $period=array("Weekly","Monthly");
                            if ($sl % 2 == 1) {
                                echo "<div id='pag'>";
                            }else{
                                echo "<div id='pag1'>";
                            }
                            ?>
                            <div class='name' style='width:12%;' ><a href='confdetail.php?id=<?php echo $row['id']?>' ><?php echo $row['name'];?></a></div>
                            <div class='message' ><?php echo $row['welcome_msg']; ?></div>
                            <div class='speaker' style='width:11%;'><?php echo $row['speaker'];?></div>
                            <div class='topic' ><?php echo $row['topic'];?></div>
                            <div class='date' ><?php echo $dbAccess->fromDBDate($row['meeting_date'])." ". $row['meeting_time']; ?></div>
                            <div class='duration' ><?php echo $row['duration'];?></div>
                            <?php
                            if(date('H.i', strtotime("+60 min")) >= str_replace(":",".",$row['meeting_time']) ){
                                if($row['status']=="accept"){
                                    echo "<div class='action' style='width:11%;'><a target='_blank' href='getJoinMeetingUrlModerator.php?id=".$row['id']."'>Start Conference</a></div>";
                                    echo "<div class='action' style='width:11%;'><a target='_blank' class='basic' href='getRecordings.php?id=".$row['id']."'>View</a></div>";
                                }else{
                                    echo "<div class='action' style='width:11%;'>&nbsp;</div>";
                                    echo "<div class='action' style='width:11%;'>&nbsp;</div>";
                                }
                            }else{
                                echo "<div class='action' style='width:11%;'>&nbsp;</div>";
                                echo "<div class='action' style='width:11%;'>&nbsp;</div>";
                            }

                            ?>
                        </div>
                    </div>

                    <?php
                    ++$sl;

                    } ?>

                </div>





                </div>
                <div id="view2">
                    <div class="internalManuBar" ><h3 style="text-align: center;">Future Conference</h3>
                    </div>
                    <div class="internalDataGridBar">
                        <div class="Tmenu_bgBigCatalogue" style="width:97%;">
                            <div class="menuBG1" style="text-align:left; width:10%;">Name</div>
                            <div class="menuBG1" style="text-align:left; width:40%;">Welcome Message</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Speaker</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Topic</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Date</div>
                            <div class="menuBG1" style="text-align:left; width:10%;border:none;">Duration</div>
                         </div>
                        <div id="crDate">
                            <?php
                            $sl = 1;
                            $result=$dbAccess->getFutureMeetings($_SESSION['owner_id']);
                            while($row=mysql_fetch_array($result)){
                            $period=array("Weekly","Monthly");
                            if ($sl % 2 == 1) {
                                echo "<div id='pag'>";
                            }else{
                                echo "<div id='pag1'>";
                            }
                            ?>
                            <div class='name' style='width:12%;' ><a href='confdetail.php?id=<?php echo $row['id']?>' ><?php echo $row['name'];?></a></div>
                            <div class='message' style='width:40%;'><?php echo $row['welcome_msg']; ?></div>
                            <div class='speaker' style='width:11%;'><?php echo $row['speaker'];?></div>
                            <div class='topic' ><?php echo $row['topic'];?></div>
                            <div class='date' ><?php echo $dbAccess->fromDBDate($row['meeting_date'])." ". $row['meeting_time']; ?></div>
                            <div class='duration'><?php echo $row['duration'];?></div>

                        </div>


                    <?php
                    ++$sl;

                    } ?>
                    </div>
                </div>
                </div>
                <div id="view3">
                    <div class="internalManuBar" ><h3 style="text-align: center;">Old Conference</h3>
                    </div>
                    <div class="internalDataGridBar">
                        <div class="Tmenu_bgBigCatalogue" style="width:97%;">
                            <div class="menuBG1" style="text-align:left; width:10%;">Name</div>
                            <div class="menuBG1" style="text-align:left; width:30%;">Welcome Message</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Speaker</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Topic</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Date</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Duration</div>
                            <div class="menuBG1" style="text-align:left; width:10%;border:none;">Recordings</div>
                        </div>
                        <div id="crDate">
                            <?php
                            $sl = 1;
                            $result=$dbAccess->getPastMeetings($_SESSION['owner_id']);
                            while($row=mysql_fetch_array($result)){
                            $period=array("Weekly","Monthly");
                            if ($sl % 2 == 1) {
                                echo "<div id='pag'>";
                            }else{
                                echo "<div id='pag1'>";
                            }
                            ?>
                            <div class='name' style='width:12%;' ><a href='confdetail.php?id=<?php echo $row['id']?>' ><?php echo $row['name'];?></a></div>
                            <div class='message' style='width:30%;'><?php echo $row['welcome_msg']; ?></div>
                            <div class='speaker' style='width:11%;'><?php echo $row['speaker'];?></div>
                            <div class='topic' ><?php echo $row['topic'];?></div>
                            <div class='date' ><?php echo $dbAccess->fromDBDate($row['meeting_date'])." ". $row['meeting_time']; ?></div>
                            <div class='duration'><?php echo $row['duration'];?></div>
                            <div class='duration'><a target='_blank' href='getRecordings.php?id=<?php echo $row['id'];?>'>View</a>
                            </div>
                        </div>


                    <?php
                    ++$sl;

                    } ?>
                    </div>
                </div>

                </div>
            </div>
</div>
        </div>
            </div>
        <?php include_once 'assets/main/FooterNew.php'; ?>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
        <div id="basic-modal-content">

        </div>
    </body>
    </html>

