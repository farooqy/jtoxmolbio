<?php session_start();
$root = $_SERVER['DOCUMENT_ROOT']."/";
$url = "http://jtoxmolbio";
require_once($root."classes/functions.php");
if(isset($_SESSION["isLoggedIn"]))
{
	
	echo json_encode(array(
		"errorMessage" => "You have a passage to the den",
		"successMessage" => null,
		"isSuccess" => false,
	));
}
else if(isset($_POST["loginUser"]) && isset($_POST["loginEmailAddress"]) && isset($_POST["loginPassword"]))
{
	$errorMessage = null;
	$successMessage = null;
	$isSuccess = false;
	
	$email = Validate_Email($_POST["loginEmailAddress"]);
	$password = Sanitize_String($_POST["loginPassword"]);
	
	if($email === false)
	{
		$errorMessage = "Invalid email address";
	}
	else
	{
		$hashedPass = Get_Hash($password);
		$table = "users";
		$fields = "*";
		$condition = "email = '$email' AND password = '$hashedPass'";
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
			$errorMessage = "Invalid email or password";
		else
		{
			$successMessage = "success";
			$isSuccess = true;
			$_SESSION["isLoggedIn"] = true;
			$_SESSION["veriftoken"] = $user[0]["veriftoken"];
			$_SESSION["email"] = $user[0]["email"];
			$_SESSION["salutation"] = $user[0]["salutation"];
			$_SESSION["firstname"] = $user[0]["firstName"];
			$_SESSION["lastname"] = $user[0]["secondName"];
			$_SESSION["fullname"] = $user[0]["salutation"]." ".$user[0]["secondName"];
			$_SESSION["country"] = $user[0]["country"];
			$_SESSION["institute"] = $user[0]["Institution"];
			$_SESSION["department"] = $user[0]["Department"];
			$_SESSION["verifStatus"] = $user[0]["status"];
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