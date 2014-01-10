<?php
    session_start();
    require_once '../../include/db.php';
    require_once('../../classes/Authorization.php');
    require_once('../../include/bbb-api.php');
    require_once('../../classes/DBAccess.php');

    require_once 'check.php';

    $dbAccess= new DBAccess();
    $result=$dbAccess->getAllConferences();

?>

<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8" /> 
        <title>Conference</title>
        <!--     Cascading Style Sheet --> 
        <link rel="stylesheet" type="text/css" href="../../css/Style.css"/>
        <link rel="icon" href="../../images/favicon.ico" type="image/x-icon" /
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="../../css/rhd.css"/>
        <?php require_once '../../assets/main/tipsy.php'; ?>


    </head>
    <body>
        <?php require_once '../../assets/main/HeaderNew.php'; ?>

        <?php require_once '../../assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
            <div class="RightTextCntr">
                <div class="contentCntrTab">
                   <div class="internalManuBar" >   <h3 style="text-align: center;">Directory</h3></div>
                    <div class="internalDataGridBar">
                        <div class="Tmenu_bgBigCatalogue" style="width:97%;">
                            <div class="menuBG1" style="text-align:left; width:10%;">User</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Name</div>
                            <div class="menuBG1" style="text-align:left; width:15%;">Welcome Message</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Speaker</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Topic</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Date</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Duration</div>
                            <div class="menuBG1" style="text-align:left; width:5%;">Action</div>
                            <div class="menuBG1" style="text-align:left; width:10%;border: none;">Broadcast</div>
                        </div>
                        <div id="crDate">
                            <?php
                            $sl = 1;
                            while($row=mysql_fetch_array($result)){
                            $period=array("Weekly","Monthly");
                            if ($sl % 2 == 1) {
                                echo "<div id='pag'>";
                            }else{
                                echo "<div id='pag1'>";
                            }
                            ?>


                            <div class='directory_user'  ><?php echo $row['full_name']; ?></div>
                            <div class='name' ><a href='confdetail.php?id=<?php echo $row['id']?>' ><?php echo $row['name'];?></a></div>
                            <div class='message' ><?php echo $row['welcome_msg']; ?></div>
                            <div class='speaker' ><?php echo $row['speaker'];?></div>
                            <div class='topic' ><?php echo $row['topic'];?></div>
                            <div class='date' ><?php echo $dbAccess->fromDBDate($row['meeting_date'])." ". $row['meeting_time']; ?></div>
                            <div class='duration' ><?php echo $row['duration'];?></div>
                                <?php
                                if($row['status']=="reject"){
                                    echo "<div class='action' ><a href='accept.php?meeting_id=".$row['id']."'>Accept</a></div>";
                                    echo "<div class='action' ></div>";
                                }else{
                                    echo "<div class='action' ><a href='reject.php?meeting_id=".$row['id']."'>Reject</a></div>";
                                    echo "<div class='action' ><a href='invite.php?id=".$row['id']."'>Broadcast</a></div>";
                                }
                                ?>
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

