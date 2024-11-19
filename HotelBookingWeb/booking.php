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
<!-- Room Details Section Begin -->
<section class="room-details-section spad" style="margin-top: 92px">
    <div class="container">
        <?php
            require ('Inc/login_register.php');
            $row = [];
            $khachhang = [];
            $path = ROOMS_IMG_PATH;
            $ma_phong = 0;
            $sodem = 1;
            $sl_phong = 1;
            if(isset($_GET['id'])){
                if(isset($_SESSION['ma_tk_kh'])){
                    $form_data = filteration($_GET);
                    $result = select("SELECT * FROM phong WHERE ma_phong = ?", [$form_data['id']], 'i');
                    $row = mysqli_fetch_assoc($result);
                    $result1 = select("SELECT * FROM taikhoan WHERE ma_tk = ?", [$_SESSION['ma_tk_kh']], "i");
                    $taikhoan = mysqli_fetch_assoc($result1);
                    $result2 = select("SELECT * FROM khachhang WHERE ma_kh = ?", [$taikhoan['ma_nd']], "i");
                    $khachhang = mysqli_fetch_assoc($result2);
                } else {
                    $_SESSION['error'] = "Bạn cần phải đăng nhập!";
                    header("Location: rooms.php"."?id=".$_GET['id']);
                    exit;
                }
            }
            $gia = $row['gia'];

            if(isset($_POST['cap_nhat'])){
                $form_data = filteration($_POST);
                if(empty($form_data['ngay_np'])){
                    alert('error', 'Ngày nhận phòng không được để trống!');
                } else if(empty($form_data['ngay_tp'])) {
                    alert('error', 'Ngày trả phòng không được để trống!');
                } else if(empty($form_data['sl_phong'])) {
                    alert('error', 'Số lượng phòng không được để trống!');
                } else {
                    $hom_nay = new DateTime();
                    if ($form_data['ngay_np'] <= $hom_nay->format('Y-m-d')) {
                        alert('error', 'Ngày nhận phòng phải sau ngày hôm nay!');
                    } else if($form_data['ngay_np'] >= $form_data['ngay_tp']) {
                        alert('error', 'Ngày trả phòng phải sau ngày nhận phòng!');
                    } else if(!filter_var($form_data['sl_phong'], FILTER_VALIDATE_INT) || $form_data['sl_phong'] < 1) {
                        alert('error', 'Số lượng phòng phải là 1 số nguyên > 0 !');
                    } else {
                        $gia = $row['gia'];
                        $sl_phong = $form_data['sl_phong'];
                        $ngay_np = new DateTime($form_data['ngay_np']);
                        $ngay_tp = new DateTime($form_data['ngay_tp']);
                        $hieu = $ngay_tp->diff($ngay_np);
                        $sodem = $hieu->days;
                        $gia = $gia * (int)$sl_phong * $sodem;
                        alert('success', 'Cập nhật giá trị thành công!');
                    }
                }
            }

            if(isset($_POST['dat_ngay'])){
            $form_data = filteration($_POST);
            if(empty($form_data['ngay_np'])){
                $_SESSION['error'] = "Ngày nhận phòng không được để trống!";
            } else if(empty($form_data['ngay_tp'])) {
                $_SESSION['error'] = "Ngày trả phòng không được để trống!";
            } else if(empty($form_data['sl_phong'])) {
                $_SESSION['error'] = "Số lượng phòng không được để trống!";
            } else {
                $hom_nay = new DateTime();
                if ($form_data['ngay_np'] <= $hom_nay->format('Y-m-d')) {
                    $_SESSION['error'] = "Ngày nhận phòng phải sau ngày hôm nay!";
                } else if($form_data['ngay_np'] >= $form_data['ngay_tp']) {
                    $_SESSION['error'] = "Ngày trả phòng phải sau ngày nhận phòng!";
                } else if(!filter_var($form_data['sl_phong'], FILTER_VALIDATE_INT) || $form_data['sl_phong'] < 1) {
                    $_SESSION['error'] = "Số lượng phòng phải là 1 số nguyên > 0 !";
                } else {
                    // Them vao bang datphong
                    $datePart = date('Ymd'); // Phần ngày: "20241117"
                    $randomPart = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 2));
                    $ma_dp = "DP".$datePart.$randomPart;
                    $query1 = "INSERT INTO `datphong` (`ma_dp`, `ma_kh`, `ngay_np`, `ngay_tp`,  `tong_gia`) VALUES (?, ?, ?, ?, ?)";
                    $values1 = [$ma_dp, $khachhang['ma_kh'], $form_data['ngay_np'], $form_data['ngay_tp'], str_replace([",", " VNĐ"], "", $form_data['gia'])];
                    $result1 = insert($query1, $values1, "sissi");
                    // Them vao bang phong_datphong
                    $query2 = "INSERT INTO `phong_datphong`(`ma_phong`, `ma_dp`, `sl_phong`) VALUES (?, ?, ?)";
                    $values2 = [$row['ma_phong'], $ma_dp, $form_data['sl_phong']];
                    $result2 = insert($query2, $values2, "isi");
                    if($result1 && $result2){
                        header('Location: booking_success.php');
                        exit;
                    } else {
                        $_SESSION['error'] = "Có lỗi xảy ra";
                    }
                }
            }
            header('Location: booking.php?id='.$_GET['id']);
            exit;
        }
        ?>
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
                <form method="post">
                    <div class="room-details-item m-0">
                        <div class="rd-text">
                            <div class="mb-3">
                                <label>Họ tên:</label>
                                <input class="custom-input" type="text" value="<?php echo $khachhang['ten_kh']?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label>Số điện thoại:</label>
                                <input class="custom-input" type="text" value="<?php echo $khachhang['so_dien_thoai']?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label>Email:</label>
                                <input class="custom-input" type="text" value="<?php echo $khachhang['email']?>" readonly>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label>Ngày nhận phòng:</label>
                                    <input class="custom-input pe-2" type="date" name="ngay_np" value="<?php if(isset($_POST['ngay_np'])) echo $_POST['ngay_np']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label>Ngày trả phòng:</label>
                                    <input class="custom-input pe-2" type="date" name="ngay_tp" value="<?php if(isset($_POST['ngay_tp'])) echo $_POST['ngay_tp']; ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="row align-items-center col-md-6 m-0">
                                    <label class="col-md-7">Số lượng:</label>
                                    <input class="custom-input col-md-5" type="number" value="<?php echo $sl_phong; ?>" name="sl_phong" maxlength="2" style="text-align: center">
                                </div>
                                <div class="d-flex col-md-6 align-items-center">
                                    <label class="me-2">Thời gian:</label>
                                    <label><?php echo $sodem ?> đêm</label>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="me-2 my-0" style="font-size: 30px">Giá:</label>
                                <input readonly type="text" name="gia" class="m-0" style="font-size: 30px; border: none; " value="<?php echo number_format($gia, 0, '', ',')." VNĐ"?>">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <button type="submit" name="dat_ngay" class="btn col-md-8 shadow-none me-2" style="background-color: #dfa974; color: white">Đặt ngay</button>
                        <button type="submit" name="cap_nhat" class="btn btn-primary col-md-3 shadow-none">Cập nhật</button>
                    </div>
                </form>
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