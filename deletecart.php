<?php
$id=$_GET['id'];
// setcookie("myfav[$id]", $id);
setcookie("myfav[$id]", null, -1, "/");


header('Location:cart.php?success='. urlencode('Product removed from favourites!'));

?>