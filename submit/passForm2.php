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
	if(empty($userToken))
		$errorMessage = "Incomplete data token to verify account";
	else if(empty($userEmail))
		$errorMessage = "Incomplete data to verify account";
	else if($_stage < 1)
	{
		$errorMessage = "Please complete the manuscript information stage first";
	}
	else if(isset($_SESSION["ManInfo"]["man_authors"]) === false )
		$errorMessage = "The manuscript authors have  not been initiated";
	else if(is_array($_SESSION["ManInfo"]["man_authors"]) === false || is_array($_existingAuthors) === false)
		$errorMessage = "The manuscript authors is initiated to invalid type. Please contact admin";
	else if(isset($_POST["submitType"]) && $_POST["submitType"] === "continueForm2" && isset($_POST["cAuthor"]))
	{
		
		$cAuthor = Validate_Email($_POST["cAuthor"]);
		
		$Authors = $_SESSION["ManInfo"]["man_authors"];
		if($cAuthor === false)
			$errorMessage = "The corresponding author  is not valid. Probably tempered with";
		$_authorEmails = array_column($Authors, "authorEmail");
		if(in_array($cAuthor, $_authorEmails) === false)
			$errorMessage = "The corresponding author email doesn't exist among authors. Please ensure you have a corresponding author";
		else
		{
			if($_stage === 1) 
				$_stage = $_stage +1;
			$_SESSION["ManInfo"]["man_stage"] = $_stage;
			$_SESSION["ManInfo"]["corresPondingAuthor"] = $cAuthor;
			$isSuccess = true;
			$successMessage = "success";
		}
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