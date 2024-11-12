<?php
    require ('Inc/essentials.php');
    session_unset();
    session_destroy();
    redirect("login.php");
?>