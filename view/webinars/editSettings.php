<?php
    session_start();
    require_once '../../include/db.php';
    require_once('../../classes/Authorization.php');
    require_once('../../classes/DBAccess.php');

    require_once 'check.php';

    $dbAccess = new DBAccess();
    $id=$_GET['id'];

    if(isset($_POST['submit'])){
        $dbAccess->updateSetting($id,$_POST['period'],$_POST['max_conference']);
        header("location: settings.php");
    }

    $row=$dbAccess->getSetting($id);

?>

<!doctype html>

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
            <h3 style="text-align: center;">Edit Settings</h3>
            <form method="post" action="" name="frm" onsubmit="return editSettings();">
                <table align="center" class="rightform" cellpadding="5">
                    <tr><td>User</td>
                        <td>
                            <select name="user" disabled="disabled">
                            <option value='0'>Select</option>
                            <?php
                            $users=$dbAccess->getAllUsersExceptAdmin();
                            while($row2=mysql_fetch_array($users)){
                                echo "<option value='".$row2['id']."' ";
                                if($row2['id']==$row['user_id']) echo " selected='selected' ";
                                echo " >".$row2['full_name']."</option>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr><td>Period</td>
                        <td>
                            <input  <?php if($row['period']=="0") echo " checked='checked' "; ?> type="radio" name="period" value="0">Weekly
                            <input  <?php if($row['period']=="1") echo " checked='checked' "; ?> type="radio" name="period" value="1">Monthly
                        </td>
                    </tr>

                    <tr><td>Max Conference</td><td><input  value="<?php echo $row['max_conference']; ?>" onkeypress="return isNumberKey(event)" type="text" name="max_conference" size="13" maxlength="3"></td></tr>
                    <tr><td align="center" colspan="2">&nbsp;</td></tr>
                    <tr><td align="center" colspan="2"><input type="submit" name="submit" value="Update" class="Btn"></td></tr>
                </table>
            </form>
            <br>
        </div>
                </div>
            </div>
        <?php require_once '../../assets/main/FooterNew.php'; ?>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
    </body>
    </html>

