<?php

  include "connect.php";

  $Id = $_GET['id'];

        $conn = oci_connect('suburban', 'suburban', '//localhost/xe');
        $query=oci_parse($conn, "SELECT * FROM PRODUCT WHERE PRODUCT_ID = '$Id' "); 
        oci_execute($query);

        $row=oci_fetch_assoc($query);


  //print_r($row);

  //exit();

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
      <form method="post" action="updateProduct.php">
              <fieldset>
                  <legend>
                      Update Product
                  </legend>

                  
                  <input type="hidden" name="txtProductId"  value = "<?php echo $row['PRODUCT_ID']?>"/><br /><br />

                  <label for="name">Product Name: </label>
                  <input type="text" name="txtProductName" value = "<?php echo $row['PRODUCT_NAME']?>"/><br /><br />

                  <label for="price">Product Price: </label>
                  <input type="text" name="txtProductPrice" value = "<?php echo $row['PRODUCT_PRICE']?>" /><br /><br />
                  <label for="price">PRODUCT DESCRIPTION: </label>
                  <input type="text" name="txtProductDescription" value = "<?php echo $row['PRODUCT_DECRIPTION']?>" /><br /><br />  
                  <label for="price">ALLERGY INFO: </label> 
                  <input type="text" name="txtProductAllergy" value = "<?php echo $row['ALLERGY_INFO']?>" /><br /><br />
                  <label for="price">STOCK AVAILBLE: </label>
                  <input type="text" name="txtProductStock" value = "<?php echo $row['STOCK_AVAILBLE']?>" /><br /><br />  
                  <label for="price">MIN ORDER: </label> 
                  <input type="text" name="txtMaxOrder" value = "<?php echo $row['MIN_ORDER']?>" /><br /><br />
                  <label for="price">MAX ORDER: </label>
                  <input type="text" name="txtMinOrder" value = "<?php echo $row['MAX_ORDER']?>" /><br /><br />

                  <label for="imagename">Image Filename: </label>
                  <input type="text" name="txtProductImage" value = "<?php echo $row['PRODUCT_IMAGENAME']?>"/><br /><br />

                  
                  <input type="submit" value="Submit" name="subUpdate" />
                  
                  
              </fieldset>
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