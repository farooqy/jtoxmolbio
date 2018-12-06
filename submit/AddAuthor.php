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
	else if(is_array($_SESSION["ManInfo"]["man_authors"]) === false)
		$errorMessage = "The manuscript authors is initiated to invalid type. Please contact admin";
	else if(isset($_POST["submitType"]) && $_POST["submitType"] === "authorAddition" && isset($_POST["cAuthor"]))
	{
		
		$cAuthor = Validate_Email($_POST["cAuthor"]);
		$authorFields = array(
			"authorTitle","authorFirstName", "authorLastName", 
			"authorInstitution", "authorEmail", "authorLocation"
		);
		$fieldNames = array(
			"Author title", "author first name", "author last name",
			"author institution", "author email", "author location"
		);
		$Authors = $_SESSION["ManInfo"]["man_authors"];
		
		foreach($authorFields as $fieldKey => $fieldValue)
		{
			$value = Sanitize_String($_POST[$fieldValue]);
			if(empty($value))
			{
				$errorMessage = "Please  provide the ".$fieldNames[$fieldKey];
				break;
			}
			else if($fieldKey === 0 && $value === "dft")
			{
				$errorMessage = "Please  provide the ".$fieldNames[$fieldKey];
				break;
			}
			else if($fieldKey === 4 && Validate_Email($value) === false)
			{
				$errorMessage = "The ".$fieldNames[$fieldKey]. " is not a valid email";
				break;
			}
			else
			{
				if($fieldKey === 4)
					$value = Validate_Email($value);
				$singleAuthor[$fieldValue] = $value;
			}
				
				
		}
		if(empty($errorMessage) && $errorMessage === null)
		{
			if($cAuthor === false)
				$errorMessage = "The corresponding author  is not valid";
			else
			{
				$authorToken = Get_Hash(time());
				if($cAuthor === $singleAuthor["authorEmail"])
					$singleAuthor["isCorresponding"] = true;
				else
					$singleAuthor["isCorresponding"] = false;
				$singleAuthor["authorToken"] = $authorToken;
				array_push($Authors, $singleAuthor);
				$_SESSION["ManInfo"]["man_authors"] = $Authors;
				if($_stage === 1) 
					$_stage = $_stage +1;
				$_SESSION["ManInfo"]["man_stage"] = $_stage;
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
		"author" => $singleAuthor
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