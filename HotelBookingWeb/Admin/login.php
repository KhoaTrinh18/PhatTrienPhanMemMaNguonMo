<?php
    require ('Inc/connect_db.php');
    require ('Inc/essentials.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Đăng nhập</title>

    <?php require ('Inc/links.php')?>
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <?php
                            if (isset($_SESSION['success'])) {
                                alert("success", $_SESSION['success']);
                                unset($_SESSION['success']);
                            }

                            if (isset($_SESSION['error'])) {
                                alert("error", $_SESSION['error']);
                                unset($_SESSION['error']);
                            }

                            if(isset($_POST['dang_nhap'])){
                                    $form_data = filteration($_POST);
                                    $query = "SELECT * FROM taikhoan WHERE ten_tk = ? AND mat_khau = ? AND quyen = 'admin' OR quyen = 'nhanvien'";
                                    $values = [$form_data["ten_tk"], $form_data["mat_khau"]];
                                    $result = select($query, $values, "ss");
                                    if(empty($form_data['ten_tk'])){
                                        $_SESSION['error'] = "Tên tài khoản không được để trống!";
                                    } else if(empty($form_data['mat_khau'])){
                                        $_SESSION['error'] = "Mật khẩu không được để trống!";
                                    } else if(mysqli_num_rows($result) == 0){
                                        $_SESSION['error'] = "Tên đăng nhập hoặc mật khẩu không đúng!";
                                    } else {
                                        if($result){
                                            $row = mysqli_fetch_assoc($result);
                                            $_SESSION['ma_tk_nv'] = $row['ma_tk'];
                                            $_SESSION['success'] = "Đăng nhập thành công!";
                                            header('location: dashboard.php');
                                            exit;
                                        } else {
                                            $_SESSION['error'] = "Có lỗi xảy ra!";
                                        }
                                    }
                                }
                        ?>
                        <div class="auth-form-light text-left p-5">
                            <div class="text-center">
                                <h1>Đăng nhập</h1>
                                <h6 class="font-weight-light">Đăng nhập để tiếp tục.</h6>
                            </div>
                            <form class="pt-3" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" placeholder="Tên tài khoản"
                                           name="ten_tk">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" placeholder="Mật khẩu"
                                           name="mat_khau">
                                </div>
                                <div class="mt-3">
                                    <input type="submit" name="dang_nhap" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="Đăng nhập">
                                </div>
                                <div class="text-center mt-4 font-weight-light"> Bạn chưa có tài khoản? <a href="register.php" class="text-primary">Đăng ký</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <!-- Javascript - Jquery -->
    <?php require ('Inc/scripts.php')?>
</body>
</html>