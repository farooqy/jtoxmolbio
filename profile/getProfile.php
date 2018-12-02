<?php session_start();

if(isset($_SESSION["isLoggedIn"]))
{
	$errorMessage = null;
	$successMessasge = null;
	$isSuccess = false;
	$userToken = $_SESSION["token"];
	$userEmail = $_SESSION["email"];
	
	if(empty($userToken))
	{
		$errorMessage = "Invalid user credential token";
	}
	else if(empty($userEmail))
	{
		$errorMessage = "Invalid user credential email";
	}
	else
	{
		
	}
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