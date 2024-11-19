<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NiKa Hotel - Phòng</title>
    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>
</head>

<body>
<!-- Header -->
<?php
    require ('Inc/header.php');
    require('Inc/login_register.php');
?>

<!-- Rooms Section Begin -->
<section class="rooms-section spad" style="margin-top: 92px">
    <div class="container">
        <div class="breadcrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-text">
                            <h2>Đề xuất phòng</h2>
                            <div class="bt-option">
                                <a href="index.php">Trang chủ</a>
                                <a href="rooms.php">Phòng</a>
                                <span>Đề xuất phòng</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
<!--            --><?php
//                $query = "SELECT SUM(sl_phong) as sl_phong_hd FROM phong_datphong GROUP BY ma_phong WHERE trang_thai = ?";
//                $result = select($query, [1], "i");
//                $row = mysqli_fetch_assoc($result);
//                $sl_phong_hd =
//            ?>
        </div>
    </div>
</section>
<!-- Rooms Section End -->

<!-- Footer -->
<?php require ('Inc/footer.php')?>

<!-- Javascript - Jquery -->
<?php require('Inc/scripts.php') ?>
</body>

</html>