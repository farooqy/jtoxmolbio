<?php session_start();
$root = $_SERVER[ "DOCUMENT_ROOT" ] . "/";
$url = "http://jtoxmolbio/";
require_once($root."classes/functions.php");
require_once($root."classes/SuperClass.php");
if(isset($_SESSION["isLoggedIn"]) && isset($_SESSION["isLoggedIn"]))
{
	$errorMessage = null;
	$isSuccess = false;
	$successMessage = null;
	$singleAuthor = array();
	$userToken = $_SESSION["veriftoken"];
	$userEmail = $_SESSION["email"];
	$Super_Class = new SUper_Class();
	if(empty($userToken))
		$errorMessage = "Incomplete data token to verify account";
	else if(empty($userEmail))
		$errorMessage = "Incomplete data to verify account";
	else if(isset($_POST["submitType"]) && $_POST["submitType"] === "dfigure" && isset($_POST["target"]))
	{
		$target = explode("|",Sanitize_String($_POST["target"]));
		if(is_array($target) === false)
		{
			$errorMessage = "The data of the target is not valid";
		}
		else if(count($target) !== 3)
		{
			$errorMessage = "The length of the data is not valid";
		}
		else if(Validate_Int($target[1]) === false)
		{
			$errorMessage =  "The data contains invalid content";
		}
		else
		{
			$jid = $target[2];
			$figId = $target[0];
			$table = "journal_main";
			$fields = "status, manToken";
			$condition = "id = $jid AND submitter = '$userEmail'";
			$isValid = $Super_Class->Super_Get($fields, $table, $condition, "manToken");
			if($isValid === false)
			{
				$errorMessage =  "Failed to verify the user uploading action. Please contact support ";
			}
			else if(is_array($isValid) === false)
			{
				$errorMessage = "The verification of the user is not of recognzied type";
			}
			else if(count($isValid) !== 1)
			{
				$errorMessage = "The manuscript you are trying to remove a file from doenst exist. Please contact support";
			}
			else if($isValid[0]["status"] !== "submitted")
			{
				$errorMessage = "You cannot remove files from this manuscript. Contact support if necessary";
			}
			else if(Validate_int($figId) === false)
				$errorMessage = "The figure contains invalid data";
			else
			{
				$figId = Validate_int($figId);
				$table = "journal_figures";
				$fields = "status = 'deleted'";
				$condition = "id = $figId";
				$isDeleted = $Super_Class->Super_Update($table, $fields, $condition);
				if($isDeleted === true)
				{
					$isSuccess = true;
					$successMessage = "success";
					
				}
				else
					$errorMessage = "Failed to delete the file. Please contact support";
			}
		}
	}
	else
		$errorMessage = "submition type is altered. Please try again";
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"isSuccess" => $isSuccess,
		"successMessage" => $successMessage,
//		"data" => $_FILES
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