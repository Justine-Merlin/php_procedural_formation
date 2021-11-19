<?php
    require_once 'config.php';

    $name = $address = $salary = "";
    $name_err = $address_err = $salary_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $input_address = trim($_POST["address"]);
        if(empty($input_address)){
            $address_err = "Please enter an address";
        } else {
            $address = $input_address;
        }

        $input_name = trim($_POST["name"]);
        if(empty($input_name)){
            $name_err = "Please enter a name";
        } else {
            $name = $input_name;
        }

        $input_salary = trim($_POST["salary"]);
        if(!empty($input_salary)){
            $salary = $input_salary;
        } elseif (!ctype_digit($input_salary)){
            $name_err="Please enter a number";
        } else {
            $salary_err = "Please enter a salary";
        }
        
        if(empty($name_err) && empty($address_err) && empty($salary_err)){
            $sql = "INSERT INTO employees (name, address, salary) VALUES (? ,? ,?)";
            if($stmt = mysqli_prepare($link, $sql)){
                mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_address, $param_salary);
                $param_address = $address;
                $param_name = $name;
                $param_salary = $salary;
                if(mysqli_stmt_execute($stmt)){
                    header("location: index.php");
                    exit();
                } else {
                    echo "Something went wrong";
                }
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($link);
        
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>

    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
		.deleteBtn{
			margin-right: 4px;
		}
    </style>

</head>
<body>
    <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php (!empty($name_err)) ? 'has-error' : '' ?>">
                        <label for="name">Name :</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name;?>">
                        <span class="help-block"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group <?php (!empty($address_err)) ? 'has-error' : '' ?>">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $address;?>">
                        <span class="help-block"><?php echo $address_err; ?></span>
                    </div>
                    <div class="form-group <?php (!empty($salary_err)) ? 'has-error' : '' ?>">
                        <label for="salary">Salary</label>
                        <input type="number" class="form-control" id="salary" name="salary" value="<?php echo $salary;?>">
                        <span class="help-block"><?php echo $salary_err; ?></span>
                    </div>
                        <input type="submit" class="btn btn-primary">
                    </form>
                    <a href="./" class="btn btn-default">Back</a>
                </div>
            </div>
    </div>
</body>
</html>