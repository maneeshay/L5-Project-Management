<?php $conn = oci_connect('suburban', 'suburban', '//localhost/xe'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Product Detail</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/style2.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	
		<!-- Header -->
		<?php include "header.php" ?>

	<!--------Single product------->
	<?php		
		$id= $_GET['id'];
		$query = "SELECT * FROM PRODUCT WHERE PRODUCT_ID=$id";
		$sql= oci_parse($conn,$query);
		oci_execute($sql);
		$row=oci_fetch_assoc($sql);

		$sid=$row['SHOP_ID'];
		$query1 = "SELECT SHOP_NAME FROM SHOP WHERE SHOP_ID=$sid";
		$sql1= oci_parse($conn,$query1);
		oci_execute($sql1);
		$row1=oci_fetch_assoc($sql1);

		$query2 = "SELECT * FROM DISCOUNT WHERE PRODUCT_ID=$id";
		$sql2= oci_parse($conn,$query2);
		oci_execute($sql2);
		$row2=oci_fetch_assoc($sql2);

		$query3 = "SELECT * FROM FEEDBACK WHERE PRODUCT_ID=$id";
		$sql3= oci_parse($conn,$query3);
		oci_execute($sql3);
		$row3=oci_fetch_assoc($sql3);
		$userno= $row3['USER_ID'];
		
		if($row3){
		$query4 = "SELECT * FROM USERS WHERE USER_ID=$userno";
		$sql4= oci_parse($conn,$query4);
		oci_execute($sql4);
		$row4=oci_fetch_assoc($sql4);
			}

		session_start();
		if(isset($_POST['review']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in']){
			$uId = $_SESSION['id'];
			$review = $_POST['comment'];
			//var_dump($review);
			//var_dump($uId );
			$insertCommentSql = 'INSERT INTO FEEDBACK(COMMENTS,PRODUCT_ID,USER_ID) '.
										'VALUES(:comments,:pId,:userId)';
									
			$insertCommentStatement = oci_parse($conn, $insertCommentSql);

			oci_bind_by_name($insertCommentStatement, ':comments', $review);
			oci_bind_by_name($insertCommentStatement, ':pId', $id);
			oci_bind_by_name($insertCommentStatement, ':userId', $uId);
			

			oci_execute($insertCommentStatement);
		}

	?>
	<div class="container">
		<form action="" method="post">
		<div class="col">
			<div class="col-1">
				<img src="images/<?php echo $row['PRODUCT_IMAGENAME'];?>" alt="" srcset="">
			</div>
			<div class="col-2">
				<h1><?php echo $row['PRODUCT_NAME'];?></h1>
                <h4><?php echo  "£ ".$row['PRODUCT_PRICE'];?></h4>
				<!-------->
                <h4> <?php echo "Discount: ".$row2['DISCOUNT_PERCENTAGE']."%";?></h4>
                <h4> <?php echo "Shop Name: ".$row1['SHOP_NAME'];?></h4>
                <h4><?php echo "Stock Available: ".$row['STOCK_AVAILBLE'];?></h4>
				<div class="ratings">
					<i class="fa fa-star" ></i>
					<i class="fa fa-star" ></i>
					<i class="fa fa-star" ></i>
					<i class="fa fa-star" ></i>
					<i class="fa fa-star" ></i>
				</div>
				<a class="btn btn-dark" style="border-radius: 10px;" href="<?php echo "addtocart.php?id=". $row['PRODUCT_ID'] ?>">Add to Cart</a><br/>
                <h4><?php echo "Allergy Information: ".$row['ALLERGY_INFO'];?></h4>
				
                <h4><?php echo "Product Description: ". $row['PRODUCT_DECRIPTION'];?></h4>
                
			</div>
			<div class="col-3">
				<h3>Review</h3>
				<div id="comment" ><?php 
						while ($row3=oci_fetch_assoc($sql3)){
							echo "<p>".$row4['USER_EMAIL'].":<b>".$row3['COMMENTS']."</b></p>";
						}
				?>
				</div>
				<div id="comment-box">
				<form action="product_detail.php?id=<?= $id ?>" method="post">
					
					<textarea name="comment" id="" cols="40" placeholder="Enter your message here.."></textarea>
					<br>
					<button class="btn" type="submit" name="review">Submit</button>
				</form>
			</div>
			</div>
		</div>
	</div>

	<!-------------Related Product---------------->
	 <div class= "small-container">
		 <h2>Other Product</h2>
		<div class="row">
			<?php
				$conn = oci_connect('suburban', 'suburban', '//localhost/xe');
				$query=oci_parse($conn,'SELECT * FROM( SELECT * FROM product ORDER BY dbms_random.value) WHERE rownum <9'); 
				oci_execute($query);
				while ($row=oci_fetch_assoc($query)){
					echo '<div class="col-4">';
					echo '<a href="product_detail.php?id='.$row['PRODUCT_ID'].'"><img src="images/'.$row['PRODUCT_IMAGENAME'].'" alt="img can\'t load" >';
						echo "<h4>".$row['PRODUCT_NAME']."</h4>";
						echo'<div class="ratings">
		                        <i class="fa fa-star" ></i>
		                        <i class="fa fa-star" ></i>
		                        <i class="fa fa-star" ></i>
		                        <i class="fa fa-star" ></i>
		                        <i class="fa fa-star" ></i>
							</div>';
						echo"<p> £".$row['PRODUCT_PRICE']."</p></a></div>";
						
				}
			?>
        </div>
    </div>
    
	
	<!-- footer -->
	<?php include "footer.php"?>
</body>
</html>