 <?php
   $servername  = "localhost";
   $username    = "root";
   $password    = "";
   $dbname      = "account";

   $conn = mysqli_connect($servername,$username,$password,$dbname);

	 use PHPMailer\PHPMailer\PHPMailer;
	 use PHPMailer\PHPMailer\Exception;

	 require 'phpmailer/src/Exception.php';
	 require 'phpmailer/src/PHPMailer.php';
	 require 'phpmailer/src/SMTP.php';



   $error       = '';
   $lenght      = '';
   $pass        = '';
	 $email_check = '';

   if(isset($_POST['signup'])){
	   $name            = mysqli_escape_string($conn,$_POST['name']);
	   $email           = mysqli_escape_string($conn,$_POST['email']);
		 $mobile          = mysqli_escape_string($conn,$_POST['phone']);
	   $password        = mysqli_escape_string($conn,$_POST['pass']);
	   $ConfirmPassword = mysqli_escape_string($conn,$_POST['con-pass']);

		 $email_exist = "SELECT email FROM signup WHERE email='$email'";
		 $query       = mysqli_query($conn,$email_exist);

		 if(mysqli_num_rows($query)>0){
			 $email_check = "This email is alredy existed";
		 }

	  elseif(empty($name) || empty($email)  || empty($password) ||    empty($ConfirmPassword)){
		  $error = "This field is empty";
	  }
	  elseif (strlen($password)<5) {
	 	 $lenght = "Password must be greater then five";
	  }
		elseif ($ConfirmPassword != $password) {
			$pass = "Your passworg does not match";
		}
		else{
			$password = md5($password);
			$vkey     = md5(time().$email);
			$sql      = "INSERT INTO signup (name,email,mobile,password,vkey,vstatus) VALUES ('$name','$email','$mobile','$password','$vkey',0)";
			$query    = mysqli_query($conn,$sql);

			if($query){
				$mail = new PHPMailer;

				$mail -> isSMTP();
				$mail -> Host       = "smtp.gmail.com";
				$mail -> SMTPAuth   = "true";
				$mail -> Username   = "***********";
				$mail -> Password   = "***********";
				$mail -> SMTPSecure = "tls";
				$mail -> Port       = 587;
				$mail -> From       = "itshasan573@gmail.com";
				$mail -> FromName   = "Hasan Hero";
				$mail -> addAddress($email,"Hasan");
				$mail -> isHTML(true);
				$mail -> Subject    = "Email verification from HasanHero";
				$mail -> Body       = "<a href='http://localhost/php%20file/visitors_web/registration.php?vkey=$vkey'>Click Here</a>";

				if(!$mail->send()){
					echo "Mail are error".$mail -> ErrorInfo;
				}
				else {
					echo "<script> alert('Verification link has been send successfuly on your mail,please check your mail')</script>";

					header ('location:success.php');


				}
			}
			else {
	 	 	echo mysqli_error($conn);
	 	 }
		}
   }

 ?>


<!DOCTYPE html>
<head>
 <?php
		include_once 'stylesheet/registration.php';
  ?>
</head>
<body>
<div class="reg-w3">
<div class="w3layouts-main">
	<h2>Register Now</h2>
		<form action="#" method="POST">
			<input type="text" class="ggg" name="name" placeholder="NAME">
			<span><?= $error;?></span>
			<input type="email" class="ggg" name="email" placeholder="E-MAIL"><span><?= $error;?><?=$email_check?></span>
			<input type="text" class="ggg" name="phone" placeholder="PHONE">
			<span><?= $error;?></span>
			<input type="password" class="ggg" name="pass" placeholder="PASSWORD">
			<span><?= $error;?><?=$lenght;?></span>
			<input type="password" class="ggg" name="con-pass" placeholder="CONFIRM PASSWORD">
			<span><?= $error;?><?=$pass;?></span>

				<div class="clearfix"></div>
				<input type="submit" value="submit" name="signup">
		</form>
		<p>Already Registered.<a href="login.html">Login</a></p>
</div>
</div>
<script src="js/bootstrap.js"></script>
<script src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/scripts.js"></script>
<script src="js/jquery.slimscroll.js"></script>
<script src="js/jquery.nicescroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="js/jquery.scrollTo.js"></script>
</body>
</html>
