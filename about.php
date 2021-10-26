<?php $conn = oci_connect('suburban', 'suburban', '//localhost/xe');?>
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
	<?php include "header.php" ?>

	<!-- main body -->
	<div class= "content">
		<div id="banner">
			<h1>About Us</h1>
		</div>
		<div id="about-info">
			<div class="a-text">
				<h3>Helping farmer to emerge markets and maximize profit. Ecosystem for food and agriculture through digital innovation.</h3>
			</div>
			<div class="a-img">
				<img src="images/ab.jpg">
			</div>
			<div class="a-img">
				<img src="images/about1.jpg">
			</div>
			<div class="a-text">
		
				<h2>Welcome to The Suburban Takeaway</h2>
				<h3>The Suburban Takeaway enables farmers to sell their quality products with ease an convinience and allows customer to buy grocery with just few clicks.</h3>
			</div>
			
			<div class="a-text">
				<h2>Get Quality Food</h2>
				<h3>The Suburban Takeaway enables farmers to sell their quality products with ease an convinience and allows customer to buy grocery with just few clicks.</h3>
			</div>
			<div class="a-img">
				<img src="images/about2.jpg">
			</div>
		</div>
		<div id="team">
			
			<?php 
				$result=oci_parse($conn,'SELECT * FROM SHOP WHERE rownum <9');
				oci_execute($result);
				while ($row=oci_fetch_assoc($result)){
						echo'<div class="trader"><i class="fa fa-user" style="font-size:58px;"></i>';
						echo "<h3>".$row['SHOP_NAME']."</h3>";
						echo"<h6> We are local ".$row['SHOP_KEYWORD']." shop on the suburbs Cleckhuddersfax. Shop with us!!</h6></div>";
				}
			?>
		</div>
		<div id="bottom-banner">
			<h1> Healthy Life With Fresh Products</h1>
		</div>

	</div>
	<!-- footer -->
	<?php include "footer.php"?>
</body>
</html>