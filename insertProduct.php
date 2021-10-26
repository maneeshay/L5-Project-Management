<?php
  include "connect.php";

  if(isset($_POST['subProduct'])){
    $name = $_POST['txtName'];
    $price = $_POST['txtPrice'];
    $category =  $_POST['txtCategory'];
    $description =  $_POST['txtDiscription'];
    $allergy =  $_POST['txtAllergy'];
    $stock =  $_POST['txtStock'];
    $min =$_POST['txtMin'];
    $max =$_POST['txtMax'];
    $image =  $_POST['txtImage'];
    $sid=$_POST['shopId'];
    $conn = oci_connect('suburban', 'suburban', '//localhost/xe');
	  $query=oci_parse($conn,"INSERT INTO PRODUCT(PRODUCT_NAME, PRODUCT_PRICE,PRODUCT_CATEGORY,PRODUCT_DECRIPTION,ALLERGY_INFO, STOCK_AVAILBLE, MIN_ORDER , MAX_ORDER ,PRODUCT_IMAGENAME, SHOP_ID) VALUES('$name' , '$price' ,'$category','$description','$allergy', '$stock','$min','$max','$image',$sid)"); 
	  
    if(oci_execute($query)){

    header("location:shopdetail.php?id=".$sid);
}    
  }
?>
