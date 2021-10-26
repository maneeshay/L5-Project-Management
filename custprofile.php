<?php
	$connection = oci_connect('suburban', 'suburban', '//localhost/xe');
    session_start();
    if(!$_SESSION['logged_in']){
		header("Location: login.php");
	}
	//$id=$_SESSION['id'];
	$query = "SELECT * FROM USERS WHERE USER_ID ='{$_SESSION['id']}' ";
	$result=oci_parse($connection, $query);
	oci_execute($result);
	$row=oci_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Profile</title>
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
				<a href="#"><i class="fa fa-user"></i> My Profile</a>
				<a href="custpass.php"><i class="fa fa-lock"></i> Password</a>
				
			</div>
			<div id="profile">
				<form method ="POST" name="profile" action="custprofile.php">
					<input type="text" name="FName" placeholder=" First Name" value="<?php echo $row['USER_FIRST_NAME']; ?>" required>
					<input type="text" name="lName" placeholder=" Last Name" value="<?php echo $row['USER_LAST_NAME']; ?>" required>
					<input type="text" name="txtEmail" placeholder="Email" value="<?php echo $row['USER_EMAIL']; ?>" readonly >
					<input type="text" name="txtPhone" placeholder="Phone Number " value="<?php echo $row['USER_CONTACT']; ?>" required>
					</br>
					<div class="button">
						<button type="submit" >Cancel</button>
						<button type="submit" name ="save">Save</button>
					</div>
				</form>
				<?php
				
				if(isset($_POST['save'])){
					/*$fname = $_POST['FName'];
					$lname = $_POST['lName'];
					$email = $_POST['txtEmail'];
					$contact = $_POST['txtPhone'];*/
					$query = "UPDATE USERS SET USER_FIRST_NAME = '{$_POST['FName']}',
								USER_LAST_NAME = '{$_POST['lName']}', USER_EMAIL = '{$_POST['txtEmail']}', USER_CONTACT = '{$_POST['txtPhone']}'
								WHERE USER_ID = '{$_SESSION['id']}'";

					$result=oci_parse($connection, $query);
					oci_execute($result);
					
				
				}                  					
			?>
    
			</div>
		</div>
	</div>
	
	<!-- footer -->
	<?php include'footer.php'?>
</body>
</html>
   