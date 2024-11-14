<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NiKa Hotel - Chi tiết phòng</title>
    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>
</head>

<body>
    <!-- Header -->
    <?php require ('Inc/header.php'); ?>
    <div style="margin-top: 92px">
    <?php
        $row = [];
        $path = ROOMS_IMG_PATH;
        $feature = "";
        $service = "";
        if(isset($_GET['id'])){
            $form_data = filteration($_GET);
            $result = select("SELECT * FROM phong WHERE ma_phong = ?", [$form_data['id']], 'i');
            $row = mysqli_fetch_assoc($result);
            //Feature
            $query1 = "SELECT * FROM phong_dacdiem JOIN dacdiem ON dacdiem.ma_dacdiem = phong_dacdiem.ma_dacdiem WHERE ma_phong = ?";
            $res_room_fea = select($query1, [$row['ma_phong']], "i");
            while($row1 = mysqli_fetch_assoc($res_room_fea)){
                $feature .= $row1['ten_dacdiem'].", ";
            }
            $feature = rtrim($feature, ", ");
            //Service
            $query2 = "SELECT * FROM phong_dichvu JOIN dichvu ON dichvu.ma_dichvu = phong_dichvu.ma_dichvu WHERE ma_phong = ?";
            $res_room_ser = select($query2, [$row['ma_phong']], "i");
            while($row2 = mysqli_fetch_assoc($res_room_ser)){
                $service .= $row2['ten_dichvu'].", ";
            }
            $service = rtrim($service, ", ");
        }
        ?>
    </div>
    <?php require('Inc/login_register.php'); ?>
    <!-- Room Details Section Begin -->
    <section class="room-details-section spad" style="margin-top: 92px">
        <div class="container">
            <div class="breadcrumb-section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcrumb-text">
                                <h2><?php echo $row['ten_phong']?></h2>
                                <div class="bt-option">
                                    <a href="index.php">Trang chủ</a>
                                    <a href="rooms.php">Phòng</a>
                                    <span><?php echo $row['ten_phong']?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="room-details-item">
                        <img src="<?php echo $path.$row['anh_phong']?>" width="100%" class="m-0">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="room-details-item m-0">
                        <div class="rd-text">
                            <h2><?php echo number_format($row['gia'], 0, '', ',')."VNĐ"?><span>/Đêm</span></h2>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="r-o">Diện tích:</td>
                                    <td><?php echo $row['dien_tich']?>m²</td>
                                </tr>
                                <tr>
                                    <td class="r-o">Người lớn:</td>
                                    <td>Số lượng tối đa <?php echo $row['sl_nguoi_lon']?></td>
                                </tr>
                                <tr>
                                    <td class="r-o">Trẻ em:</td>
                                    <td>Số lượng tối đa <?php echo $row['sl_tre_em']?></td>
                                </tr>
                                <tr>
                                    <td class="r-o">Đặc điểm:</td>
                                    <td><?php echo $feature?></td>
                                </tr>
                                <tr>
                                    <td class="r-o">Dịch vụ:</td>
                                    <td><?php echo $service?></td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="rd-text">
                                <p class="f-para m-0">Motorhome or Trailer that is the question for you. Here are some of the
                                    advantages and disadvantages of both, so you will be confident when purchasing an RV.
                                    When comparing Rvs, a motorhome or a travel trailer, should you buy a motorhome or fifth
                                    wheeler?</p>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-success mt-4 w-100">Book Now</a>
                </div>
            </div

        </div>
    </section>
    <!-- Room Details Section End -->

    <!-- Footer -->
    <?php require ('Inc/footer.php')?>

    <!-- Javascript - Jquery -->
    <?php require('Inc/scripts.php') ?>
</body>

</html>