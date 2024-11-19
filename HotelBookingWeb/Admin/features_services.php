<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Đặc điểm và dịch vụ</title>

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

                    // Them dac diem
                    if(isset($_POST['them_dacdiem'])){
                        $form_data = filteration($_POST);
                        if(!empty($form_data['ten_dacdiem'])){
                            if(!preg_match('/^[\p{L}\d\s]+$/u', $form_data['ten_dacdiem'])) {
                                $_SESSION['error'] = "Tên đặc điểm không chứa kí tự đặc biệt!";
                            } else if(preg_match('/[0-9]/', $form_data['ten_dacdiem'])) {
                                $_SESSION['error'] = "Tên đặc điểm không chứa số!";
                            } else {
                                $query = "INSERT INTO dacdiem (ten_dacdiem) VALUES (?)";
                                $values = array($form_data['ten_dacdiem']);
                                $result = insert($query, $values, "s");
                                if($result){
                                    $_SESSION['success'] = "Thêm bản ghi thành công!";
                                }else{
                                    $_SESSION['error'] = "Có lỗi xảy ra!";
                                }
                            }
                        } else {
                            $_SESSION['error'] = "Tên đặc điểm không được để trống!";
                        }
                        header("Location: features_services.php");
                        exit;
                    }

                    // Xoa dac diem
                    if(isset($_GET['xoa_dacdiem'])){
                        $form_data = filteration($_GET);
                        $rooms_fea = selectAll("phong_dacdiem");
                        $flag = 0;
                        $features_id = [];
                        while ($row = mysqli_fetch_assoc($rooms_fea)) {
                            $features_id[] = $row['ma_dacdiem'];
                        }
                        // Xoa toan bo dac diem
                        if($form_data['xoa_dacdiem'] == 'all') {
                            $features = selectAll("dacdiem");
                            // Kiem tra xem co dac diem nao duoc them vao phong khong (co: flag = 1, khong: flag = 0)
                            while ($row = mysqli_fetch_assoc($features)) {
                                if(in_array($row['ma_dacdiem'], $features_id)){
                                    $flag = 1;
                                    break;
                                }
                            }
                            if($flag == 0){
                                $query = "DELETE FROM dacdiem";
                                if(mysqli_query($conn, $query)){
                                    $_SESSION['success'] = "Xóa toàn bộ bản ghi thành công!";
                                }else{
                                    $_SESSION['error'] = "Có lỗi xảy ra!";
                                }
                            } else {
                                $_SESSION['error'] = "Có đặc điểm đã được thêm vào phòng!";
                            }
                        } else if(in_array($form_data['xoa_dacdiem'], $features_id)){// Kiem tra xem dac diem nay có duoc them vao phong khong
                            $_SESSION['error'] = "Đặc điểm này đã được thêm vào phòng!";
                        } else {
                            // Xoa dac diem nay
                            $query = "DELETE FROM dacdiem WHERE ma_dacdiem = ?";
                            $values = array($form_data['xoa_dacdiem']);
                            $result = delete($query, $values, "i");
                            if($result){
                                $_SESSION['success'] = "Xóa bản ghi thành công!";
                            }else{
                                $_SESSION['error'] = "Có lỗi xảy ra!";
                            }
                        }
                        header("Location: features_services.php");
                        exit;
                    }

                    // Chinh sua dac diem
                    if(isset($_POST['chinhsua_dacdiem'])){
                        $form_data = filteration($_POST);
                        if(!empty($form_data['ten_dacdiem'])){
                            if(!preg_match('/^[\p{L}\d\s]+$/u', $form_data['ten_dacdiem'])) {
                                $_SESSION['error'] = "Tên đặc điểm không chứa kí tự đặc biệt!";
                            } else if(preg_match('/[0-9]/', $form_data['ten_dacdiem'])) {
                                $_SESSION['error'] = "Tên đặc điểm không chứa số!";
                            } else {
                                $query = "UPDATE dacdiem set ten_dacdiem = ? where ma_dacdiem = ?";
                                $values = array($form_data['ten_dacdiem'], $form_data['ma_dacdiem']);
                                $result = insert($query, $values, "si");
                                if($result){
                                    $_SESSION['success'] = "Cập nhật bản ghi thành công!";
                                } else {
                                    $_SESSION['error'] = "Có lỗi xảy ra!";
                                }
                            }
                        } else {
                            $_SESSION['error'] = "Tên đặc điểm không được để trống!";
                        }
                        header("Location: features_services.php");
                        exit;
                    }

                    // Them dich vu
                    if(isset($_POST['them_dichvu'])){
                        $form_data = filteration($_POST);
                        if(empty($form_data['ten_dichvu'])){
                            $_SESSION['error'] = "Tên dịch vụ không được để trống!";
                        } else if(!preg_match('/^[\p{L}\d\s]+$/u', $form_data['ten_dichvu'])) {
                            $_SESSION['error'] = "Tên dịch vụ không chứa kí tự đặc biệt!";
                        } else if(preg_match('/[0-9]/', $form_data['ten_dichvu'])) {
                            $_SESSION['error'] = "Tên dịch vụ không chứa số!";
                        } else if(empty($form_data['mo_ta'])){
                            $_SESSION['error'] = "Mô tả không được để trống!";
                        } else {
                            // Them hinh anh
                            $img_r = uploadImage($_FILES['anh_dichvu'], SERVICES_FOLDER);
                            // Kiem tra hinh anh them vao co loi hay khong
                            if($img_r == 'inv_img'){
                                $_SESSION['error'] = "Hỉnh ảnh không hợp lệ!";
                            } else if($img_r == 'inv_size'){
                                $_SESSION['error'] = "Kích thước hình ảnh không hợp lệ!";
                            } else if($img_r == 'upl_failed'){
                                $_SESSION['error'] = "Tải hình ảnh thất bại!";
                            } else {
                                $query = "INSERT INTO dichvu (ten_dichvu, anh_dichvu, mo_ta) VALUES (?, ?, ?)";
                                $values = array($form_data['ten_dichvu'], $img_r, $form_data['mo_ta']);
                                $result = insert($query, $values, "sss");
                                if ($result) {
                                    $_SESSION['success'] = "Thêm bản ghi thành công!";
                                } else {
                                    $_SESSION['error'] = "Có lỗi xảy ra!";
                                }
                            }
                        }
                        header("Location: features_services.php");
                        exit;
                    }

                    // Xoa dich vu
                    if(isset($_GET['xoa_dichvu'])){
                        $form_data = filteration($_GET);
                        $rooms_ser = selectAll("phong_dichvu");
                        $services_id = [];
                        $flag = 0;
                        while ($row = mysqli_fetch_assoc($rooms_ser)) {
                            $services_id[] = $row['ma_dichvu'];
                        }
                        // Xoa toan bo dich vu
                        if($form_data['xoa_dichvu'] == 'all'){
                            $query = "DELETE FROM dichvu";
                            $services = selectAll("dichvu");
                            $images = [];
                            // Kiem tra xem co dich vu nao duoc them vao phong khong (co: flag = 1, khong: flag = 0)
                            while($row = mysqli_fetch_assoc($services)){
                                if(in_array($row['ma_dichvu'], $services_id)){
                                    $flag = 1;
                                }
                                $images[] = $row['anh_dichvu'];
                            }
                            if($flag == 0){
                                if(mysqli_query($conn, $query)){
                                    foreach ($images as $image) {
                                        deleteImage($image, SERVICES_FOLDER);
                                    }
                                    $_SESSION['success'] = "Xóa toàn bộ bản ghi thành công!";
                                }else{
                                    $_SESSION['error'] = "Có lỗi xảy ra!";
                                }
                            } else {
                                $_SESSION['error'] = "Có dịch vụ đã được thêm vào phòng!";
                            }
                        } else if(in_array($form_data['xoa_dichvu'], $services_id)) {// Kiem tra xem dac diem nay có duoc them vao phong khong
                            $_SESSION['error'] = "Dịch vụ này đã được thêm vào phòng!";
                        } else {
                            // Xoa dich vu nay
                            $query = "SELECT * FROM dichvu WHERE ma_dichvu = ?";
                            $values = array($form_data['xoa_dichvu']);
                            $result = select($query, $values, "i");
                            $row = mysqli_fetch_array($result);
                            if(deleteImage($row['anh_dichvu'], SERVICES_FOLDER)){
                                $query = "DELETE FROM dichvu WHERE ma_dichvu = ?";
                                $values = array($form_data['xoa_dichvu']);
                                $result = delete($query, $values, "i");
                                if($result){
                                    $_SESSION['success'] = "Xóa bản ghi thành công!";
                                }else{
                                    $_SESSION['error'] = "Có lỗi xảy ra!";
                                }
                            } else {
                                $_SESSION['error'] = "Có lỗi xảy ra!";
                            }
                        }
                        header("Location: features_services.php");
                        exit;
                    }

                    // Chinh sua dich vu
                    if(isset($_POST['chinhsua_dichvu'])){
                        $form_data = filteration($_POST);
                        $query = "SELECT * FROM dichvu WHERE ma_dichvu = ?";
                        $values = array($form_data['ma_dichvu']);
                        $result = select($query, $values, "i");
                        $row = mysqli_fetch_array($result);
                        if(empty($form_data['ten_dichvu'])){
                            $_SESSION['error'] = "Tên dịch vụ không được để trống!";
                        } else if(empty($form_data['mo_ta'])){
                            $_SESSION['error'] = "Mô tả không được để trống!";
                        } else {
                            if(!empty($_FILES['anh_dichvu']['name'])){
                                $img_r = uploadImage($_FILES['anh_dichvu'], SERVICES_FOLDER);
                                deleteImage($row['anh_dichvu'], SERVICES_FOLDER);
                            } else {
                                $img_r = $row['anh_dichvu'];
                            }
                            if($img_r == 'inv_img'){
                                $_SESSION['error'] = "Hình ảnh không hợp lệ!";
                            } else if($img_r == 'inv_size'){
                                $_SESSION['error'] = "Kích thước hình ảnh không hợp lệ!";
                            } else if($img_r == 'upl_failed'){
                                $_SESSION['error'] = "Tải hình ảnh thất bại!";
                            } else {
                                $query = "UPDATE dichvu SET ten_dichvu = ?, anh_dichvu = ?, mo_ta = ? WHERE ma_dichvu = ?";
                                $values = array($form_data['ten_dichvu'], $img_r, $form_data['mo_ta'], $form_data['ma_dichvu']);
                                $result = update($query, $values, "sssi");
                                if ($result) {
                                    $_SESSION['success'] = "Cập nhật bản ghi thành công!";
                                } else {
                                    $_SESSION['error'] = "Có lỗi xảy ra!";
                                }
                            }
                        }
                        header("Location: features_services.php");
                        exit;
                    }
                    ob_end_flush();
                ?>
                <div class="card text-black mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Đặc điểm</h4>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary shadow-none" data-toggle="modal" data-target="#createFeatureModal">
                                    <i class="mdi mdi-plus-circle mr-2"></i>
                                    Thêm đặc điểm
                                </button>
                                <a href="?xoa_dacdiem=all" class="btn btn-danger ml-2 shadow-none"><i class="mdi mdi-trash-can mr-2"></i>Xóa hết</a>
                            </div>
                        </div>
                        <div class="modal fade" id="createFeatureModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title d-flex align-items-center">
                                                <i class="mdi mdi-plus-circle mr-2"></i>
                                                <span>Thêm đặc điểm</span>
                                            </h5>
                                            <button type="reset" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Tên đặc điểm<span class="text-danger">*</span></label>
                                                <input type="text" name="ten_dacdiem" class="form-control shadow-none" value="<?php if(isset($form_data['ten_dacdiem'])) echo $form_data['ten_dacdiem']?>">
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Đóng</button>
                                                <button type="submit" name="them_dacdiem" class="btn btn-success">Thêm</button>
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
                                    <th>Tên đặc điểm</th>
                                    <th width="15%">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $query = "SELECT * FROM dacdiem ORDER BY ma_dacdiem DESC";
                                $data = mysqli_query($conn, $query);
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($data)) {
                                    echo "<tr>
                                            <td>$i</td>
                                            <td>{$row['ten_dacdiem']}</td>             
                                            <td class='d-flex align-items-center justify-content-around'>
                                                <button type='button' class='btn bg-transparent text-primary p-0 shadow-none' data-toggle='modal' data-target='#editFeatureModal{$row['ma_dacdiem']}'>
                                                    <i class='mdi mdi-pen' style='font-size: 23px'></i>
                                                </button>
                                                <!-- Modal Edit cho từng hàng -->
                                                <div class='modal fade' id='editFeatureModal{$row['ma_dacdiem']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <form method='post'>
                                                                <div class='modal-header'>
                                                                    <h5 class='modal-title d-flex align-items-center'>
                                                                        <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                        <span>Chỉnh sửa đặc điểm</span>
                                                                    </h5>
                                                                    <button type='button' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                        <span aria-hidden='true'>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class='modal-body'>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Tên đặc điểm<span class='text-danger'>*</span></label>
                                                                        <input type='hidden' name='ma_dacdiem' value='{$row['ma_dacdiem']}'>
                                                                        <input type='text' name='ten_dacdiem' class='form-control shadow-none' value='{$row['ten_dacdiem']}'>
                                                                    </div>
                                                                    <div class='d-flex align-items-center justify-content-end'>
                                                                        <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Đóng</button>
                                                                        <button type='submit' name='chinhsua_dacdiem' class='btn btn-success'>Chỉnh sửa</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href='?xoa_dacdiem={$row['ma_dacdiem']}' class='fa-2x text-danger ml-2'><i class='mdi mdi-trash-can'></i></a>                  
                                            </td>
                                          </tr>";
                                    $i++;
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card text-black mb-5">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Dịch vụ</h4>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-primary shadow-none" data-toggle="modal" data-target="#createServiceModal">
                                    <i class="mdi mdi-plus-circle mr-2"></i>
                                    Thêm dịch vụ
                                </button>
                                <a href="?xoa_dichvu=all" class="btn btn-danger ml-2 shadow-none"><i class="mdi mdi-trash-can mr-2"></i>Xóa hết</a>
                            </div>
                        </div>
                        <div class="modal fade" id="createServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5 class="modal-title d-flex align-items-center">
                                                <i class="mdi mdi-plus-circle mr-2"></i>
                                                <span>Thêm dịch vụ</span>
                                            </h5>
                                            <button type="reset" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Tên dịch vụ<span class="text-danger">*</span></label>
                                                <input type="text" name="ten_dichvu" class="form-control shadow-none">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Hình ảnh<span class="text-danger">*</span></label>
                                                <input type="file" name="anh_dichvu" class="form-control shadow-none" style="height: fit-content">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Mô tả<span class="text-danger">*</span></label>
                                                <textarea name="mo_ta" class="form-control shadow-none" rows='5'></textarea>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Đóng</button>
                                                <button type="submit" name="them_dichvu" class="btn btn-success">Thêm</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-striped table-bordered" id="myTable">
                            <thead class="bg-dark text-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Tên dich vụ</th>
                                <th>Hình ảnh</th>
                                <th width="45%">Mô tả</th>
                                <th width="15%">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $query = "SELECT * FROM dichvu ORDER BY ma_dichvu DESC";
                                $data = mysqli_query($conn, $query);
                                $path = SERVICES_IMG_PATH;
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($data)) {
                                    echo "<tr>
                                            <td>$i</td>
                                            <td>{$row['ten_dichvu']}</td>             
                                            <td>
                                                <img src='$path{$row['anh_dichvu']}' class='rounded mx-auto d-block' width='100px'>
                                            </td>             
                                            <td class='custom-cell'>{$row['mo_ta']}</td>                      
                                            <td class='d-flex align-items-center justify-content-around'>
                                                <button type='button' class='btn bg-transparent text-primary p-0 shadow-none' data-toggle='modal' data-target='#editServiceModal{$row['ma_dichvu']}'>
                                                    <i class='mdi mdi-pen' style='font-size: 23px'></i>
                                                </button>
                                
                                                <!-- Modal Edit cho từng hàng -->
                                                <div class='modal fade' id='editServiceModal{$row['ma_dichvu']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <form method='post' enctype='multipart/form-data'>
                                                                <div class='modal-header'>
                                                                    <h5 class='modal-title d-flex align-items-center'>
                                                                        <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                        <span>Chỉnh sửa dịch vụ</span>
                                                                    </h5>
                                                                    <button type='button' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                        <span aria-hidden='true'>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class='modal-body'>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Tên dịch vụ<span class='text-danger'>*</span></label>
                                                                        <input type='hidden' name='ma_dichvu' value='{$row['ma_dichvu']}'>
                                                                        <input type='text' name='ten_dichvu' class='form-control shadow-none' value='{$row['ten_dichvu']}'>
                                                                    </div>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Hình ảnh<span class='text-danger'>*</span></label>
                                                                        <input type='file' name='anh_dichvu' class='form-control shadow-none' style='height: fit-content'>
                                                                    </div>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Mô tả<span class='text-danger'>*</span></label>
                                                                        <textarea name='mo_ta' class='form-control shadow-none' rows='5'>{$row['mo_ta']}</textarea>
                                                                    </div>
                                                                    <div class='d-flex align-items-center justify-content-end'>
                                                                        <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Đóng</button>
                                                                        <button type='submit' name='chinhsua_dichvu' class='btn btn-success'>Chỉnh sửa</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href='?xoa_dichvu={$row['ma_dichvu']}' class='fa-2x text-danger ml-2'><i class='mdi mdi-trash-can'></i></a>                  
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