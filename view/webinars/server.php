<?php
    session_start();
    require_once '../../include/db.php';
    require_once('../../classes/Authorization.php');
    require_once('../../classes/DBAccess.php');

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
        <link rel="stylesheet" type="text/css" href="../../css/Style.css"/>
        <link rel="stylesheet" type="text/css" href="../../css/rhd.css"/>
        <link rel="icon" href="../../favicon.ico" type="image/x-icon" /
        <?php include_once '../../assets/main/tipsy.php'; ?>
        <script type="text/javascript" src="../../js/validation.js"></script>

    </head>
    <body>
        <?php include_once '../../assets/main/HeaderNew.php'; ?>

        <?php include_once '../../assets/main/LeftSideNew.php'; ?>
        <div id="rightform">
            <div class="RightTextCntr">
                <div class="contentCntrTab">
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
                    <div class="internalManuBar" ></div>
                    <div class="internalDataGridBar">
                    <div class="Tmenu_bgBigCatalogue" style="width:97%;">
                        <div class="menuBG1" style="text-align:left; width:10%;">Server Name</div>
                        <div class="menuBG1" style="text-align:left; width:25%;">BBB URL</div>
                        <div class="menuBG1" style="text-align:left; width:25%;">Salt</div>
                        <div class="menuBG1" style="text-align:left; width:13%;">Status</div>
                        <div class="menuBG1" style="text-align:left; width:12%;">Edit</div>
                        <div class="menuBG1" style="text-align:left; width:5%; border:none;">Delete</div>
                    </div>
                    <div id="crDate">
           <?php
                $sl = 1;
                while($row=mysql_fetch_array($result)){
                    $status=array("Passive","Active");
                    if ($sl % 2 == 1) {
                        echo "<div id='pag'>";
                    }else{
                        echo "<div id='pag1'>";
                    }
                    ?>


            <div class='server_name'  ><?php echo $row['name']; ?></div>
                    <div class='bbb_url' ><?php echo $row['url']; ?></div>
                    <div class='salt' ><?php echo $row['salt']; ?></div>
                    <div class='status' ><?php echo $status[$row['status']]; ?></div>
                    <div class='edit' ><a href='editserver.php?id=<?php echo $row['id'];?>'>Edit</a></div>
                    <div class='delete' >
                    <?php
                    if(!$dbAccess->checkServerInUse($row['id'])){
                        echo "<a href='#' onclick='deleteConfirm(".$row['id'].")' >Delete</a>";
                    }else{
                        echo "In Use";
                    }
                    ?>
                </div>
           </div>

                <?php
                    ++$sl;

                } ?>

</div>


                </div>
            </div>
        <?php include_once '../../assets/main/FooterNew.php'; ?>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>

    </body>
    </html>

