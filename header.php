<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Products</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/style2.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<!-- Header -->
	<header>
		<div class="topnav">
			<img src="images/logo.png">
			<div class="search-container">
    			<form method="GET" action="product.php">
      				<input type="text" placeholder="Search.." name="search" value="<?php if (isset($_GET['search'])) echo $_GET['search']?>"/>
     				<button type="submit" value="Search"><i class="fa fa-search"></i></button>
   				 </form>
 			</div>
 			<div id="topicon">
 				<a href="cart.php"><i class="fa fa-shopping-cart"></i></a>
 				<div class="dropdown">
					<button class="dropbtn"><i class="fa fa-user"></i></button>
					<div class="dropdown-content">
						<a href="custprofile.php">My Profile</a>
						<a href="logout.php">Logout</a>
				  	</div>
				</div>
 			</div>
 	
		</div>
		<nav>
			<div  id="navBar">
			
				<ul>
					<li class="items"><a href="home.php">Home</a></li>
					<li class="items"><a href="about.php">About Us</a></li>
					<li class="items"><a href="product.php">Our Products</a></li>
					<li class="items"><a href="contact.php">Contact Us</a></li>
				</ul>
			</div>
		</nav>
	</header>
    </body>
</html>