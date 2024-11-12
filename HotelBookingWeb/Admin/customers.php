<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Khách hàng</title>

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
                        $form_data = filteration($_GET);
                        // Xoa toan bo khach hang
                        if($form_data['xoa'] == 'all'){
                            $query1 = "DELETE FROM khachhang";
                            $query2 = "DELETE FROM taikhoan where quyen = 'khachhang'";
                            if(mysqli_query($conn, $query1) && mysqli_query($conn, $query2)) {
                                $_SESSION['success'] = "Xóa toàn bộ bản ghi thành công!";
                            }else{
                                $_SESSION['error'] = "Có lỗi xảy ra!";
                            }
                        } else {
                            // Xoa 1 khach hang
                            // Xoa khach hang trong bang khach hang
                            $query1 = "DELETE FROM khachhang WHERE ma_kh = ?";
                            $values = array($form_data['xoa']);
                            $result1 = delete($query1, $values, "i");

                            // Xoa tai khoan khach hang trong bang tai khoan
                            $query2 = "DELETE FROM taikhoan WHERE ma_nd = ? AND quyen = 'khachhang'";
                            $result2 = delete($query2, $values, "i");
                            if($result1 && $result2){
                                $_SESSION['success'] = "Xóa bản ghi thành công!";
                            }else{
                                $_SESSION['error'] = "Có lỗi xảy ra!";
                            }
                        }
                        header("Location: customers.php");
                        exit;
                    }
                    ob_end_flush();
                ?>
                <div class="card text-black">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Khách hàng</h4>
                            <div class="d-flex justify-content-end">
                                <a href="?xoa=all" class="btn btn-danger"><i class="mdi mdi-trash-can mr-2"></i>Xóa hết</a>
                            </div>
                        </div>
                        <table class="table table-hover table-striped table-bordered" id="myTable">
                            <thead class="bg-dark text-light">
                            <tr>
                                <th>#</th>
                                <th>Tên khách hàng</th>
                                <th>Ngày sinh</th>
                                <th>Email</th>
                                <th>Số điện thoaại</th>
                                <th>Địa chỉ</th>
                                <th>Hình ảnh</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $query = "SELECT * FROM khachhang ORDER BY ma_kh DESC";
                                $data = mysqli_query($conn, $query);
                                $path = CUSTOMERS_IMG_PATH;
                                $i = 1;
                                while($row = mysqli_fetch_assoc($data)){
                                    echo "<tr>
                                            <td>$i</td>
                                            <td>{$row['ten_kh']}</td>
                                            <td>{$row['ngay_sinh']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['so_dien_thoai']}</td>
                                            <td class='custom-cell'>{$row['dia_chi']}</td>
                                            <td>
                                                <img src='$path{$row['anh_kh']}' class='rounded mx-auto d-block' width='100px'>
                                            </td>
                                            <td class='d-flex align-items-center justify-content-around'>
                                                <button type='button' class='btn bg-transparent text-primary p-0 shadow-none' data-toggle='modal' data-target='#detailModal{$row['ma_kh']}'>
                                                    <i class='mdi mdi-eye' style='font-size: 23px'></i>
                                                </button>
                                                <!-- Modal Edit cho từng hàng -->
                                                <div class='modal fade' id='detailModal{$row['ma_kh']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content' style='width: 600px'>
                                                            <form method='post'>
                                                                <div class='modal-header'>
                                                                    <h5 class='modal-title d-flex align-items-center'>
                                                                        <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                        <span>Chi tiết khách hàng</span>
                                                                    </h5>
                                                                    <button type='button' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                        <span aria-hidden='true'>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class='modal-body row'>
                                                                    <div class='col-md-6'>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Tên khách hàng</label>
                                                                            <input type='hidden' name='ma_lienhe' value='{$row['ma_kh']}'>
                                                                            <input type='text' class='form-control shadow-none' value='{$row['ten_kh']}' readonly>
                                                                        </div>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Ngày sinh</label>
                                                                            <input type='text' class='form-control shadow-none' value='{$row['ngay_sinh']}' readonly>                                                                                
                                                                        </div>
                                                                         <div class='mb-3'>
                                                                            <label class='form-label'>Email</label>
                                                                            <input type='text' class='form-control shadow-none' value='{$row['email']}' readonly>                                                                                
                                                                         </div>
                                                                    </div>
                                                                    <div class='col-md-6'>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Số điện thoại</label>
                                                                            <input type='text' class='form-control shadow-none' value='{$row['so_dien_thoai']}' readonly>
                                                                        </div>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Địa chỉ</label>
                                                                            <textarea class='form-control shadow-none' rows='5' readonly>{$row['dia_chi']}</textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class='mb-3'>
                                                                            <label class='form-label'>Hình ảnh</label>
                                                                            <img src='$path{$row['anh_kh']}' class='rounded mx-auto d-block' style='width: 200px; height: 200px'>
                                                                    </div>
                                                                    <div class='d-flex align-items-center justify-content-end'>
                                                                        <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Đóng</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href='?xoa={$row['ma_kh']}' class='fa-2x text-danger'><i class='mdi mdi-trash-can'></i></a>
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