<?php $conn = oci_connect('suburban', 'suburban', '//localhost/xe'); ?>		
<?php 
	session_start();
	
	if(!$_SESSION['logged_in']){
		header("Location: login.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Anout Us</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="http://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
</head>
<body>
	<!-- Header -->
	<?php include'header.php'?>
    <!-- main body -->
	<div class= "content">
        <div id="banner">
			<h1>Order Summary</h1>
		</div>
        <div class="order-detail">
            <div class="order">
				<div class="product-detail">
					<h3>Products</h3>
					<h3>Quantity</h3>
					<h3>Price</h3>
				<?php 
				$userId = $_SESSION['id'];
				$sql=oci_parse($conn,"SELECT * FROM CART WHERE USER_ID= '$userId'");
				oci_execute($sql);
				$fetch= oci_fetch_assoc($sql);
				$cid= $fetch['CART_ID'];
				$orderSql = "SELECT ORDER_ID FROM ORDERS WHERE CART_ID= '$cid' AND STATUS='PENDING'";
					$statement = oci_parse($conn, $orderSql);
					oci_execute($statement);

					$order = oci_fetch_assoc($statement);
					$numRow = oci_num_rows($statement);
					$orderId = 0;
					
					if(!$numRow){
						$date = date('d-M-Y') ;
						$status = 'PENDING';
						
						$insertOrderSql = 'INSERT INTO ORDERS(CART_ID, ORDER_DATE, STATUS) '.
							'VALUES(:cid, :orderDate, :status) RETURNING ORDER_ID INTO :p_val';
						
						
						$insertOrderStatement = oci_parse($conn, $insertOrderSql);
						
						oci_bind_by_name($insertOrderStatement, ':cid', $cid);
						oci_bind_by_name($insertOrderStatement, ':orderDate', $date);
						oci_bind_by_name($insertOrderStatement, 'p_val', $orderId);
						oci_bind_by_name($insertOrderStatement, ':status', $status);

						oci_execute($insertOrderStatement);
					}else{
						$orderId = $order['ORDER_ID'];
					}
				?>
				<?php if(isset($_COOKIE['cart_detail']['products']) && $_COOKIE['cart_detail']['products']){ ?>
						<?php 
							$products = unserialize($_COOKIE['cart_detail']['products']); 

							foreach($products as $product){
								
								$productId = $product['id'];
								$qty = $product['qty'];


								$findOrderSql = "SELECT PRODUCT_ID FROM ORDER_PRODUCT WHERE PRODUCT_ID=". $productId . " ";
								$findOrderSql .= "AND ORDER_ID = " . $orderId;
								$findOrderStatement = oci_parse($conn, $findOrderSql);
								oci_execute($findOrderStatement);
								$fp = oci_fetch_assoc($findOrderStatement);

								if(!oci_num_rows($findOrderStatement)){
									$insertOrderSql = 'INSERT INTO ORDER_PRODUCT(ORDER_ID,PRODUCT_ID,ORDER_QUANTITY) '.
										'VALUES(:orderId, :productId, :quantity)';
									
									$insertOrderStatement = oci_parse($conn, $insertOrderSql);
									
									oci_bind_by_name($insertOrderStatement, ':orderId', $orderId);
									oci_bind_by_name($insertOrderStatement, ':productId', $productId);
									oci_bind_by_name($insertOrderStatement, ":quantity", $qty);
									

									oci_execute($insertOrderStatement);
									//setcookie("myfav[$productId]", null, -1, "/");
								}else{
									$updateOrderSql = 'UPDATE ORDER_PRODUCT ';
									$updateOrderSql .= 'SET ORDER_QUANTITY=:quantity ';
									$updateOrderSql .= "WHERE PRODUCT_ID = " . $productId . ' ';
									$updateOrderSql .= "AND ORDER_ID = " . $orderId ;

									
									$updateOrderStatement = oci_parse($conn, $updateOrderSql);
								
									oci_bind_by_name($updateOrderStatement, ":quantity", $qty);
									oci_execute($updateOrderStatement);
									//setcookie("myfav[$productId]", null, -1, "/");
								}
							}

							
							setcookie("cart_detail", null, -1, "/");
						?>
				<?php } ?>
				
				<?php
					$orderProductsSql = "SELECT PRODUCT_ID,ORDER_QUANTITY FROM ORDER_PRODUCT WHERE ORDER_ID = $orderId";
					$orderProductsStatement = oci_parse($conn,$orderProductsSql);
	                oci_execute($orderProductsStatement);
	               	// oci_fetch_all($orderProductsStatement, $orderProducts);
					   
				
					  
				?>



				<?php $grandTotal = 0; ?>
				<?php while($oproduct=oci_fetch_assoc($orderProductsStatement)){ ?>
					
				
					<?php
					
						$id = $oproduct['PRODUCT_ID'];
						$qty = $oproduct['ORDER_QUANTITY'];
						$sql = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = $id";
						$result = oci_parse($conn,$sql);
						oci_execute($result);
						$data=oci_fetch_assoc($result);

						$sql1 = "SELECT * FROM DISCOUNT WHERE PRODUCT_ID=$id";
						$result1= oci_parse($conn,$sql1);
						oci_execute($result1);
						$data1=oci_fetch_assoc($result1); 
					?>
					<div class="order-product">
						<?php echo'<img src="images/'.$data['PRODUCT_IMAGENAME'].'">'?>
						<h5><?= $data['PRODUCT_NAME'] ?></h5>
						<h5>Trader Name</h5>
					</div>
					<div class="order-quantity">
						<h5><?= $qty ?></h5>		
					</div>
					<div id="order-price">
						<h4>€<?= $qty *  $data['PRODUCT_PRICE']; ?></h4>
					</div>
					<?php $grandTotal += $qty *  $data['PRODUCT_PRICE']; ?>
				<?php } ?>
				
					

					<!-- <div class="order-product">
						<img src="images/product1.jpg">
						<h5>Product Name</h5>
						<h5>Trader Name</h5>
					</div>
					<div class="order-quantity">
						<h5>Quantity</h5>	
					</div>
					<div id="order-price">
						<h4>€50</h4>
					</div> -->
				</div>
				
				<div class="order-summary">
					<div class="slot">
						<H3> Collection Slot</H3>
						<form method ="POST" action="pay-with-paypal.php">
						<?php 
						date_default_timezone_set("Asia/Kathmandu");
						?>
							<input type="hidden" name="orderId" value="<?= $orderId ?>">
							<input type="hidden" name="grandTotal" value="<?= $grandTotal ?>">
							<label>Select Day:</label>
							<input type="text" name="date" class="date" id="date">

							<label>Select time:</label>
							<select type="text" name="time" class="time" id="time">
								<option value="10:00:00">10 AM to 1PM</option>
								<option value="13:00:00">1PM to 4PM</option>
								<option value="16:00:00">4PM to 7PM</option>
							</select>
							<input type="submit" name="submit" value="Submit">
							<script type="text/javascript">
								$(document).ready(function () {
									$(".date").datepicker({
										beforeShowDay: limitDays,
										minDate: 1, 
										dateFormat: 'dd/mm/yy'
									});

									$("#date").on('change', function(){
										
										var timeSlot = ['10', '13', '16'];

										var date = new Date($('#date').val());
										if(date.getDay())
										console.log(date)
									}); 
								});

								function limitDays(date){
									if (date.getDay() === 3 || date.getDay() === 4 || date.getDay() === 5){ 
										return [ true, "", "" ];
									}else{
										return [ false, "closed", "Not Available" ];
									}
								}

								function getOptions(){
									
								}
							</script>

						</form>
					</div>

					<div class="payment">
					
						<p>Total: € <?= $grandTotal ?> </p><br>
						
					</div>
				</div>
            </div>

            
            <div class="recomend-product">
				<h3>Recomended Product</h3><br>
				<?php
				$query=oci_parse($conn,'SELECT * FROM( SELECT * FROM product ORDER BY dbms_random.value) WHERE rownum <5'); 
				oci_execute($query);
				while ($row=oci_fetch_assoc($query)){
				echo'<div class="rec-product">
                    <img src="images/'.$row['PRODUCT_IMAGENAME'].'" alt="img can\'t load" >';
                   	echo "<p>".$row['PRODUCT_NAME']."</p>";
                    echo"<p> £".$row['PRODUCT_PRICE']."</p>";

                echo'</div>
				<div class="view-details">
					<a href="product_detail.php?id='.$row['PRODUCT_ID'].'"><button>View Details</button></a>
				</div>';}?>
        </div>



    </div>
	<!-- footer -->
	<?php include'footer.php'?>
</body>
</html>
