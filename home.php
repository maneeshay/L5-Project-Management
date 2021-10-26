<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Suburban Takeaway</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<!-- Header -->
	<?php include "header.php" ?>
	
	<!-- main body -->
	<div class="slideshow-container">

		<div class="mySlides fade">
		  <div class="numbertext">1 / 3</div>
		  <img src="images/b.jpg" style="width:100% ">
		</div>

		<div class="mySlides fade">
		  <div class="numbertext">2 / 3</div>
		  <img src="images/bb.jpg" style="width:100%">
		</div>

		<div class="mySlides fade">
		  <div class="numbertext">3 / 3</div>
		  <img src="images/bbb.jpg" style="width:100%">
		</div>

	</div>
	<br>

	<div style="text-align:center">
	  <span class="dot"></span> 
	  <span class="dot"></span> 
	  <span class="dot"></span> 
	</div>

		<div class= "content">
			<h2>What we Sell</h2>
			<br>
			<h3>FEATURED PRODUCTS</h3>
		</div>
	<div class="row">
		<?php
				$conn = oci_connect('suburban', 'suburban', '//localhost/xe');
				$query=oci_parse($conn,'SELECT * FROM( SELECT * FROM product ORDER BY dbms_random.value) WHERE rownum <9'); 
				oci_execute($query);

				while ($row=oci_fetch_assoc($query)){
					echo '<div class="column"> <a href="product_detail.php?id='.$row['PRODUCT_ID'].'"> <img src="images/'.$row['PRODUCT_IMAGENAME'].'" alt="img can\'t load" ><br>';
						echo "<p>".$row['PRODUCT_NAME']."</p>";
						echo"<p> £".$row['PRODUCT_PRICE']."</p>";
						echo'<div class="star">
		                        <i class="fa fa-star" ></i>
		                        <i class="fa fa-star" ></i>
		                        <i class="fa fa-star" ></i>
		                        <i class="fa fa-star" ></i>
		                        <i class="fa fa-star" ></i>
							</div></a></div>';
						
				}
			?>
	</div>
	<div class="banner1">
		<h1>Fresh From Farm</h1>
		<a href="product.php"><button type="button">Order Now</button></a>
	</div>
	<br>
	<div class="banner2">
		<h1>List Your Shop with US</h1>
		<a href="traderReg.php"><button type="button">Send Request</button></a>
	</div>
	<br>
	<!-- footer -->
	<?php include "footer.php"?>

	<script>
		var slideIndex = 0;
		showSlides();
		
		function showSlides() {
		  var i;
		  var slides = document.getElementsByClassName("mySlides");
		  var dots = document.getElementsByClassName("dot");
		  for (i = 0; i < slides.length; i++) {
			slides[i].style.display = "none";  
		  }
		  slideIndex++;
		  if (slideIndex > slides.length) {slideIndex = 1}    
		  for (i = 0; i < dots.length; i++) {
			dots[i].className = dots[i].className.replace(" active", "");
		  }
		  slides[slideIndex-1].style.display = "block";  
		  dots[slideIndex-1].className += " active";
		  setTimeout(showSlides, 5000); // Change image every 2 seconds
		}
		</script>
</body>
</html>