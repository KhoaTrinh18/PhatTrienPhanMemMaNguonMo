<?php
    if (isset($_SESSION['success'])) {
        alert("success", $_SESSION['success']);
        unset($_SESSION['success']);
    }

    if (isset($_SESSION['error'])) {
        alert("error", $_SESSION['error']);
        unset($_SESSION['error']);
    }

    if(isset($_POST['dang_ky'])) {
        $form_data = filteration($_POST);
        $result1 = selectAll("taikhoan");
        $ten_tks = [];
        while ($row = mysqli_fetch_assoc($result1)) {
            $ten_tks[] = $row['ten_tk'];
        }
        $result2 = selectAll("khachhang");
        $emails = [];
        $so_dien_thoais = [];
        while ($row = mysqli_fetch_assoc($result2)) {
            $emails[] = $row['email'];
            $so_dien_thoais[] = $row['so_dien_thoai'];
        }
        if (empty($form_data['ten_kh'])) {
            $_SESSION['error'] = "Tên không được để trống!";
        } else if (!preg_match('/^[\p{L}\d\s]+$/u', $form_data['ten_kh'])) {
            $_SESSION['error'] = "Tên không chứa kí tự đặc biệt!";
        } else if (preg_match('/[0-9]/', $form_data['ten_kh'])) {
            $_SESSION['error'] = "Tên không chứa số!";
        } else if (empty($form_data['email'])) {
            $_SESSION['error'] = "Email không được để trống!";
        } else if (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ!";
        } else if (in_array($form_data['email'], $emails)) {
            $_SESSION['error'] = "Email đã tồn tại!";
        } else if (empty($form_data['so_dien_thoai'])) {
            $_SESSION['error'] = "Số điện thoại không được để trống!";
        } else if (!preg_match('/^([+]\d{2})?\d{10}$/', $form_data['so_dien_thoai'])) {
            $_SESSION['error'] = "Số điện thoại không hợp lệ!";
        } else if(in_array($form_data['so_dien_thoai'], $so_dien_thoais)) {
            $_SESSION['error'] = "Số điện thoại đã tồn tại!";
        }else if(empty($form_data['dia_chi'])){
            $_SESSION['error'] = "Địa chỉ không được để trống!";
        } else if(empty($form_data['ngay_sinh'])){
            $_SESSION['error'] = "Ngày sinh không được để trống!";
        } else if(empty($form_data['ten_tk'])){
            $_SESSION['error'] = "Tên tài khoản không được để trống!";
        } else if(in_array($form_data['ten_tk'], $ten_tks)) {
            $_SESSION['error'] = "Tên tài khoản đã tồn tại!";
        } else if(empty($form_data['mat_khau'])){
            $_SESSION['error'] = "Mật khẩu không được để trống!";
        } else if(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $form_data['mat_khau'])){
            $_SESSION['error'] = "Mật khẩu phải có ít nhất 8 kí tự, 1 kí tự đặc biệt, 1 số và 1 chữ hoa!";
        } else if($form_data['xacnhan_mk'] != $form_data['mat_khau']){
            $_SESSION['error'] = "Mật khẩu xác nhận không trùng với mật khẩu!";
        } else {
            $img_r = uploadImage($_FILES['anh_kh'], CUSTOMER_FOLDER);
            if($img_r == 'inv_img'){
                $_SESSION['error'] = "Hình ảnh không hợp lệ!";
            } else if($img_r == 'inv_size'){
                $_SESSION['error'] = "Kích thước hình ảnh không hợp lệ!";
            } else if($img_r == 'upl_failed') {
                $_SESSION['error'] = "Tải hình ảnh thất bại!";
            } else {
                // Them vao bang khach hang
                $query1 = "INSERT INTO `khachhang`(`ten_kh`, `ngay_sinh`, `email`, `so_dien_thoai`, `dia_chi`, `anh_kh`) VALUES (?, ?, ?, ?, ?, ?)";
                $values1 = [$form_data['ten_kh'], $form_data['ngay_sinh'], $form_data['email'], $form_data['so_dien_thoai'], $form_data["dia_chi"], $img_r];
                $result1 = insert($query1, $values1, "ssssss");

                // Them vao bang tai khoan
                $ma_kh = mysqli_insert_id($conn);
                $query2 = "INSERT INTO `taikhoan`(`ten_tk`, `mat_khau`, `ma_nd`, `quyen`) VALUES (?, ?, ?, ?)";
                $mat_khau_bm = password_hash($form_data['mat_khau'], PASSWORD_DEFAULT);
                $values2 = [$form_data['ten_tk'], $mat_khau_bm, $ma_kh, 'khachhang'];
                $result2 = insert($query2, $values2, "ssss");

                if($result1 && $result2){
                    $_SESSION['success'] = "Đăng kí thành công! Mời bạn đăng nhập!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra!";
                }
            }
        }
        header("Location: index.php");
        exit;
    }

    if(isset($_POST['dang_nhap'])){
        $form_data = filteration($_POST);
        if (empty($form_data['ten_tk'])) {
            $_SESSION['error'] = "Tên đăng nhập không được để trống!";
        } else if (empty($form_data['mat_khau'])) {
            $_SESSION['error'] = "Mật khẩu không được để trống!";
        } else {
            $query = "SELECT * FROM taikhoan WHERE ten_tk = ? AND quyen = 'khachhang'";
            $values = [$form_data['ten_tk']];
            $result = select($query, $values, "s");
            if (mysqli_num_rows($result) != 1) {
                $_SESSION['error'] = "Tên đăng nhập hoặc mật khẩu không đúng!";
            } else {
                $row = mysqli_fetch_assoc($result);
                if (password_verify($form_data['mat_khau'], $row['mat_khau'])) {
                    $_SESSION['ma_tk_kh'] = $row['ma_tk'];
                    $_SESSION['success'] = "Đăng nhập thành công!";
                    header("Location: index.php");
                    exit;
                } else {
                    $_SESSION['error'] = "Tên đăng nhập hoặc mật khẩu không đúng!";
                }
            }
        }
        header("Location: index.php");
        exit;
    }
?>