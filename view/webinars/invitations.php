<?php
    session_start();
    require_once '../../include/db.php';
    require_once('../../classes/Authorization.php');
    require_once('../../include/bbb-api.php');
    require_once('../../classes/DBAccess.php');

    $auth_right = new Authorization();
    if(!$auth_right->checkAccessRight()) {
        header('Location: ../../index.php');
    }

    $dbAccess= new DBAccess();
    $result=$dbAccess->getInvitations($_SESSION['owner_id']);

?>

<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8" /> 
        <title>Conference</title>
        <!--     Cascading Style Sheet --> 
        <link rel="stylesheet" type="text/css" href="../../css/Style.css"/>
        <link rel="stylesheet" type="text/css" href="../../css/rhd.css"/>
        <link rel="icon" href="../../favicon.ico" type="image/x-icon" /

        <?php require_once '../../assets/main/tipsy.php'; ?>



    </head>
    <body>
        <?php require_once '../../assets/main/HeaderNew.php'; ?>

        <?php require_once '../../assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
            <div class="RightTextCntr">
                <div class="contentCntrTab">
                    <div class="internalManuBar" ><h3 style="text-align: center;">Invitations</h3>
                    </div>
                    <div class="internalDataGridBar">
                        <div class="Tmenu_bgBigCatalogue" style="width:97%;">
                            <div class="menuBG1" style="text-align:left; width:10%;">User</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Name</div>
                            <div class="menuBG1" style="text-align:left; width:20%;">Welcome Message</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Speaker</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Topic</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Date</div>
                            <div class="menuBG1" style="text-align:left; width:10%;">Duration</div>
                            <div class="menuBG1" style="text-align:left; width:10%;border: none;">Action</div>

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
                            <div class='user' style='width:12%;' ><?php echo $row['full_name'];?></div>
                            <div class='name' style='width:11%;' ><a href='confdetail.php?id=<?php echo $row['id']?>' ><?php echo $row['name'];?></a></div>
                            <div class='message'  style='width:20%;' ><?php echo $row['welcome_msg']; ?></div>
                            <div class='speaker' style='width:11%;'><?php echo $row['speaker'];?></div>
                            <div class='topic' ><?php echo $row['topic'];?></div>
                            <div class='date' ><?php echo $dbAccess->fromDBDate($row['meeting_date'])." ". $row['meeting_time']; ?></div>
                            <div class='duration' ><?php echo $row['duration'];?></div>
                           <div class='action' style='width:11%;'>
                               <a class='basic' href='enroll.php?meeting_id=<?php echo $row['id'];?>'>Enroll</a></div>

                    </div>

                    <?php
                    ++$sl;

                    } ?>

                </div>

        </div>
                </div>
            </div>
        <?php require_once '../../assets/main/FooterNew.php'; ?>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
    </body>
    </html>

