<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "qlkhachsan";
    $conn = new mysqli($hostname, $username, $password, $dbname);

    if (!$conn) {
        die.("Không thể kết nối MySQL: ".mysqli_connect_error());
    }

    function filteration($data){
        foreach ($data as $key => $value) {
            $data[$key] = preg_replace('/\s+/', ' ', $value);
            $data[$key] = trim($value);
            $data[$key] = stripslashes($value);
            $data[$key] = htmlspecialchars($value);
            $data[$key] = strip_tags($value);
        }
        return $data;
    }

    function selectAll($table)
    {
        $conn = $GLOBALS['conn'];
        $result = mysqli_query($conn, "SELECT * FROM $table");
        return $result;
    }

    function select($query, $values, $datatypes)
    {
        $conn = $GLOBALS['conn'];
        if($stmt = mysqli_prepare($conn, $query)){
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            }else{
                mysqli_stmt_close($stmt);
                die("Câu truy vấn thực hiện lỗi - Select");
            }
        }else{
            die("Câu truy vấn chuẩn bị lỗi - Select");
        }
    }

    function update($query, $values, $datatypes)
    {
        $conn = $GLOBALS['conn'];
        if($stmt = mysqli_prepare($conn, $query)){
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            }else{
                mysqli_stmt_close($stmt);
                die("Câu truy vấn thực hiện lỗi - Update");
            }
        }else{
            die("Câu truy vấn chuẩn bị lỗi - Update");
        }
    }

    function insert($query, $values, $datatypes)
    {
        $conn = $GLOBALS['conn'];
        if($stmt = mysqli_prepare($conn, $query)){
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            }else{
                mysqli_stmt_close($stmt);
                die("Câu truy vấn thực hiện lỗi - Insert");
            }
        }else{
            die("Câu truy vấn chuẩn bị lỗi - Insert");
        }
    }

    function delete($query, $values, $datatypes)
    {
        $conn = $GLOBALS['conn'];
        if($stmt = mysqli_prepare($conn, $query)){
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $result;
            }else{
                mysqli_stmt_close($stmt);
                die("Câu truy vấn thực hiện lỗi - Delete");
            }
        }else{
            die("Câu truy vấn chuẩn bị lỗi - Delete");
        }
    }
?>