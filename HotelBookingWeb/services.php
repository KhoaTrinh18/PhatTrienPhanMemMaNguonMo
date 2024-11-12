<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NiKa Hotel - Dịch vụ</title>
    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>
</head>

<body>
    <!-- Header -->
    <?php
        require ('Inc/header.php');
        require ('Inc/login.php');
    ?>

    <!-- Services Section End -->
    <section class="services-section spad">
        <div class="container">
            <div class="breadcrumb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-text">
                                <h2>Dịch vụ</h2>
                                <div class="bt-option">
                                    <a href="index.php">Trang chủ</a>
                                    <span>Dịch vụ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                    $result = selectAll('dichvu');
                    $path = SERVICES_IMG_PATH;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='col-lg-4 col-sm-6'>
                                <div class='service-item'>
                                    <img src='$path{$row['anh_dichvu']}' width='80px'>
                                    <h4>{$row['ten_dichvu']}</h4>
                                    <p>{$row['mo_ta']}</p>
                                </div>
                            </div>";
                    }
                ?>
            </div>
        </div>
    </section>
    <!-- Services Section End -->

    <!-- Footer -->
    <?php require ('Inc/footer.php')?>

    <!-- Javascript - Jquery -->
    <?php require('Inc/scripts.php') ?>
</body>

</html>