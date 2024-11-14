<?php
    ob_start();
    session_start();
    define('SERVICES_IMG_PATH', '/Admin/Public/images/services/');
    define('ROOMS_IMG_PATH', '/Admin/Public/images/rooms/');
    define('CUSTOMERS_IMG_PATH', '/Admin/Public/images/customers/');
    define('STAFF_IMG_PATH', '/Admin/Public/images/staff/');
    define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/Admin/Public/images/');
    define('SERVICES_FOLDER', 'services/');
    define('ROOMS_FOLDER', 'rooms/');
    define('CUSTOMER_FOLDER', 'customers/');
    define('STAFF_FOLDER', 'staff/');

    function Login()
    {
        if(empty($_SESSION['ma_tk_nv'])){
            redirect("login.php");
        } else {
            if (isset($_SESSION['hoat_dong']) && (time() - $_SESSION['hoat_dong']) > 900) {
                session_unset();
                session_destroy();
                session_start();
                $_SESSION['error'] = "Bạn đã bị đăng xuất vì không hoạt động quá lâu!";
                header("Location: login.php");
                exit;
            }
            $_SESSION['hoat_dong'] = time();
        }
    }

    function redirect($url)
    {
        echo "<script>window.location.href='$url'</script>";
    }

    function alert($type, $msg)
    {
        $bg_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo "<div class='d-flex justify-content-center'>
                <div class='alert {$bg_class} alert-dismissible fade show m-0 d-flex text-center mb-2 mt-2' role='alert' style='width: fit-content'>
                    <strong>$msg</strong>
                    <button type='button' class='close' data-dismiss='alert' aria-label='close'>
                    <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
              </div>";
    }

    function uploadImage($image, $folder): string
    {
        $valid_mine = ['image/png', 'image/jpeg', 'image/wedp'];
        $img_mine = $image['type'];

       if(!in_array($img_mine, $valid_mine)) {
           return 'inv_img';
       } else if(($image['size'] / (1024 * 1024)) > 2) {
           return 'inv_size';
       } else {
           $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
           $rname = 'IMG_'.random_int(11111, 99999).".$ext";

           $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
           if(move_uploaded_file($image['tmp_name'], $img_path)) {
               return $rname;
           }
       }
       return 'upl_failed';
    }

    function deleteImage($image, $folder): bool
    {
        if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)) {
            return true;
        }
        return false;
    }
?>