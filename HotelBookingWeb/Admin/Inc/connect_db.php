<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hotelbookingweb";
    $conn = new mysqli($hostname, $username, $password, $dbname);

    if (!$conn) {
        die.("Cannot connect to MySQL: ".mysqli_connect_error());
    }

    function filteration($data){
        foreach ($data as $key => $value) {
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
                die("Query excuted failed - Select");
            }
        }else{
            die("Query prepared failed - Select");
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
                die("Query excuted failed - Update");
            }
        }else{
            die("Query prepared failed - Update");
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
                die("Query excuted failed - Insert");
            }
        }else{
            die("Query prepared failed - Insert");
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
                die("Query excuted failed - Delete");
            }
        }else{
            die("Query prepared failed - Delete");
        }
    }
?>