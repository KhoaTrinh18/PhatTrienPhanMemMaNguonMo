<?php
    define('SITE_URL', 'http://127.0.0.1/HotelBookingWeb/');
    define('SERVICES_IMG_PATH', SITE_URL.'Admin/Public/images/services/');
    define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/Admin/Public/images/');
    define('SERVICES_FOLDER', 'services/');

    function adminLogin()
    {
        ob_start();
        session_start();
        if (!(isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == true)) {
            echo "<script>window.location.href='login.php'</script>";
        }
    }

    function redirect($url)
    {
        echo "<script>window.location.href='$url'</script>";
    }

    function alert($type, $msg)
    {
        $bg_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo "<div class='d-flex justify-content-center mb-4'>
                <div class='alert {$bg_class} alert-dismissible fade show m-0 d-flex text-center' role='alert' style='width: fit-content'>
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