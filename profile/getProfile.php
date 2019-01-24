<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$config = require_once($root."config/config.php");
$url = $config["URL"];

if(isset($_SESSION["isLoggedIn"]) && isset($_POST["requestType"]))
{
	$errorMessage = null;
	$successMessage = null;
	$isSuccess = false;
	$userToken = $_SESSION["veriftoken"];
	$userEmail = $_SESSION["email"];
	$data = null;
//	print_r($_SESSION);
	if(empty($userToken))
	{
		$errorMessage = "Invalid user credential token Please log out and login back";
	}
	else if(empty($userEmail))
	{
		$errorMessage = "Invalid user credential email. Please log out and login back";
	}
	else if($_POST["requestType"] === "profile")
	{
		require_once($root."classes/SuperClass.php");
		$Super_Class = new Super_Class();
		$table = "users";
		$fields = "*";
		$conditions = "email = '$userEmail' AND veriftoken = '$userToken'";
		$userInfo = $Super_Class->Super_Get($fields, $table, $conditions, "id");
		if($userInfo === false)
		{
			$errorMessage = $Super_Class->Get_Message();
		}
		else if(is_array($userInfo) === false)
		{
			$errorMessage = "User data returned unrecognized type. Please contact admin";
		}
		else if(count($userInfo) <= 0)
		{
			$errorMessage = "User info failed to retrieve. Please logout and login back in.";
		}
		else if(count($userInfo) > 1)
		{
			$errorMessage = "User retrieved has a collision. Please contact the admin";
		}
		else
		{
			$isSuccess = true;
			$successMessage = "success";
			$data = array(
				"email" => $userInfo[0]["email"],
				"salutation" => $userInfo[0]["salutation"],
				"firstName" => $userInfo[0]["firstName"],
				"lastName" => $userInfo[0]["secondName"],
				"institution" => $userInfo[0]["Institution"],
				"department" => $userInfo[0]["Department"],
				"country" => $userInfo[0]["country"]
				);
		
		}
		
	}
	else
	{
		$errorMessage = "unknown request type, please contact admin";
	}
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"successMessage" => $successMessage,
		"isSuccess" => $isSuccess,
		"data" => $data
	));
	exit(0);
}
else
{
	echo json_encode(array(
		"errorMessage" => "Missing credentials",
		"isSuccess" => false,
		"successMessage" => null
	));
	exit(0);
}
?>