<?php
    session_start();
    require_once '../../include/db.php';
    require_once('../../classes/Authorization.php');
    require_once('../../classes/DBAccess.php');

    require_once 'check.php';

    $dbAccess = new DBAccess();

    $msg="";
    $success="";
    if(isset($_POST['submit'])){
        if($dbAccess->checkOldPassword($_POST['old_pass'])){
            $dbAccess->changePassword($_POST['new_pass']);
            $success="Password changed successfully";
        }else{
            $msg="Invalid old password";
        }
    }



?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
    <head>
        <meta charset="utf-8" /> 
        <title>Conference</title>
        <!--     Cascading Style Sheet --> 
        <link rel="stylesheet" type="text/css" href="../../css/Style.css"/>
        <link rel="icon" href="../../images/favicon.ico" type="image/x-icon" /
        <link rel="stylesheet" type="text/css" href="../../css/rhd.css"/>
        <?php require_once '../../assets/main/tipsy.php'; ?>
        <script type="text/javascript" src="../../js/validation.js"></script>
    </head>
    <body>
        <?php require_once '../../assets/main/HeaderNew.php'; ?>

        <?php require_once '../../assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
            <div class="RightTextCntr">
                <div class="contentCntrTab">
            <br>
            <span style="color:green" ><?php echo $success; ?></span>
            <h3 style="text-align: center;">Change Password</h3>


            <form method="post" action="" name="frm" onsubmit="return change_password()">
                <table align="center" class="rightform">
                    <tr><td>Old Password</td>
                        <td>
                            <input type="password" name="old_pass"  size="40" maxlength="250">
                            <span style="color:red" ><?php echo $msg; ?></span>
                        </td>
                    </tr>
                    <tr><td>New Password</td><td><input type="password" name="new_pass"  size="40" maxlength="250"></td></tr>
                    <tr><td>Confirm Password</td><td><input type="password" name="conf_pass"  size="40" maxlength="250"></td></tr>
                    <tr><td align="center" colspan="2">&nbsp;</td></tr>
                    <tr><td align="center" colspan="2"><input type="submit" name="submit" value="Save" class="Btn"></td></tr>
                </table>
            </form>
                    </div>
                </div>
        <?php require_once 'assets/main/FooterNew.php'; ?>
    </body>
    </html>

