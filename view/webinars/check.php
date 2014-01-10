<?php
    if(!isset($_SESSION['email']) || $_SESSION['user_type'] != "admin"){
        header("location: ../../index.php");
    }
?>