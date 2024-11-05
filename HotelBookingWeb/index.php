<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Sona Template">
    <meta name="keywords" content="Sona, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- css - icon - font -->
    <title>NiKa Hotel - Home</title>
    <?php require ('Inc/links.php')?>
</head>

<body>
    <!-- Header -->
    <?php require ('Inc/header.php')?>

    <!-- Hero Section Begin -->
    <section class="hero-section mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="hero-text">
                        <h1>Kira A Luxury Hotel</h1>
                        <p>Here are the best hotel booking sites, including recommendations for international
                            travel and for finding low-priced hotel rooms.</p>
                        <a href="#" class="primary-btn">Discover Now</a>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                    <div class="booking-form">
                        <h3>Booking Your Hotel</h3>
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
                                <label>Adult:</label>
                                <select>
                                    <option value="1">1 Adults</option>
                                    <option value="2">2 Adults</option>
                                    <option value="3">3 Adults</option>
                                </select>
                            </div>
                            <div class="select-option">
                                <label>Children:</label>
                                <select id="room">
                                    <option value="1">1 Children</option>
                                    <option value="2">2 Children</option>
                                    <option value="3">3 Children</option>
                                </select>
                            </div>
                            <button type="submit">Check Availability</button>
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
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="Public/img/room/room-b1.jpg">
                            <div class="hr-text">
                                <h3>Simple Room Name</h3>
                                <h2 class="mb-3">200$<span>/Pernight</span></h2>
                                <div class="feature mb-2">
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        2 Rooms
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        1 Bath
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        1 Balcony
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        3 Sofa
                                    </span>
                                </div>
                                <div class="rating mb-4">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>                                    
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Roomheater,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="btn btn-success me-3">Book Now</a>
                                <a href="#" class="primary-btn color-success">More details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="Public/img/room/room-b2.jpg">
                            <div class="hr-text">
                                <h3>Premium King Room</h3>
                                <h2 class="mb-3">159$<span>/Pernight</span></h2>
                                <div class="feature mb-2">
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        2 Rooms
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        1 Bath
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        1 Balcony
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        3 Sofa
                                    </span>
                                </div>
                                <div class="rating mb-4">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>                 
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="btn btn-success me-3">Book Now</a>
                                <a href="#" class="primary-btn color-success">More details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="Public/img/room/room-b3.jpg">
                            <div class="hr-text">
                                <h3>Deluxe Room</h3>
                                <h2 class="mb-3">198$<span>/Pernight</span></h2>
                                <div class="feature mb-2">
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        2 Rooms
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        1 Bath
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        1 Balcony
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        3 Sofa
                                    </span>
                                </div>
                                <div class="rating mb-4">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>                 
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="btn btn-success me-3">Book Now</a>
                                <a href="#" class="primary-btn color-success">More details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="hp-room-item set-bg" data-setbg="Public/img/room/room-b4.jpg">
                            <div class="hr-text">
                                <h3>Family Room</h3>
                                <h2 class="mb-3">299$<span>/Pernight</span></h2>
                                <div class="feature mb-2">
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        2 Rooms
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        1 Bath
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        1 Balcony
                                    </span>
                                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap" style="font-size: 14px;">
                                        3 Sofa
                                    </span>
                                </div>
                                <div class="rating mb-4">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                </div>                 
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="r-o">Size:</td>
                                            <td>30 ft</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Capacity:</td>
                                            <td>Max persion 5</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Bed:</td>
                                            <td>King Beds</td>
                                        </tr>
                                        <tr>
                                            <td class="r-o">Services:</td>
                                            <td>Wifi, Television, Bathroom,...</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="#" class="btn btn-success me-3">Book Now</a>
                                <a href="#" class="primary-btn color-success">More details</a>
                            </div>
                        </div>
                    </div>
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
                        <span>Testimonials</span>
                        <h2>What Customers Say?</h2>
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

    <!-- Footer -->
    <?php require ('Inc/footer.php')?>

    <!-- Javascript - Jquery -->
    <?php require ('Inc/scripts.php')?>
</body>

</html>