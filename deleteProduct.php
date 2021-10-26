<?php

	include "connect.php";

	$Id = $_GET['id'];

	//$query = "DELETE FROM PRODUCT WHERE PRODUCT_ID = '$Id'";

	//mysqli_query($connection, $query);

				$conn = oci_connect('suburban', 'suburban', '//localhost/xe');
				$query=oci_parse($conn,"DELETE FROM PRODUCT WHERE PRODUCT_ID = '$Id'"); 
				oci_execute($query);


	if (oci_num_rows($query) > 0) {

//If yes , return to calling page(stored in the server variables)

	header("Location: {$_SERVER['HTTP_REFERER']}");

	} else {

// print error message

	echo "Error in query: $query. " . oci_error($conn);

	exit ;

}




?>