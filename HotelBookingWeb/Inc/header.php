<?php
    require ('Admin/Inc/connect_db.php');
    require ('Admin/Inc/essentials.php');
?>

<!-- Header Section Begin -->
<header class="header-section fixed-top bg-white shadow-sm">
    <div class="menu-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="logo py-3">
                        <a href="./index.php">
                            <span class="navbar-brand fw-bold fs-3 h-font text-decoration-none">NiKa Hotel<span style="color: orange">.</span></span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="nav-menu">
                        <nav class="mainmenu">
                            <ul>
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><a href="rooms.php">Phòng</a></li>
                                <li><a href="services.php">Dịch vụ</a>
<!--                                <li><a href="./about-us.html">About Us</a></li>-->
<!--                                    <ul class="dropdown">-->
<!--                                        <li><a href="./room-details.html">Room Details</a></li>-->
<!--                                        <li><a href="./blog-details.html">Blog Details</a></li>-->
<!--                                        <li><a href="#">Family Room</a></li>-->
<!--                                        <li><a href="#">Premium Room</a></li>-->
<!--                                    </ul>-->
<!--                                </li>-->
                                <li><a href="contact.php">Liên hệ</a></li>
<!--                                <li><a href="about.php">About</a></li>-->
                            </ul>
                        </nav>
                        <div class="nav-right">
                            <?php
                                if(empty($_SESSION['ma_tk_kh'])){
                                    echo "<button type='button' class='btn btn-outline-dark shadow-none me-2' data-toggle='modal' data-target='#loginModal'>
                                            Đăng nhập
                                        </button>
                                        <button type='button' class='btn btn-outline-dark shadow-none' data-toggle='modal' data-target='#registerModal'>
                                            Đăng ký
                                        </button>";
                                } else {
                                    $result = select("SELECT * FROM taikhoan WHERE ma_tk = ?",[$_SESSION['ma_tk_kh']], 'i');
                                    $row = mysqli_fetch_assoc($result);
                                    echo "<div>
                                            <span class='mr-2'>Hello, ".$row['ten_tk']. "</span>
                                            <a href='logout.php' type='button' class='btn btn-outline-danger shadow-none'>
                                                Đăng xuất
                                            </a>
                                        </div>";
                                    if (isset($_SESSION['hoat_dong']) && (time() - $_SESSION['hoat_dong']) > 900) {
                                        session_unset();
                                        session_destroy();
                                        session_start();
                                        $_SESSION['error'] = "Bạn đã bị đăng xuất vì không hoạt động quá lâu!";
                                        header("Location: index.php");
                                        exit;
                                    }
                                    $_SESSION['hoat_dong'] = time();
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Header End -->

<!-- Login -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-circle fs-2 me-2"></i>
                        <span>Đăng nhập người dùng</span>
                    </h5>
                    <button type="reset" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Tên tài khoản<span class="text-danger">*</span></label>
                        <input type="text" name="ten_tk" class="form-control shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mật khẩu<span class="text-danger">*</span></label>
                        <input type="password" name="mat_khau" class="form-control shadow-none">
                    </div>
                    <div class='d-flex align-items-center flex-column mb-2'>
                        <button type='submit' name='dang_nhap' class='btn btn-dark shadow-none mb-2'>Đăng nhập</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- Register -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-lines-fill fs-2 me-2"></i>
                        <span>Đăng kí người dùng</span>
                    </h5>
                    <button type="reset" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base" style="font-size: 14px;">
                        Ghi chú: Chi tiết bạn cung cấp phải giống chính xác với thẻ căn cước, passport, giấy phép lái xe, ... bạn cung cấp
                        vì nó cần thiết trong suốt quá trình checkin
                    </span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Tên<span class="text-danger">*</span></label>
                                <input type="text" name="ten_kh" class="form-control shadow-none">
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
                                <label class="form-label">Ảnh của bạn<span class="text-danger">*</span></label>
                                <input type="file" name="anh_kh" class="form-control shadow-none">
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
                    <div class="text-center">
                        <button type="submit" name="dang_ky" class="btn btn-dark shadow-none">Đăng ký</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const currentUrl = window.location.href;
        const navItems = document.querySelectorAll(".mainmenu ul li a");

        navItems.forEach(link => {
            if (currentUrl.includes(link.getAttribute("href"))) {
                link.parentElement.classList.add("active");
            } else {
                link.parentElement.classList.remove("active");
            }

            if (currentUrl.includes("room_detail.php")) {
                if (link.getAttribute("href").includes("rooms.php")) {
                    link.parentElement.classList.add("active");
                }
            }
        });
    });
</script>



