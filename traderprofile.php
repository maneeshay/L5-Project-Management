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
			<div id="t-profile">
				
				<form method ="POST" name="t-profile" action="traderprofile.php">
					<div id="double">
						<label>First Name</label>
						<label>Last Name</label>
					<input type="text" name="FName" placeholder=" First Name" value="<?php echo $row['USER_FIRST_NAME']; ?>" required>
					<input type="text" name="lName" placeholder=" Last Name" value="<?php echo $row['USER_LAST_NAME']; ?>" required>
					<label>Email</label>
					<label>Number</label>
					<input type="text" name="txtEmail" placeholder="Email" value="<?php echo $row['USER_EMAIL']; ?>" readonly>
					<input type="text" name="txtPhone" placeholder="Phone Number "  value="<?php echo $row['USER_CONTACT']; ?>" required>
				    </div>
					</br>
					<div class="button">
						<button type="submit"><h4>Cancel</h4></button>
						<button type="submit" name="save"><h4>Save</h4></button>
					</div>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script>function popUp(){ swal({
				title: "Profile Updated",
				text: "Your profile info has been updated, please refresh your page.",
				icon: "success",
				button: "okay",
			});
		}
	</script>
<?php	
				if(isset($_POST['save'])){
					$fname = $_POST['FName'];
					$lname = $_POST['lName'];
					$email = $_POST['txtEmail'];
					$contact = $_POST['txtPhone'];
					$query = "UPDATE USERS SET USER_FIRST_NAME = '$fname',
									USER_LAST_NAME = '$lname', USER_EMAIL = '$email', USER_CONTACT = '$contact'
									WHERE USER_ID = '{$_SESSION['id']}'";

					$result=oci_parse($connection, $query);
					oci_execute($result);
					if($result){
					echo'<script> popUp();</script>';
					}
					
					
				}
				                 					
			?>