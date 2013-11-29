<?php
    session_start();
    include 'include/config.php';
    include 'include/db.php';
    require_once('classes/Login.php');
    require_once('classes/EncryptDecrypt.php');
    require_once('classes/Authorization.php');
    require_once('classes/DBAccess.php');

    if(isset($_GET['logout'])) {
        session_destroy();
        header('Location: index.php');
    }

    $dbAccess= new DBAccess();

    $auth_right = new Authorization();
    if($auth_right->checkAccessRight()){ 
        header('Location: body.php?pages=LND');
    }
    else {

        $login = new Login();
        $email = "";
        //$client_session="";
        $fe = 0;
        if(isset($_POST['submit'])) { 
            $fe = $login->checkFieldEmpty($_POST['nametxt'],$_POST['passtxt']);
            if($fe==1) {
                // Unsuccessful in Login
            }
            else {
                $reply_json = $login->authenticateUser($_POST['nametxt'],$_POST['passtxt']);
                if(isset($reply_json->user_email)){
                    $dbAccess= new DBAccess();
                    $dbAccess->createOrUpdateUser($_POST['nametxt'],$_POST['passtxt'],$reply_json->user_email,$reply_json->user_name);
                }
                if($dbAccess->checkUser($_POST['nametxt'],$_POST['passtxt'])==1){
                    $row=$dbAccess->getUser($_POST['nametxt'],$_POST['passtxt']);
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['name'] = $row['login'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['owner_id'] = $row['id'];
                    $_SESSION['user_type'] = $row['user_type'];
                    header('Location: body.php?pages=LND');
                }
            }
        }           
    ?>
    <!doctype html>
    <html lang="en">
        <head>
            <script type = "text/javascript" >
                function disableBackButton() { 
                    window.history.forward();
                }
                setTimeout("disableBackButton()", 0);
            </script>
            <meta charset="utf-8" />
            <title>PCI - Supply Management System - Login</title>
            <link rel="stylesheet" type="text/css" href="css/Login.css"/>
            
            <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
            <script type="text/javascript" src="js/login.js"></script>

        </head>
        <body>

            <div id="container">

            <div id="top">
                <div id="logo">
                </div>
                <div id="TextHeader">
                    Cash flow improvement specialists for healthcare providers
                    <br/>
                    <br/>
                </div>
                <div id="rs">
                    <?php if($fe == 1){
                        ?>
                        User Name and Password Required
                        <?php
                        }
                    ?>
                    <?php if($email == "" && isset($_POST['submit'])){
                        ?>
                        Authentication Failed
                        <?php
                        }
                    ?>
                </div>
            </div>
            <div style="height: 60px"><h3>Login</h3>
                <div id="Scedular_Bck_gr" style="width:390px;">
                    <div style="background-color: #2690cc;height:30px;"></div>
                    <div style="background-color: #2086c4;height: 30px;"></div>
                </div>
            </div>
            <div id="login">
                <form method="POST" action="index.php">
                    <table border="0">
                        <tr>
                            <td style="padding-bottom: 10px"><span>User Name</span></td>
                            <td style="padding-left: 16px;padding-bottom: 10px"><div class="roundText">
                                    <input autocomplete="off"  type="text" id="nametxt" class="txtField" name="nametxt" value="" /></div></td>
                        </tr>
                        <tr>
                            <td><span>Password</span></td>
                            <td style="padding-left: 16px"><div class="roundText">
                                <input autocomplete="off" type="password" id="passtxt" class="txtField" name="passtxt" value="" />
                            </div>
                        </tr>
                        <tr><td></td>
                            <td> <div id="btncont">
                                    <input type="submit" id="btn" value="Login" class="Lbutton orange" name="submit" />
                                </div>
                            </td>
                        </tr>
                    </table>
                </form> 
            </div>
        </body>
    </html>
    <?php
    }
?>