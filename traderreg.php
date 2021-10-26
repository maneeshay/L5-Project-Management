<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function popUp(){ swal({
                title: "Thankyou!",
                text: "We will look over your request and get back to you soon.",
                icon: "success",
                button: "okay",
            });
        }
    </script>
<?php
    $connection = oci_connect('suburban', 'suburban', '//localhost/xe');
    session_start();
    $errors=array();
    if(isset($_POST['signup'])){
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $shopname=$_POST['shopname'];
        $shopcate=$_POST['shopcate'];
        $number=$_POST['number'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
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
            $subject = "Trader Registration";
            $message = "Trader registration request received. Follow up with  shop detail and reply ASAP.
                         Details:\nFull Name: $fname $lname\nContact number: $number\nTrader email: $email\nShop Name: $shopname\nShop Category: $shopcate\nThankyou.\nThe Suburban Takeaway.";
            $sender ='Cc:'. $email ; 
            
            if(mail("suburbantakeaway@gmail.com", $subject, $message, $sender)){
               
                echo '<script> popUp();</script>';

            }        
        }
    }
?>
                <form action="traderreg.php" method="POST" >
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
                    <div class="leftContainer">
                        <span>First Name</span>
                        <br><input type="text" name="fname" required>
                        
                        <br><span>Email</span>
                        <br><input type="email" name="email" required>

                        <br><span>Shop Name</span>
                        <br><input type="text" name="shopname" required>

                        <br><span>password</span>
                        <br><input type="password" name="password" required>
                    </div>
                    <div class="rightContainer">
                        <span>Last Name</span>
                        <br><input type="text" name="lname" required>
                        
                        <br><span>Phone Number</span>
                        <br><input type="number" name="number" required>

                        <br><span>Shop Category</span>
                        <br><input type="text" name="shopcate" required>

                        <br><span>Confirm Password</span>
                        <br><input type="password" name="cpassword" required>
                    </div>
                </div> 
                    <div>
                        <input type="checkbox" name="submit" signup required> I agree to all the terms and conditions
                    </div>
               
                    <button class="signup" type="submit" name="signup">Sign Up</button>
                    <br><br><a href="home.php"><i class="fa fa-arrow-left"> Return to Home Page </i></a>
                </form>
            </div>

        </div>
    </section>
</body>
</html>