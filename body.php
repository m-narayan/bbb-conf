<?php
    session_start();
    if($_GET['pages']=="LND") {
        header("Location: assets/LandingPage/LandingPage.php");
    }
?>