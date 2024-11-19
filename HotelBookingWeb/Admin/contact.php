<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Liên hệ</title>

    <!-- css - icon - font -->
    <?php require ('Inc/links.php')?>

</head>
<body>
    <div class="container-scroller">
        <!-- Header -->
        <?php require ('Inc/header.php'); ?>

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

                        // Danh dau toan bo lien he la da kiem tra
                        if(isset($_GET['kiemtra_all'])){
                            $query = "UPDATE lienhe SET `kiem_tra` = ?";
                            $values = array(1);
                            $lienhes = select("SELECT * FROM lienhe WHERE kiem_tra = ?", [0], "i");
                            while ($row = mysqli_fetch_assoc($lienhes)) {
                                if(sendMail($row['email'], $row['ten_kh'], "Phản hồi liên hệ", "Chúng tôi đã thấy phản hồi của bạn! Cảm ơn bạn đã liên hệ chúng tôi") == 0){
                                    $_SESSION['error'] = "Có lỗi xảy ra!";
                                    return;
                                }
                            }
                            $result = update($query, $values, "i");
                            if($result){
                                $_SESSION['success'] = "Đánh dấu đã kiểm tra toàn bộ thành công!";
                            }else{
                                $_SESSION['error'] = "Có lỗi xảy ra!";
                            }
                            header("Location: contact.php");
                            exit;
                        }

                        // Danh dau lien he da kiem tra
                        if(isset($_POST['kiemtra'])){
                            $form_data = filteration($_POST);
                            $query = "UPDATE lienhe SET `kiem_tra` = ? WHERE ma_lienhe = ?";
                            $values = array(1, $form_data['ma_lienhe']);
                            $result = update($query, $values, "ii");
                            $sendMail = sendMail($form_data["email"], $form_data["ten_kh"], "Phản hồi liên hệ", "Chúng tôi đã thấy phản hồi của bạn! Cảm ơn bạn đã liên hệ chúng tôi");
                            if($result && $sendMail == 1){
                                $_SESSION['success'] = "Đánh dấu đã kiểm tra thành công!";
                            }else{
                                $_SESSION['error'] = "Có lỗi xảy ra!";
                            }
                            header("Location: contact.php");
                            exit;
                        }

                        // Xoa lien he
                        if(isset($_GET['xoa'])){
                            $form_data = filteration($_GET);
                            // Xoa toan bo lien he
                            if($form_data['xoa'] == 'all'){
                                $query = "DELETE FROM lienhe";
                                if(mysqli_query($conn, $query)){
                                    $_SESSION['success'] = "Xóa toàn bộ bản ghi thành công!";
                                }else{
                                    $_SESSION['error'] = "Có lỗi xảy ra!";
                                }
                            } else {
                                // Xoa 1 lien he
                                $query = "DELETE FROM lienhe WHERE ma_lienhe = ?";
                                $values = array($form_data['xoa']);
                                $result = update($query, $values, "i");
                                if($result){
                                    $_SESSION['success'] = "Xóa bản ghi thành công!";
                                }else{
                                    $_SESSION['error'] = "Có lỗi xảy ra!";
                                }
                            }
                            header("Location: contact.php");
                            exit;
                        }

                        if(isset($_POST['send'])){
                            sendMail();
                        }
                        ob_end_flush();
                    ?>
                    <div class="card text-black">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Liên hệ</h4>
                                <div class="d-flex justify-content-end">
                                    <a href="?kiemtra_all=1" class="btn btn-success mr-2"><i class="mdi mdi-check-all mr-2"></i>Đọc hết</a>
                                    <a href="?xoa=all" class="btn btn-danger"><i class="mdi mdi-trash-can mr-2"></i>Xóa hết</a>
                                </div>
                            </div>
                            <table class="table table-hover table-striped table-bordered" id="myTable">
                                <thead class="bg-dark text-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Tên khách hàng</th>
                                        <th>Email</th>
                                        <th width="20%">Tiêu đề</th>
                                        <th width="30%">Nội dung</th>
                                        <th>Ngày</th>
                                        <th>Kiểm tra</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $query = "SELECT * FROM lienhe ORDER BY ma_lienhe DESC";
                                        $data = mysqli_query($conn, $query);
                                        $i = 1;
                                        while($row = mysqli_fetch_assoc($data)){
                                            echo "<tr>
                                                    <td>$i</td>
                                                    <td>{$row['ten_kh']}</td>
                                                    <td>{$row['email']}</td>
                                                    <td class='custom-cell'>{$row['tieu_de']}</td>
                                                    <td class='custom-cell'>{$row['noi_dung']}</td>
                                                    <td>{$row['ngay']}</td>
                                                    <td>" . ($row['kiem_tra'] == 1 ? "<span class='text-success'>Rồi</span>" : "<span class='text-danger'>Chưa</span>") . "</td>
                                                    <td class='d-flex align-items-center justify-content-around'>
                                                        <button type='button' class='btn bg-transparent text-primary p-0 shadow-none' data-toggle='modal' data-target='#detailModal{$row['ma_lienhe']}'>
                                                            <i class='mdi mdi-eye' style='font-size: 23px'></i>
                                                        </button>
                                                        <!-- Modal Edit cho từng hàng -->
                                                        <div class='modal fade' id='detailModal{$row['ma_lienhe']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' aria-hidden='true'>
                                                            <div class='modal-dialog' role='document'>
                                                                <div class='modal-content' style='width: 600px'>
                                                                    <form method='post'>
                                                                        <div class='modal-header'>
                                                                            <h5 class='modal-title d-flex align-items-center'>
                                                                                <i class='mdi mdi-pencil-circle mr-2'></i>
                                                                                <span>Chi tiết liên hệ</span>
                                                                            </h5>
                                                                            <button type='button' class='close shadow-none' data-dismiss='modal' aria-label='Close'>
                                                                                <span aria-hidden='true'>&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class='modal-body row'>
                                                                            <div class='col-md-6'>
                                                                                <div class='mb-3'>
                                                                                    <label class='form-label'>Tên khách hàng</label>
                                                                                    <input type='hidden' name='ma_lienhe' value='{$row['ma_lienhe']}'>
                                                                                    <input type='text' name='ten_kh' class='form-control shadow-none' value='{$row['ten_kh']}' readonly>
                                                                                </div>
                                                                                <div class='mb-3'>
                                                                                    <label class='form-label'>Email</label>
                                                                                    <input type='text' name='email' class='form-control shadow-none' value='{$row['email']}' readonly>                                                                                
                                                                                </div>
                                                                                 <div class='mb-3'>
                                                                                    <label class='form-label'>Ngày</label>
                                                                                    <input type='text' class='form-control shadow-none' value='{$row['ngay']}' readonly>                                                                                
                                                                                 </div>
                                                                            </div>
                                                                            <div class='col-md-6'>
                                                                                <div class='mb-3'>
                                                                                <label class='form-label'>Tiêu đề</label>
                                                                                <input type='text' class='form-control shadow-none' value='{$row['tieu_de']}' readonly>
                                                                                </div>
                                                                                <div class='mb-3'>
                                                                                    <label class='form-label'>Nội dung</label>
                                                                                    <textarea class='form-control shadow-none' rows='5' readonly>{$row['noi_dung']}</textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class='d-flex align-items-center justify-content-end'>
                                                                                <button type='button' class='btn btn-secondary mr-2' data-dismiss='modal'>Đóng</button>
                                                                                ".($row['kiem_tra'] != 1 ? "<button type='submit' name='kiemtra' class='btn btn-success'>Kiểm tra</button>" : "")."
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href='?xoa={$row['ma_lienhe']}' class='fa-2x text-danger'><i class='mdi mdi-trash-can'></i></a>
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