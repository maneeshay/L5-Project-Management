<?php
	$connection = oci_connect('suburban', 'suburban', '//localhost/xe');
    session_start();
	$id= $_GET['id'];
	
	$query = "SELECT * FROM PRODUCT WHERE  SHOP_ID= $id";
	$result= oci_parse($connection,$query);
	oci_execute($result);
	
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
				<a href="#"><i class="fa fa-tachometer"></i>Dashboard</a>
			</div>
			<div id="crud">
				<?php 
					
            		echo '<table >';
			            echo '<tr>';
			                echo '<th>Product Name </th>';
			                echo '<th>Price </th>';
			                echo '<th>DECRIPTION</th>';	
			                echo '<th>ALLERGY_INFO</th>';	
			                echo '<th>STOCK</th>';
			                echo '<th>Amend </th>';
			                echo '<th>Delete </th>';
			            echo '</tr>';
				        while($row = oci_fetch_assoc($result)){
				            echo '<tr>';
				                echo '<td><img src ="images/'. $row['PRODUCT_IMAGENAME'] . ' "width=100pxs/><h4>'. $row['PRODUCT_NAME']. '</h4></td>';
						        echo '<td>'. $row['PRODUCT_PRICE']. '</td>';
						 
						        echo '<td>'. $row['PRODUCT_DECRIPTION']. '</td>';
						        echo '<td>'. $row['ALLERGY_INFO']. '</td>';	
						        echo '<td>'. $row['STOCK_AVAILBLE']. '</td>';	
						        echo  '<td>' . '<a href = "amendProduct.php?id='.$row['PRODUCT_ID']. '">Amend</a><br>'. '</td>';
						       
						        echo '<td>' .  '<a href = "deleteProduct.php?id='.$row['PRODUCT_ID']. '">Delete</a>'.' </td>';
	        
			           		echo '</tr>';
			            }
		            echo '</table>'; 

        
    			
    				echo '<div class = "add"><a href="addProduct.php?id='.$id.'">Add Product</a> </div>';
				?>
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