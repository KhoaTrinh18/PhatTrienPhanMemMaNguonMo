<?php
    require ('Inc/connect_db.php');
    require ('Inc/essentials.php');
    session_start();
    if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == true) {
        redirect('dashboard.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Connect Plus</title>

    <?php require ('Inc/links.php')?>
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <?php
                        if(isset($_POST['login'])){
                            //Loc du lieu
                            $form_data = filteration($_POST);

                            $query = 'SELECT * FROM admin WHERE admin_name = ? AND admin_pass = ?';
                            $values = array($form_data["admin_name"],$form_data["admin_pass"]);
                            $result = select($query, $values, "ss");
                            if($result->num_rows == 1){
                                $row = mysqli_fetch_assoc($result);
                                $_SESSION['admin_login'] = true;
                                $_SESSION['admin_id'] = $row['admin_id'];
                                redirect("dashboard.php");
                                alert("success", "Login successed! Invalid username or password!");
                            }else{
                                alert("error", "Login failed! Invalid username or password!");
                            }
                        }
                        ?>
                        <div class="auth-form-light text-left p-5">
                            <div class="text-center">
                                <h1>Admin Login</h1>
                                <h6 class="font-weight-light">Sign in to continue.</h6>
                            </div>
                            <form class="pt-3" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" placeholder="Username"
                                           name="admin_name" value="<?php echo (isset($_POST['admin_name'])) ? $_POST['admin_name'] : "";?>">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" placeholder="Password"
                                           name="admin_pass" value="<?php echo (isset($_POST['admin_name'])) ? $_POST['admin_pass'] : "";?>">
                                </div>
                                <div class="mt-3">
                                    <input type="submit" name="login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="SIGN IN">
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                                    </div>
                                    <a href="#" class="auth-link text-black">Forgot password?</a>
                                </div>
                                <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="register.html" class="text-primary">Create</a>
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