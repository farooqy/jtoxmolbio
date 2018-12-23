<?php 
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$url = "http://jtoxmolbio/";
$_SESSION['IsCaptchaSolved'] = false;
if(isset($_POST["senderName"]) && isset($_POST["emailAddress"]))
{
	$errorMessage = null;
	$successMessage = null;
	$isSuccess = false;
	require_once($root."classes/functions.php");
	$senderName = Sanitize_String($_POST["senderName"]);
	$senderEmail = Validate_Email($_POST["emailAddress"]);
	if(empty($senderName))
		$errorMessage = "Please prove a name ";
	else if($senderEmail === false)
		$errorMessage = "The email address you have provided is not valid. Please provide valid email";
	else if(isset($_SESSION["email"]) && $_SESSION["email"] !== $senderEmail)
		$errorMessage = "The email address you have provided is different from the logged in user email. Please logout if you need to use different email";
	else if(isset($_SESSION["fullname"]) && $_SESSION["fullname"] !== $senderName)
		$errorMessage = "The name you have provided is different from the logged in user name. Please logout if you need to use different name";
	else if(isset($_POST["feedbackTitle"]) === false || empty($_POST["feedbackTitle"]))
		$errorMessage = "Please provide a title to your feedback/mesasge";
	else if(isset($_POST["feedbackContent"]) === false || empty($_POST["feedbackContent"]))
		$errorMessage = "Please provide a message to your feedback";
	else if(isset($_POST["CaptchaCode"]) === "false" || empty($_POST["CaptchaCode"]))
		$errorMessage = "Please verify you are human by filling the code";
	else if(isset($_POST["CaptchaInstanceId"]) === "false" || empty($_POST["CaptchaInstanceId"]))
		$errorMessage = "Your request is missing data to verify you are human. Please contact support";
	else if(ValidateCaptchaCode($_POST["CaptchaCode"], $_POST["CaptchaInstanceId"]) === false)
		$errorMessage = "Your validation code is not valid. Try again";
	else
	{
		$feedbackTitle = Sanitize_String($_POST["feedbackTitle"]);
		$feedbackContent = Sanitize_String($_POST["feedbackContent"]);
		$time = time();
		require_once($root."classes/superClass.php");
		$Super_Class = new Super_Class();
		$table = "feedback";
		$fields = "email, title, message, time, replied_status";
		$values = "'$senderEmail', '$feedbackTitle', '$feedbackContent', $time, 'false'";
		
		$isSaved = $Super_Class->Super_Insert($table, $fields, $values);
//		$isSaved = true;
		if($isSaved)
		{
			$isSuccess = true;
			$successMessage = "success";
		}
		else
			$errorMessage = "Failed to save the feedback. Please contact support ";
	}
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"successMessage" => $successMessage,
		"isSuccess" => $isSuccess
	));
	exit(0);
}

function ValidateCaptchaCode($code, $instanceId) {
    global $ContactCaptcha;
    // We want to check if the user already solved the Captcha for this message
//    $isHuman = isset($_SESSION['IsCaptchaSolved']);

//    if (!$isHuman) {
//      // Validate the captcha
//      // Both the user entered $code and $instanceId are used.
//      
//      global $request;
//      if (array_key_exists('CaptchaInstanceId', $request)) { // ajax validation of Captcha input only
////        $instanceId = $request["CaptchaInstanceId"];
//        $isHuman = $ContactCaptcha->AjaxValidate($code, $instanceId);
//      } else { // regular full form post validation of all fields
//        $isHuman = $ContactCaptcha->Validate($code);
//      }
//    }
	$isHuman = $ContactCaptcha->AjaxValidate($code, $instanceId);
    if ($isHuman === true) {
      $_SESSION['IsCaptchaSolved'] = true;
      return true;
    } else {
      return false;  
    }
  }
?>