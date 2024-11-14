<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Nhân viên</title>

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

                if(isset($_POST['them_nv'])){
                    $form_data = filteration($_POST);
                    $result1 = selectAll("taikhoan");
                    $ten_tks = [];
                    while ($row = mysqli_fetch_assoc($result1)) {
                        $ten_tks[] = $row['ten_tk'];
                    }
                    $result2 = selectAll("nhanvien");
                    $emails = [];
                    $so_dien_thoais = [];
                    while ($row = mysqli_fetch_assoc($result2)) {
                        $emails[] = $row['email'];
                        $so_dien_thoais[] = $row['so_dien_thoai'];
                    }
                    if(empty($form_data['ten_nv'])){
                        $_SESSION['error'] = "Tên không được để trống!";
                    } else if(!preg_match('/^[\p{L}\d\s]+$/u', $form_data['ten_nv'])) {
                        $_SESSION['error'] = "Tên không chứa kí tự đặc biệt!";
                    } else if(preg_match('/[0-9]/', $form_data['ten_nv'])){
                        $_SESSION['error'] = "Tên không chứa số!";
                    } else if(empty($form_data['email'])){
                        $_SESSION['error'] = "Email không được để trống!";
                    } else if(!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['error'] = "Email không hợp lệ!";
                    } else if (in_array($form_data['email'], $emails)) {
                        $_SESSION['error'] = "Email đã tồn tại!";
                    } else if(empty($form_data['so_dien_thoai'])){
                        $_SESSION['error'] = "Số điện thoại không được để trống!";
                    } else if(!preg_match('/^([+]\d{2})?\d{10}$/', $form_data['so_dien_thoai'])){
                        $_SESSION['error'] = "Số điện thoại không hợp lệ!";
                    } else if (in_array($form_data['so_dien_thoai'], $so_dien_thoais)) {
                        $_SESSION['error'] = "Số điện thoại đã tồn tại!";
                    } else if(empty($form_data['dia_chi'])){
                        $_SESSION['error'] = "Địa chỉ không được để trống!";
                    } else if(empty($form_data['ngay_sinh'])){
                        $_SESSION['error'] = "Ngày sinh không được để trống!";
                    } else if(empty($form_data['ten_tk'])){
                        $_SESSION['error'] = "Tên tài khoản không được để trống!";
                    } else if(in_array($form_data['ten_tk'], $ten_tks)) {
                        $_SESSION['error'] = "Tên tài khoản đã tồn tại!";
                    } else if(empty($form_data['mat_khau'])){
                        $_SESSION['error'] = "Mật khẩu không được để trống!";
                    } else if($form_data['xacnhan_mk'] != $form_data['mat_khau']){
                        $_SESSION['error'] = "Mật khẩu xác nhận không trùng với mật khẩu!";
                    } else {
                        $img_r = uploadImage($_FILES['anh_nv'], STAFF_FOLDER);
                        if($img_r == 'inv_img'){
                            $_SESSION['error'] = "Hình ảnh không hợp lệ!";
                        } else if($img_r == 'inv_size'){
                            $_SESSION['error'] = "Kích thước hình ảnh không hợp lệ!";
                        } else if($img_r == 'upl_failed') {
                            $_SESSION['error'] = "Tải hình ảnh thất bại!";
                        } else {
                            // Them vao bang nhan vien
                            $query1 = "INSERT INTO `nhanvien`(`ten_nv`, `ngay_sinh`, `email`, `so_dien_thoai`, `dia_chi`, `anh_nv`) VALUES (?, ?, ?, ?, ?, ?)";
                            $values1 = [$form_data['ten_nv'], $form_data['ngay_sinh'], $form_data['email'], $form_data['so_dien_thoai'], $form_data["dia_chi"], $img_r];
                            $result1 = insert($query1, $values1, "ssssss");

                            // Them vao bang tai khoan
                            $ma_kh = mysqli_insert_id($conn);
                            $mat_khau_bm = password_hash($form_data['mat_khau'], PASSWORD_DEFAULT);
                            $query2 = "INSERT INTO `taikhoan`(`ten_tk`, `mat_khau`, `ma_nd`, `quyen`) VALUES (?, ?, ?, ?)";
                            $values2 = [$form_data['ten_tk'], $mat_khau_bm, $ma_kh, 'nhanvien'];
                            $result2 = insert($query2, $values2, "ssss");

                            if($result1 && $result2){
                                $_SESSION['success'] = "Thêm nhân viên thành công!";
                            } else {
                                $_SESSION['error'] = "Có lỗi xảy ra!";
                            }
                        }
                    }
                    header("Location: staff.php");
                    exit;
                }

                if(isset($_GET['xoa'])){
                    $form_data = filteration($_GET);
                    // Xoa toan bo khach hang
                    if($form_data['xoa'] == 'all'){
                        $result = select("SELECT * FROM taikhoan WHERE quyen = ?", ['admin'], 's');
                        $row = mysqli_fetch_assoc($result);
                        $ma_admin = $row['ma_nd'];
                        $query1 = "DELETE FROM nhanvien WHERE ma_nv != $ma_admin";
                        $query2 = "DELETE FROM taikhoan where quyen = 'nhanvien'";
                        $nhanviens = selectAll("nhanvien");
                        $images = [];
                        while($row = mysqli_fetch_assoc($nhanviens)){
                            $images[] = $row['anh_nv'];
                        }
                        if(mysqli_query($conn, $query1) && mysqli_query($conn, $query2)) {
                            //Xoa anh nhan vien trong folder staff
                            foreach ($images as $image) {
                                deleteImage($image, STAFF_FOLDER);
                            }
                            $_SESSION['success'] = "Xóa toàn bộ bản ghi thành công!";
                        }else{
                            $_SESSION['error'] = "Có lỗi xảy ra!";
                        }
                    } else {
                        $result = select("SELECT * FROM nhanvien WHERE ma_nv = ?", [$form_data['xoa']], 'i');
                        $row = mysqli_fetch_assoc($result);
                        // Xoa 1 nhan vien
                        if(deleteImage($row['anh_nv'], STAFF_FOLDER)){
                            // Xoa nhan vien trong bang nhan vien
                            $query1 = "DELETE FROM nhanvien WHERE ma_nv = ?";
                            $values = array($form_data['xoa']);
                            $result1 = delete($query1, $values, "i");

                            // Xoa tai khoan nhan vien trong bang tai khoan
                            $query2 = "DELETE FROM taikhoan WHERE ma_nd = ? AND quyen = 'nhanvien'";
                            $result2 = delete($query2, $values, "i");
                            if($result1 && $result2){
                                $_SESSION['success'] = "Xóa bản ghi thành công!";
                            }else{
                                $_SESSION['error'] = "Có lỗi xảy ra!";
                            }
                        } else {
                            $_SESSION['error'] = "Có lỗi xảy ra!";
                        }
                    }
                    header("Location: staff.php");
                    exit;
                }

                if(isset($_POST['chinhsua_nv'])){
                    $form_data = filteration($_POST);
                    $result = selectAll("nhanvien");
                    $nhanvien = select("SELECT * FROM nhanvien WHERE ma_nv = ?", [$form_data['ma_nv']], 'i');
                    $row = mysqli_fetch_assoc($nhanvien);
                    $emails = [];
                    $so_dien_thoais = [];
                    while ($row1 = mysqli_fetch_assoc($result)) {
                        $emails[] = $row1['email'];
                        $so_dien_thoais[] = $row1['so_dien_thoai'];
                    }
                    if(empty($form_data['ten_nv'])){
                        $_SESSION['error'] = "Tên không được để trống!";
                    } else if(!preg_match('/^[\p{L}\d\s]+$/u', $form_data['ten_nv'])) {
                        $_SESSION['error'] = "Tên không chứa kí tự đặc biệt!";
                    } else if(preg_match('/[0-9]/', $form_data['ten_nv'])){
                        $_SESSION['error'] = "Tên không chứa số!";
                    } else if(empty($form_data['email'])){
                        $_SESSION['error'] = "Email không được để trống!";
                    } else if(!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['error'] = "Email không hợp lệ!";
                    } else if($form_data['email'] != $row['email'] && in_array($form_data['email'], $emails)){
                        $_SESSION['error'] = "Email đã tồn tại!";
                    } else if(empty($form_data['so_dien_thoai'])){
                        $_SESSION['error'] = "Số điện thoại không được để trống!";
                    } else if(!preg_match('/^([+]\d{2})?\d{10}$/', $form_data['so_dien_thoai'])){
                        $_SESSION['error'] = "Số điện thoại không hợp lệ!";
                    } else if ($form_data['so_dien_thoai'] != $row['so_dien_thoai'] && in_array($form_data['so_dien_thoai'], $so_dien_thoais)){
                        $_SESSION['error'] = "Số điện thoại đã tồn tại!";
                    } else if(empty($form_data['dia_chi'])){
                        $_SESSION['error'] = "Địa chỉ không được để trống!";
                    } else if(empty($form_data['ngay_sinh'])){
                        $_SESSION['error'] = "Ngày sinh không được để trống!";
                    } else {
                        if(!empty($_FILES['anh_nv']['name'])){
                            $img_r = uploadImage($_FILES['anh_nv'], STAFF_FOLDER);
                            deleteImage($row['anh_nv'], STAFF_FOLDER);
                        } else {
                            $img_r = $row['anh_nv'];
                        }
                        if($img_r == 'inv_img'){
                            $_SESSION['error'] = "Hình ảnh không hợp lệ!";
                        } else if($img_r == 'inv_size'){
                            $_SESSION['error'] = "Kích thước hình ảnh không hợp lệ!";
                        } else if($img_r == 'upl_failed') {
                            $_SESSION['error'] = "Tải hình ảnh thất bại!";
                        } else {
                            // Cap nhat nhan vien
                            $query = "UPDATE `nhanvien` SET `ten_nv` = ?, `ngay_sinh` = ?, `email` = ?, `so_dien_thoai` = ?, `dia_chi` = ? , `anh_nv` = ? WHERE ma_nv = ?";
                            $values = [$form_data['ten_nv'], $form_data['ngay_sinh'], $form_data['email'], $form_data['so_dien_thoai'], $form_data["dia_chi"], $img_r, $form_data["ma_nv"]];
                            $result = update($query, $values, "ssssssi");
                            if($result){
                                $_SESSION['success'] = "Cập nhật nhân viên thành công!";
                            } else {
                                $_SESSION['error'] = "Có lỗi xảy ra!";
                            }
                        }
                    }
                    header("Location: staff.php");
                    exit;
                }
                ob_end_flush();
                ?>
                <div class="card text-black">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Nhân viên</h4>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary shadow-none" data-toggle="modal" data-target="#createStaffModal">
                                    <i class="mdi mdi-plus-circle mr-2"></i>
                                    Thêm nhân viên
                                </button>
                                <a href="?xoa=all" class="btn btn-danger ml-2"><i class="mdi mdi-trash-can mr-2"></i>Xóa hết</a>
                            </div>
                        </div>
                        <div class="modal fade" id="createStaffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5 class="modal-title d-flex align-items-center">
                                                <i class="bi bi-person-lines-fill fs-2 me-2"></i>
                                                <span>Thêm nhân viên</span>
                                            </h5>
                                            <button type="reset" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-6 ps-0 mb-3">
                                                        <label class="form-label">Tên<span class="text-danger">*</span></label>
                                                        <input type="text" name="ten_nv" class="form-control shadow-none">
                                                    </div>
                                                    <div class="col-md-6 p-0">
                                                        <label class="form-label">Email<span class="text-danger">*</span></label>
                                                        <input type="text" name="email" class="form-control shadow-none">
                                                    </div>
                                                    <div class="col-md-6 ps-0 mb-3">
                                                        <label class="form-label">Số điện thoại<span class="text-danger">*</span></label>
                                                        <input type="text" name="so_dien_thoai" class="form-control shadow-none">
                                                    </div>
                                                    <div class="col-md-6 p-0 mb-3">
                                                        <label class="form-label">Hình ảnh<span class="text-danger">*</span></label>
                                                        <input type="file" name="anh_nv" class="form-control shadow-none" style="height: fit-content">
                                                    </div>
                                                    <div class="col-md-12 p-0 mb-3">
                                                        <label class="form-label">Địa chỉ<span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="dia_chi" rows="1"></textarea>
                                                    </div>
                                                    <div class="col-md-6 ps-0 mb-3">
                                                        <label class="form-label">Ngày sinh<span class="text-danger">*</span></label>
                                                        <input type="date" name="ngay_sinh" class="form-control shadow-none">
                                                    </div>
                                                    <div class="col-md-6 p-0 mb-3">
                                                        <label class="form-label">Tên tài khoản<span class="text-danger">*</span></label>
                                                        <input type="text" name="ten_tk" class="form-control shadow-none">
                                                    </div>
                                                    <div class="col-md-6 ps-0 mb-3">
                                                        <label class="form-label">Mật khẩu<span class="text-danger">*</span></label>
                                                        <input type="password" name="mat_khau" class="form-control shadow-none">
                                                    </div>
                                                    <div class="col-md-6 p-0 mb-3">
                                                        <label class="form-label">Xác nhận mật khẩu<span class="text-danger">*</span></label>
                                                        <input type="password" name="xacnhan_mk" class="form-control shadow-none">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Đóng</button>
                                                <button type="submit" name="them_nv" class="btn btn-success">Thêm</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-striped table-bordered" id="myTable">
                            <thead class="bg-dark text-light">
                            <tr>
                                <th>#</th>
                                <th>Tên nhân viên</th>
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
                            $result = select("SELECT * FROM taikhoan WHERE quyen = ?", ['admin'], 's');
                            $row = mysqli_fetch_assoc($result);
                            $ma_admin = $row['ma_nd'];
                            $query = "SELECT * FROM nhanvien WHERE ma_nv != '{$ma_admin}' ORDER BY ma_nv DESC";
                            $data = mysqli_query($conn, $query);
                            $path = STAFF_IMG_PATH;
                            $i = 1;
                            while($row = mysqli_fetch_assoc($data)){
                                echo "<tr>
                                        <td>$i</td>
                                        <td>{$row['ten_nv']}</td>
                                        <td>{$row['ngay_sinh']}</td>
                                        <td>{$row['email']}</td>
                                        <td>{$row['so_dien_thoai']}</td>
                                        <td class='custom-cell'>{$row['dia_chi']}</td>
                                        <td>
                                            <img src='$path{$row['anh_nv']}' class='rounded mx-auto d-block' width='100px'>
                                        </td>
                                        <td class='d-flex align-items-center justify-content-around'>
                                            <button type='button' class='btn bg-transparent text-primary p-0 shadow-none' data-toggle='modal' data-target='#detailModal{$row['ma_nv']}'>
                                                <i class='mdi mdi-pencil' style='font-size: 23px'></i>
                                            </button>
                                            <!-- Modal Edit cho từng hàng -->
                                            <div class='modal fade' id='detailModal{$row['ma_nv']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                    <div class='modal-content' style='width: 600px'>
                                                        <form method='post' enctype='multipart/form-data'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title d-flex align-items-center'>
                                                                    <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                    <span>Chỉnh sửa nhân viên</span>
                                                                </h5>
                                                                <button type='button' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body row'>
                                                                <div class='col-md-6'>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Tên</label>
                                                                        <input type='hidden' name='ma_nv' value='{$row['ma_nv']}'>
                                                                        <input type='text' name='ten_nv' class='form-control shadow-none' value='{$row['ten_nv']}'>
                                                                    </div>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Ngày sinh</label>
                                                                        <input type='text' name='ngay_sinh' class='form-control shadow-none' value='{$row['ngay_sinh']}'>                                                                                
                                                                    </div>
                                                                     <div class='mb-3'>
                                                                        <label class='form-label'>Email</label>
                                                                        <input type='text' name='email' class='form-control shadow-none' value='{$row['email']}'>                                                                                
                                                                     </div>
                                                                </div>
                                                                <div class='col-md-6'>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Số điện thoại</label>
                                                                        <input type='text' name='so_dien_thoai' class='form-control shadow-none' value='{$row['so_dien_thoai']}'>
                                                                    </div>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Địa chỉ</label>
                                                                        <textarea class='form-control shadow-none' name='dia_chi' rows='5'>{$row['dia_chi']}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class='mb-3'>
                                                                        <label class='form-label'>Hình ảnh</label>
                                                                        <input type='file' name='anh_nv' class='form-control' style='height: fit-content'>
                                                                </div>
                                                                <div class='d-flex align-items-center justify-content-end'>
                                                                    <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Đóng</button>
                                                                    <button type='submit' name='chinhsua_nv' class='btn btn-success'>Chỉnh sửa</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href='?xoa={$row['ma_nv']}' class='fa-2x text-danger'><i class='mdi mdi-trash-can'></i></a>
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