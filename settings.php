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
        <link rel="stylesheet" type="text/css" href="css/Style.css"/>
        <link rel="stylesheet" type="text/css" href="css/rhd.css"/>
        <link rel="icon" href="favicon.ico" type="image/x-icon" /

        <script type="text/javascript" src="js/validation.js"></script>
        <?php include_once 'assets/main/tipsy.php'; ?>
    </head>
    <body>
        <?php include_once 'assets/main/HeaderNew.php'; ?>

        <?php include_once 'assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
            <div class="RightTextCntr">
                <div class="contentCntrTab">
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
                    <div class="internalManuBar" ></div>
                    <div class="internalDataGridBar">
                        <div class="Tmenu_bgBigCatalogue" style="width:97%;">
                            <div class="menuBG1" style="text-align:left; width:44%;">User</div>
                            <div class="menuBG1" style="text-align:left; width:13%;">Period</div>
                            <div class="menuBG1" style="text-align:left; width:15%;">Max Conference</div>
                           <div class="menuBG1" style="text-align:left; width:11%;">Edit</div>
                            <div class="menuBG1" style="text-align:left; width:5%; border:none;">Delete</div>
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


                            <div class='user'  ><?php echo $row['full_name']; ?></div>
                            <div class='period' ><?php echo $period[$row['period']]; ?></div>
                            <div class='max_conf' ><?php echo $row['max_conference']; ?></div>
                            <div class='edit' ><a href='editSettings.php?id=<?php echo $row['id'];?>'>Edit</a></div>
                            <div class='delete' >
                                <a href='#' onclick='deleteSettings("<?php echo $row['id'];?>")' >Delete</a>
                            </div>
                        </div>

                        <?php
                        ++$sl;

                        } ?>

                    </div>
        </div>
                </div>
            </div>
        <?php include_once 'assets/main/FooterNew.php'; ?>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
    </body>
    </html>

