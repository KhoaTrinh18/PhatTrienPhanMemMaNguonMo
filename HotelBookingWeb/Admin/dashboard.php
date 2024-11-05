<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Connect Plus</title>

    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>
</head>
<body>
    <div class="container-scroller">
        <!-- Header -->
        <?php
        require ('Inc/header.php');
        adminLogin();
        ?>
        <div class="container-fluid page-body-wrapper ">
            <?php require ('Inc/sidebar.php')?>
        </div>
    </div>

    <?php require ('Inc/scripts.php');?>
</body>