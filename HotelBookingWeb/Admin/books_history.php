<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lịch sử</title>

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

                    if(isset($_GET['xoa'])){
                        $result1 = delete("DELETE FROM `phong_datphong` WHERE `ma_dp` = ?", [$_GET['xoa']], "s");
                        $result2 = delete("DELETE FROM `datphong` WHERE `ma_dp` = ?", [$_GET['xoa']], "s");
                        if($result1 && $result2){
                            $_SESSION['success'] = "Xóa đơn đặt phòng thành công!";
                        } else {
                            $_SESSION['error'] = "Có lỗi xảy ra";
                        }
                        header('Location: books_history.php');
                        exit;
                    }
                    ob_end_flush();
                ?>
                <div class="card text-black mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Lịch sử</h4>
                        </div>
                        <table class="table table1 table-hover table-striped table-bordered" id="myTable1">
                            <thead class="bg-dark text-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Mã đặt phòng</th>
                                <th>Tên khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Nhân viên xác nhận</th>
                                <th>Ngày xác nhận</th>
                                <th>Trạng thái</th>
                                <th width="5%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $query = "SELECT * FROM datphong JOIN phong_datphong ON datphong.ma_dp = phong_datphong.ma_dp WHERE trang_thai != 0 ORDER BY datphong.ma_dp DESC";
                                $data = mysqli_query($conn, $query);
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($data)) {
                                    $result1 = select("SELECT * FROM khachhang WHERE ma_kh = ?", [$row['ma_kh']], "i");
                                    $khachhang = mysqli_fetch_assoc($result1);
                                    $result2 = select("SELECT * FROM nhanvien WHERE ma_nv = ?", [$row['ma_nv']], "i");
                                    $nhanvien = mysqli_fetch_assoc($result2);
                                    $result = select("SELECT * FROM phong_datphong WHERE ma_dp = ?", [$row['ma_dp']], "s");
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
                                    while ($row1 = mysqli_fetch_assoc($result)) {
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
                                            <td>".number_format($row['tong_gia'], 0, '', ',')." VNĐ</td>                   
                                            <td>{$nhanvien['ten_nv']}</td>                   
                                            <td>{$row['ngay_xac_nhan']}</td>                   
                                            <td>".($row['trang_thai'] == 1 ? "<span class='text-success'>Đã xác nhận</span>" : "<span class='text-danger'>Đã hủy</span>")."</td>
                                            <td class='d-flex justify-content-center align-items-center'>
                                                <button type='button' class='btn bg-transparent text-primary p-0 shadow-none me-2' data-toggle='modal' data-target='#detailModal{$row['ma_dp']}'>
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
                                                                        <label class='form-label'>Tên nhân viên</label>
                                                                        <input type='hidden' name='ma_dp' value='{$row['ma_dp']}'>
                                                                        <input type='text' class='form-control shadow-none bg-white' value='{$nhanvien['ten_nv']}' readonly>
                                                                    </div>
                                                                    <div class='mb-3 col-md-6'>
                                                                        <label class='form-label'>Ngày xác nhận</label>
                                                                        <input type='text' class='form-control shadow-none bg-white' value='{$row['ngay_xac_nhan']}' readonly>
                                                                    </div>
                                                                    <div class='mb-3 col-md-6'>
                                                                        <label class='form-label'>Tên khách hàng</label>
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
                                                                        <a href='?xoa={$row['ma_dp']}' class='btn btn-danger mr-2'>Xóa</a>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href='?xoa={$row['ma_dp']}' class='fa-2x text-danger'><i class='mdi mdi-trash-can'></i></a>
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