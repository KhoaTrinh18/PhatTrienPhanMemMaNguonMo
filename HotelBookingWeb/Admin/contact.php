<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Contacts</title>

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

                        if(isset($_GET['check_all'])){
                            $query = "UPDATE contact SET `checked` = ?";
                            $values = array(1);
                            $result = update($query, $values, "i");
                            if($result){
                                $_SESSION['success'] = "Marked as read all successfully!";
                            }else{
                                $_SESSION['error'] = "Something went wrong!";
                            }
                            header("Location: contact.php");
                            exit;
                        }
                        if(isset($_POST['check'])){
                            $form_data = filteration($_POST);
                            $query = "UPDATE contact SET `checked` = ? WHERE contact_id = ?";
                            $values = array(1, $form_data['contact_id']);
                            $result = update($query, $values, "ii");
                            if($result){
                                $_SESSION['success'] = "Marked as read successfully!";
                            }else{
                                $_SESSION['error'] = "Something went wrong!";
                            }
                            header("Location: contact.php");
                            exit;
                        }

                        if(isset($_GET['delete'])){
                            $form_data = filteration($_GET);
                            if($form_data['delete'] == 'all'){
                                $query = "DELETE FROM contact";
                                if(mysqli_query($conn, $query)){
                                    $_SESSION['success'] = "Delete all rows successfully!";
                                }else{
                                    $_SESSION['error'] = "Something went wrong!";
                                }
                            } else {
                                $query = "DELETE FROM contact WHERE contact_id = ?";
                                $values = array($form_data['delete']);
                                $result = update($query, $values, "i");
                                if($result){
                                    $_SESSION['success'] = "Delete row successfully!";
                                }else{
                                    $_SESSION['error'] = "Something went wrong!";
                                }
                            }
                            header("Location: contact.php");
                            exit;
                        }
                        ob_end_flush();
                    ?>
                    <div class="card text-black">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Contact</h4>
                                <div class="d-flex justify-content-end">
                                    <a href="?check_all=1" class="btn btn-success mr-2"><i class="mdi mdi-check-all mr-2"></i>Check all</a>
                                    <a href="?delete=all" class="btn btn-danger"><i class="mdi mdi-trash-can mr-2"></i>Delete all</a>
                                </div>
                            </div>
                            <table class="table table-hover table-striped table-bordered table-responsive" id="myTable">
                                <thead class="bg-dark text-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th width="20%">Subject</th>
                                        <th width="30%">Message</th>
                                        <th>Date</th>
                                        <th>Checked</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = "SELECT * FROM contact ORDER BY contact_id DESC";
                                        $data = mysqli_query($conn, $query);
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($data)){
                                            $checked = '';
                                            if($row['checked'] != 1){
                                                $checked = "<a href='?checked={$row['contact_id']}' class='fa-2x text-success mr-3'><i class='mdi mdi-check'></i></a>";
                                            }
                                            $checked .= "";
                                            echo "<tr>
                                                    <td>$i</td>
                                                    <td>{$row['user_name']}</td>
                                                    <td>{$row['email']}</td>
                                                    <td class='custom-cell'>{$row['subject']}</td>
                                                    <td class='custom-cell'>{$row['message']}</td>
                                                    <td>{$row['date']}</td>
                                                    <td>" . ($row['checked'] == 1 ? "<span class='text-success'>YES</span>" : "<span class='text-danger'>NO</span>") . "</td>
                                                    <td class='d-flex align-items-center justify-content-around'>
                                                        <button type='button' class='btn bg-transparent text-primary p-0 shadow-none' data-toggle='modal' data-target='#detailModal{$row['contact_id']}'>
                                                            <i class='mdi mdi-eye' style='font-size: 23px'></i>
                                                        </button>
                                                        <!-- Modal Edit cho từng hàng -->
                                                        <div class='modal fade' id='detailModal{$row['contact_id']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                            <div class='modal-dialog' role='document'>
                                                                <div class='modal-content' style='width: 600px'>
                                                                    <form method='post'>
                                                                        <div class='modal-header'>
                                                                            <h5 class='modal-title d-flex align-items-center'>
                                                                                <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                                <span>Contact detail</span>
                                                                            </h5>
                                                                            <button type='button' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                                <span aria-hidden='true'>&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class='modal-body row'>
                                                                            <div class='col-md-6'>
                                                                                <div class='mb-3'>
                                                                                    <label class='form-label'>Name</label>
                                                                                    <input type='hidden' name='contact_id' value='{$row['contact_id']}'>
                                                                                    <input type='text' class='form-control shadow-none' value='{$row['user_name']}' readonly>
                                                                                </div>
                                                                                <div class='mb-3'>
                                                                                    <label class='form-label'>Email</label>
                                                                                    <input type='text' class='form-control shadow-none' value='{$row['email']}' readonly>                                                                                
                                                                                </div>
                                                                                 <div class='mb-3'>
                                                                                    <label class='form-label'>Date</label>
                                                                                    <input type='text' class='form-control shadow-none' value='{$row['date']}' readonly>                                                                                
                                                                                 </div>
                                                                            </div>
                                                                            <div class='col-md-6'>
                                                                                <div class='mb-3'>
                                                                                <label class='form-label'>Subject</label>
                                                                                <input type='text' class='form-control shadow-none' value='{$row['subject']}' readonly>
                                                                                </div>
                                                                                <div class='mb-3'>
                                                                                    <label class='form-label'>Message</label>
                                                                                    <textarea class='form-control shadow-none' rows='5' readonly>{$row['message']}</textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class='d-flex align-items-center justify-content-end'>
                                                                                <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Close</button>
                                                                                ".($row['checked'] != 1 ? "<button type='submit' name='check' class='btn btn-success'>Check</button>" : "")."
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href='?delete={$row['contact_id']}' class='fa-2x text-danger'><i class='mdi mdi-trash-can'></i></a>
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