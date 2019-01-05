<?php session_start();
$root = $_SERVER[ "DOCUMENT_ROOT" ] . "/";
$url = "http://jtoxmolbio/";
//if ( isset( $_SESSION[ "admin" ] ) === false ) {
//	header( "Location: $url" . "maintenance" );
//	exit( 0 );
//}
ini_set("SMTP","ssl://smtp.gmail.com");
	  ini_set("smtp_port","465");
require_once($root."classes/functions.php");
if(isset($_SESSION["isLoggedIn"]) === false )
{
	header("Location: $url".'login?redirect=profile');
	exit(0);
}
else if(isset($_GET["requestType"]) && isset($_GET["token"]))
{
	$reqType = Sanitize_String($_GET["requestType"]);
	$userToken = Sanitize_String($_GET["token"]);
	if($userToken !== $_SESSION["veriftoken"] && $reqType === "verification")
	{
		$errorMessage = "Invalid data has been submitted. Cannot do verification. Please contact admin if error persist";
	} 
	else if($reqType === "verification")
	{
		require_once($root."classes/SuperClass.php");
		$Super_Class = new Super_Class();
		$table = "user_verification";
		$fields = "verif_status = 'expired'";
		$condition = "verif_target = '$userToken'";
		$isUpdated = $Super_Class->Super_Update($table, $fields, $condition);
		if($isUpdated === false)
		{
			$errorMessage = "Failed to update verification details. Please contact support";
		}
		else 
		{
			$time = time();
			$verifToken = Get_Hash($time);
			$verifStatus = 'active';

			$fields = "verif_token,verif_target, verif_time, verif_status";
			$values = "'$verifToken', '$userToken', $time, '$verifStatus'";
			$gotToken = $Super_Class->Super_Insert($table, $fields, $values);
			if($gotToken === false)
				$errorMessage = "Failed to generate token for your verification. Please contact support";
			else
			{
				$userName = $_SESSION["fullname"];
				$from = "no-reply@jtoxmolbio.com";
				$to = $_SESSION["email"];
				$subject = 'JToxMolBio | Verify your email';
				$message = "Hello $userName <br>";
				$replyto = "support@jtoxmolbio.com";
				$link = $url."profile.php?requestType=vuwhut&token=$verifToken";
				$message = $message."To verify your email address, 
				please <a href=\"".$link."\"> click here. </a><br>";
				$message = $message."If the link is not clickable, 
				please copy the url below and paste it 
				to your browser.<br><br> ";
				$message = $message." $link <br><br><br>";
				$message = $message."Regards,<br>Jtox Team.";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				// Create email headers
				$headers .= 'From: '.$from."\r\n".
				  'Reply-To: '.$replyto."\r\n" .
				  'X-Mailer: PHP/' . phpversion();
				require_once($root."classes/mail.php");
				$Mailer = new Mail();
				$Mailer->set_mail_data($to, $subject, $message, $headers);
				$mail_status = $Mailer->send_mail();
				if($mail_status === true)
				{
					$success = "sent the verification email. Pleae check you mailbox and click on the verification link to verify your account";
					if($Mailer->log_email())
					{
						$success = "successfully ".$success;
					}
				}
				else
					$errorMessage = "The verification has failed. Please contact admin for support";
			}
			
		}
		
	}
	else if($reqType === "vuwhut")
	{
		require_once($root."classes/SuperClass.php");
		$Super_Class = new Super_Class();
		$verifToken = $userToken;
		$userEmail = $_SESSION["email"];
		$userToken = $_SESSION["veriftoken"];
		$verifStatus = 'verified';
		$table = "user_verification";
		$fields = "*";
		$condition = "verif_token ='$verifToken' AND verif_target = '$userToken' AND verif_status = 'active' ";
		$gotToken = $Super_Class->Super_Get($fields, $table, $condition, "verif_id");
		if($gotToken === false)
			$errorMessage = "Failed to get token for your verification. Please contact support";
		else if($gotToken[0]["verif_time"] < (time() - (24*60*60)))
		{
			//verification time must not be 24 hrs more than the time requested
			$errorMessage = "Your verification link has expired. Please request a new verification link";
		}
		else
		{
			$table = "users";
			$fields = "status = 'active'";
			$condition= "veriftoken ='$userToken' AND email ='$userEmail'  ";
			$isUpdated = $Super_Class->Super_Update($table, $fields, $condition);
			if($isUpdated === true)
			{
				$userName = $_SESSION["fullname"];
				$from = "no-reply@jtoxmolbio.com";
				$to = $_SESSION["email"];
				$subject = 'JToxMolBio | Verify your email';
				$message = "Hello $userName <br>";
				$replyto = "support@jtoxmolbio.com";
				$link = $url."profile.php?requestType=vuwhut&token=$verifToken";
				$message = $message."To verify your email address, 
				please <a href=\"".$link."\"> click here. </a><br>";
				$message = $message."If the link is not clickable, 
				please copy the url below and paste it 
				to your browser.<br><br> ";
				$message = $message." $link <br><br><br>";
				$message = $message."Regards,<br>Jtox Team.";
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				// Create email headers
				$headers .= 'From: '.$from."\r\n".
				  'Reply-To: '.$replyto."\r\n" .
				  'X-Mailer: PHP/' . phpversion();
				require_once($root."classes/mail.php");
				$Mailer = new Mail();
				$Mailer->set_mail_data($to, $subject, $message, $headers);
				$mail_status = $Mailer->send_mail();
				if($mail_status === true)
				{
					$success = "Verified your account. Thank you.";
					$_SESSION["verifStatus"] = "active";
					if($Mailer->log_email())
					{
						$success = "successfully ".$success;
					}
				}
				else
					$errorMessage = "The verification has failed. Please contact admin for support";
			}
			else
				$errorMessage = "failed to verify your account. Please contact support";
				
		}
	}
}
$profilePage = true;
?>
<!doctype html>
<html><head>
<meta charset="utf-8">

<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.progressbar.min.css" rel="stylesheet" type="text/css">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Journal Of Toxicology and Molecular Biology</title>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body style="padding-top: 70px">
<div class="container">
  <div class="row" id="header">
  	<?php require($root."includes/nav.php"); ?>
  </div>
 
	
</div>
<div class="container profileContainer">
	 
  <div class="row errorDiv">
  	
  </div>
  <?php
	if(isset($errorMessage))
	{
		$usertoken = $_SESSION["veriftoken"];
		$veriflink = $url.'profile?requestType=verification&token='.$usertoken;
		?>
  <div class="row displayError" style="display: block">
  	<?php echo $errorMessage ?>
  </div>
  <div class="row verifDiv">
  	You have not verified your account. Some of the functionalities are disabled until your verify your account. Please
	<a href="<?php echo $veriflink ?>"> Click here </a> 
	to verify your account
  </div>
		<?php
	}
	else if(isset($success))
	{
		?>
  <div class="row successDiv " style="display: block">
  	<?php echo $success ?>
  </div>
		<?php
	}
	else  if(isset($_SESSION["verifStatus"]) && $_SESSION["verifStatus"] === "unverified")
	{
		$usertoken = $_SESSION["veriftoken"];
		$veriflink = $url.'profile?requestType=verification&token='.$usertoken;
		?>
  <div class="row verifDiv ">
  	You have not verified your account. Some of the functionalities are disabled until your verify your account. Please
	<a href="<?php echo $veriflink ?>"> Click here </a> 
	to verify your account
  </div>
		<?php 
	}
	?>
  <div class="row profilePage">
  <div class="col-xs-0 col-sm-0 col-md-3 col-lg-3">
  	
  </div>
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 profileDiv">
  	<div class="row ">
  		<label for="userTitle" class="textLabel">Salutation</label>
  		<input type="text" class="userTitle" name="userTitle" placeholder="first name" value="">
  		<button class="btn btn-primary changeProfile" target="userTitle">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userFirstName" class="textLabel">First Name</label>
  		<input type="text" class="userFirstName" name="userFirstName" placeholder="first name" value="">
  		<button class="btn btn-primary changeProfile" target="userFirstName">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userLastName" class="textLabel"> Last Name</label>
  		<input type="text" class="userLastName" name="userLastName" placeholder="last name" value="">
  		<button class="btn btn-primary changeProfile" target="userLastName">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userEmailAddress" class="textLabel">Email Address</label>
  		<input type="text" class="userEmailAddress" name="userEmailAddress" placeholder="email address" value="">
  		<button class="btn btn-primary changeProfile" target="userEmailAddress">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userPasswordOld" class="textLabel">Old Password</label>
  		<input type="password" class="userPasswordOld" name="userPasswordOld" placeholder="old password" value="">
  	</div>
  	<div class="row ">
  		<label for="userPasswordNew" class="textLabel">New Password</label>
  		<input type="password" class="userPasswordNew" name="userPasswordNew" placeholder="new password" value="">
  		<button class="btn btn-primary changeProfile" target="userPassword">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userInstitute" class="textLabel">Institue</label>
  		<input type="text" class="userInstitute" name="userInstitute" placeholder="Institute" value="">
  		<button class="btn btn-primary changeProfile" target="userInstitute">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userDepartment" class="textLabel">Department</label>
  		<input type="text" class="userDepartment" name="userDepartment" placeholder="UserFirstName" value="">
  		<button class="btn btn-primary changeProfile" target="userDepartment">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userCountry" class="textLabel">Country</label>
  		<input type="text" class="userCountry" name="userCountry" placeholder="Country" value="">
  		<button class="btn btn-primary changeProfile" target="userCountry">Save</button>
  	</div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
  	
  </div>
		
  </div>
	<?php require_once($root."includes/footer.html") ?>
</div>
<div class="container-fluid loader-gif">
	<img src="../uploads/sitefiles/icons/tv_loading.gif">
</div>

<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/main.js"></script>
<script src="../jQueryAssets/jquery-1.11.1.min.js"></script>
<script src="../jQueryAssets/jquery.ui-1.10.4.progressbar.min.js"></script>
<style>
	@import url("../css/main.css");
	@import url("../css/768.css");
	@import url("../css/footer.css");
	@import url("../css/font-awesome.min.css");
	
</style>
</body>

</html>