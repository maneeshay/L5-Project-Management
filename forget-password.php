<?php
    $connection = oci_connect('suburban', 'suburban', '//localhost/xe');
    session_start();
    $errors=array();
    if(isset($_POST['check-email'])){
        $email =  $_POST['email'];
        $result = oci_parse($connection,"SELECT * FROM USERS WHERE USER_EMAIL ='$email'");
        //$result=oci_parse($connection, $check_email);
        //$run_sql=oci_fetch_all($result,$res);
        oci_execute($result);
        $fetch_data =oci_fetch_assoc($result);
        $run_sql=oci_num_rows($result);
        if($run_sql){
            $code = rand(999999, 111111);
            $insert_code = "UPDATE USERS SET USER_CODE = $code WHERE USER_EMAIL = '$email'";
            $run_query=oci_parse($connection,$insert_code);
            oci_execute($run_query);
            
            if($run_query){
                $subject = "Password Reset Code";
                $message = "Your password reset code is $code";
                $sender = "From: suburbantakeaway@gmail.com";
                if(mail($email, $subject, $message, $sender)){
                    $info = "We've sent a passwrod reset otp to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    header('location: reset-code.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{
                $errors['db-error'] = "Something went wrong!";
            }
        }else{
            $errors['email'] = "This email address does not exist!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forget Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="otp.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="forget-password.php" method="POST" autocomplete="">
                    <h2 class="text-center">Forgot Password</h2>
                    <p class="text-center">Enter your email address</p>
                    <?php
                        if(count($errors) > 0){
                            ?>
                            <div class="alert alert-danger text-center">
                                <?php 
                                    foreach($errors as $error){
                                        echo $error;
                                    }
                                ?>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Enter email address" required >
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="check-email" value="Continue">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>