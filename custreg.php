<?php //require_once "register.php"; ?>
<?php
$connection = oci_connect('suburban', 'suburban', '//localhost/xe');
    session_start();
   // include "connect.php";
    
    $fname="";
    $lname="";
    $email="";
    $number="";
    $errors=array();

    /***********************************
     * Customer Registration
     ***********************************/
    
     if(isset($_POST['signup'])){
        $fname = $_POST['fname'];
        $lname =  $_POST['lname'];
        $email =  $_POST['email'];
        $number= $_POST['number'];
        $password =  $_POST['password'];
        $cpassword =  $_POST['cpassword'];
        if($password !== $cpassword){
            $errors['password'] = "Confirm password not matched!";
            
        }

        $email_check = "SELECT * FROM USERS WHERE USER_EMAIL = '$email'";
        $result = oci_parse($connection, $email_check);
        oci_execute($result);
        $row=oci_fetch_all($result,$res);
        if($row > 0){
            $errors['email'] = "Email that you have entered is already exist!";
        }

        if(count($errors) == 0){
            //$encpass=password_hash($password, PASSWORD_BCRYPT);
            $encpass=$password;
            $code=rand(9999,1111);
            $status="notverfied";
            $insert_data="INSERT INTO USERS
                            (USER_FIRST_NAME, USER_LAST_NAME, USER_EMAIL, USER_CONTACT, USER_PASSWORD, USER_CODE, USER_STATUS, USER_ROLE)
                                VALUES('$fname' , '$lname', '$email', $number, '$encpass', $code,'$status' , 'customer')";
            $data_check = oci_parse($connection, $insert_data);
            oci_execute($data_check);

            if($data_check){
                $subject = "Email Verification Code";
                $message = "Your verification code is $code";
                $sender = "From: noreply@thesuburbantakeaway.com";
                if(mail($email, $subject, $message, $sender)){
                    $info = "We've sent a verification code to your email - $email";
                    $_SESSION['info'] = $info;
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
                    header('location: customer-otp.php');
                    exit();
                }else{
                    $errors['otp-error'] = "Failed while sending code!";
                }
            }else{
                $errors['db-error'] = "Failed while inserting data into database!";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>SubUrban Takeaway Login</title>
</head>
<body>
    <section>
        <div class="imgBx">
            <img src="images/vegetable.jpg">
        </div>
        <div class="contentBx">
            <div class="formBx">
                <form action="custreg.php" method="POST" autocomplete="">
                    <img src="images/logo.png" ></img>
                    <?php
                    if(count($errors) == 1){
                        ?>
                        <div class="alert ">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }elseif(count($errors) > 1){
                        ?>
                        <div class="alert ">
                            <?php
                            foreach($errors as $showerror){
                                ?>
                                <li><?php echo $showerror; ?></li>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="division">
                    <!--TESTING-->
                    
                    <div class="leftContainer">
                        <span>First Name</span>
                        <br><input type="text" name="fname" required value ="<?php echo $fname?>" >
                        
                        <br><span>Email</span>
                        <br><input type="email" name="email" required value ="<?php echo $email?>" >

                        <br><span>password</span>
                        <br><input type="password" name="password" required >
                    </div>
                    <div class="rightContainer">
                        <span>Last Name</span>
                        <br><input type="text" name="lname" required value ="<?php echo $lname?>" >
                        
                        <br><span>Phone Number</span>
                        <br><input type="number" name="number" required value ="<?php echo $number?>" >

                        <br><span>Confirm Password</span>
                        <br><input type="password" name="cpassword" required>
                    </div>
                </div> 
                    <div>
                        <input type="checkbox" name="checkbox" required> I agree to all the terms and conditions
                    </div>
               
                    <button class="signup" type="submit" name="signup">Sign Up</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>
