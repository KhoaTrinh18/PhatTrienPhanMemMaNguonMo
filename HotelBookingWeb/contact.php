<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NiKa Hotel - Liên hệ</title>
    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>
</head>

<body>
    <!-- Header -->
    <?php require ('Inc/header.php'); ?>

    <!-- Contact Section Begin -->
    <section class="contact-section spad mt-5">
        <?php
            if (isset($_SESSION['success'])) {
                alert("success", $_SESSION['success']);
                unset($_SESSION['success']);
            }

            if (isset($_SESSION['error'])) {
                alert("error", $_SESSION['error']);
                unset($_SESSION['error']);
            }

            if(isset($_POST["gui"])){
                $form_data = filteration($_POST);
                if(empty($form_data['ten_kh'])){
                    $_SESSION['error'] = "Tên không được để trống!";
                } else if(!preg_match('/^[\p{L}\d\s]+$/u', $form_data['ten_kh'])) {
                    $_SESSION['error'] = "Tên không chứa kí tự đặc biệt!";
                } else if(preg_match('/[0-9]/', $form_data['ten_kh'])){
                    $_SESSION['error'] = "Tên không chứa số!";
                } else if(empty($form_data['email'])){
                    $_SESSION['error'] = "Email không được để trống!";
                } else if(!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)){
                    $_SESSION['error'] = "Email không hợp lệ!";
                } else if(empty($form_data['noi_dung'])){
                    $_SESSION['error'] = "Nội dung không được để trống!";
                } else {
                    $query = "INSERT INTO `lienhe`(`ten_kh`, `email`, `tieu_de`, `noi_dung`) VALUES (?, ?, ?, ?)";
                    $values = array($form_data['ten_kh'], $form_data['email'], $form_data['tieu_de'], $form_data['noi_dung']);
                    $result = insert($query, $values, "ssss");
                    if($result) {
                        $_SESSION['success'] = "Gửi thành công! Cảm ơn bạn đã liên hệ!";
                    } else {
                        $_SESSION['error'] = "Gửi thất bại! Thử lại sau!";
                    }
                }
                header("Location: contact.php");
                exit;
            }
        ?>
        <?php require('Inc/login_register.php'); ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="contact-text">
                        <h2>Thông tin liên hệ</h2>
                        <table>
                            <tbody>
                            <tr>
                                <td class="c-o">Địa chỉ:</td>
                                <td>Khu Bãi Dương, Vĩnh Phước, Nha Trang, Khánh Hòa</td>
                            </tr>
                            <tr>
                                <td class="c-o">Phone:</td>
                                <td>(+84) 0368410685</td>
                            </tr>
                            <tr>
                                <td class="c-o">Email:</td>
                                <td>trinhkhoa1811@gmail.com</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <form class="contact-form" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="ten_kh" placeholder="Tên">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="email" placeholder="Email">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" name="tieu_de" placeholder="Tiêu đề">
                                <textarea name="noi_dung" placeholder="Nội dung"></textarea>
                                <button name="gui" type="submit">Gửi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31188.917772516386!2d109.16324877431643!3d12.274331400000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317067ee6aa41d05%3A0x34e05c23b1d7a999!2zS2jDoWNoIFPhuqFuIE3GsOG7nW5nIFRoYW5oIEx1eHVyeSBWaeG7hW4gVHJp4buBdQ!5e0!3m2!1svi!2s!4v1730035375932!5m2!1svi!2s"
                        width="600" height="470" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Footer -->
    <?php require ('Inc/footer.php')?>

    <!-- Javascript - Jquery -->
    <?php require('Inc/scripts.php') ?>
</body>

</html>