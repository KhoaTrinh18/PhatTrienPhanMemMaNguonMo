<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- css - icon - font -->
    <title>NiKa Hotel - Trang chủ</title>
    <?php require ('Inc/links.php')?>
</head>

<body>
    <!-- Header -->
    <?php require ('Inc/header.php')?>
    <div style="margin-top: 92px">
        <?php
            require('Inc/login_register.php');
            if(isset($_POST['kiem_tra'])){
                $form_data = filteration($_POST);
                if(empty($form_data['ngay_np'])){
                    $_SESSION['error'] = "Ngày nhận phòng không được để trống!";
                } else if(empty($form_data['ngay_tp'])){
                    $_SESSION['error'] = "Ngày trả phòng không được để trống!";
                } else if(empty($form_data['sl_nguoi_lon'])){
                    $_SESSION['error'] = "Số lượng người lớn không được để trống!";
                } else if(empty($form_data['sl_tre_em'])){
                    $_SESSION['error'] = "Số lượng trẻ em không được để trống!";
                } else {
                    $ngay_np = DateTime::createFromFormat("d F, Y", $form_data['ngay_np']);
                    $ngay_tp = DateTime::createFromFormat("d F, Y", $form_data['ngay_tp']);
                    $hom_nay = new DateTime();
                    if ($ngay_np->format('y-m-d') <= $hom_nay->format('y-m-d')){
                        $_SESSION['error'] = "Ngày nhận phòng phải sau ngày hôm nay!";
                    } else if($ngay_np->format('y-m-d') >= $ngay_tp->format('y-m-d')) {
                        $_SESSION['error'] = "Ngày trả phòng phải sau ngày nhận phòng!";
                    } else if(!filter_var($form_data['sl_nguoi_lon'], FILTER_VALIDATE_INT) || $form_data['sl_nguoi_lon'] < 1){
                        $_SESSION['error'] = "Số lượng người lớn phải là số nguyên > 0 !";
                    } else if (!filter_var($form_data['sl_tre_em'], FILTER_VALIDATE_INT) || $form_data['sl_tre_em'] < 0){
                        $_SESSION['error'] = "Số lượng trẻ em phải là số nguyên >= 0 !";
                    } else {
                        $_SESSION['ngay_np'] = $ngay_np;
                        $_SESSION['ngay_tp'] = $ngay_tp;
                        $_SESSION['sl_nguoi_lon'] = $form_data['sl_nguoi_lon'];
                        $_SESSION['sl_tre_em'] = $form_data['sl_tre_em'];
                        header("Location: dexuat.php");
                        exit;
                    }
                }
                header("Location: index.php");
                exit;
            }
        ?>
    </div>

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>Nika A Luxury Hotel</h1>
                        <p>Đây là trang web đặt phòng khách sạn tốt nhất, bao gồm các khuyến nghị
                            về du lịch quốc tế và tìm phòng khách sạn giá rẻ.</p>
                        <a href="#" class="primary-btn">Khám phá ngay</a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <h3>Đặt phòng</h3>
                        <form method="post">
                            <div class="check-date">
                                <label>Ngày nhận phòng:</label>
                                <input type="text" name="ngay_np" class="date-input">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="check-date">
                                <label>Ngày trả phòng:</label>
                                <input type="text" name="ngay_tp" class="date-input">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="select-option">
                                <label>Số lượng người lớn:</label>
                                <input type="text" name="sl_nguoi_lon" class="custom-input">
                            </div>
                            <div class="select-option">
                                <label>Số lượng trẻ em:</label>
                                <input type="text" name="sl_tre_em"class="custom-input">
                            </div>
                            <button type="submit" name="kiem_tra">Kiểm tra</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="Public/img/hero/hero-1.jpg"></div>
            <div class="hs-item set-bg" data-setbg="Public/img/hero/hero-2.jpg"></div>
            <div class="hs-item set-bg" data-setbg="Public/img/hero/hero-3.jpg"></div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- About Us Section Begin -->
    <section class="aboutus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-text">
                        <div class="section-title">
                            <span>Về chúng tôi</span>
                            <h2>NiKa Hotel</h2>
                        </div>
                        <p class="f-para">Nika.com là trang web lưu trú trực tuyến hàng đầu.
                            Chúng tôi đam mê du lịch. Mỗi ngày, chúng tôi truyền cảm hứng
                            và tiếp cận hàng triệu du khách trên 90 trang web địa phương bằng 41 ngôn ngữ.</p>
                        <p class="s-para">Vì vậy, khi nói đến việc đặt phòng khách sạn, nhà nghỉ dưỡng, khu nghỉ dưỡng, căn hộ, nhà khách hoặc nhà trên cây hoàn hảo,
                            chúng tôi sẽ giúp bạn.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-pic">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="Public/img/about/about-1.jpg" alt="">
                            </div>
                            <div class="col-sm-6">
                                <img src="Public/img/about/about-2.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section End -->

    <!-- Home Room Section Begin -->
    <section class="hp-room-section">
        <div class="container-fluid">
            <div class="hp-room-items">
                <div class="row">
                    <?php
                    $result = select("SELECT * FROM phong WHERE trang_thai= ? ORDER BY ma_phong DESC", [1], 'i');
                    $path = ROOMS_IMG_PATH;
                    $i = 0;

                    while ($row = mysqli_fetch_assoc($result)) {
                        if($i == 4){
                            break;
                        }
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

                        echo "<div class='col-lg-3 col-md-6'>
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
                        $i++;
                    }
                    ?>

                </div>
            </div>
        </div>
    </section>
    <!-- Home Room Section End -->
    <script>

    </script>
    <!-- Footer -->
    <?php require ('Inc/footer.php')?>

    <!-- Javascript - Jquery -->
    <?php require ('Inc/scripts.php')?>
</body>

</html>