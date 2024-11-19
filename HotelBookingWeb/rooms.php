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
    <style>
        .room-pagination a.active{
            background-color: #dfa974;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php
        require ('Inc/header.php');
    ?>

    <!-- Rooms Section Begin -->
    <section class="rooms-section spad" style="margin-top: 92px">
        <div class="container">
            <?php
                require('Inc/login_register.php');

            ?>
            <div class="breadcrumb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-text">
                                <h2>Phòng</h2>
                                <div class="bt-option">
                                    <a href="index.php">Trang chủ</a>
                                    <span>Phòng</span>
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
                    $sql = 'SELECT * FROM phong WHERE trang_thai = 1 ORDER BY ma_phong DESC LIMIT '.$offset.','.$rowsPerPage;

                    $result = mysqli_query($conn, $sql);
                    $path = ROOMS_IMG_PATH;

                    while ($row = mysqli_fetch_assoc($result)) {
                        //Feature
                        $query1 = "SELECT * FROM phong_dacdiem JOIN dacdiem ON dacdiem.ma_dacdiem = phong_dacdiem.ma_dacdiem WHERE ma_phong = ?";
                        $res_room_fea = select($query1, [$row['ma_phong']], "i");
                        $feature = "";
                        while($row1 = mysqli_fetch_assoc($res_room_fea)){
                            $feature .= $row1['ten_dacdiem'].", ";
                        }
                        $feature = rtrim($feature, ", ");
                        //Service
                        $query2 = "SELECT * FROM phong_dichvu JOIN dichvu ON dichvu.ma_dichvu = phong_dichvu.ma_dichvu WHERE ma_phong = ?";
                        $res_room_ser = select($query2, [$row['ma_phong']], "i");
                        $service = "";
                        while($row2 = mysqli_fetch_assoc($res_room_ser)){
                            $service .= $row2['ten_dichvu'].", ";
                        }
                        $service = rtrim($service, ", ");

                        echo "<div class='col-lg-4 col-md-6'>
                                <div class='room-item'>
                                    <img src='$path{$row['anh_phong']}' alt=''>
                                    <div class='ri-text'>
                                        <h4>{$row['ten_phong']}</h4>
                                        <h3>".number_format($row['gia'], 0, '', ',')."VNĐ<span>/Đêm</span></h3>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class='r-o'>Diện tích:</td>
                                                    <td>{$row['dien_tich']}m²</td>
                                                </tr>
                                                <tr>
                                                    <td class='r-o'>Người lớn:</td>
                                                    <td>Số lượng tối đa {$row['sl_nguoi_lon']}</td>
                                                </tr>
                                                <tr>
                                                    <td class='r-o'>Trẻ em:</td>
                                                    <td>Số lượng tối đa {$row['sl_tre_em']}</td>
                                                </tr>
                                                <tr>
                                                    <td class='r-o'>Đặc điểm:</td>
                                                    <td>$feature</td>
                                                </tr>
                                                <tr>
                                                    <td class='r-o'>Dịch vụ:</td>
                                                    <td>$service</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class='d-flex justify-content-center align-items-center'>
                                            <a href='booking.php?id={$row['ma_phong']}' class='btn me-3 shadow-none' style='background-color: #dfa974; color: white'>Đặt phòng</a>
                                            <a href='room_detail.php?id={$row['ma_phong']}' class='primary-btn'>Chi tiết</a>
                                        </div>       
                                    </div>
                                </div>
                            </div>";
                    }
                ?>
                <div class="col-lg-12">
                    <div class="room-pagination">
                        <?php
                            $result = selectAll("phong");
                            $numRows = mysqli_num_rows($result);
                            $maxPage = ceil($numRows / $rowsPerPage);

                            if ($_GET['page'] > 1) {
                                echo "<a href=" . $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] - 1) . "><i class='fa fa-long-arrow-left'></i> Previous</a> ";
                            }

                            if ($_GET['page'] > 3) {
                                echo "<a href=" . $_SERVER['PHP_SELF'] . "?page=1".">"."1 </a> ... ";
                            }

                            for ($i = max(1, $_GET['page'] - 2); $i <= min($maxPage, $_GET['page'] + 2); $i++) {
                                if ($i == $_GET['page']) {
                                    echo "<a class='active'>$i</a> "; // Trang hiện tại
                                } else {
                                    echo "<a href=" . $_SERVER['PHP_SELF'] . "?page=$i".">"."$i</a> ";
                                }
                            }

                            if ($_GET['page'] < $maxPage - 2) {
                                echo "... <a href=" . $_SERVER['PHP_SELF'] . "?page=$maxPage".">."."$maxPage</a> ";
                            }

                            if ($_GET['page'] < $maxPage) {
                                echo "<a href=" . $_SERVER['PHP_SELF'] . "?page=" . ($_GET['page'] + 1) . ">Next <i class='fa fa-long-arrow-right'></i></a>";
                            }
                        ?>
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