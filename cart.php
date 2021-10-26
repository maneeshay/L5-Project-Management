<?php $conn = oci_connect('suburban', 'suburban', '//localhost/xe'); ?>		
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cart</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<!-- Header -->
	<?php include "header.php"?>
	<!-- main body -->

	<?php 
		if(isset($_POST['order'])){
			setcookie("cart_detail[products]", serialize($_POST['products']));
			setcookie("cart_detail[grand_total]", $_POST['grand_total']);

			header("Location: order_summary.php");

		}
	?>
	
	<div class= "content">
		<div id="banner">
			<h1>Shopping Cart</h1>
		</div>
		<form action="cart.php" method="POST">

        <?php
        

        if (isset($_COOKIE['myfav'])) {
       
        	echo'<div id="cart-detail">
			<h3>Products</h3>
			<h3>Quantity</h3>
			<h3>Price</h3>
			<h3>Discount</h3>
			<h3>Total</h3>
			<h3></h3>';
			
            foreach ($_COOKIE['myfav'] as $name => $value) {
            //foreach ($products as $data) {
                $id = htmlspecialchars($value);
                $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = $id";
                $result = oci_parse($conn,$sql);
                oci_execute($result);
                $data=oci_fetch_assoc($result);

                $sql1 = "SELECT * FROM DISCOUNT WHERE PRODUCT_ID=$id";
				$result1= oci_parse($conn,$sql1);
				oci_execute($result1);
				$data1=oci_fetch_assoc($result1);
			echo'<div id="product">
				<img src="images/'.$data['PRODUCT_IMAGENAME'].'">
				<h4>'.$data['PRODUCT_NAME'].'</h4>
				<h4>'.$data['PRODUCT_DECRIPTION'].'</h4>
			</div>';
			echo'<div id="quantity">';?>
				<input type="hidden" class='id' value="<?= $data['PRODUCT_ID'] ?>" name="products[<?= $data['PRODUCT_ID'] ?>][id]">
				<input type="hidden" class='price' value="<?= $data['PRODUCT_PRICE'] ?>">
                <input type="hidden" class='discount' value="<?= $data1['DISCOUNT_PERCENTAGE'] ? $data1['DISCOUNT_PERCENTAGE'] : 0 ?>">
				<input type="number" class="qty" name="products[<?= $data['PRODUCT_ID'] ?>][qty]" min="1" max= 
				<?php if($data['STOCK_AVAILBLE']<20){echo $data['STOCK_AVAILBLE'];}
				else echo "20"; ?> value="1" required>
			</div>
			<div id="price">
				<h4><?php echo '€ '.$data['PRODUCT_PRICE']; ?></h4>
			</div>
			<div id="discount">
				<h4><?php if($data1['DISCOUNT_PERCENTAGE']== null){echo '-';}
				else echo $data1['DISCOUNT_PERCENTAGE'].'%';?></h4>
			</div>
			<div id="total" >
				<input type="hidden" id="total-<?= $data['PRODUCT_ID'] ?>" class='total-prices'>
				<h4 class='total'>€</h4>
			</div>
			<div id="delete">
				 <a href="deletecart.php?id=<?php echo $data['PRODUCT_ID']; ?>">Delete</a>
			</div>
		 	<?php }
        } 
    	else {echo 'No Product in favourites!';}
        ?>
		</div>

		<div id="cart-total">
			<a href="product.php"><i class="fa fa-arrow-left"> Continue Shopping</i></a>
			<div id="c-total">
				<input type="hidden" id='gtotal' value="" name="grand_total" required="">
				<h4 class='gtotal'><?php ?></h4>
			</div>
			<div id="order">
				<button type="submit" name="order" <?= isset($_COOKIE['myfav']) && count($_COOKIE['myfav']) > 0 ? '' : 'disabled' ?>> Order Now</button>
			</div>
		</div>
		</form>	

	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			initCalculate();
		})
	

		$('.qty').on('change', function(){
			var qty = $(this).val();
            var price = $(this).prev().prev('.price').val();
			var id = $(this).prev().prev().prev('.id').val();
			var discount = $(this).prev().val()
			var total_price = eval(qty*(price - price * discount/100))
		                                                                                       
			
            $('#total-' + id).val(total_price)
			$('#total-' + id).next().html('€' + total_price)
			caclulateTotal()
		})

		function initCalculate(){
			var qty = $('.qty');
			
			qty.each(function(){
				var price = qty.prev().prev('.price').val();
				var id = qty.prev().prev().prev('.id').val();
				var discount = qty.prev().val();
				var total_price = eval(qty*(price - price * discount/100));                                                                   
			
            	$('#total-' + id).val(total_price);
				$('#total-' + id).next().html(total_price);
			});

			//caclulateTotal()
		}

        function caclulateTotal(){
			
			var grand_total = 0;
            var price = $('.total-prices')
			price.each(function(){
				grand_total += parseFloat($(this).val())
				$('.gtotal').html('€'+grand_total)
				$('#gtotal').val(grand_total)
			});
			
        }
    </script>
	<!-- footer -->
	<?php include"footer.php"?>
</body>
</html>