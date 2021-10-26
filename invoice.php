<?php $conn = oci_connect('suburban', 'suburban', '//localhost/xe'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Invoice</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel="stylesheet" type="text/css" href="css/style2.css"/>


	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<!-- Header -->
	<?php include'header.php'?>

	<!-- main body -->
	<div class= "content">
		<div id="banner">
			<h1>Invoice</h1>
		</div>
		<?php
			session_start();//
			$orderId = $_GET['item_number'];
			
			$orderUpdateSql = "UPDATE ORDERS SET STATUS='COMPLETED' WHERE ORDER_ID = " . $orderId;
			$orderUpdateResult = oci_parse($conn,$orderUpdateSql);
			oci_execute($orderUpdateResult);

			
		
			$orderSql = "SELECT ORDER_DATE FROM ORDERS WHERE ORDER_ID = " . $orderId;
			$result = oci_parse($conn,$orderSql);
			oci_execute($result);
			$order=oci_fetch_assoc($result);

			$paymentSql = "SELECT * FROM PAYMENT WHERE ORDER_ID = ". $orderId ;//
			$result = oci_parse($conn,$paymentSql);//
		
			oci_execute($result);//
			oci_fetch_assoc($result);//

			if(!oci_num_rows($result)){//
				$amount = $_GET['amt'];
				$userId = $_SESSION['id'];
				$status = 1;

				$insertPaymentSql = 'INSERT INTO PAYMENT(ORDER_ID, USER_ID, TOTAL_AMOUNT,PAYMENT_STATUS) ';
				$insertPaymentSql .= "VALUES(:orderNo, :userId, :amt, :pStatus) ";
				
				$insertPaymentStatement = oci_parse($conn, $insertPaymentSql);

				oci_bind_by_name($insertPaymentStatement, ':orderNo', $orderId);
				oci_bind_by_name($insertPaymentStatement, ':userId', $userId);
				oci_bind_by_name($insertPaymentStatement, ':amt', $amount);
				oci_bind_by_name($insertPaymentStatement, ':pStatus', $status);

				oci_execute($insertPaymentStatement);
			}//
		?>

        <div class="invoice-header">
                <h4> Order ID : <?= $orderId ?></h4><br>
				<h4>Placed on : <?= $order['ORDER_DATE'] ?></h4> 
            <div class="total-amount">
                <h5>Total: €<span id="gtotal">50</span></h5>
            </div>
        </div>
		<div id="invoice-detail">
			<h3>Products</h3>
			<h3>Quantity</h3>
			<h3>Price</h3>
			<h3>SHop Name</h3>
			<h3></h3>
			
			<?php 
				$orderSql = "SELECT product.PRODUCT_ID, product.STOCK_AVAILBLE, PRODUCT_NAME, ORDER_QUANTITY, PRODUCT_PRICE, PRODUCT_IMAGENAME, SHOP_NAME" ;
				$orderSql .= " FROM order_product";
				$orderSql .= " JOIN product ON order_product.PRODUCT_ID = product.PRODUCT_ID";
				$orderSql .= " JOIN SHOP ON product.SHOP_ID = shop.SHOP_ID";
				$orderSql .= " WHERE order_product.ORDER_ID = '" . $orderId . "' ";
				
				$result = oci_parse($conn,$orderSql);
				oci_execute($result);
			// $data=oci_fetch_assoc($result);
				$grandTotal = 0;

				
			?>

			<?php while($product=oci_fetch_assoc($result)){?>
				<?php
					$newQty = $product['STOCK_AVAILBLE'] - $product['ORDER_QUANTITY'];
					$updateProductSql = "UPDATE PRODUCT SET STOCK_AVAILBLE = " . $newQty . " ";
					$updateProductSql .= "WHERE PRODUCT_ID = ". $product['PRODUCT_ID'];

					$updateProductStatement = oci_parse($conn,$updateProductSql);
					oci_execute($updateProductStatement);

					$pId = $product['PRODUCT_ID'];
					setcookie("myfav[$pId]", null, -1, "/");
				?>

				<?php $grandTotal += $product['ORDER_QUANTITY'] *  $product['PRODUCT_PRICE']; ?>
				<div class="invoiceproduct">
					<img src="images/<?= $product['PRODUCT_IMAGENAME']?>">
					<h4><?= $product['PRODUCT_NAME']?></h4>
					
				</div>
				<div class="price">
					<h4><?= $product['ORDER_QUANTITY']?></h4>
				</div>
				<div class="price">
					<h4><?= "€".$product['PRODUCT_PRICE'] ?></h4>
				</div>
				<div class="traderName">
					<h4><?= $product['SHOP_NAME'] ?></h4>
				</div>
				<div class="review">
					<h4><a href="product_detail.php?id=<?= $product['PRODUCT_ID'] ?>">Review</a></h4>
				</div>
			<?php }?>
		
		</div>
		<script>
			$('#gtotal').html('<?= $grandTotal ?>')
		</script>

		<?php 
			$colSql = "SELECT * FROM COLLECTIONSLOT WHERE ORDER_ID=".$orderId ;
			$result = oci_parse($conn,$colSql);
			oci_execute($result);
			$data=oci_fetch_assoc($result);
			
			
			
			$time = date("h:i a", strtotime($data['COLLECTION_TIME']))
		?>
		<div class="collection-slot">
			<h4>Collection Slot:</h4>
			Day : <?= $data['COLLECTION_DATE'] ?>
			Time : <?= $time ?>
		</div>

	<!-- footer -->
	<?php include'footer.php'?>
</body>
</html>