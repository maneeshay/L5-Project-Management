<?php
  $connection = oci_connect('suburban', 'suburban', '//localhost/xe');
    session_start();
  $id= $_GET['id'];
  
  $query = "SELECT * FROM USERS WHERE  USER_ID= $id";
  $result= oci_parse($connection,$query);
  oci_execute($result);
  $row = oci_fetch_assoc($result);

?>
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
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title> About Us</title>
  <link rel="icon" href="images/logo.png" type="image/x-icon"/>
  <link rel="stylesheet" type="text/css" href="css/style.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <!-- Header -->
  <header>
    <div class="topnav">
      <img src="images/logo.png">
      <div class="search-container">
          
      </div>
      <div id="topicon">
        <div class="dropdown">
          <button class="dropbtn"><i class="fa fa-user"></i></button>
          <div class="dropdown-content">
            <a href="logout.php">Logout</a>
            </div>
        </div>
      </div>
  
    </div>
    
  </header>

  <!-- main body -->
  <div class= "content">
    <div id="banner">
      <h1> My Shop </h1>
    </div>
    <div class="container">
      <div id="menu">
        <a href="traderprofile.php"><i class="fa fa-user"></i> My Profile</a>
        <a href="traderpass.php"><i class="fa fa-lock"></i> Password</a>
        <a href="tradershop.php"><i class="fa fa-home"></i>Shop</a>
        <a href="http://127.0.0.1:8080/apex/f?p=103:LOGIN_DESKTOP:14438762505251:::::"><i class="fa fa-tachometer"></i>Dashboard</a>
      </div>


    <div class="amend">

<?php
    $connection = oci_connect('suburban', 'suburban', '//localhost/xe');
    if(isset($_POST['subShop'])){
        $shopname=$_POST['txtName'];
        $shoploc=$_POST['txtLocation'];
        $owner=$_POST['txtOwner'];
        $cat=$_POST['txtCategory'];
        $des=$_POST['txtDescription'];

        $email= $row['USER_EMAIL'];
        $subject = "Add Shop Request";
        $message = "Add shop request received. Follow up with  shop detail and reply ASAP.
                         Details:\nOwner Name: $owner \nShop Location: $shoploc\nShop Name: $shopname\nShop Category: $cat\nShop Description: $des\nThankyou.\nThe Suburban Takeaway.";
            $sender ='Cc:'. $email ; 
            
            if(mail("suburbantakeaway@gmail.com", $subject, $message, $sender)){
               echo '<script> popUp();</script>';
            }        
        }
    
?>
      <form method="post">
        <label for="name">Shop Name</label>
        <input type="text"  name="txtName" placeholder="Shop Name" required>

        <label for="location">Shop Location</label>
        <input type="text" name="txtLocation" placeholder="Shop Location" required>

        <label for="owner">Shop Owner</label>
        <input type="text" name="txtOwner" value="<?php echo $row['USER_FIRST_NAME'], $row['USER_LAST_NAME']?>" readonly>

      
        <label for="category">Shop Category</label>
        <input type="text" name="txtCategory" placeholder="Shop Category" required>
      

        <label for="sescription">Shop Description</label>
        <input type="text" name="txtDescription" placeholder="Shop Description" required>

        <input type="text" name="UserId" value="<?php echo $row['USER_ID']?>" hidden>

        <input type="submit" value="Request" name="subShop">
      </form>
    </div>
</div>
<!-- footer -->
  <footer>
    <div id="bottom">
      <div class="b-left">
        <a href="termsofservices.php">Terms of services</a> |
        <a href="privacypolicy.php">Privacy Policy</a>
      </div>
      <div class="b-right">
        &#169; The Subrban Takeaway
      </div>
    </div>
  </footer>



</body>
</html>