<nav class="sidebar sidebar-offcanvas position-fixed" style="left: 0px" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="statistics.php?songay=7ngay">
                <span class="icon-bg"><i class="mdi mdi-chart-bar menu-icon"></i></span>
                <span class="menu-title">Thống kê</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#datphong" aria-expanded="false" aria-controls="ui-basic">
                <span class="icon-bg"><i class="mdi mdi-library-books menu-icon"></i></span>
                <span class="menu-title">Đặt phòng</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="datphong">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="books.php">Đơn mới nhận</a></li>
                    <li class="nav-item"> <a class="nav-link" href="books_history.php">Lịch sử</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="rooms.php">
                <span class="icon-bg"><i class="mdi mdi-hotel menu-icon"></i></span>
                <span class="menu-title">Phòng</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="features_services.php">
                <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
                <span class="menu-title">Đặc điểm và dịch vụ</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#khachhang" aria-expanded="false" aria-controls="ui-basic">
                <span class="icon-bg"><i class="mdi mdi-human-male menu-icon"></i></span>
                <span class="menu-title">Khách hàng</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="khachhang">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="customers.php">Thông tin</a></li>
                    <li class="nav-item"> <a class="nav-link" href="contact.php">Liên hệ</a></li>
                </ul>
            </div>
        </li>
        <?php
            $taikhoan = mysqli_fetch_assoc(select("SELECT * FROM taikhoan WHERE ma_tk = ?", [$_SESSION['ma_tk_nv']], "i"));
            if($taikhoan['quyen'] == 'admin'){
                echo "<li class='nav-item'>
                        <a class='nav-link' href='staff.php'>
                            <span class='icon-bg'><i class='mdi mdi-human menu-icon'></i></span>
                            <span class='menu-title'>Nhân viên</span>
                        </a>
                    </li>";
            }
        ?>
    </ul>
</nav>