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
	else if(isset($_POST["tvalue"])  && isset($_POST["manData"]) && isset($_POST["target"]))
	{
		$target = explode("|",Sanitize_String($_POST["manData"]));
		$allowedChanges = array("editManTitle", "editManAbstract", "editManKeywords");
		$targetChange = Sanitize_String($_POST["target"]);
		$targetValue = Sanitize_string($_POST["tvalue"]);
		$changeNames = array("Manuscript title", "Manuscript abstract", "Manuscript keywords");
		$changedTables = array("title", "abstract", "keywords");
		$targetIndex = array_search($targetChange, $allowedChanges);
		if($targetIndex === false)
		{
			$errorMessage = "The change you are trying is not valid";
		}
		else if(is_array($target) === false)
		{
			$errorMessage = "The data of the target is not valid";
		}
		else if(count($target) !== 2)
		{
			$errorMessage = "The length of the data is not valid";
		}
		else if(Validate_Int($target[1]) === false)
		{
			$errorMessage =  "The data contains invalid content";
		}
		else if(empty($targetValue))
		{
			$errorMessage = "You cannot change the ".$changeNames[$targetIndex]." to empty value";
		}
		else
		{
			$jid = $target[1];
			$table = "journal_main";
			$fields = "status, manToken";
			$condition = "id = $jid AND submitter = '$userEmail'";
			$isValid = $Super_Class->Super_Get($fields, $table, $condition, "manToken");
			if($isValid === false)
			{
				$errorMessage =  "Failed to verify the user . Please contact support ";
			}
			else if(is_array($isValid) === false)
			{
				$errorMessage = "The verification of the user is not of recognzied type";
			}
			else if(count($isValid) !== 1)
			{
				$errorMessage = "The manuscript you are trying to change doenst exist. Please contact support";
			}
			else if($isValid[0]["status"] !== "submitted")
			{
				$errorMessage = "You cannot change this manuscript. Contact support if necessary";
			}
			else
			{
				$table = "journal_main";
				$fields = "$changedTables[$targetIndex] = '$targetValue'";
				$condition = "id = $jid AND submitter = '$userEmail'";
				$isUpdated = $Super_Class->Super_Update($table, $fields, $condition);
				if($isUpdated === true)
				{
					$isSuccess = true;
					$successMessage = "success";
				}
				else
				{
					$errorMessage = "Failed to update the ".$changeNames[$targetIndex]." Contact support if error persist";
					
				}
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