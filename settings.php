<?php
    session_start();
    include 'include/db.php';
    require_once('classes/Authorization.php');
    require_once('classes/DBAccess.php');

    $auth_right = new Authorization();
    if(!$auth_right->checkAccessRight()) {
        header('Location: index.php');
    }

    include 'check.php';
    $dbAccess = new DBAccess();
    if(isset($_POST['submit'])){
        $dbAccess->addUserSettings($_POST['user'],$_POST['period'],$_POST['max_conference']);
    }

    $result=$dbAccess->getAllSettings();

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

        <script type="text/javascript" src="js/validation.js"></script>

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
            <h3 style="text-align: center;">Settings</h3>
            <form method="post" action="" name="frm" onsubmit="return settings();">
                <table align="center" class="rightform">
                    <tr><td>User</td>
                        <td>
                            <select name="user">
                            <option value='0'>Select</option>
                            <?php $users=$dbAccess->getAllUsersExceptAdmin();
                            while($row=mysql_fetch_array($users)){
                                echo "<option value='".$row['id']."'>".$row['full_name']."</option>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr><td>Period</td>
                        <td>
                            <input type="radio" name="period" value="0" checked="checked">Weekly
                            <input type="radio" name="period" value="1">Monthly
                        </td>
                    </tr>

                    <tr><td>Max Conference</td><td><input onkeypress="return isNumberKey(event)" type="text" name="max_conference" size="13" maxlength="3"></td></tr>
                    <tr><td align="center" colspan="2">&nbsp;</td></tr>
                    <tr><td align="center" colspan="2"><input type="submit" name="submit" value="Save" class="Btn"></td></tr>
                </table>
            </form>
            <br>
            <table align="center" class="rightform" border="1">
            <tr><th>User</th><th style="text-align: right;">Period</th><th style='text-align: right;'>Max Conference</th></tr>
            <?php
                while($row=mysql_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>".$row['full_name']."</td>";
                    $period=array("Weekly","Monthly");
                    echo "<td style='text-align: right;'>".$period[$row['period']]."</td>";
                    echo "<td style='text-align: right;'>".$row['max_conference']."</td>";
                    echo "</tr>";
                }
            ?>
            </table>
        </div>
        <?php include_once 'assets/main/FooterNew.php'; ?>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
    </body>
    </html>

