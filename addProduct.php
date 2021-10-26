<?php
  $connection = oci_connect('suburban', 'suburban', '//localhost/xe');
    session_start();
  $id= $_GET['id'];
  
  $query = "SELECT * FROM SHOP WHERE  SHOP_ID= $id";
  $result= oci_parse($connection,$query);
  oci_execute($result);
  $row = oci_fetch_assoc($result);
?>
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
      <form method="post" action="insertProduct.php">
        <label for="name">Name</label>
        <input type="text"  name="txtName" placeholder="Product Name" required>

        <label for="price">Price</label>
        <input type="text" name="txtPrice" placeholder="Product Price" required>

        <label for="category">Category</label>
        <input type="text" name="txtCategory" value="<?php echo $row['SHOP_KEYWORD']?>" readonly>

      
        <label for="discription">Description</label>
        <input type="text" name="txtDiscription" placeholder="Product Discription" required>
      

        <label for="allergy">Allergy Information</label>
        <input type="text" name="txtAllergy" placeholder="Product allergy information" required>

        <label for="stock">Stock Available</label>
        <input type="text" name="txtStock" placeholder="No of stocks" required>

        <label for="stock">Min Order</label>
        <input type="text" name="txtMin" placeholder="Minimum Order Quantity" required>

        <label for="stock">Max Order</label>
        <input type="text" name="txtMax" placeholder="Maximum Order Quantity" required>
        

        <label for="imagename">Image</label>
        <input type="text" name="txtImage" placeholder="Image file name" required>

        <input type="text" name="shopId" value="<?php echo $row['SHOP_ID']?>" hidden>

        <input type="submit" value="Submit" name="subProduct">
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