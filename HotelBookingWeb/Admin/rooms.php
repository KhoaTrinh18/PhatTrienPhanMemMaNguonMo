<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rooms</title>

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

                    if(isset($_POST['create_room'])){
                        $form_fil = array_intersect_key($_POST, array_flip(['room_name', 'area', 'price', 'quantity', 'adult', 'children', 'description']));
                        $form_data = filteration($form_fil);
                        if(empty($form_data['room_name'])){
                            $_SESSION['error'] = "Room name cannot be empty!";
                        } else if(empty($form_data['area'])){
                            $_SESSION['error'] = "Area cannot be empty!";
                        } else if(empty($form_data['price'])) {
                            $_SESSION['error'] = "Price cannot be empty!";
                        } else if(empty($form_data['quantity'])){
                            $_SESSION['error'] = "Quantity cannot be empty!";
                        } else if(empty($form_data['adult'])) {
                            $_SESSION['error'] = "Adult cannot be empty!";
                        } else if(empty($form_data['children'])) {
                            $_SESSION['error'] = "Children cannot be empty!";
                        } else if(empty($form_data['description'])){
                            $_SESSION['error'] = "Description cannot be empty!";
                        } else {
                            $features = filteration($_POST['features']);
                            $services = filteration($_POST['services']);
                            if(!is_numeric($form_data['area'])){
                                $_SESSION['error'] = "Area must be a number!";
                            } else if(!is_numeric($form_data['price'])){
                                $_SESSION['error'] = "Price must be a number!";
                            } else if(!is_numeric($form_data['quantity'])){
                                $_SESSION['error'] = "Quantity must be a number!";
                            } else if(!is_numeric($form_data['adult'])){
                                $_SESSION['error'] = "Adult must be a number!";
                            } else if(!is_numeric($form_data['children'])){
                                $_SESSION['error'] = "Children must be a number!";
                            } else {
                                $img_r = uploadImage($_FILES['image'], ROOMS_FOLDER);
                                if($img_r == 'inv_img'){
                                    $_SESSION['error'] = "Image invalid!";
                                } else if($img_r == 'inv_size'){
                                    $_SESSION['error'] = "Image size invalid!";
                                } else if($img_r == 'upl_failed'){
                                    $_SESSION['error'] = "Upload image failed!";
                                } else {
                                    $query1 = "INSERT INTO `rooms`(`room_name`, `area`, `price`, `quantity`, `adult`, `children`, `image`, `description`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                                    $values = array($form_data['room_name'], $form_data['area'], $form_data['price'], $form_data['quantity'], $form_data['adult'], $form_data['children'], $img_r, $form_data['description']);
                                    $result = insert($query1, $values, "siiiiiss");
                                    $flag = 0;
                                    if($result){
                                        $flag = 1;
                                    }
                                    $room_id = mysqli_insert_id($conn);
                                    $query2 = "INSERT INTO `rooms_services`(`room_id`, `service_id`) VALUES (?, ?)";
                                    if($stmt = mysqli_prepare($conn, $query2)){
                                        foreach ($services as $service) {
                                            mysqli_stmt_bind_param($stmt, "ii", $room_id, $service);
                                            mysqli_stmt_execute($stmt);
                                        }
                                        mysqli_stmt_close($stmt);
                                        $flag = 1;
                                    } else {
                                        die("Query prepare failed - Insert");
                                        $flag = 0;
                                    }
                                    $query3 = "INSERT INTO `rooms_features`(`room_id`, `feature_id`) VALUES (?, ?)";
                                    if($stmt = mysqli_prepare($conn, $query3)){
                                        foreach ($features as $feature) {
                                            mysqli_stmt_bind_param($stmt, "ii", $room_id, $feature);
                                            mysqli_stmt_execute($stmt);
                                        }
                                        mysqli_stmt_close($stmt);
                                        $flag = 1;
                                    } else {
                                        die("Query prepare failed - Insert");
                                        $flag = 0;
                                    }
                                    if($flag == 1){
                                        $_SESSION['success'] = "Insert row successfully!";
                                    } else {
                                        $_SESSION['error'] = "Something went wrong!";
                                    }
                                }
                            }
                        }
                        header("Location: rooms.php");
                        exit;
                    }

                    if(isset($_GET['delete_room'])){
                        $form_data = filteration($_GET);
                        if($form_data['delete_room'] == 'all'){
                            $query1 = "DELETE FROM rooms";
                            $query2 = "DELETE FROM rooms_features";
                            $query3 = "DELETE FROM rooms_services";
                            $rooms = selectAll('rooms');
                            $images = [];
                            while($row = mysqli_fetch_assoc($rooms)){
                                $images[] = $row['image'];
                            }
                            if(mysqli_query($conn, $query2) && mysqli_query($conn, $query3) && mysqli_query($conn, $query1)){
                                foreach ($images as $image) {
                                    deleteImage($image, ROOMS_FOLDER);
                                }
                                $_SESSION['success'] = "Delete all row successfully!";
                            }else{
                                $_SESSION['error'] = "Something went wrong!";
                            }
                        } else {
                            $result = select("SELECT * FROM rooms WHERE `room_id` = ?", [$form_data['delete_room']], 'i');
                            $row = mysqli_fetch_assoc($result);
                            if(deleteImage($row['image'], ROOMS_FOLDER)){
                                $query1 = "DELETE FROM rooms WHERE room_id = ?";
                                $query2 = "DELETE FROM rooms_features WHERE room_id = ?";
                                $query3 = "DELETE FROM rooms_services WHERE room_id = ?";
                                $values = array($form_data['delete_room']);
                                $result2 = delete($query2, $values, "i");
                                $result3 = delete($query3, $values, "i");
                                $result1 = delete($query1, $values, "i");
                                if($result1 && $result2 && $result3){
                                    $_SESSION['success'] = "Delete row successfully!";
                                }else{
                                    $_SESSION['error'] = "Something went wrong!";
                                }
                            } else {
                                $_SESSION['error'] = "Something went wrong!";
                            }
                        }
                        header("Location: rooms.php");
                        exit;
                    }

                    if(isset($_POST['update_room'])){
                        $form_fil = array_intersect_key($_POST, array_flip(['room_name', 'area', 'price', 'quantity', 'adult', 'children', 'description', 'room_id']));
                        $form_data = filteration($form_fil);
                        if(empty($form_data['room_name'])){
                            $_SESSION['error'] = "Room name cannot be empty!";
                        } else if(empty($form_data['area'])){
                            $_SESSION['error'] = "Area cannot be empty!";
                        } else if(empty($form_data['price'])) {
                            $_SESSION['error'] = "Price cannot be empty!";
                        } else if(empty($form_data['quantity'])){
                            $_SESSION['error'] = "Quantity cannot be empty!";
                        } else if(empty($form_data['adult'])) {
                            $_SESSION['error'] = "Adult cannot be empty!";
                        } else if(empty($form_data['children'])) {
                            $_SESSION['error'] = "Children cannot be empty!";
                        } else if(empty($form_data['description'])){
                            $_SESSION['error'] = "Description cannot be empty!";
                        } else {
                            $features = filteration($_POST['features']);
                            $services = filteration($_POST['services']);
                            if(!is_numeric($form_data['area'])){
                                $_SESSION['error'] = "Area must be a number!";
                            } else if(!is_numeric($form_data['price'])){
                                $_SESSION['error'] = "Price must be a number!";
                            } else if(!is_numeric($form_data['quantity'])){
                                $_SESSION['error'] = "Quantity must be a number!";
                            } else if(!is_numeric($form_data['adult'])){
                                $_SESSION['error'] = "Adult must be a number!";
                            } else if(!is_numeric($form_data['children'])){
                                $_SESSION['error'] = "Children must be a number!";
                            } else {
                                $query1 = "UPDATE `rooms` SET `room_name`= ?,`area`= ?,`price`= ?,`quantity`= ?,`adult`= ?,`children`= ?,`description`= ? WHERE `room_id` = ?";
                                $values = array($form_data['room_name'], $form_data['area'], $form_data['price'], $form_data['quantity'], $form_data['adult'], $form_data['children'], $form_data['description'], $form_data['room_id']);
                                $result = update($query1, $values, "siiiiisi");
                                $flag = 0;
                                if($result){
                                   $flag = 1;
                                }
                                $del_service = delete("DELETE FROM `rooms_services` WHERE `room_id` = ?", [$form_data['room_id']], "i");
                                $query2 = "INSERT INTO `rooms_services`(`room_id`, `service_id`) VALUES (?, ?)";
                                if($stmt = mysqli_prepare($conn, $query2)){
                                    foreach ($services as $service) {
                                        mysqli_stmt_bind_param($stmt, "ii",$form_data['room_id'], $service);
                                        mysqli_stmt_execute($stmt);
                                    }
                                    mysqli_stmt_close($stmt);
                                    $flag = 1;
                                } else {
                                    die("Query prepare failed - Update");
                                    $flag = 0;
                                }
                                $del_feature = delete("DELETE FROM `rooms_features` WHERE `room_id` = ?", [$form_data['room_id']], "i");
                                $query3 = "INSERT INTO `rooms_features`(`room_id`, `feature_id`) VALUES (?, ?)";
                                if($stmt = mysqli_prepare($conn, $query3)){
                                    foreach ($features as $feature) {
                                        mysqli_stmt_bind_param($stmt, "ii", $form_data['room_id'], $feature);
                                        mysqli_stmt_execute($stmt);
                                    }
                                    mysqli_stmt_close($stmt);
                                    $flag = 1;
                                } else {
                                    die("Query prepare failed - Insert");
                                    $flag = 0;
                                }
                                if($flag == 1){
                                    $_SESSION['success'] = "Update row successfully!";
                                } else {
                                    $_SESSION['error'] = "Something went wrong!";
                                }
                            }
                            header("Location: rooms.php");
                            exit;
                        }
                    }

                    if(isset($_GET['room_id'])){
                        $query = "SELECT * FROM `rooms` WHERE `room_id` = ?";
                        $values = array($_GET['room_id']);
                        $result1 = select($query, $values, "i");
                        $row = mysqli_fetch_assoc($result1);
                        if($row['status'] == 1){
                            $query = "UPDATE `rooms` SET `status` = '0' WHERE `room_id` = ?";
                        } else {
                            $query = "UPDATE `rooms` SET `status` = '1' WHERE `room_id` = ?";
                        }
                        $result2 = update($query, $values, "i");
                        if($result2){
                            $_SESSION['success'] = "Update status successfully!";
                        } else {
                            $_SESSION['error'] = "Something went wrong!";
                        }
                        header("Location: rooms.php");
                        exit;
                    }
                    ob_end_flush();
                ?>
                <div class="card text-black mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Rooms</h4>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary shadow-none" data-toggle="modal" data-target="#createRoomModal">
                                    <i class="mdi mdi-plus-circle mr-2"></i>
                                    Create room
                                </button>
                                <a href="?delete_room=all" class="btn btn-danger ml-2 shadow-none"><i class="mdi mdi-trash-can mr-2"></i>Delete all</a>
                            </div>
                        </div>
                        <div class="modal fade" id="createRoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content" style="width: 600px">
                                    <form method="post" enctype='multipart/form-data'>
                                        <div class="modal-header">
                                            <h5 class="modal-title d-flex align-items-center">
                                                <i class="mdi mdi-plus-circle mr-2"></i>
                                                <span>Create room</span>
                                            </h5>
                                            <button type="reset" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Room name<span class='text-danger'>*</span></label>
                                                    <input type="text" name="room_name" class="form-control shadow-none">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Price<span class='text-danger'>*</span></label>
                                                    <input type="text" name="price" class="form-control shadow-none">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Adult (Max.)<span class='text-danger'>*</span></label>
                                                    <input type="text" name="adult" class="form-control shadow-none">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Area<span class='text-danger'>*</span></label>
                                                    <input type="text" name="area" class="form-control shadow-none">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Quanity<span class='text-danger'>*</span></label>
                                                    <input type="text" name="quantity" class="form-control shadow-none">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Children (Max.)<span class='text-danger'>*</span></label>
                                                    <input type="text" name="children" class="form-control shadow-none">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Features</label>
                                                <div class="row">
                                                    <?php
                                                        $result = selectAll('features');
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<div class='col-md-3 mb-1'>
                                                                    <label>
                                                                        <input type='checkbox' name='features[]' value='{$row['feature_id']}' class='form-check-input shadow-none ml-0'>
                                                                        <span class='ml-4'>{$row['feature_name']}</span>
                                                                    </label>   
                                                                </div>";
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Services</label>
                                                <div class="row">
                                                    <?php
                                                        $result = selectAll('services');
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<div class='col-md-3 mb-1'>
                                                                        <label>
                                                                            <input type='checkbox' name='services[]' value='{$row['service_id']}' class='form-check-input shadow-none ml-0'>
                                                                            <span class='ml-4'>{$row['service_name']}</span>
                                                                        </label>   
                                                                    </div>";
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Image<span class="text-danger">*</span></label>
                                                    <input type="file" name="image" class="form-control shadow-none" style="height: fit-content">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Desciption<span class='text-danger'>*</span></label>
                                                    <textarea name="description" class="form-control shadow-none" rows="5"></textarea>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-end">
                                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Close</button>
                                                <button type="submit" name="create_room" class="btn btn-success">Create</button>
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
                                    <th>Area</th>
                                    <th>Guests</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT * FROM rooms ORDER BY room_id DESC";
                                    $data = mysqli_query($conn, $query);
                                    $path = ROOMS_IMG_PATH;
                                    $i = 1;
                                    while ($row = mysqli_fetch_assoc($data)) {
                                        if($row['status'] == 1){
                                            $status = "<a href='?room_id={$row['room_id']}' class='btn btn-dark btn-sm shadow-none'>active</a>";
                                        } else {
                                            $status = "<a href='?room_id={$row['room_id']}' class='btn btn-warning btn-sm shadow-none'>inactive</a>";
                                        }
                                        $values = array($row['room_id']);
                                        $res_fea = selectAll('features');
                                        $query1 = "SELECT feature_id FROM rooms_features WHERE room_id = ?";
                                        $res_room_fea = select($query1, $values, "i");
                                        $features_id = [];
                                        while($row1 = mysqli_fetch_assoc($res_room_fea)){
                                            $features_id[] = $row1['feature_id'];
                                        }
                                        $feature = "";

                                        while ($row2 = mysqli_fetch_assoc($res_fea)) {
                                            $check = in_array($row2['feature_id'], $features_id) ? "checked" : "";
                                            $feature .=  "<div class='col-md-3 my-2'>
                                                            <label>
                                                                <input type='checkbox' name='features[]' value='{$row2['feature_id']}' class='form-check-input shadow-none m-0' $check>
                                                                <span class='ml-4'>{$row2['feature_name']}</span>
                                                            </label>
                                                        </div>";
                                        }
                                        $res_ser = selectAll('services');
                                        $query2 = "SELECT service_id FROM rooms_services WHERE room_id = ?";
                                        $res_room_ser = select($query2, $values, "i");
                                        $services_id = [];
                                        while($row3 = mysqli_fetch_assoc($res_room_ser)){
                                            $services_id[] = $row3['service_id'];
                                        }
                                        $service = "";

                                        while ($row4 = mysqli_fetch_assoc($res_ser)) {
                                            $check = in_array($row4['service_id'], $services_id) ? "checked" : "";
                                            $service .=  "<div class='col-md-3 my-2'>
                                                            <label>
                                                                <input type='checkbox' name='services[]' value='{$row4['service_id']}' class='form-check-input shadow-none m-0' $check>
                                                                <span class='ml-4 d-block'>{$row4['service_name']}</span>
                                                            </label>   
                                                        </div>";
                                        }
                                        echo "<tr>
                                                <td>$i</td>
                                                <td>{$row['room_name']}</td>             
                                                <td>{$row['area']} sqm</td>             
                                                <td >
                                                    <span class='badge rounded-pill bg-light text-dark mb-2' style='font-size: 14px;'>Adult: {$row['adult']}</span><br>
                                                    <span class='badge rounded-pill bg-light text-dark' style='font-size: 14px;'>Children: {$row['children']}</span>
                                                </td>             
                                                <td>".number_format($row['price'], 0, '', ',')." VNĐ</td>             
                                                <td>{$row['quantity']}</td>       
                                                <td>
                                                    <img src='$path{$row['image']}' class='rounded mx-auto d-block' width='100px'>
                                                </td>        
                                                <td class='text-center'>$status</td>                         
                                                <td>
                                                    <button type='button' class='btn bg-transparent text-primary p-0 shadow-none text-center' data-toggle='modal' data-target='#editRoomModal{$row['room_id']}'>
                                                        <i class='mdi mdi-pen' style='font-size: 23px'></i>
                                                    </button>
                                                    <!-- Modal Edit cho từng hàng -->
                                                    <div class='modal fade' id='editRoomModal{$row['room_id']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                        <div class='modal-dialog' role='document'>
                                                            <div class='modal-content' style='width: 600px'>
                                                                <form method='post' enctype='multipart/form-data'>
                                                                    <div class='modal-header'>
                                                                        <h5 class='modal-title d-flex align-items-center'>
                                                                            <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                            <span>Edit room</span>
                                                                        </h5>
                                                                        <button type='reset' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                            <span aria-hidden='true'>&times;</span>
                                                                        </button>
                                                                    </div>                                                           
                                                                    <div class='modal-body row'>
                                                                        <div class='col-md-6'>
                                                                            <div class='mb-3'>
                                                                                <label class='form-label'>Room name<span class='text-danger'>*</span></label>
                                                                                <input type='hidden' name='room_id' value='{$row['room_id']}'>
                                                                                <input type='text' name='room_name' class='form-control shadow-none' value='{$row['room_name']}'>
                                                                            </div>
                                                                            <div class='mb-3'>
                                                                                <label class='form-label'>Price<span class='text-danger'>*</span></label>
                                                                                <input type='text' name='price' class='form-control shadow-none' value='{$row['price']}'>
                                                                            </div>
                                                                            <div class='mb-3'>
                                                                                <label class='form-label'>Adult (Max.)<span class='text-danger'>*</span></label>
                                                                                <input type='text' name='adult' class='form-control shadow-none' value='{$row['adult']}'>
                                                                            </div>
                                                                        </div>
                                                                        <div class='col-md-6'>
                                                                            <div class='mb-3'>
                                                                                <label class='form-label'>Area<span class='text-danger'>*</span></label>
                                                                                <input type='text' name='area' class='form-control shadow-none' value='{$row['area']}'>
                                                                            </div>
                                                                            <div class='mb-3'>
                                                                                <label class='form-label'>Quantity<span class='text-danger'>*</span></label>
                                                                                <input type='text' name='quantity' class='form-control shadow-none' value='{$row['quantity']}'>
                                                                            </div>
                                                                            <div class='mb-3'>
                                                                                <label class='form-label'>Children (Max.)<span class='text-danger'>*</span></label>
                                                                                <input type='text' name='children' class='form-control shadow-none' value='{$row['children']}'>
                                                                            </div>
                                                                        </div>
                                                                        <div class='col-md-12'>
                                                                            <label class='form-label'>Features</label>
                                                                            <div class='row'>
                                                                                $feature
                                                                            </div>
                                                                            </div>
                                                                        <div class='col-md-12'>
                                                                            <label class='form-label'>Services</label>
                                                                            <div class='row'>
                                                                                $service
                                                                            </div>
                                                                        </div>
                                                                          <div class='col-md-12'>
                                                                            <div class='mb-3'>
                                                                                <label class='form-label'>Image<span class='text-danger'>*</span></label>
                                                                                <input type='file' name='image' class='form-control shadow-none' style='height: fit-content'>
                                                                            </div>
                                                                        </div>
                                                                        <div class='col-md-12'>
                                                                            <div class='mb-3'>
                                                                                <label class='form-label'>Description<span class='text-danger'>*</span></label>
                                                                                <textarea name='description' class='form-control shadow-none' rows='5'>{$row['description']}</textarea>
                                                                            </div>
                                                                        </div>
                                                                         <div class='d-flex align-items-center justify-content-end'>
                                                                            <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Close</button>
                                                                            <button type='submit' name='update_room' class='btn btn-success'>Update</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href='?delete_room={$row['room_id']}' class='btn bg-transparent text-danger p-0 shadow-none text-center ml-3'><i class='mdi mdi-trash-can' style='font-size: 28px'></i></a>                  
                                                </td>
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