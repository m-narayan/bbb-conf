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
        $dbAccess->addServer($_POST['server_name'],$_POST['url'],$_POST['salt'],$_POST['status']);
    }

    $result=$dbAccess->getAllServers();

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
            <h3 style="text-align: center;">BBB Server</h3>
            <form method="post" action="" name="frm" onsubmit="return server();">
                <table align="center" class="rightform">
                    <tr><td>Server Name</td><td><input type="text" name="server_name"  size="40" maxlength="250"></td></tr>
                    <tr><td>BBB URL</td><td><input type="text" name="url" size="40" maxlength="250"></td></tr>
                    <tr><td>Salt</td><td><input type="text" name="salt"  size="40" maxlength="250"></td></tr>
                    <tr><td>Status</td><td>
                        <select name="status">
                            <option value="1">Active</option>
                            <option value="0">Passive</option>
                        </select>
                    </td></tr>
                    <tr><td align="center" colspan="2">&nbsp;</td></tr>
                    <tr><td align="center" colspan="2"><input type="submit" name="submit" value="Save" class="Btn"></td></tr>
                </table>
            </form>
            <br>
            <table align="center" class="rightform" border="1">
            <tr><th>Server Name</th><th>BBB URL</th><th>Salt</th><th>Status</th><th>Edit</th><th>Delete</th></tr>
            <?php
                while($row=mysql_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['url']."</td>";
                    echo "<td>".$row['salt']."</td>";
                    $status=array("Passive","Active");
                    echo "<td>".$status[$row['status']]."</td>";
                    echo "<td><a href='editserver.php?id=".$row['id']."'>Edit</a></td>";
                    echo "<td>";
                    if(!$dbAccess->checkServerInUse($row['id'])){
                        //echo "<a href='deleteserver.php?id=".$row['id']."'>Delete</a>";
                        echo "<a href='#' onclick='deleteConfirm(".$row['id'].")' >Delete</a>";
                    }else{
                        echo "In Use";
                    }
                    echo "</td>";
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

