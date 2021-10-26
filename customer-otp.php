<?php session_start();?>
<?php
    $connection = oci_connect('suburban', 'suburban', '//localhost/xe');
    $errors=array();
    if(isset($_POST['check'])){
        $code=$_POST['otp'];
        $code_res=oci_parse($connection, "SELECT * from USERS WHERE USER_CODE=$code");
        oci_execute($code_res);
        //problem lies here
        $fetch_data = oci_fetch_assoc($code_res); 
        $numRow = oci_num_rows($code_res);
        // var_dump($numRow);
        // var_dump($row);

                //if(oci_num_rows($code_res) > 0){
            if($numRow){
          
            $userid=  $fetch_data['USER_ID'];
            $fetch_code = $fetch_data['USER_CODE'];
            $email = $fetch_data['USER_EMAIL'];
            $code = 0;
            $status = 'verified';
            $update_otp = oci_parse($connection,"UPDATE USERS SET USER_CODE = $code, USER_STATUS = '$status' WHERE USER_CODE = $fetch_code");
            //$update_res = oci_parse($connection, $update_otp);
            oci_execute($update_otp);
            if($update_otp){
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $sql= "INSERT INTO CART(USER_ID) VALUES('$userid')";
                $result= oci_parse($connection, $sql);
                oci_execute($result);
                header('location: login.php');
                exit();
            }else{
                $errors['otp-error'] = "Failed while updating code!";
            }
        }else{
            $errors['otp-error'] = "You've entered incorrect code!";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Code Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="otp.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="customer-otp.php" method="POST" autocomplete="off">
                    <h2 class="text-center">Code Verification</h2>
                    <?php 
                    if(isset($_SESSION['info'])){
                        ?>
                        <div class="alert alert-success text-center">
                            <?php echo $_SESSION['info']; ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="number" name="otp" placeholder="Enter verification code" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="check" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>   
</body>
</html>