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

    if(isset($_POST['submit'])){
        if(isset($_POST['invitation_list'])){
            $dbAccess->broadcast($_POST['meeting_id'],$_POST['invitation_list']);
        }
        header("location: directory.php");
    }

    $row=$dbAccess->getMeetingDetail($_GET['id']);

?>

<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8" /> 
        <title>Conference</title>
        <!--     Cascading Style Sheet --> 
        <link rel="stylesheet" type="text/css" href="css/Style.css"/>
        <link rel="icon" href="favicon.ico" type="image/x-icon" /
        <link rel="stylesheet" type="text/css" href="css/rhd.css"/>
        <?php include_once 'assets/main/tipsy.php'; ?>


    </head>
    <body>
        <?php include_once 'assets/main/HeaderNew.php'; ?>

        <?php include_once 'assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
            <div class="RightTextCntr">
                <div class="contentCntrTab">
            <br>
            <h3 style="text-align: center;">Conference Detail</h3>
            <table align="center" class="rightform" border="1">
            <tr><td>User</td><td><?php echo $row['full_name'] ?></td></tr>
            <tr><td>Name</td><td><?php echo $row['name'] ?></td></tr>
            <tr><td>Welcome Message</td><td><?php echo $row['welcome_msg'] ?></td></tr>
            <tr><td>Speaker</td><td><?php echo $row['speaker'] ?></td></tr>
            <tr><td>Topic</td><td><?php echo $row['topic'] ?></td></tr>
            <tr><td>Date</td><td><?php echo $dbAccess->fromDBDate($row['meeting_date'])."&nbsp;".$row['meeting_time'] ?></td></tr>
            <tr><td>Duration</td><td><?php echo $row['duration'] ?></td></tr>
            <tr><td>Presentation</td><td><a target="_blank" href='<?php echo $row['slide'] ?>'>View</a></a></td></tr>
            </table>
            <h3 style="text-align: center;">&nbsp;</h3>
            <form method="post"  action="" name="frm" ">
                <input type="hidden" name="meeting_id" value="<?php echo $_GET['id']; ?>">
                <table align="center" class="rightform">
                    <tr><td>Users</td>
                        <td>
                            <div style="height:100px;overflow-y: scroll">
                                <?php
                                $users=$dbAccess->getAllUsers($row['owner_id']);
                                while($row=mysql_fetch_array($users)){
                                    echo "<input type='checkbox' name='invitation_list[]' value='".$row['id']."' ";
                                    if($dbAccess->getBroadcast($_GET['id'],$row['id'])) echo " checked='checked' ";
                                    echo ">".$row['full_name']."<br>";
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr><td align="center" colspan="2">&nbsp;</td></tr>
                    <tr><td align="center" colspan="2"><input type="submit" name="submit" value="Broadcast" class="Btn"></td></tr>

                </table>
            </form>
        </div>
                </div>
            </div>
        <?php include_once 'assets/main/FooterNew.php'; ?>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
    </body>
    </html>

