<?php
    require ('Inc/essentials.php');
    session_start();
    session_destroy();
    redirect("login.php");
?>