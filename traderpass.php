<?php
	$connection = oci_connect('suburban', 'suburban', '//localhost/xe');
    session_start();
	//$id=$_SESSION['id'];
	if(!$_SESSION['logged_in']){
		header("Location: login.php");
	}
	$query = "SELECT * FROM USERS WHERE USER_ID ='{$_SESSION['id']}' ";
	$result=oci_parse($connection, $query);
	oci_execute($result);
	$row=oci_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Anout Us</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<!-- Header -->
	<header>
		<div class="topnav">
			<img src="images/logo.png">
			<div class="search-container">
    			
 			</div>
 			<div id="topicon">
 				<div class="dropdown">
					<button class="dropbtn"><i class="fa fa-user"></i></button>
					<div class="dropdown-content">
						<a href="logout.php">Logout</a>
				  	</div>
				</div>
 			</div>
 	
		</div>
		
	</header>

	<!-- main body -->
	<div class= "content">
		<div id="banner">
			<h1> My Profile </h1>
		</div>
		<div class="container">
			<div id="menu">
				<a href="traderprofile.php"><i class="fa fa-user"></i> My Profile</a>
				<a href="traderpass.php"><i class="fa fa-lock"></i> Password</a>
				<a href="tradershop.php"><i class="fa fa-home"></i>Shop</a>
				<a href="http://127.0.0.1:8080/apex/f?p=103:LOGIN_DESKTOP:14438762505251:::::"><i class="fa fa-tachometer"></i>Dashboard</a>
			</div>
			<div id="pass">	
			<?php
				if(isset($_POST['save'])){
					$oldpass=$_POST['oldPass'];
					$newpass=$_POST['newPass'];
					$confirm=$_POST['confirmPass'];
					if($row['USER_PASSWORD'] == ($_POST['oldPass'])){
						$query = "UPDATE USERS SET USER_PASSWORD='{$_POST['newPass']}'
													WHERE USER_ID = '{$_SESSION['id']}'";
						$result=oci_parse($connection, $query);
						oci_execute($result);
						header('location: login.php');
					}
					else{
						echo "<div class='error'>wrong password!</div><br>";
					}
				}
			?>		
				<form method="POST" name="password" action="traderpass.php">
					<input type="password" name="oldPass" placeholder=" Old Password">
					<input type="password" name="newPass" placeholder=" New Password">
					<input type="password" name="confirmPass" placeholder="Confirm Password"></br>
						<button type="submit"><h4>Cancel</h4></button>
						<button type="submit" name="save"><h4>Save</h4></button>
				</form>
			</div>
		</div>
	</div>
	<!-- footer -->
	<footer>
		<div id="bottom">
			<div class="b-left">
				<a href="termsofservices.php">Terms of services</a> |
				<a href="privacypolicy.php">Privacy Policy</a>
			</div>
			<div class="b-right">
				&#169; The Subrban Takeaway
			</div>
		</div>
	</footer>
</body>
</html>