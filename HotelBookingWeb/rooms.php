<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NiKa Hotel - Rooms</title>
    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>
</head>

<body>
    <!-- Header -->
    <?php require ('Inc/header.php')?>

    <!-- Rooms Section Begin -->
    <section class="rooms-section spad" style="margin-top: 92px">
        <div class="container">
            <div class="breadcrumb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-text">
                                <h2>Our Rooms</h2>
                                <div class="bt-option">
                                    <a href="index.php">Home</a>
                                    <span>Rooms</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                    // Phan trang
                    $rowsPerPage = 6;
                    if (!isset($_GET['page']))
                    {
                        $_GET['page'] = 1;
                    }
                    //vị trí của mẩu tin đầu tiên trên mỗi trang
                    $offset = ($_GET['page'] - 1) * $rowsPerPage;
                    $sql = 'SELECT * FROM rooms WHERE status = 1 LIMIT '.$offset.','.$rowsPerPage;

                    $result = mysqli_query($conn, $sql);
                    $path = ROOMS_IMG_PATH;

                    while ($row = mysqli_fetch_assoc($result)) {
                        //Feature
                        $query1 = "SELECT * FROM rooms_features JOIN features ON features.feature_id = rooms_features.feature_id WHERE room_id = ?";
                        $res_room_fea = select($query1, [$row['room_id']], "i");
                        $feature = "";
                        while($row1 = mysqli_fetch_assoc($res_room_fea)){
                            $feature .= $row1['feature_name'].", ";
                        }
                        $feature = rtrim($feature, ", ");
                        //Service
                        $query2 = "SELECT * FROM rooms_services JOIN services ON services.service_id = rooms_services.service_id WHERE room_id = ?";
                        $res_room_ser = select($query2, [$row['room_id']], "i");
                        $service = "";
                        while($row2 = mysqli_fetch_assoc($res_room_ser)){
                            $service .= $row2['service_name'].", ";
                        }
                        $service = rtrim($service, ", ");

                        echo "<div class='col-lg-4 col-md-6'>
                                <div class='room-item'>
                                <img src='$path{$row['image']}' alt=''>
                                <div class='ri-text'>
                                    <h4>{$row['room_name']}</h4>
                                    <h3>".number_format($row['price'], 0, '', ',')."VNĐ<span>/Pernight</span></h3>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class='r-o'>Area:</td>
                                                <td>{$row['area']} sqm</td>
                                            </tr>
                                            <tr>
                                                <td class='r-o'>Adult:</td>
                                                <td>Max person {$row['adult']}</td>
                                            </tr>
                                            <tr>
                                                <td class='r-o'>Children:</td>
                                                <td>Max person {$row['children']}</td>
                                            </tr>
                                            <tr>
                                                <td class='r-o'>Features:</td>
                                                <td>$feature</td>
                                            </tr>
                                            <tr>
                                                <td class='r-o'>Services:</td>
                                                <td>$service</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class='d-flex justify-content-center align-items-center'>
                                        <a href='#' class='btn btn-success me-3'>Book Now</a>
                                        <a href='room_detail.php?id={$row['room_id']}' class='primary-btn'>More Details</a>
                                    </div>       
                                </div>
                            </div>
                            </div>";
                    }
                ?>
                <div class="col-lg-12">
                    <div class="room-pagination">
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">Next <i class="fa fa-long-arrow-right"></i></a>
                        <a href="#"><i class="fa fa-long-arrow-left"></i> Previous </a>
                    </div>
                </div>
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