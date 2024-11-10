<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NiKa Hotel - Services</title>
    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>
</head>

<body>
    <!-- Header -->
    <?php require ('Inc/header.php')?>

    <!-- Services Section End -->
    <section class="services-section spad">
        <div class="container">
            <div class="breadcrumb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-text">
                                <h2>Our Services</h2>
                                <div class="bt-option">
                                    <a href="index.php">Home</a>
                                    <span>Services</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                    $result = selectAll('services');
                    $path = SERVICES_IMG_PATH;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='col-lg-4 col-sm-6'>
                                <div class='service-item '>
                                    <img src='$path{$row['image']}' width='80px'>
                                    <h4>{$row['service_name']}</h4>
                                    <p>{$row['description']}</p>
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