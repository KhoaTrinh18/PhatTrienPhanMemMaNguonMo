<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang chủ</title>

    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>
</head>
<body>
    <div class="container-scroller">
        <!-- Header -->
        <?php require ('Inc/header.php'); ?>
        <div class="container-fluid page-body-wrapper ">
            <?php require ('Inc/sidebar.php')?>
            <div class="container-fluid page-body-wrapper d-flex justify-content-end">
                <?php require ('Inc/sidebar.php')?>
                <div class="main-panel">
                    <div class="content-wrapper">
                        <?php
                        if (isset($_SESSION['success'])) {
                            alert("success", $_SESSION['success']);
                            unset($_SESSION['success']);
                        }

                        if (isset($_SESSION['error'])) {
                            alert("error", $_SESSION['error']);
                            unset($_SESSION['error']);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require ('Inc/scripts.php');?>
</body>