<?php
    session_start();
    include 'include/config.php';
    require_once('classes/Login.php');
    require_once('classes/EncryptDecrypt.php');
    require_once('classes/Authorization.php');

    $auth_right = new Authorization();
    if(!$auth_right->checkAccessRight()) {
        header('Location: index.php');
    }    
?>

<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8" /> 
        <title>Conference</title>

        <link rel="stylesheet" type="text/css" href="css/Style.css"/>
        <link rel="icon" href="favicon.ico" type="image/x-icon" /
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.alerts.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/rhd.css"/>  

        <script type="text/javascript" src="js/jquery-1.7.2.js"></script>
        <script type="text/javascript" src="js/jquery.ui.draggable.js" ></script>    
        <script type="text/javascript" src="js/jquery.alerts.js"></script>
        <script type="text/javascript" src="js/jquery-1.8.3.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script>      
        <script type="text/javascript" src='js/jquery.simplemodal.js'></script>
        <script type="text/javascript" src='assets/Catalogue/js/Catalogue.js'></script>
        <script type="text/javascript" src="js/LoginFields.js"></script>


        <script type="text/javascript">
            function changeHashOnLoad() {
                window.location.href += "#";
                setTimeout("changeHashAgain()", "50");
            }

            function changeHashAgain() {
                window.location.href += "1";
            }

            var storedHash = window.location.hash;
            window.setInterval(function() { 
                if (window.location.hash != storedHash) { window.location.hash = storedHash; } }, 50);

        </script>

        <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.tipsy.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#north').tipsy({fade: true});
                $('#north1').tipsy({fade: true});
                $('#north2').tipsy({fade: true});
                $('#north3').tipsy({fade: true});
                $('#north4').tipsy({fade: true});
                $('#north5').tipsy({fade: true});
                $('#north6').tipsy({fade: true});
                $('#east').tipsy({gravity: 'e'});
                $('#east1').tipsy({gravity: 'e'});
                $('#north7').tipsy({fade: true});
                $('#north8').tipsy({fade: true});
                $('#north9').tipsy({fade: true});
                $('#north10').tipsy({fade: true});
                $('#north11').tipsy({fade: true});
                $('#north12').tipsy({fade: true});
                $('#north13').tipsy({fade: true});
                $('#north14').tipsy({fade: true});
            });
        </script>

    </head>
    <?php

        if (!isset($_COOKIE['user_name'])) {

            // header('Location: authentication.php');
            // exit();
        } else {
            //setcookie("user_name", "", time() - 3600);
        }

    ?>
    <body onLoad="changeHashOnLoad();" >
        <?php include_once 'assets/main/HeaderNew.php'; ?>

        <?php include_once 'assets/main/LeftSideNew.php'; ?>
        <?php include_once 'assets/main/RightSideNew.php'; ?>
        <?php include_once 'assets/main/FooterNew.php'; ?>
        <form name="refreshForm">
            <input type="hidden" name="visited" value="" />
        </form>
    </body>
    </html>

