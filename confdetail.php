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
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.alerts.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/rhd.css"/>



    </head>
    <body>
        <?php include_once 'assets/main/HeaderNew.php'; ?>

        <?php include_once 'assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
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
            <tr><td>Presentation</td>
                <?php if($row['slide']!="") {?>
                <td><a target="_blank" href='<?php echo $row['slide'] ?>'>View</a></td>
                <?php }else{ ?>
                <td></td>
                <?php } ?>
            </tr>
            </table>
        </div>
        <?php include_once 'assets/main/FooterNew.php'; ?>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
    </body>
    </html>

