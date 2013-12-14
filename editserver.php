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
        $dbAccess->updateServer($_GET['id'],$_POST['server_name'],$_POST['url'],$_POST['salt'],$_POST['status']);
        mysql_query($sql);
        header("location: server.php");
    }

    $row=$dbAccess->getServer($_GET['id']);

?>

<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8" /> 
        <title>Conference</title>
        <!--     Cascading Style Sheet --> 
        <link rel="stylesheet" type="text/css" href="css/Style.css"/>

        <link rel="stylesheet" type="text/css" href="css/rhd.css"/>
        <?php include_once 'assets/main/tipsy.php'; ?>
        <script type="text/javascript" src="js/validation.js"></script>

    </head>
    <body>
        <?php include_once 'assets/main/HeaderNew.php'; ?>

        <?php include_once 'assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
            <div class="RightTextCntr">
                <div class="contentCntrTab">
            <br>
            <h3 style="text-align: center;">Edit Server</h3>
            <form method="post" action="" name="frm" onsubmit="return server();">
                <table align="center" class="rightform">
                    <tr><td>Server Name</td><td><input value="<?php echo $row['name']; ?>" type="text" name="server_name"  size="40" maxlength="250"></td></tr>
                    <tr><td>BBB URL</td><td><input value="<?php echo $row['url']; ?>" type="text" name="url" size="40" maxlength="250"></td></tr>
                    <tr><td>Salt</td><td><input value="<?php echo $row['salt']; ?>" type="text" name="salt"  size="40" maxlength="250"></td></tr>
                    <tr><td>Status</td><td>
                        <select name="status">
                            <option <?php if($row['status']==1) echo "selected='selected'"; ?> value="1">Active</option>
                            <option <?php if($row['status']==0) echo "selected='selected'"; ?>  value="0">Passive</option>
                        </select>
                     </td></tr>
                    <tr><td align="center" colspan="2">&nbsp;</td></tr>
                    <tr><td align="center" colspan="2"><input type="submit" name="submit" value="Update" class="Btn"></td></tr>
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

