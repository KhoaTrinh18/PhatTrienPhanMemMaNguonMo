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
                                <li><a href="index.php">Home</a></li>
                                <li><a href="rooms.php">Rooms</a></li>
                                <li><a href="services.php">Services</a>
<!--                                <li><a href="./about-us.html">About Us</a></li>-->
<!--                                    <ul class="dropdown">-->
<!--                                        <li><a href="./room-details.html">Room Details</a></li>-->
<!--                                        <li><a href="./blog-details.html">Blog Details</a></li>-->
<!--                                        <li><a href="#">Family Room</a></li>-->
<!--                                        <li><a href="#">Premium Room</a></li>-->
<!--                                    </ul>-->
<!--                                </li>-->
                                <li><a href="contact.php">Contact Us</a></li>
<!--                                <li><a href="about.php">About</a></li>-->
                            </ul>
                        </nav>
                        <div class="nav-right">
                            <button type="button" class="btn btn-outline-dark shadow-none me-2" data-toggle="modal" data-target="#loginModal">
                                Login
                            </button>
                            <button type="button" class="btn btn-outline-dark shadow-none" data-toggle="modal" data-target="#registerModal">
                                Register
                            </button>
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
            <form>
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-circle fs-2 me-2"></i>
                        <span>User Login</span>
                    </h5>
                    <button type="reset" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control shadow-none">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control shadow-none">
                    </div>
                    <div class="d-flex align-items-center flex-column mb-2">
                        <button type="submit" class="btn btn-dark shadow-none mb-2">Login</button>
                        <a href="javascript: void(0)" class="text-secondary text-decoration-none">Forgot Password?</a>
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
            <form>
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-lines-fill fs-2 me-2"></i>
                        <span>User Registration</span>
                    </h5>
                    <button type="reset" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base" style="font-size: 14px;">
                        Note: Your detail must match with your ID (Citizen identification, Passport, Driving license, etc)
                        that will be required during check-in
                    </span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 p-0">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="number" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Picture</label>
                                <input type="file" class="form-control shadow-none">
                            </div>
                            <div class="col-md-12 p-0 mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" rows="1"></textarea>
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="number" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Date of birth</label>
                                <input type="date" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control shadow-none">
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-dark shadow-none">Register</button>
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



