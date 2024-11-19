<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Phòng</title>

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

                    // Them phong
                    if(isset($_POST['them_phong'])){
                        $form_fil = array_intersect_key($_POST, array_flip(['ten_phong', 'dien_tich', 'gia', 'so_luong', 'sl_nguoi_lon', 'sl_tre_em', 'mo_ta']));
                        $form_data = filteration($form_fil);
                        if(empty($form_data['ten_phong'])){
                            $_SESSION['error'] = "Tên phòng không được để trống!";
                        } else if(empty($form_data['dien_tich'])){
                            $_SESSION['error'] = "Diện tích không được để trống!";
                        } else if(empty($form_data['gia'])) {
                            $_SESSION['error'] = "Giá không được để trống!";
                        } else if(empty($form_data['so_luong'])){
                            $_SESSION['error'] = "Số lượng không được để trống!";
                        } else if(empty($form_data['sl_nguoi_lon'])) {
                            $_SESSION['error'] = "Số lượng người lớn không được để trống!";
                        } else if(empty($form_data['sl_tre_em'])) {
                            $_SESSION['error'] = "Số lượng trẻ em không được để trống!";
                        } else if(empty($form_data['mo_ta'])){
                            $_SESSION['error'] = "Mô tả không được để trống!";
                        } else {
                            $features = filteration($_POST['dacdiem']);
                            $services = filteration($_POST['dichvu']);
                            if(!is_numeric($form_data['dien_tich'])){
                                $_SESSION['error'] = "Diện tích phải là 1 số!";
                            } else if(!filter_var($form_data['gia'], FILTER_VALIDATE_INT)){
                                $_SESSION['error'] = "Giá phải là 1 số nguyên!";
                            } else if(!filter_var($form_data['so_luong'], FILTER_VALIDATE_INT)){
                                $_SESSION['error'] = "Số lượng phải là 1 số nguyên!";
                            } else if(!filter_var($form_data['sl_nguoi_lon'], FILTER_VALIDATE_INT)){
                                $_SESSION['error'] = "Số lượng người lớn phải là 1 số nguyên!";
                            } else if(!filter_var($form_data['sl_tre_em'], FILTER_VALIDATE_INT)){
                                $_SESSION['error'] = "Số lượng trẻ em phải là 1 số nguyên!";
                            } else {
                                // Them anh phong
                                $img_r = uploadImage($_FILES['anh_phong'], ROOMS_FOLDER);
                                // Kiem tra anh phong them vao co loi hay khong
                                if($img_r == 'inv_img'){
                                    $_SESSION['error'] = "Hình ảnh không hợp lệ!";
                                } else if($img_r == 'inv_size'){
                                    $_SESSION['error'] = "Kích thước hình ảnh không hợp lệ!";
                                } else if($img_r == 'upl_failed'){
                                    $_SESSION['error'] = "Tải hình ảnh thất bại!";
                                } else {
                                    // Them phong
                                    $query1 = "INSERT INTO `phong`(`ten_phong`, `dien_tich`, `gia`, `so_luong`, `sl_nguoi_lon`, `sl_tre_em`, `anh_phong`, `mo_ta`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                    $values = array($form_data['ten_phong'], $form_data['dien_tich'], $form_data['gia'], $form_data['so_luong'], $form_data['sl_nguoi_lon'], $form_data['sl_tre_em'], $img_r, $form_data['mo_ta']);
                                    $result = insert($query1, $values, "siiiiiss");
                                    $flag = 0;
                                    if($result){
                                        $flag = 1;
                                    }
                                    // Them cac dich vu vao phong
                                    $room_id = mysqli_insert_id($conn);
                                    $query2 = "INSERT INTO `phong_dichvu`(`ma_phong`, `ma_dichvu`) VALUES (?, ?)";
                                    if($stmt = mysqli_prepare($conn, $query2)){
                                        foreach ($services as $service) {
                                            mysqli_stmt_bind_param($stmt, "ii", $room_id, $service);
                                            mysqli_stmt_execute($stmt);
                                        }
                                        mysqli_stmt_close($stmt);
                                        $flag = 1;
                                    } else {
                                        die("Câu truy vấn chuẩn bị lỗi - Insert");
                                        $flag = 0;
                                    }
                                    // Them cac dac diem vao phong
                                    $query3 = "INSERT INTO `phong_dacdiem`(`ma_phong`, `ma_dacdiem`) VALUES (?, ?)";
                                    if($stmt = mysqli_prepare($conn, $query3)){
                                        foreach ($features as $feature) {
                                            mysqli_stmt_bind_param($stmt, "ii", $room_id, $feature);
                                            mysqli_stmt_execute($stmt);
                                        }
                                        mysqli_stmt_close($stmt);
                                        $flag = 1;
                                    } else {
                                        die("Câu truy vấn chuẩn bị lỗi - Insert");
                                        $flag = 0;
                                    }
                                    if($flag == 1){
                                        $_SESSION['success'] = "Thêm bản ghi thành công!";
                                    } else {
                                        $_SESSION['error'] = "Có lỗi xảy ra!";
                                    }
                                }
                            }
                        }
                        header("Location: rooms.php");
                        exit;
                    }

                    // Xoa phong
                    if(isset($_GET['xoa_phong'])){
                        $form_data = filteration($_GET);
                        // Xoa toan bo phong
                        if($form_data['xoa_phong'] == 'all'){
                            $query1 = "DELETE FROM phong";
                            // Xoa toan bo dac diem co trong phong
                            $query2 = "DELETE FROM phong_dacdiem";
                            // Xoa toan bo dich vu co trong phong
                            $query3 = "DELETE FROM phong_dichvu";
                            $rooms = selectAll('phong');
                            $images = [];
                            while($row = mysqli_fetch_assoc($rooms)){
                                $images[] = $row['anh_phong'];
                            }
                            if(mysqli_query($conn, $query2) && mysqli_query($conn, $query3) && mysqli_query($conn, $query1)){
                                // Xoa anh trong foler phong
                                foreach ($images as $image) {
                                    deleteImage($image, ROOMS_FOLDER);
                                }
                                $_SESSION['success'] = "Xóa toàn bộ bản ghi thành công!";
                            }else{
                                $_SESSION['error'] = "Có lỗi xảy ra!";
                            }
                        } else {
                            // Xoa phong nay
                            $result = select("SELECT * FROM phong WHERE `ma_phong` = ?", [$form_data['xoa_phong']], 'i');
                            $row = mysqli_fetch_assoc($result);
                            // Xoa anh trong folder phong
                            if(deleteImage($row['anh_phong'], ROOMS_FOLDER)){
                                $query1 = "DELETE FROM phong WHERE ma_phong = ?";
                                // Xoa cac dac diem cua phong nay
                                $query2 = "DELETE FROM phong_dacdiem WHERE ma_phong = ?";
                                // Xoa cac dich vu cua phong nay
                                $query3 = "DELETE FROM phong_dichvu WHERE ma_phong = ?";
                                $values = array($form_data['xoa_phong']);
                                $result2 = delete($query2, $values, "i");
                                $result3 = delete($query3, $values, "i");
                                $result1 = delete($query1, $values, "i");
                                if($result1 && $result2 && $result3){
                                    $_SESSION['success'] = "Xóa bản ghi thành công!";
                                }else{
                                    $_SESSION['error'] = "Có lỗi xảy ra!";
                                }
                            } else {
                                $_SESSION['error'] = "Có lỗi xảy ra!";
                            }
                        }
                        header("Location: rooms.php");
                        exit;
                    }

                    if(isset($_POST['chinhsua_phong'])){
                        $form_fil = array_intersect_key($_POST, array_flip(['ten_phong', 'dien_tich', 'gia', 'so_luong', 'sl_nguoi_lon', 'sl_tre_em', 'mo_ta', 'ma_phong']));
                        $form_data = filteration($form_fil);
                        if(empty($form_data['ten_phong'])){
                            $_SESSION['error'] = "Tên phòng không được để trống!";
                        } else if(empty($form_data['dien_tich'])){
                            $_SESSION['error'] = "Diện tích không được để trống!";
                        } else if(empty($form_data['gia'])) {
                            $_SESSION['error'] = "Giá không được để trống!";
                        } else if(empty($form_data['so_luong'])){
                            $_SESSION['error'] = "Số lượng không được để trống!";
                        } else if(empty($form_data['sl_nguoi_lon'])) {
                            $_SESSION['error'] = "Số lượng người lớn không được để trống!";
                        } else if(empty($form_data['sl_tre_em'])) {
                            $_SESSION['error'] = "Số lượng trẻ em không được để trống!";
                        } else if(empty($form_data['mo_ta'])){
                            $_SESSION['error'] = "Mô tả không được để trống!";
                        } else {
                            $features = filteration($_POST['dacdiem']);
                            $services = filteration($_POST['dichvu']);
                            if(!is_numeric($form_data['dien_tich']) || $form_data['dien_tich'] < 1){
                                $_SESSION['error'] = "Diện tích phải là 1 số > 0 !";
                            } else if(!filter_var($form_data['gia'], FILTER_VALIDATE_INT) || $form_data['gia'] < 1){
                                $_SESSION['error'] = "Giá phải là 1 số nguyên > 0 !";
                            } else if(!filter_var($form_data['so_luong'], FILTER_VALIDATE_INT) || $form_data['so_luong'] < 0){
                                $_SESSION['error'] = "Số lượng phải là 1 số nguyên >= 0 !";
                            } else if(!filter_var($form_data['sl_nguoi_lon'], FILTER_VALIDATE_INT) || $form_data['sl_nguoi_lon'] < 1){
                                $_SESSION['error'] = "Số lượng người lớn phải là 1 số nguyên > 0 !";
                            } else if(!filter_var($form_data['sl_tre_em'], FILTER_VALIDATE_INT) || $form_data['sl_tre_em'] < 0){
                                $_SESSION['error'] = "Số lượng trẻ em phải là 1 số nguyên >= 0 !";
                            } else {
                                $result = select("SELECT * FROM phong WHERE `ma_phong` = ?", [$form_data['ma_phong']], 'i');
                                $row = mysqli_fetch_assoc($result);
                                if (!empty($_FILES['anh_phong']['name'])) {
                                    $img_r = uploadImage($_FILES['anh_phong'], ROOMS_FOLDER);
                                    deleteImage($row['anh_phong'], ROOMS_FOLDER);
                                } else {
                                    $img_r = $row['anh_phong'];
                                }
                                if ($img_r == 'inv_img') {
                                    $_SESSION['error'] = "Hình ảnh không hợp lệ!";
                                } else if ($img_r == 'inv_size') {
                                    $_SESSION['error'] = "Kích thước hình ảnh không hợp lệ!";
                                } else if ($img_r == 'upl_failed') {
                                    $_SESSION['error'] = "Tải ảnh thất bại!";
                                } else {
                                    $query1 = "UPDATE `phong` SET `ten_phong`= ?,`dien_tich`= ?,`gia`= ?,`so_luong`= ?,`sl_nguoi_lon`= ?,`sl_tre_em`= ?, `anh_phong`= ?, `mo_ta`= ? WHERE `ma_phong` = ?";
                                    $values = array($form_data['ten_phong'], $form_data['dien_tich'], $form_data['gia'], $form_data['so_luong'], $form_data['sl_nguoi_lon'], $form_data['sl_tre_em'], $img_r, $form_data['mo_ta'], $form_data['ma_phong']);
                                    $result = update($query1, $values, "siiiiissi");
                                    $flag = 0;
                                    if ($result) {
                                        $flag = 1;
                                    }
                                    $del_service = delete("DELETE FROM `phong_dichvu` WHERE `ma_phong` = ?", [$form_data['ma_phong']], "i");
                                    $query2 = "INSERT INTO `phong_dichvu`(`ma_phong`, `ma_dichvu`) VALUES (?, ?)";
                                    if ($stmt = mysqli_prepare($conn, $query2)) {
                                        foreach ($services as $service) {
                                            mysqli_stmt_bind_param($stmt, "ii", $form_data['ma_phong'], $service);
                                            mysqli_stmt_execute($stmt);
                                        }
                                        mysqli_stmt_close($stmt);
                                        $flag = 1;
                                    } else {
                                        die("Câu truy vấn chuẩn bị lỗi - Insert");
                                        $flag = 0;
                                    }
                                    $del_feature = delete("DELETE FROM `phong_dacdiem` WHERE `ma_phong` = ?", [$form_data['ma_phong']], "i");
                                    $query3 = "INSERT INTO `phong_dacdiem`(`ma_phong`, `ma_dacdiem`) VALUES (?, ?)";
                                    if ($stmt = mysqli_prepare($conn, $query3)) {
                                        foreach ($features as $feature) {
                                            mysqli_stmt_bind_param($stmt, "ii", $form_data['ma_phong'], $feature);
                                            mysqli_stmt_execute($stmt);
                                        }
                                        mysqli_stmt_close($stmt);
                                        $flag = 1;
                                    } else {
                                        die("Câu truy vấn chuẩn bị lỗi - Insert");
                                        $flag = 0;
                                    }
                                    if ($flag == 1) {
                                        $_SESSION['success'] = "Cập nhật bản ghi thành công!";
                                    } else {
                                        $_SESSION['error'] = "Có lỗi xảy ra!";
                                    }
                                }
                            }
                        }
                        header("Location: rooms.php");
                        exit;
                    }

                    if(isset($_GET['ma_phong'])){
                        $query = "SELECT * FROM `phong` WHERE `ma_phong` = ?";
                        $values = array($_GET['ma_phong']);
                        $result1 = select($query, $values, "i");
                        $row = mysqli_fetch_assoc($result1);
                        if($row['trang_thai'] == 1){
                            $query = "UPDATE `phong` SET `trang_thai` = '0' WHERE `ma_phong` = ?";
                        } else {
                            $query = "UPDATE `phong` SET `trang_thai` = '1' WHERE `ma_phong` = ?";
                        }
                        $result2 = update($query, $values, "i");
                        if($result2){
                            $_SESSION['success'] = "Cập nhật trạng thái thành công!";
                        } else {
                            $_SESSION['error'] = "Có lỗi xảy ra!";
                        }
                        header("Location: rooms.php");
                        exit;
                    }
                    ob_end_flush();
                ?>
                <div class="card text-black mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Phòng</h4>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary shadow-none" data-toggle="modal" data-target="#createRoomModal">
                                    <i class="mdi mdi-plus-circle mr-2"></i>
                                    Thêm phòng
                                </button>
                                <a href="?xoa_phong=all" class="btn btn-danger ml-2 shadow-none"><i class="mdi mdi-trash-can mr-2"></i>Xóa hết</a>
                            </div>
                        </div>
                        <div class="modal fade" id="createRoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content" style="width: 600px">
                                    <form method="post" enctype='multipart/form-data'>
                                        <div class="modal-header">
                                            <h5 class="modal-title d-flex align-items-center">
                                                <i class="mdi mdi-plus-circle mr-2"></i>
                                                <span>Thêm phòng</span>
                                            </h5>
                                            <button type="reset" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Tên phòng<span class='text-danger'>*</span></label>
                                                    <input type="text" name="ten_phong" class="form-control shadow-none">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Giá<span class='text-danger'>*</span></label>
                                                    <input type="text" name="gia" class="form-control shadow-none">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Số lượng người lớn tối đa<span class='text-danger'>*</span></label>
                                                    <input type="text" name="sl_nguoi_lon" class="form-control shadow-none">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Diện tích<span class='text-danger'>*</span></label>
                                                    <input type="text" name="dien_tich" class="form-control shadow-none">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Số lượng<span class='text-danger'>*</span></label>
                                                    <input type="text" name="so_luong" class="form-control shadow-none">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Số lượng trẻ em tối đa<span class='text-danger'>*</span></label>
                                                    <input type="text" name="sl_tre_em" class="form-control shadow-none">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Đặc điểm</label>
                                                <div class="row">
                                                    <?php
                                                        $result = selectAll('dacdiem');
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<div class='col-md-3 mb-1'>
                                                                    <label>
                                                                        <input type='checkbox' name='dacdiem[]' value='{$row['ma_dacdiem']}' class='form-check-input shadow-none ml-0'>
                                                                        <span class='ml-4'>{$row['ten_dacdiem']}</span>
                                                                    </label>   
                                                                </div>";
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Dịch vụ</label>
                                                <div class="row">
                                                    <?php
                                                        $result = selectAll('dichvu');
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<div class='col-md-3 mb-1'>
                                                                        <label>
                                                                            <input type='checkbox' name='dichvu[]' value='{$row['ma_dichvu']}' class='form-check-input shadow-none ml-0'>
                                                                            <span class='ml-4'>{$row['ten_dichvu']}</span>
                                                                        </label>   
                                                                    </div>";
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Hình ảnh<span class="text-danger">*</span></label>
                                                    <input type="file" name="anh_phong" class="form-control shadow-none" style="height: fit-content">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Mô tả<span class='text-danger'>*</span></label>
                                                    <textarea name="mo_ta" class="form-control shadow-none" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Đóng</button>
                                                <button type="submit" name="them_phong" class="btn btn-success">Thêm</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <table class="table table1 table-hover table-striped table-bordered" id="myTable1">
                            <thead class="bg-dark text-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Tên phòng</th>
                                    <th>Diện tích</th>
                                    <th>Số lượng khách</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Hình ảnh</th>
                                    <th>Trạng thái</th>
                                    <th width="5%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $query = "SELECT * FROM phong ORDER BY ma_phong DESC";
                                $data = mysqli_query($conn, $query);
                                $path = ROOMS_IMG_PATH;
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($data)) {
                                    if($row['trang_thai'] == 1){
                                        $status = "<a href='?ma_phong={$row['ma_phong']}' class='btn btn-dark btn-sm shadow-none'>Hoạt động</a>";
                                    } else {
                                        $status = "<a href='?ma_phong={$row['ma_phong']}' class='btn btn-warning btn-sm shadow-none'>Bảo trì</a>";
                                    }
                                    $values = array($row['ma_phong']);
                                    $res_fea = selectAll('dacdiem');
                                    $query1 = "SELECT ma_dacdiem FROM phong_dacdiem WHERE ma_phong = ?";
                                    $res_room_fea = select($query1, $values, "i");
                                    $features_id = [];
                                    while($row1 = mysqli_fetch_assoc($res_room_fea)){
                                        $features_id[] = $row1['ma_dacdiem'];
                                    }
                                    $feature = "";

                                    while ($row2 = mysqli_fetch_assoc($res_fea)) {
                                        $check = in_array($row2['ma_dacdiem'], $features_id) ? "checked" : "";
                                        $feature .=  "<div class='col-md-3 my-2'>
                                                        <label>
                                                            <input type='checkbox' name='dacdiem[]' value='{$row2['ma_dacdiem']}' class='form-check-input shadow-none m-0' $check>
                                                            <span class='ml-4'>{$row2['ten_dacdiem']}</span>
                                                        </label>
                                                    </div>";
                                    }
                                    $res_ser = selectAll('dichvu');
                                    $query2 = "SELECT ma_dichvu FROM phong_dichvu WHERE ma_phong = ?";
                                    $res_room_ser = select($query2, $values, "i");
                                    $services_id = [];
                                    while($row3 = mysqli_fetch_assoc($res_room_ser)){
                                        $services_id[] = $row3['ma_dichvu'];
                                    }
                                    $service = "";

                                    while ($row4 = mysqli_fetch_assoc($res_ser)) {
                                        $check = in_array($row4['ma_dichvu'], $services_id) ? "checked" : "";
                                        $service .=  "<div class='col-md-3 my-2'>
                                                        <label>
                                                            <input type='checkbox' name='dichvu[]' value='{$row4['ma_dichvu']}' class='form-check-input shadow-none m-0' $check>
                                                            <span class='ml-4 d-block'>{$row4['ten_dichvu']}</span>
                                                        </label>   
                                                    </div>";
                                    }
                                    echo "<tr>
                                            <td>$i</td>
                                            <td>{$row['ten_phong']}</td>             
                                            <td>{$row['dien_tich']}m²</td>             
                                            <td >
                                                <span class='badge rounded-pill bg-light text-dark mb-2' style='font-size: 14px;'>Người lớn: {$row['sl_nguoi_lon']}</span><br>
                                                <span class='badge rounded-pill bg-light text-dark' style='font-size: 14px;'>Trẻ em: {$row['sl_tre_em']}</span>
                                            </td>             
                                            <td>".number_format($row['gia'], 0, '', ',')." VNĐ</td>             
                                            <td>{$row['so_luong']}</td>       
                                            <td>
                                                <img src='$path{$row['anh_phong']}' class='rounded mx-auto d-block' width='100px'>
                                            </td>        
                                            <td class='text-center'>$status</td>                         
                                            <td>
                                                <button type='button' class='btn bg-transparent text-primary p-0 shadow-none text-center' data-toggle='modal' data-target='#editRoomModal{$row['ma_phong']}'>
                                                    <i class='mdi mdi-pen' style='font-size: 23px'></i>
                                                </button>
                                                <!-- Modal Edit cho từng hàng -->
                                                <div class='modal fade' id='editRoomModal{$row['ma_phong']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content' style='width: 600px'>
                                                            <form method='post' enctype='multipart/form-data'>
                                                                <div class='modal-header'>
                                                                    <h5 class='modal-title d-flex align-items-center'>
                                                                        <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                        <span>Chỉnh sửa phòng</span>
                                                                    </h5>
                                                                    <button type='reset' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                        <span aria-hidden='true'>&times;</span>
                                                                    </button>
                                                                </div>                                                           
                                                                <div class='modal-body row'>
                                                                    <div class='col-md-6'>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Tên phòng<span class='text-danger'>*</span></label>
                                                                            <input type='hidden' name='ma_phong' value='{$row['ma_phong']}'>
                                                                            <input type='text' name='ten_phong' class='form-control shadow-none' value='{$row['ten_phong']}'>
                                                                        </div>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Price<span class='text-danger'>*</span></label>
                                                                            <input type='text' name='gia' class='form-control shadow-none' value='{$row['gia']}'>
                                                                        </div>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Số lượng người lớn tối đa<span class='text-danger'>*</span></label>
                                                                            <input type='text' name='sl_nguoi_lon' class='form-control shadow-none' value='{$row['sl_nguoi_lon']}'>
                                                                        </div>
                                                                    </div>
                                                                    <div class='col-md-6'>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Diện tích<span class='text-danger'>*</span></label>
                                                                            <input type='text' name='dien_tich' class='form-control shadow-none' value='{$row['dien_tich']}'>
                                                                        </div>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Số lượng<span class='text-danger'>*</span></label>
                                                                            <input type='text' name='so_luong' class='form-control shadow-none' value='{$row['so_luong']}'>
                                                                        </div>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Số lượng trẻ em tối đa<span class='text-danger'>*</span></label>
                                                                            <input type='text' name='sl_tre_em' class='form-control shadow-none' value='{$row['sl_tre_em']}'>
                                                                        </div>
                                                                    </div>
                                                                    <div class='col-md-12'>
                                                                        <label class='form-label'>Đặc điểm</label>
                                                                        <div class='row'>
                                                                            $feature
                                                                        </div>
                                                                        </div>
                                                                    <div class='col-md-12'>
                                                                        <label class='form-label'>Dịch vụ</label>
                                                                        <div class='row'>
                                                                            $service
                                                                        </div>
                                                                    </div>
                                                                      <div class='col-md-12'>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Hình ảnh<span class='text-danger'>*</span></label>
                                                                            <input type='file' name='anh_phong' class='form-control shadow-none' style='height: fit-content'>
                                                                        </div>
                                                                    </div>
                                                                    <div class='col-md-12'>
                                                                        <div class='mb-3'>
                                                                            <label class='form-label'>Mô tả<span class='text-danger'>*</span></label>
                                                                            <textarea name='mo_ta' class='form-control shadow-none' rows='5'>{$row['mo_ta']}</textarea>
                                                                        </div>
                                                                    </div>
                                                                     <div class='d-flex align-items-center justify-content-end'>
                                                                        <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Đóng</button>
                                                                        <button type='submit' name='chinhsua_phong' class='btn btn-success'>Chỉnh sửa</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href='?xoa_phong={$row['ma_phong']}' class='btn bg-transparent text-danger p-0 shadow-none text-center ml-3'><i class='mdi mdi-trash-can' style='font-size: 28px'></i></a>                  
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