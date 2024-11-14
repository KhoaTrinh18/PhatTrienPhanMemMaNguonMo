<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tài khoản</title>

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

                    if(isset($_SESSION['chinhsua_tk'])){
                        $form_data = filteration($_POST);
                        $taikhoan = select("SELECT * FROM taikhoan WHERE ma_tk = ?", [$form_data['ma_tk']], 'i');
                        $row = mysqli_fetch_assoc($taikhoan);
                        $result = selectAll("taikhoan");
                        $taikhoans = [];
                        while ($row = mysqli_fetch_assoc($result)) {
                            $taikhoans[] = $row['ten_tk'];
                        }
//                        if(empty($form_data['ten_tk'])){
//                            $_SESSION['error'] = "Tên tài khoản không được để trống!";
//                        } else if($form_data['ten_tk']!= $row['ten_tk'] && in_array($form_data['ten_tk'], $taikhoans)){
//                            $_SESSION['error'] = "Tên tài khoản đã tồn tại!";
//                        } else if(empty($form_data['mk_cu'])){
//                            $_SESSION['error'] = "Mật khẩu cũ không được để trống!";
//                        } else if(empty($form_data['mk_moi'])){
//                            $_SESSION['error'] = "Mật khẩu mới không được để trống!";
//                        } else if(){
//
//                        }
                    }
                    ob_end_flush();
                ?>
                <div class="card text-black">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Tài khoản</h4>
                            <div class="d-flex justify-content-end">
                                <a href="?xoa=all" class="btn btn-danger"><i class="mdi mdi-trash-can mr-2"></i>Xóa hết</a>
                            </div>
                        </div>
                        <table class="table table-hover table-striped table-bordered" id="myTable">
                            <thead class="bg-dark text-light">
                            <tr>
                                <th>#</th>
                                <th>Tên người dùng</th>
                                <th>Tên tài khoản</th>
                                <th>Quyền</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $query = "SELECT * FROM taikhoan WHERE quyen != 'admin' ORDER BY ma_tk DESC";
                                $data = mysqli_query($conn, $query);
                                $i = 1;
                                while($row = mysqli_fetch_assoc($data)){
                                    $ten_nd = "";
                                    if($row['quyen'] == 'nhanvien'){
                                        $result = select("SELECT * FROM nhanvien WHERE ma_nv = ?", [$row['ma_nd']], "i");
                                        $nhan_vien = mysqli_fetch_assoc($result);
                                        $ten_nd = $nhan_vien['ten_nv'];
                                    } else {
                                        $result = select("SELECT * FROM khachhang WHERE ma_kh = ?", [$row['ma_nd']], "i");
                                        $khach_hang = mysqli_fetch_assoc($result);
                                        $ten_nd = $khach_hang['ten_kh'];
                                    }
                                    echo "<tr>
                                            <td>$i</td>
                                            <td>{$ten_nd}</td>
                                            <td>{$row['ten_tk']}</td>
                                            <td>{$row['quyen']}</td>
                                            <td class='d-flex align-items-center justify-content-around'>
                                                <button type='button' class='btn bg-transparent text-primary p-0 shadow-none' data-toggle='modal' data-target='#detailModal{$row['ma_tk']}'>
                                                    <i class='mdi mdi-pencil' style='font-size: 23px'></i>
                                                </button>
                                                <!-- Modal Edit cho từng hàng -->
                                                <div class='modal fade' id='detailModal{$row['ma_tk']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content' style='width: 600px'>
                                                            <form method='post'>
                                                                <div class='modal-header'>
                                                                    <h5 class='modal-title d-flex align-items-center'>
                                                                        <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                        <span>Thay đổi tài khoản hoặc mật khẩu</span>
                                                                    </h5>
                                                                    <button type='button' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                        <span aria-hidden='true'>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class='modal-body row'>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Tên tài khoản</label>
                                                                        <input type='hidden' name='ma_lienhe' value='{$row['ma_tk']}'>
                                                                        <input type='text' name='ten_tk' class='form-control shadow-none' value='{$row['ten_tk']}'>
                                                                    </div>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Mật khẩu cũ</label>
                                                                        <input type='text' name='mk_cu' class='form-control shadow-none''>                                                                                
                                                                    </div>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Mật khẩu mới</label>
                                                                        <input type='text' name='mk_moi' class='form-control shadow-none''>                                                                                
                                                                    </div>      
                                                                    <div class='d-flex align-items-center justify-content-end'>
                                                                        <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Đóng</button>
                                                                        <button type='submit' name='chinhsua_tk' class='btn btn-success'>Chỉnh sửa</button>
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