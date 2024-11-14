<?php
    require ('connect_db.php');
    require ('essentials.php');
    Login();
    $result = select("SELECT * FROM `taikhoan` WHERE ma_tk = ?", [$_SESSION['ma_tk_nv']], "i");
    $row = mysqli_fetch_assoc($result);
?>

<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="dashboard.php"><span class="navbar-brand fw-bold fs-3 h-font text-decoration-none" style="color: white">NiKa Hotel<span style="color: orange">.</span></span></a>
        <a class="navbar-brand brand-logo-mini" href="dashboard.php" style="color: white">NK</a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
        <div class="d-flex">
            <button class="navbar-toggler navbar-toggler align-self-center shadow-none" type="button" data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
            </button>
            <div class="search-field d-none d-xl-block">
                <form class="d-flex align-items-center justify-content-between h-100" action="#">
                    <div class="input-group ">
                        <div class="input-group-prepend bg-transparent">
                            <i class="input-group-text border-0 mdi mdi-magnify"></i>
                        </div>
                        <input type="text" class="form-control bg-transparent border-0" placeholder="Search products">
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <span>Xin chào, <?php echo $row['ten_tk']?></span>
            <a href="logout.php" class="btn btn-danger btn-sm m-2 d-flex align-items-center">Đăng xuất</a>
        </div>
    </div>
</nav>
