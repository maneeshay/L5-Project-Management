
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
	<?php include'header.php'?>

	<!-- main body -->
	<div class= "content">
		<div id="banner">
			<h1>Account Setting </h1>
		</div>
		<div class="container">
			<div id="menu">
				<a href="custprofile.php"><i class="fa fa-user"></i> My Profile</a>
				<a href="#"><i class="fa fa-lock"></i> Password</a>
				
			</div>
			<div id="pass">	
			<?php
				$connection = oci_connect('suburban', 'suburban', '//localhost/xe');
				session_start();

				if(isset($_POST['save'])){
					$oldpass=$_POST['oldPass'];
					$newpass=$_POST['newPass'];
					$confirm=$_POST['confirmPass'];
					$query = "SELECT * FROM USERS WHERE USER_ID ='{$_SESSION['id']}' ";
					$result=oci_parse($connection, $query);
					oci_execute($result);
					$row=oci_fetch_assoc($result);
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
				<form method="POST" name="password" action="custpass.php">
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
<?php include'footer.php'?>
</body>
</html>