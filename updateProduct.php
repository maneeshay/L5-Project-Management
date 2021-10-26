<?php

include "connect.php";

$Id= $_POST['txtProductId'];
$name = $_POST['txtProductName'];
$price = $_POST['txtProductPrice'];
$image = $_POST['txtProductImage'];
$description=$_POST["txtProductDescription"]; 
$allergy=$_POST["txtProductAllergy"]; 
$stock=$_POST["txtProductStock" ]; 
$maxOrder=$_POST["txtMaxOrder"]; 
$minOrder=$_POST["txtMinOrder"];  
$conn = oci_connect('suburban', 'suburban', '//localhost/xe');
$sql= oci_parse($conn,"SELECT * FROM PRODUCT WHERE PRODUCT_ID = '$Id'");
oci_execute($sql);
$row= oci_fetch_assoc($sql);
echo $row['SHOP_ID'];
$query=oci_parse($conn,"UPDATE PRODUCT SET PRODUCT_NAME = '$name', PRODUCT_PRICE = '$price', PRODUCT_DECRIPTION= '$description', ALLERGY_INFO = '$allergy', STOCK_AVAILBLE= '$stock',	 MIN_ORDER= '$maxOrder',	 MAX_ORDER= '$minOrder', PRODUCT_IMAGENAME = '$image' WHERE  PRODUCT_ID = '$Id'");

oci_execute($query);

	header("location:shopdetail.php?id=".$row['SHOP_ID']);




				


?>