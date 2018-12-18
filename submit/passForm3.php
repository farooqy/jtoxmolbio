<?php session_start();
$root = $_SERVER[ "DOCUMENT_ROOT" ] . "/";
$url = "http://jtoxmolbio/";
require_once($root."classes/functions.php");
if(isset($_SESSION["isLoggedIn"]) && isset($_SESSION["ManInfo"]))
{
	$errorMessage = null;
	$isSuccess = false;
	$successMessage = null;
	$singleAuthor = array();
	$userToken = $_SESSION["veriftoken"];
	$userEmail = $_SESSION["email"];
	$_stage = $_SESSION["ManInfo"]["man_stage"];
	$_existingAuthors = array_column($_SESSION["ManInfo"]["man_authors"], "authorEmail");
	if(isset($_SESSION["ManInfo"]["ManDocument"]))
		$uploadFiles = $_SESSION["ManInfo"]["ManDocument"];
	else
		$uploadFiles = array();
	if(empty($userToken))
		$errorMessage = "Incomplete data token to verify account";
	else if(empty($userEmail))
		$errorMessage = "Incomplete data to verify account";
	else if(isset($uploadFiles["manuscript"]) === false )
		$errorMessage = "Please upload manuscript";
	else if(isset($uploadFiles["cover"]) === false )
		$errorMessage = "Please upload cover";
	else if(isset($uploadFiles["figures"]) === false )
		$errorMessage = "Please upload at least one figure";
	else if(is_array($uploadFiles["figures"]) === false)
		$errorMessage = "The figures are not set. Please contact admin";
	else if(count($uploadFiles["figures"]) <= 0)
		$errorMessage = "Please upload at least one figure to continue";
	else if($_stage < 2)
	{
		$errorMessage = "Please complete the Author info stage first";
	}
	else if(isset($_SESSION["ManInfo"]["man_authors"]) === false )
		$errorMessage = "The manuscript authors have  not been initiated";
	else if(is_array($_SESSION["ManInfo"]["man_authors"]) === false || is_array($_existingAuthors) === false)
		$errorMessage = "The manuscript authors is initiated to invalid type. Please contact admin";
	else if(isset($_POST["submitType"]) && $_POST["submitType"] === "completeForm3" )
	{
		$_stage = 3;
		$_SESSION["ManInfo"]["man_stage"] = $_stage;	
		$isSuccess = true;
		$successMessage = "success";
	}
	else
		$errorMessage = "submition type is altered. Please try again";
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"isSuccess" => $isSuccess,
		"successMessage" => $successMessage,
		"author" => $singleAuthor,
		"stage" => $_SESSION["ManInfo"]["man_stage"],
	));
	exit(0);
}
else
{
	echo json_encode(array(
		"errorMessage" => "You are missing the helmet for the ride",
		"isSuccess" => false,
		"successMessage" => null,
		"data" => $_POST
	));
	exit(0);
}
?>