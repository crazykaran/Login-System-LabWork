<?php
    session_start();
    $_SESSION['isLoggedIn' ]=false;
    header("location:https://localhost/demo/login.php");
?>