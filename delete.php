<?php
require_once 'config.php';

$sql = "DELETE FROM employees WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            $param_id = trim($_GET['id']);
            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong";
            }
        }
        mysqli_stmt_close($stmt);
    mysqli_close($link);
?>