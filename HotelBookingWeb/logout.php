<?php
    require('Admin/Inc/essentials.php');
    session_unset();
    session_destroy();
    redirect("index.php");
?>