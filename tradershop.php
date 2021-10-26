<?php
	$connection = oci_connect('suburban', 'suburban', '//localhost/xe');
    session_start();
	$id=$_SESSION['id'];
	if(!$_SESSION['logged_in']){
		header("Location: login.php");
	}
	$query1 = "SELECT * FROM SHOP WHERE USER_ID = {$_SESSION['id']}";
	$result1= oci_parse($connection,$query1);
	oci_execute($result1);
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> About Us</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel="stylesheet" type="text/css" href="css/style2.css"/>
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
			<div>

			<div id="t-shop">
				<?php 
					while ($row1=oci_fetch_assoc($result1)) {
					echo '<div class="shop"><i class="fa fa-home"></i>Shop Name: '.$row1['SHOP_NAME'];
					echo "<br>Location: ".$row1['SHOP_LOCATION'];				
					echo "<br>Product Category: ".$row1['SHOP_KEYWORD'];
					echo '<br><a href="shopdetail.php?id='.$row1['SHOP_ID'].'"><button>View</button></a></div>';
					
				}
				?>
			</div>
			<?php echo '<div class = "add"><a href="addShop.php?id='.$id.'">Request Add Shop</a> </div>';?>
		</div>
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