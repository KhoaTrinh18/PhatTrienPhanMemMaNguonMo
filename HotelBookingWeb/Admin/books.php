<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Đơn mới nhận</title>

    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>
</head>
<body>
<div class="container-scroller">
    <!-- Header -->
    <?php require ('Inc/header.php'); ?>

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

                    if(isset($_POST['xac_nhan'])){
                        $ngay_hn = new DateTime();
                        $taikhoan = mysqli_fetch_assoc(select("SELECT * FROM taikhoan WHERE ma_tk = ?", [$_SESSION['ma_tk_nv']], "i"));
                        $result1 = update("UPDATE `phong_datphong` SET `trang_thai`= 1 WHERE ma_dp = ?", [$_POST['ma_dp']], "s");
                        $result2 = update("UPDATE `datphong` SET `ma_nv` = ?, `ngay_xac_nhan` = ? WHERE ma_dp = ?", [$taikhoan['ma_nd'], $ngay_hn->format('Y-m-d'), $_POST['ma_dp']], "iss");
                        $result3 = select("SELECT * FROM datphong WHERE ma_dp = ?", [$_POST['ma_dp']], "s");
                        $row = mysqli_fetch_assoc($result3);
                        $khachhang = mysqli_fetch_assoc(select("SELECT * FROM khachhang WHERE ma_kh = ?", [$row['ma_kh']], "i"));
                        if($result1 && $result2){
                            sendMail($khachhang['email'], $khachhang['ten_kh'], "Đặt phòng thành công", "Bạn đã đặt phòng thành công! Vui lòng thanh toán khi nhận phòng tại khách sạn!");
                            $_SESSION['success'] = "Xác nhận đơn phòng thành công!";
                        } else {
                            $_SESSION['error'] = "Có lỗi xảy ra!";
                        }
                        header('Location: books.php');
                        exit;
                    }

                    if(isset($_POST['huy_don'])){
                        $ngay_hn = new DateTime();
                        $taikhoan = mysqli_fetch_assoc(select("SELECT * FROM taikhoan WHERE ma_tk = ?", [$_SESSION['ma_tk_nv']], "i"));
                        $result1 = update("UPDATE `phong_datphong` SET `trang_thai`= -1 WHERE ma_dp = ?", [$_POST['ma_dp']], "s");
                        $result2 = update("UPDATE `datphong` SET `ma_nv` = ? , `ngay_xac_nhan` = ?  WHERE ma_dp = ?", [$taikhoan['ma_nd'], $ngay_hn->format("Y-m-d"), $_POST['ma_dp']], "iss");
                        $result3 = select("SELECT * FROM datphong WHERE ma_dp = ?", [$_POST['ma_dp']], "s");
                        $row = mysqli_fetch_assoc($result3);
                        $khachhang = mysqli_fetch_assoc(select("SELECT * FROM khachhang WHERE ma_kh = ?", [$row['ma_kh']], "i"));
                        if($result1 && $result2){
                            sendMail($khachhang['email'], $khachhang['ten_kh'], "Hủy đặt phòng", "Chúng tôi đã hủy đơn đặt phòng của bạn vì không đáp ứng đủ yêu cầu của chúng tôi!");
                            $_SESSION['success'] = "Hủy đơn phòng thành công!";
                        } else {
                            $_SESSION['error'] = "Có lỗi xảy ra!";
                        }
                        header('Location: books.php');
                        exit;
                    }
                    ob_end_flush();
                ?>
                <div class="card text-black mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Đơn mới nhận</h4>
                        </div>
                        <table class="table table1 table-hover table-striped table-bordered" id="myTable1">
                            <thead class="bg-dark text-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Mã đặt phòng</th>
                                <th>Tên khách hàng</th>
                                <th>Ngày nhận phòng</th>
                                <th>Ngày trả phòng</th>
                                <th>Tổng tiền</th>
                                <th width="5%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $query = "SELECT * FROM datphong JOIN phong_datphong ON datphong.ma_dp = phong_datphong.ma_dp WHERE trang_thai = 0 ORDER BY datphong.ma_dp DESC";
                                $data = mysqli_query($conn, $query);
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($data)) {
                                    $result1 = select("SELECT * FROM khachhang WHERE ma_kh = ?", [$row['ma_kh']], "i");
                                    $khachhang = mysqli_fetch_assoc($result1);
                                    $result2 = select("SELECT * FROM phong_datphong WHERE ma_dp = ?", [$row['ma_dp']], "s");
                                    $rooms = "";
                                    $ngay_np = new DateTime($row['ngay_np']);
                                    $ngay_tp = new DateTime($row['ngay_tp']);
                                    $ngay_hn = new DateTime();
                                    $hieu1 = $ngay_tp->diff($ngay_np);
                                    $hieu2 = $ngay_np->diff($ngay_hn);
                                    if($row['ngay_np'] <= $ngay_hn->format('Y-m-d')) {
                                        $sodem = "<span class='text-warning'>Hết hạn</span>";;
                                        $time_hethan = "<span class='text-warning'>Hết hạn</span>";
                                    } else {
                                        $sodem = $hieu1->days." đêm";
                                        $time_hethan = $hieu2->days." ngày";
                                    }
                                    while ($row1 = mysqli_fetch_assoc($result2)) {
                                        $result1 = select("SELECT * FROM phong WHERE ma_phong = ?", [$row1['ma_phong']], "i");
                                        $room = mysqli_fetch_assoc($result1);
                                        $rooms .="<li class='list-group-item d-flex justify-content-between align-items-start'>
                                                    <div class='ms-2 me-auto'>
                                                        <div class='fw-bold'>{$room['ten_phong']}</div>
                                                        Người lớn: {$room['sl_nguoi_lon']}, Trẻ em: {$room['sl_tre_em']}
                                                    </div>
                                                    <span class='badge bg-primary rounded-pill'>{$row1['sl_phong']}</span>
                                                </li>";
                                    }
                                    echo "<tr>
                                            <td>$i</td>
                                            <td>{$row['ma_dp']}</td>             
                                            <td>{$khachhang['ten_kh']}</td>                     
                                            <td>{$row['ngay_np']}</td>                     
                                            <td>{$row['ngay_tp']}</td>                     
                                            <td>".number_format($row['tong_gia'], 0, '', ',')." VNĐ</td>                   
                                            <td class='d-flex justify-content-center align-items-center'>
                                                <button type='button' class='btn bg-transparent text-primary p-0 shadow-none' data-toggle='modal' data-target='#detailModal{$row['ma_dp']}'>
                                                    <i class='mdi mdi-eye' style='font-size: 23px'></i>
                                                </button>
                                                <!-- Modal Edit cho từng hàng -->
                                                <div class='modal fade' id='detailModal{$row['ma_dp']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content' style='width: 600px'>
                                                            <form method='post'>
                                                                <div class='modal-header'>
                                                                    <h5 class='modal-title d-flex align-items-center'>
                                                                        <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                        <span>Chi tiết đơn đặt phòng</span>
                                                                    </h5>
                                                                    <button type='button' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                        <span aria-hidden='true'>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class='modal-body row'>
                                                                    <div class='mb-3 col-md-6'>
                                                                        <label class='form-label'>Tên khách hàng</label>
                                                                        <input type='hidden' name='ma_dp' value='{$row['ma_dp']}'>
                                                                        <input type='text' class='form-control shadow-none bg-white' value='{$khachhang['ten_kh']}' readonly>
                                                                    </div>
                                                                    <div class='mb-3 col-md-6'>
                                                                        <label class='form-label'>Số điện thoại</label>
                                                                        <input type='text' class='form-control shadow-none bg-white' value='{$khachhang['so_dien_thoai']}' readonly>                                                                                
                                                                    </div>
                                                                     <div class='mb-3 col-md-6'>
                                                                        <label class='form-label'>Ngày nhận phòng</label>
                                                                        <input type='text' class='form-control shadow-none bg-white' value='{$row['ngay_np']}' readonly>
                                                                    </div>
                                                                     <div class='mb-3 col-md-6'>
                                                                        <label class='form-label'>Ngày trả phòng</label>
                                                                        <input type='text' class='form-control shadow-none bg-white' value='{$row['ngay_tp']}' readonly>
                                                                    </div>
                                                                    <div class='mb-3 col-md-12'>
                                                                        <label class='form-label'>Danh sách phòng</label>
                                                                        <ol class='list-group list-group-numbered'>
                                                                            ".$rooms."
                                                                        </ol>
                                                                    </div>
                                                                    <div class='mb-3'>
                                                                        <div style='width: 240px'>
                                                                             <p class='m-0' style='font-size: 15px'>Thời gian: $sodem</p>
                                                                        </div>
                                                                    </div>
                                                                     <div class='mb-3'>
                                                                        <div style='width: 240px'>
                                                                            <p class='m-0' style='font-size: 15px'>Thời gian còn lại: $time_hethan</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class='mb-3'>
                                                                        <div style='width: 240px'>
                                                                            <p class='m-0' style='font-size: 25px'>Tổng giá: ".number_format($row['tong_gia'], 0, '', ',')." VNĐ</p>
                                                                        </div>                                                                       
                                                                    </div>
                                                                    </div>
                                                                    <div class='d-flex align-items-center justify-content-end mb-3'>
                                                                        <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Đóng</button>
                                                                        <button type='submit' name='huy_don' class='btn btn-danger mr-2'>Hủy đơn</button>
                                                                        ".($time_hethan == "<span class='text-warning'>Hết hạn</span>" ? "" : "<button type='submit' name='xac_nhan' class='btn btn-success mr-2'>Xác nhận</button>")."
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                          </tr>";
                                    $i++;
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ('Inc/scripts.php');?>
</body>