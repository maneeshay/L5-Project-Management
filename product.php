<?php $conn = oci_connect('suburban', 'suburban', '//localhost/xe');?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Our Products</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/style2.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<!-- Header -->
	<?php include "header.php" ?>


	<!--------All product------->
    <div class="product">
        <div class="sort">
        	<h3> Refine your Results</h3>
        	<form method="GET" action="product.php">
            <label for="category">Category:</label>
			<select name="category">
 				<option value="">All</option>
 				<?php 
 					$sql = "SELECT DISTINCT PRODUCT_CATEGORY from PRODUCT";
 					$result = oci_parse($conn, $sql);
 					oci_execute($result);
 					while($row = oci_fetch_assoc($result)) {
 						echo "<option value={$row['PRODUCT_CATEGORY']} ". (isset($_GET['category']) && $_GET['category'] == $row['PRODUCT_CATEGORY'] ? "selected" : "") . ">".$row['PRODUCT_CATEGORY']."</option>";
 					}
 				?>
 			</select><br><br>
 			<label for="alphabetical">Alphabetical [ a-z ]</label>
 			<input type="radio" name="sort" value="ASC" <?php if (isset($_GET['sort']) && $_GET['sort'] == "PRODUCT_NAME") echo "checked" ?>/><br><br>
 		
 			<label for="rev-alphabetical">Alphabetical [ z-a ]</label>
 			<input type="radio" name="sort" value="DESC" <?php if (isset($_GET['sort']) && $_GET['sort'] == "PRODUCT_NAME ") echo "checked" ?>/><br><br>

        	<label for="Price">Price [ high - low] :</label>
        	<input type="radio" name="sort" value="HL" <?php if (isset($_GET['sort']) && $_GET['sort'] == "PRODUCT_PRICE") echo "checked" ?>/></br><br>
 		   
      		<label for="Price">Price [ low - high ]: </label>
        	<input type="radio" name="sort" value="LH" <?php if (isset($_GET['sort']) && $_GET['sort'] == "PRODUCT_PRICE") echo "checked" ?>/></br><br>

        	<input type="submit" value="sort" name="Sort" />
        </form>
        </div>
        <div class="main">

        	<?php
				
				$query='SELECT * FROM PRODUCT';
				if (isset($_GET['search'])) {
				$search = strtolower($_GET['search']);
				$query="SELECT * FROM PRODUCT WHERE LOWER(PRODUCT_NAME) LIKE '%{$search}%'";
				}
				if (isset($_GET['category']) && $_GET['category'] != "") {
					$query = "SELECT * FROM PRODUCT WHERE PRODUCT_CATEGORY = '{$_GET['category']}'";
					if (isset($_GET['sort'])&& $_GET['sort'] == "ASC") {
						$query = "SELECT * FROM PRODUCT WHERE PRODUCT_CATEGORY = '{$_GET['category']}' ORDER BY PRODUCT_NAME ASC ";
					}
					else if (isset($_GET['sort'])&& $_GET['sort'] == "DESC") {
						$query = "SELECT * FROM PRODUCT WHERE PRODUCT_CATEGORY = '{$_GET['category']}' ORDER BY PRODUCT_NAME DESC ";
					}
					else if (isset($_GET['sort'])&& $_GET['sort'] == "HL") {
						$query = "SELECT * FROM PRODUCT WHERE PRODUCT_CATEGORY = '{$_GET['category']}' ORDER BY PRODUCT_PRICE DESC ";
					}
					else if (isset($_GET['sort'])&& $_GET['sort'] == "LH") {
						$query = "SELECT * FROM PRODUCT WHERE PRODUCT_CATEGORY = '{$_GET['category']}' ORDER BY PRODUCT_PRICE ASC ";
					}
				} 
				else {
					if (isset($_GET['sort'])&& $_GET['sort'] == "ASC") {
						$query = "SELECT * FROM PRODUCT ORDER BY PRODUCT_NAME ASC ";
					}
					else if (isset($_GET['sort'])&& $_GET['sort'] == "DESC") {
						$query = "SELECT * FROM PRODUCT ORDER BY PRODUCT_NAME DESC ";
					}
					else if (isset($_GET['sort'])&& $_GET['sort'] == "HL") {
						$query = "SELECT * FROM PRODUCT ORDER BY PRODUCT_PRICE DESC ";
					}
					else if (isset($_GET['sort'])&& $_GET['sort'] == "LH") {
						$query = "SELECT * FROM PRODUCT ORDER BY PRODUCT_PRICE ASC ";
					}
				}
				$result= oci_parse($conn, $query);
				oci_execute($result);
				while ($row=oci_fetch_assoc($result)){
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