
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Contact Us</title>
	<link rel="icon" href="images/logo.png" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<!-- Header -->
	<?php include "header.php" ?>

	<!-- main body -->
	<div class= "content">
		<div id="banner">
			<h1>Contact Us</h1>
		</div>
		<h2>We would like to hear from you</h2>
		<div id="contact">
			<div id="contact-form">
				<h2>Contact Form</h2>
				<form method = "POST" name="contact" action="contact.php"   >
				
						<input type="text" name="txtName" placeholder="Name" required>
						<input type="email" name="txtEmail" placeholder="Email" required>
						<input type="number" name="txtPhone" placeholder="Phone">
						<input type="text" name="txtSub" placeholder="Subject" required>
						<textarea name="txtMsg" placeholder="write your message..." required></textarea>
						<BR>
						<button type="submit" name="send"><h4>Send</h4></button>
					
				</form>
			</div>

			<div id="contact-info">
				<h2>Contact Info</h2>
				<div class="c-info" >
					<i class="fa fa-map-marker"></i><h3>Cleckhudderfax, United Kingdoms</h3>
					<i class="fa fa-phone"></i><h3>07911 123456</h3>
					<i class="fa fa-envelope"></i><h3>suburbantakeaway@gmail.com</h3>
				</div>
			</div>
		</div>
	</div>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script>function popUp(){ swal({
				title: "Thankyou!",
				text: "We will look over your message and get back to you soon.",
				icon: "success",
				button: "okay",
			});
		}
	</script>

	<?php

		if(isset($_POST["send"])){
			
			//if (!empty($_POST)) {
			$name= $_POST['txtName'];
			$email=$_POST['txtEmail'];
			$number=$_POST['txtPhone'];
			$sub=$_POST['txtSub'];
			$msg=$_POST['txtMsg'];

					$subject = $sub;
					$message = "Message:$msg \n Sender Email: $email";
					//$headers = 'From:'. $email . "rn"; // Sender's Email
					$headers = 'Cc:'. $email ; // Carbon copy to Sender
					
					// Send Mail By PHP Mail Function
					mail("suburbantakeaway@gmail.com", $subject, $message, $headers);
					if(isset($name, $email,$sub, $msg)){
					echo'<script> popUp();</script>';
					}
		}
					//echo "Your mail has been sent successfuly ! Thank you for your feedback";
					//header('location: thank.php');
	?>
	


</body>
<footer>
		<!-- footer -->
	<?php include "footer.php"?>

</footer>
</html>