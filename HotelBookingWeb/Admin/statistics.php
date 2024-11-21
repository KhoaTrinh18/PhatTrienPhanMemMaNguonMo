<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang chủ</title>

    <!-- Include CSS, Icon, and Font -->
    <?php require('Inc/links.php'); ?>

    <style>
        .btn.active {
            background: cornflowerblue;
            color: white;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    <!-- Header -->
    <?php require('Inc/header.php'); ?>

    <div class="container-fluid page-body-wrapper d-flex justify-content-end">
        <!-- Sidebar -->
        <?php require('Inc/sidebar.php'); ?>

        <div class="main-panel">
            <div class="content-wrapper">
                <!-- Flash messages -->
                <?php
                    if (isset($_SESSION['success'])) {
                        alert("success", $_SESSION['success']);
                        unset($_SESSION['success']);
                    }

                    if (isset($_SESSION['error'])) {
                        alert("error", $_SESSION['error']);
                        unset($_SESSION['error']);
                    }

                    $row1 = [];
                    $row2 = [];
                    $row3 = [];
                    $row4 = [];

                    if(isset($_GET['songay'])){
                        $form_data = filteration($_GET);
                        if($form_data['songay'] == "7ngay"){
                            //Tong don dat phong
                            $query1 = "SELECT COUNT(ma_dp) AS tongdon, SUM(tong_gia) AS tonggia FROM datphong
                                    WHERE ngay_dat_phong >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                            $result1 = mysqli_query($conn, $query1);
                            $row1 = mysqli_fetch_array($result1);
                            //Tong don dat phong da xac nhan
                            $query2 = "SELECT COUNT(datphong.ma_dp) AS tongdon, SUM(tong_gia) AS tonggia FROM datphong
                                    JOIN phong_datphong ON phong_datphong.ma_dp = datphong.ma_dp
                                    WHERE ngay_dat_phong >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND trang_thai = 1";
                            $result2 = mysqli_query($conn, $query2);
                            $row2 = mysqli_fetch_array($result2);
                            //Tong don dat phong da huy
                            $query3 = "SELECT COUNT(datphong.ma_dp) AS tongdon, SUM(tong_gia) AS tonggia FROM datphong
                                    JOIN phong_datphong ON phong_datphong.ma_dp = datphong.ma_dp
                                    WHERE ngay_dat_phong >= DATE_SUB(NOW(), INTERVAL 7 DAY) AND trang_thai = -1";
                            $result3 = mysqli_query($conn, $query3);
                            $row3 = mysqli_fetch_array($result3);
                            //Lien he khach hang
                            $query4 = "SELECT COUNT(ma_lienhe) AS tong_lh FROM lienhe WHERE ngay >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                            $result4 = mysqli_query($conn, $query4);
                            $row4 = mysqli_fetch_array($result4);
                        } else if($form_data['songay'] == "1thang"){
                            //Tong don dat phong
                            $query1 = "SELECT COUNT(ma_dp) AS tongdon, SUM(tong_gia) AS tonggia FROM datphong
                                    WHERE ngay_dat_phong >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
                            $result1 = mysqli_query($conn, $query1);
                            $row1 = mysqli_fetch_array($result1);
                            //Tong don dat phong da xac nhan
                            $query2 = "SELECT COUNT(datphong.ma_dp) AS tongdon, SUM(tong_gia) AS tonggia FROM datphong
                                    JOIN phong_datphong ON phong_datphong.ma_dp = datphong.ma_dp
                                    WHERE ngay_dat_phong >= DATE_SUB(NOW(), INTERVAL 1 MONTH) AND trang_thai = 1";
                            $result2 = mysqli_query($conn, $query2);
                            $row2 = mysqli_fetch_array($result2);
                            //Tong don dat phong da huy
                            $query3 = "SELECT COUNT(datphong.ma_dp) AS tongdon, SUM(tong_gia) AS tonggia FROM datphong
                                    JOIN phong_datphong ON phong_datphong.ma_dp = datphong.ma_dp
                                    WHERE ngay_dat_phong >= DATE_SUB(NOW(), INTERVAL 1 MONTH) AND trang_thai = -1";
                            $result3 = mysqli_query($conn, $query3);
                            $row3 = mysqli_fetch_array($result3);
                            //Lien he khach hang
                            $query4 = "SELECT COUNT(ma_lienhe) AS tong_lh FROM lienhe WHERE ngay >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
                            $result4 = mysqli_query($conn, $query4);
                            $row4 = mysqli_fetch_array($result4);
                        } else {
                            //Tong don dat phong
                            $query1 = "SELECT COUNT(ma_dp) AS tongdon, SUM(tong_gia) AS tonggia FROM datphong
                                    WHERE ngay_dat_phong >= DATE_SUB(NOW(), INTERVAL 3 MONTH)";
                            $result1 = mysqli_query($conn, $query1);
                            $row1 = mysqli_fetch_array($result1);
                            //Tong don dat phong da xac nhan
                            $query2 = "SELECT COUNT(datphong.ma_dp) AS tongdon, SUM(tong_gia) AS tonggia FROM datphong
                                    JOIN phong_datphong ON phong_datphong.ma_dp = datphong.ma_dp
                                    WHERE ngay_dat_phong >= DATE_SUB(NOW(), INTERVAL 3 MONTH) AND trang_thai = 1";
                            $result2 = mysqli_query($conn, $query2);
                            $row2 = mysqli_fetch_array($result2);
                            //Tong don dat phong da huy
                            $query3 = "SELECT COUNT(datphong.ma_dp) AS tongdon, SUM(tong_gia) AS tonggia FROM datphong
                                    JOIN phong_datphong ON phong_datphong.ma_dp = datphong.ma_dp
                                    WHERE ngay_dat_phong >= DATE_SUB(NOW(), INTERVAL 3 MONTH) AND trang_thai = -1";
                            $result3 = mysqli_query($conn, $query3);
                            $row3 = mysqli_fetch_array($result3);
                            //Lien he khach hang
                            $query4 = "SELECT COUNT(ma_lienhe) AS tong_lh FROM lienhe WHERE ngay >= DATE_SUB(NOW(), INTERVAL 3 MONTH)";
                            $result4 = mysqli_query($conn, $query4);
                            $row4 = mysqli_fetch_array($result4);
                        }
                    }
                ?>

                <!-- Thống kê -->
                <div class="d-flex justify-content-between align-items-center mb-4 daybox">
                    <h3>Thống kê</h3>
                    <div class="btn-group" role="group" aria-label="Thống kê thời gian">
                        <a href="?songay=7ngay" class="btn shadow-none">7 Ngày</a>
                        <a href="?songay=1thang" class="btn shadow-none">1 Tháng</a>
                        <a href="?songay=3thang" class="btn shadow-none">3 Tháng</a>
                    </div>
                </div>

                <div class="row">
                    <!-- Card Tổng đơn đặt phòng -->
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="mb-2 text-dark font-weight-normal">Tổng đơn đặt phòng</h5>
                                <h2 class="mb-4 text-success font-weight-bold"><?php echo $row1['tongdon']?></h2>
                                <h3 class="mb-4 text-success font-weight-bold"><?php echo number_format($row1['tonggia'], 0, '', ',')." VNĐ"?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Card Đơn đã xác nhận -->
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="mb-2 text-dark font-weight-normal">Đơn đặt phòng đã xác nhận</h5>
                                <h2 class="mb-4 text-primary font-weight-bold"><?php echo $row2['tongdon']?></h2>
                                <h3 class="mb-4 text-primary font-weight-bold"><?php echo number_format($row2['tonggia'], 0, '', ',')." VNĐ"?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Card Đơn đã hủy -->
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="mb-2 text-dark font-weight-normal">Đơn đặt phòng đã hủy</h5>
                                <h2 class="mb-4 text-danger font-weight-bold"><?php echo $row3['tongdon']?></h2>
                                <h3 class="mb-4 text-danger font-weight-bold"><?php echo number_format($row3['tonggia'], 0, '', ',')." VNĐ"?></h3>
                            </div>
                        </div>
                    </div>

                    <!-- Card Khách hàng liên hệ -->
                    <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="mb-2 text-dark font-weight-normal">Khách hàng liên hệ</h5>
                                <h2 class="mb-4 text-warning font-weight-bold"><?php echo $row4['tong_lh']?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include JavaScript -->
<?php require('Inc/scripts.php'); ?>

<!-- Thêm JavaScript để vẽ biểu đồ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const currentUrl = window.location.href;
        const navItems = document.querySelectorAll(".daybox div a");

        navItems.forEach(link => {
            if (currentUrl.includes(link.getAttribute("href"))) {
                link.classList.add("active");
            } else {
                link.classList.remove("active");
            }
        });
    });
</script>
</body>
</html>
