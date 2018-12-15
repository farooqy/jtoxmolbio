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
	else if(isset($_POST["submitType"]) && $_POST["submitType"] === "authorLevelAlter" )
	{
		$authorEmail = Validate_Email($_POST["target"]);
		if($authorEmail === false)
		{
			$errorMessage = "The author you are trying to remove contains invalid email address";
		}
		else if(in_array($authorEmail, $_existingAuthors) === false)
		{
			$errorMessage = "The author you are trying to remove is not in the list of existing authors in this manuscript";
		}
		else if($authorEmail === $userEmail)
		{
			$errorMessage = "You cannot remove the hosting/logged in author from the list of authors"; 
		}
		else
		{
			$authorIndex = array_search($authorEmail, $_existingAuthors);
			if($authorIndex === false)
				$errorMessage = "Failed to get the author index. Please contact admin";
			else 
			{
				
				unset($_SESSION["ManInfo"]["man_authors"][$authorIndex]);
				$_SESSION["ManInfo"]["man_authors"] = array_values($_SESSION["ManInfo"]["man_authors"]);
				$singleAuthor = $_SESSION["ManInfo"]["man_authors"];
				$isSuccess = true;
				$successMessage = "success";
			}
			
		}
		
	}
	else
		$errorMessage = "submition type is altered. Please try again";
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"isSuccess" => $isSuccess,
		"successMessage" => $successMessage,
		"author" => $_SESSION["ManInfo"]["man_authors"],
//		"target" => $authorIndex
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