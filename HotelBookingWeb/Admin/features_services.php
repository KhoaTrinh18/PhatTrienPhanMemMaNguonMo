<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Features and services</title>

    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>

</head>
<body>
<div class="container-scroller">
    <!-- Header -->
    <?php
        require ('Inc/header.php');
        adminLogin();
    ?>

    <div class="container-fluid page-body-wrapper d-flex justify-content-end">
        <?php require ('Inc/sidebar.php')?>
        <div class="main-panel">
            <div class="content-wrapper">
                <?php
                    if (isset($_SESSION['success'])) {
                        alert("success", $_SESSION['success']);
                        unset($_SESSION['success']);
                    }

                    if (isset($_SESSION['error'])) {
                        alert("error", $_SESSION['error']);
                        unset($_SESSION['error']);
                    }

                    if(isset($_POST['create_feature'])){
                        $form_data = filteration($_POST);
                        if(!empty($form_data['feature_name'])){
                            $query = "INSERT INTO features (feature_name) VALUES (?)";
                            $values = array($form_data['feature_name']);
                            $result = insert($query, $values, "s");
                            if($result){
                                $_SESSION['success'] = "Insert row successfully!";
                            }else{
                                $_SESSION['error'] = "Something went wrong!";
                            }
                        } else {
                            $_SESSION['error'] = "Feature name cannot be empty!";
                        }
                        header("Location: features_services.php");
                        exit;
                    }

                    if(isset($_GET['delete_feature'])){
                        $form_data = filteration($_GET);
                        $rooms_fea = selectAll("rooms_features");
                        $flag = 0;
                        $features_id = [];
                        while ($row = mysqli_fetch_assoc($rooms_fea)) {
                            $features_id[] = $row['feature_id'];
                        }
                        if($form_data['delete_feature'] == 'all') {
                            $features = selectAll("features");
                            while ($row = mysqli_fetch_assoc($features)) {
                                if(in_array($row['feature_id'], $features_id)){
                                    $flag = 1;
                                    break;
                                }
                            }
                            if($flag == 0){
                                $query = "DELETE FROM features";
                                if(mysqli_query($conn, $query)){
                                    $_SESSION['success'] = "Delete all row successfully!";
                                }else{
                                    $_SESSION['error'] = "Something went wrong!";
                                }
                            } else {
                                $_SESSION['error'] = "Features is added in room!";
                            }
                        } else if(in_array($form_data['delete_feature'], $features_id)){
                            $_SESSION['error'] = "Features is added in room!";
                        } else {
                            $query = "DELETE FROM features WHERE feature_id = ?";
                            $values = array($form_data['delete_feature']);
                            $result = delete($query, $values, "i");
                            if($result){
                                $_SESSION['success'] = "Delete row successfully!";
                            }else{
                                $_SESSION['error'] = "Something went wrong!";
                            }
                        }
                        header("Location: features_services.php");
                        exit;
                    }

                    if(isset($_POST['update_feature'])){
                        $form_data = filteration($_POST);
                        if(!empty($form_data['feature_name'])){
                            $query = "UPDATE features set feature_name = ? where feature_id = ?";
                            $values = array($form_data['feature_name'], $form_data['feature_id']);
                            $result = insert($query, $values, "si");
                            if($result){
                                $_SESSION['success'] = "Update row successfully!";
                            } else {
                                $_SESSION['error'] = "Something went wrong!";
                            }
                        } else {
                            $_SESSION['error'] = "Feature name can not be empty!";
                        }
                        header("Location: features_services.php");
                        exit;
                    }

                    if(isset($_POST['create_service'])){
                        $form_data = filteration($_POST);
                        if(empty($form_data['service_name'])){
                            $_SESSION['error'] = "Service name can not be empty!";
                        } else if(empty($form_data['desciption'])){
                            $_SESSION['error'] = "Description can not be empty!";
                        } else {
                            $img_r = uploadImage($_FILES['image'], SERVICES_FOLDER);
                            if($img_r == 'inv_img'){
                                $_SESSION['error'] = "Image invalid!";
                            } else if($img_r == 'inv_size'){
                                $_SESSION['error'] = "Image size invalid!";
                            } else if($img_r == 'upl_failed'){
                                $_SESSION['error'] = "Upload image failed!";
                            } else {
                                $query = "INSERT INTO services (service_name, image, description) VALUES (?, ?, ?)";
                                $values = array($form_data['service_name'], $img_r, $form_data['desciption']);
                                $result = insert($query, $values, "sss");
                                if ($result) {
                                    $_SESSION['success'] = "Insert row successfully!";
                                } else {
                                    $_SESSION['error'] = "Something went wrong!";
                                }
                            }
                        }
                        header("Location: features_services.php");
                        exit;
                    }

                    if(isset($_GET['delete_service'])){
                        $form_data = filteration($_GET);
                        $rooms_ser = selectAll("rooms_services");
                        $services_id = [];
                        $flag = 0;
                        while ($row = mysqli_fetch_assoc($rooms_ser)) {
                            $services_id[] = $row['service_id'];
                        }
                        if($form_data['delete_service'] == 'all'){
                            $query = "DELETE FROM services";
                            $services = selectAll("services");
                            $images = [];
                            while($row = mysqli_fetch_assoc($services)){
                                if(in_array($row['service_id'], $services_id)){
                                    $flag = 1;
                                }
                                $images[] = $row['image'];
                            }
                            if($flag == 0){
                                if(mysqli_query($conn, $query)){
                                    foreach ($images as $image) {
                                        deleteImage($image, SERVICES_FOLDER);
                                    }
                                    $_SESSION['success'] = "Delete all row successfully!";
                                }else{
                                    $_SESSION['error'] = "Something went wrong!";
                                }
                            } else {
                                $_SESSION['error'] = "Services is added in room!";
                            }
                        } else if(in_array($form_data['delete_service'], $services_id)) {
                            $_SESSION['error'] = "Service is added in room!";
                        } else {
                            $query = "SELECT * FROM services WHERE service_id = ?";
                            $values = array($form_data['delete_service']);
                            $result = select($query, $values, "i");
                            $row = mysqli_fetch_array($result);
                            if(deleteImage($row['image'], SERVICES_FOLDER)){
                                $query = "DELETE FROM services WHERE service_id = ?";
                                $values = array($form_data['delete_service']);
                                $result = delete($query, $values, "i");
                                if($result){
                                    $_SESSION['success'] = "Delete row successfully!";
                                }else{
                                    $_SESSION['error'] = "Something went wrong!";
                                }
                            } else {
                                $_SESSION['error'] = "Something went wrong!";
                            }
                        }
                        header("Location: features_services.php");
                        exit;
                    }

                    if(isset($_POST['update_service'])){
                        $form_data = filteration($_POST);
                        $query = "SELECT * FROM services WHERE service_id = ?";
                        $values = array($form_data['service_id']);
                        $result = select($query, $values, "i");
                        $row = mysqli_fetch_array($result);
                        if(empty($form_data['service_name'])){
                            $_SESSION['error'] = "Service name can not be empty!";
                        } else if(empty($form_data['description'])){
                            $_SESSION['error'] = "Desciption can not be empty!";
                        } else {
                            if(!empty($_FILES['image']['name'])){
                                $img_r = uploadImage($_FILES['image'], SERVICES_FOLDER);
                            } else {
                                $img_r = $row['image'];
                            }
                            if($img_r == 'inv_img'){
                                $_SESSION['error'] = "Image invalid!";
                            } else if($img_r == 'inv_size'){
                                $_SESSION['error'] = "Image size invalid!";
                            } else if($img_r == 'upl_failed'){
                                $_SESSION['error'] = "Upload image failed!";
                            } else {
                                $query = "UPDATE services SET service_name = ?, image = ?, description = ? where service_id = ?";
                                $values = array($form_data['service_name'], $img_r, $form_data['description'], $form_data['service_id']);
                                $result = update($query, $values, "sssi");
                                if ($result) {
                                    $_SESSION['success'] = "Update row succesfully!";
                                } else {
                                    $_SESSION['error'] = "Something went wrong!";
                                }
                            }
                        }
                        header("Location: features_services.php");
                        exit;
                    }
                    ob_end_flush();
                ?>
                <div class="card text-black mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Features</h4>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary shadow-none" data-toggle="modal" data-target="#createFeatureModal">
                                    <i class="mdi mdi-plus-circle mr-2"></i>
                                    Create feature
                                </button>
                                <a href="?delete_feature=all" class="btn btn-danger ml-2 shadow-none"><i class="mdi mdi-trash-can mr-2"></i>Delete all</a>
                            </div>
                        </div>
                        <div class="modal fade" id="createFeatureModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title d-flex align-items-center">
                                                <i class="mdi mdi-plus-circle mr-2"></i>
                                                <span>Create feature</span>
                                            </h5>
                                            <button type="reset" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Feature name<span class="text-danger">*</span></label>
                                                <input type="text" name="feature_name" class="form-control shadow-none">
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Close</button>
                                                <button type="submit" name="create_feature" class="btn btn-success">Create</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <table class="table table1 table-hover table-striped table-bordered" id="myTable1">
                            <thead class="bg-dark text-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Name</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT * FROM features ORDER BY feature_id DESC";
                                    $data = mysqli_query($conn, $query);
                                    $i = 1;
                                while ($row = mysqli_fetch_assoc($data)) {
                                    echo "<tr>
                                            <td>$i</td>
                                            <td>{$row['feature_name']}</td>             
                                            <th class='d-flex align-items-center justify-content-around'>
                                                <button type='button' class='btn bg-transparent text-primary p-0 shadow-none' data-toggle='modal' data-target='#editFeatureModal{$row['feature_id']}'>
                                                    <i class='mdi mdi-pen' style='font-size: 23px'></i>
                                                </button>
                                
                                                <!-- Modal Edit cho từng hàng -->
                                                <div class='modal fade' id='editFeatureModal{$row['feature_id']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                    <div class='modal-dialog' role='document'>
                                                        <div class='modal-content'>
                                                            <form method='post'>
                                                                <div class='modal-header'>
                                                                    <h5 class='modal-title d-flex align-items-center'>
                                                                        <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                        <span>Edit feature</span>
                                                                    </h5>
                                                                    <button type='button' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                        <span aria-hidden='true'>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class='modal-body'>
                                                                    <div class='mb-3'>
                                                                        <label class='form-label'>Feature name<span class='text-danger'>*</span></label>
                                                                        <input type='hidden' name='feature_id' value='{$row['feature_id']}'>
                                                                        <input type='text' name='feature_name' class='form-control shadow-none' value='{$row['feature_name']}'>
                                                                    </div>
                                                                    <div class='d-flex align-items-center justify-content-end'>
                                                                        <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Close</button>
                                                                        <button type='submit' name='update_feature' class='btn btn-success'>Update</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href='?delete_feature={$row['feature_id']}' class='fa-2x text-danger ml-2'><i class='mdi mdi-trash-can'></i></a>                  
                                            </th>
                                          </tr>";
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card text-black mb-5">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Services</h4>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-primary shadow-none" data-toggle="modal" data-target="#createServiceModal">
                                    <i class="mdi mdi-plus-circle mr-2"></i>
                                    Create service
                                </button>
                                <a href="?delete_service=all" class="btn btn-danger ml-2 shadow-none"><i class="mdi mdi-trash-can mr-2"></i>Delete all</a>
                            </div>
                        </div>
                        <div class="modal fade" id="createServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="modal-header">
                                            <h5 class="modal-title d-flex align-items-center">
                                                <i class="mdi mdi-plus-circle mr-2"></i>
                                                <span>Create service</span>
                                            </h5>
                                            <button type="reset" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Service name<span class="text-danger">*</span></label>
                                                <input type="text" name="service_name" class="form-control shadow-none">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Image<span class="text-danger">*</span></label>
                                                <input type="file" name="image" class="form-control shadow-none" style="height: fit-content">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Desciption<span class="text-danger">*</span></label>
                                                <textarea name="desciption" class="form-control shadow-none" rows='5'></textarea>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Close</button>
                                                <button type="submit" name="create_service" class="btn btn-success">Create</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-striped table-bordered table-responsive" id="myTable">
                            <thead class="bg-dark text-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Name</th>
                                <th>Picture</th>
                                <th width="45%">Description</th>
                                <th width="15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = "SELECT * FROM services ORDER BY service_id DESC";
                            $data = mysqli_query($conn, $query);
                            $path = SERVICES_IMG_PATH;
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($data)) {
                                echo "<tr>
                                        <td>$i</td>
                                        <td>{$row['service_name']}</td>             
                                        <td>
                                            <img src='$path{$row['image']}' class='rounded mx-auto d-block' width='100px'>
                                        </td>             
                                        <td class='custom-cell'>{$row['description']}</td>                      
                                        <th class='d-flex align-items-center justify-content-around'>
                                            <button type='button' class='btn bg-transparent text-primary p-0 shadow-none' data-toggle='modal' data-target='#editServiceModal{$row['service_id']}'>
                                                <i class='mdi mdi-pen' style='font-size: 23px'></i>
                                            </button>
                            
                                            <!-- Modal Edit cho từng hàng -->
                                            <div class='modal fade' id='editServiceModal{$row['service_id']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                <div class='modal-dialog' role='document'>
                                                    <div class='modal-content'>
                                                        <form method='post' enctype='multipart/form-data'>
                                                            <div class='modal-header'>
                                                                <h5 class='modal-title d-flex align-items-center'>
                                                                    <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                    <span>Edit image</span>
                                                                </h5>
                                                                <button type='button' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                    <span aria-hidden='true'>&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class='modal-body'>
                                                                <div class='mb-3'>
                                                                    <label class='form-label'>Service name<span class='text-danger'>*</span></label>
                                                                    <input type='hidden' name='service_id' value='{$row['service_id']}'>
                                                                    <input type='text' name='service_name' class='form-control shadow-none' value='{$row['service_name']}'>
                                                                </div>
                                                                <div class='mb-3'>
                                                                    <label class='form-label'>Image<span class='text-danger'>*</span></label>
                                                                    <input type='file' name='image' class='form-control shadow-none' style='height: fit-content'>
                                                                </div>
                                                                <div class='mb-3'>
                                                                    <label class='form-label'>Desciption<span class='text-danger'>*</span></label>
                                                                    <textarea name='description' class='form-control shadow-none' rows='5'>{$row['description']}</textarea>
                                                                </div>
                                                                <div class='d-flex align-items-center justify-content-end'>
                                                                    <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Close</button>
                                                                    <button type='submit' name='update_service' class='btn btn-success'>Update</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href='?delete_service={$row['service_id']}' class='fa-2x text-danger ml-2'><i class='mdi mdi-trash-can'></i></a>                  
                                        </th>
                                      </tr>";
                                $i++;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require ('Inc/scripts.php');?>
</body>