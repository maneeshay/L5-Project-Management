<?php
$id=$_GET['id'];

setcookie("myfav[$id]",$id, time()+(60*60*24*30), "/");

header('Location:cart.php?success='. urlencode('Product added to cart!'));
?>