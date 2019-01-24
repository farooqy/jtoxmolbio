<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$config = require_once($root."config/config.php");
$url = $config["URL"];

require_once($root."classes/functions.php");
if(isset($_SESSION["isLoggedIn"]))
{
	
	echo json_encode(array(
		"errorMessage" => "You have a passage to the den",
		"successMessage" => null,
		"isSuccess" => false,
	));
}
else if(isset($_POST["forgotMemory"]) && isset($_POST["loginEmailAddress"]) )
{
	$errorMessage = null;
	$successMessage = null;
	$isSuccess = false;
	
	$email = Validate_Email($_POST["loginEmailAddress"]);
	
	if($email === false)
	{
		$errorMessage = "Invalid email address";
	}
	else
	{
		
		$table = "users";
		$fields = "*";
		$condition = "email = '$email' ";
		$sortby = "id LIMIT 1";
		
		require_once($root."classes/SuperClass.php");
		$Super_Class = new Super_Class();
		$user = $Super_Class->Super_Get($fields, $table, $condition, $sortby);
		
		if($user === false)
		{
			$errorMessage = $Super_Class->Get_Message();
		}
		else if(is_array($user) === false)
		{
			$errorMessage = "The returned user data type is not recognized. please contact admin";
		}
		else if(count($user) <= 0)
			$errorMessage = "Invalid email";
		else
		{
			$userEmail = $user[0]["email"];
			$time = time();
			$recoverToken = Get_Hash($time);
			$table ="recovers";
			$fields = "email, token, time, status";
			$values = "'$userEmail', '$recoverToken', $time, 'active'";
			$setRecovery = $Super_Class->Super_Insert($table, $fields,$values);
			if($setRecovery === false)
			{
				$errorMessage = "Failed to do verification. Please contact support if error persist";
			} 
			else
			{
				require_once($root."classes/mail.php");
				$Mailer = new Mail();
				$to = $userEmail;
				$from = $config["MAILADDRESS"];
				$subject = "Password Reset Request | Pan Asia Research ";
				$message = "Requested to reset Password<br>";
				$replyto = $config["REPLYTOADDRESS"];
				$link = $url."forgot?forgot=1&token=$recoverToken";
				$message = $message." To reset your password please click on the link below.<br><br>";
				$message = $message." <a href=\"$link\" target=\"_blank\"> Reset Password </a>";
				$message = $message."<br>If the link is not clickable, ".
				"please copy this url and paste it on the browser.<br<br>If you have not ".
				"requested a password reset, please ignore this message<br><br> $link <br><br>".
				"Regards,<br> Pan Asia Research.";
				$headers = "MIME-Version: 1.0 \r\n";
				$headers = $headers."Content-type: text/html; charset=iso-8859-1 \r\n";
				$headers = $headers." FROM: $from \r\n";
				$headers = $headers."Reply-to: $replyto \r\n";
				$headers = $headers."X-Mailer: PHP/".phpversion();

				$Mailer->set_mail_data($to, $subject, $message, $headers);
				
				if($Mailer->log_email())
				{
					$mail_status = $Mailer->send_mail();
					if($mail_status === true)
					{
						$isSuccess = true;
						$successMessage = "success";
					}
					else
						$errorMessage = "Failed to send you a recovery link. Please contact support";
				}
				else
					$errorMessage = "The verification has failed due to log. Please contact admin for support";


			}
		}
	}
	
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"successMessage" => $successMessage,
		"isSuccess" => $isSuccess
	));
	exit(0);
}
else
{
	echo json_encode(array(
		"errorMessage" => "Incomplete content request",
		"successMessage" => null,
		"isSuccess" => false,
		"data" => $_POST
	));
}