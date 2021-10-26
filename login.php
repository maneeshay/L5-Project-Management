<?php //require_once "register.php"; ?>


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
                <form action="login.php" method="POST" autocomplete="">
                    <img src="images/logo.png" ></img><br><br>
                    <?php
                        $connection = oci_connect('suburban', 'suburban', '//localhost/xe');
                        session_start();
                        if(isset($_POST['login'])){
                            $email = $_POST['email'];
                            $pass = $_POST['password'];
                            $user =$_POST['user'];
                            $s = oci_parse($connection, "SELECT * from USERS WHERE USER_EMAIL='$email' AND USER_PASSWORD='$pass' ");       
                            oci_execute($s);
                            $fetch_data =oci_fetch_assoc($s);
                            $row=oci_num_rows($s);
                            if($row){
                                $_SESSION['id']=$fetch_data['USER_ID'];
                                $_SESSION['email']=$email;
                                $_SESSION['time_start_login'] = time();
                                $_SESSION['logged_in']= TRUE;
                                if(isset($_POST['user'])){
                                    if ($fetch_data['USER_ROLE']==$_POST['user']) {
                                        switch($_POST['user']){
                                            case 'customer':
                                                header('location: custprofile.php');
                                            break;
                                            case 'Trader':
                                                header('location: traderprofile.php');
                                            break;
                                            default:
                                            break;
                                        }
                                    }
                                    else{
                                        echo "<div class='alert'> Wrong User Role ".$fetch_data['USER_ROLE']."<br><br></div> ";
                                    }
                                }
                            
                            }
                            else{
                                echo "<div class='alert'>wrong password or username <br><br></div>";
                            }
                        }
                     ?>
                    <div class="inputBx">
                       
                        <span>Email Address</span>
                        <br>
                        <input type="email" name="email" required >
                    </div>
                    <div class="inputBx">
                        
                        <span>Password</span>
                        <br>
                        <input type="password" name="password" required >
                    </div>
                    <div class="radiobtn">
                      
                        <input type="radio" name="user" value="customer" required>
                        <label for="customer">Customer</label>
                        <input type="radio" name="user" value="Trader" required>
                        <label for="trader">Trader</label><br>
                    </div>
                    <div class="inputBx">
                        <input type="submit" value="Login" name="login">
                    </div>
                    <div class="inputBx">
                   
                        <p><a href=forget-password.php>Forgot Password? </a></p>
                    </div>
                    <hr>
                    <div class="inputBx">
                        <br>
                        <p>&#169; The Suburban Takeaway </p>
                    </div>
                </form>
                <form action="" method="post">
                <div class="inputBx">
                
                        <input type="submit" value="Create New Account" name="newAccount">
                        <?php
                            if(isset($_POST['newAccount'])){
                                header('location: choose.php');
                            }
                        ?> 
                </div>
                </form>
                
            </div>
        </div>
    </section>
</body>
</html>