<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- css - icon - font -->
    <title>NiKa Hotel - Trang chủ</title>
    <?php require ('Inc/links.php')?>
</head>

<body>
    <!-- Header -->
    <?php require ('Inc/header.php')?>
    <div style="margin-top: 92px">
        <?php
            require ('Inc/login.php');
        ?>
    </div>

    <!-- Hero Section Begin -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>Nika A Luxury Hotel</h1>
                        <p>Here are the best hotel booking sites, including recommendations for international
                            travel and for finding low-priced hotel rooms.</p>
                        <a href="#" class="primary-btn">Discover Now</a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <h3>Đặt phòng</h3>
                        <form>
                            <div class="check-date">
                                <label>Check In:</label>
                                <input type="text" class="date-input">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="check-date">
                                <label>Check Out:</label>
                                <input type="text" class="date-input">
                                <i class="icon_calendar"></i>
                            </div>
                            <div class="select-option">
                                <label>Số lượng người lớn:</label>
                                <select>
                                    <option value="1">1 Adults</option>
                                    <option value="2">2 Adults</option>
                                    <option value="3">3 Adults</option>
                                </select>
                            </div>
                            <div class="select-option">
                                <label>Số lượng trẻ em:</label>
                                <select id="room">
                                    <option value="1">1 Children</option>
                                    <option value="2">2 Children</option>
                                    <option value="3">3 Children</option>
                                </select>
                            </div>
                            <button type="submit">Kiểm tra</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="Public/img/hero/hero-1.jpg"></div>
            <div class="hs-item set-bg" data-setbg="Public/img/hero/hero-2.jpg"></div>
            <div class="hs-item set-bg" data-setbg="Public/img/hero/hero-3.jpg"></div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- About Us Section Begin -->
    <section class="aboutus-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-text">
                        <div class="section-title">
                            <span>About Us</span>
                            <h2>Intercontinental LA <br />Westlake Hotel</h2>
                        </div>
                        <p class="f-para">Nika.com is a leading online accommodation site. We’re passionate about
                            travel. Every day, we inspire and reach millions of travelers across 90 local websites in 41
                            languages.</p>
                        <p class="s-para">So when it comes to booking the perfect hotel, vacation rental, resort,
                            apartment, guest house, or tree house, we’ve got you covered.</p>
                        <a href="#" class="primary-btn about-btn">Read More</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-pic">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="Public/img/about/about-1.jpg" alt="">
                            </div>
                            <div class="col-sm-6">
                                <img src="Public/img/about/about-2.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Section End -->

    <!-- Home Room Section Begin -->
    <section class="hp-room-section">
        <div class="container-fluid">
            <div class="hp-room-items">
                <div class="row">
                    <?php
                    $result = select("SELECT * FROM phong WHERE trang_thai= ? ORDER BY ma_phong DESC", [1], 'i');
                    $path = ROOMS_IMG_PATH;
                    $i = 0;

                    while ($row = mysqli_fetch_assoc($result)) {
                        if($i == 4){
                            break;
                        }
                        //Feature
                        $query1 = "SELECT * FROM phong_dacdiem JOIN dacdiem ON dacdiem.ma_dacdiem = phong_dacdiem.ma_dacdiem WHERE ma_phong = ?";
                        $res_room_fea = select($query1, [$row['ma_phong']], "i");
                        $feature = "";
                        while($row1 = mysqli_fetch_assoc($res_room_fea)){
                            $feature .= $row1['ten_dacdiem'].", ";
                        }
                        $feature = rtrim($feature, ", ");
                        //Service
                        $query2 = "SELECT * FROM phong_dichvu JOIN dichvu ON dichvu.ma_dichvu = phong_dichvu.ma_dichvu WHERE ma_phong = ?";
                        $res_room_ser = select($query2, [$row['ma_phong']], "i");
                        $service = "";
                        while($row2 = mysqli_fetch_assoc($res_room_ser)){
                            $service .= $row2['ten_dichvu'].", ";
                        }
                        $service = rtrim($service, ", ");

                        echo "<div class='col-lg-3 col-md-6'>
                                <div class='room-item'>
                                    <img src='$path{$row['anh_phong']}' alt=''>
                                    <div class='ri-text'>
                                        <h4>{$row['ten_phong']}</h4>
                                        <h3>".number_format($row['gia'], 0, '', ',')."VNĐ<span>/Đêm</span></h3>
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td class='r-o'>Diện tích:</td>
                                                    <td>{$row['dien_tich']}m²</td>
                                                </tr>
                                                <tr>
                                                    <td class='r-o'>Người lớn:</td>
                                                    <td>Số lượng tối đa {$row['sl_nguoi_lon']}</td>
                                                </tr>
                                                <tr>
                                                    <td class='r-o'>Trẻ em:</td>
                                                    <td>Số lượng tối đa {$row['sl_tre_em']}</td>
                                                </tr>
                                                <tr>
                                                    <td class='r-o'>Đặc điểm:</td>
                                                    <td>$feature</td>
                                                </tr>
                                                <tr>
                                                    <td class='r-o'>Dịch vụ:</td>
                                                    <td>$service</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class='d-flex justify-content-center align-items-center'>
                                            <a href='#' class='btn btn-success me-3'>Đặt ngay</a>
                                            <a href='room_detail.php?id={$row['ma_phong']}' class='primary-btn'>Chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                        $i++;
                    }
                    ?>

                </div>
            </div>
        </div>
    </section>
    <!-- Home Room Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Bình luận</span>
                        <h2>Những gì khách hàng nói?</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="testimonial-slider owl-carousel">
                        <div class="ts-item">
                            <p>After a construction project took longer than expected, my husband, my daughter and I
                                needed a place to stay for a few nights. As a Chicago resident, we know a lot about our
                                city, neighborhood and the types of housing options available and absolutely love our
                                vacation at Sona Hotel.</p>
                            <div class="ti-author">
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img src="Public/img/testimonial-logo.png" alt="">
                        </div>
                        <div class="ts-item">
                            <p>After a construction project took longer than expected, my husband, my daughter and I
                                needed a place to stay for a few nights. As a Chicago resident, we know a lot about our
                                city, neighborhood and the types of housing options available and absolutely love our
                                vacation at Sona Hotel.</p>
                            <div class="ti-author">
                                <div class="rating">
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star"></i>
                                    <i class="icon_star-half_alt"></i>
                                </div>
                                <h5> - Alexander Vasquez</h5>
                            </div>
                            <img src="Public/img/testimonial-logo.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Section End -->
    <script>

    </script>
    <!-- Footer -->
    <?php require ('Inc/footer.php')?>

    <!-- Javascript - Jquery -->
    <?php require ('Inc/scripts.php')?>
</body>

</html>