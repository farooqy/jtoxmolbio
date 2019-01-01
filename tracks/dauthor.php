<?php session_start();
$root = $_SERVER[ "DOCUMENT_ROOT" ] . "/";
$url = "http://jtoxmolbio/";
require_once($root."classes/functions.php");
require_once($root."classes/SuperClass.php");

if(isset($_SESSION["isLoggedIn"]) )
{
	$errorMessage = null;
	$isSuccess = false;
	$successMessage = null;
	$singleAuthor = array();
	$userToken = $_SESSION["veriftoken"];
	$userEmail = $_SESSION["email"];
	$Super_Class = new Super_Class();
	if(empty($userToken))
		$errorMessage = "Incomplete data token to verify account";
	else if(empty($userEmail))
		$errorMessage = "Incomplete data to verify account";
	else if(isset($_POST["submitType"]) && $_POST["submitType"] === "dauthor" && isset($_POST["target"]) )
	{
		
		$target = explode("|",Sanitize_String($_POST["target"])); 
		if(is_array($target) === false)
		{
			$errorMessage = "The data submitted is not recognized";
		}
		else if(count($target) !== 2)
		{
			$errorMessage = "The length of the data is not valid";
		}
		else
		{
			$atoken = $target[0];
			$jid = $target[1];
			$table = array("journal_main, journal_authors");
			$fields= "`journal_main`.`status` , `journal_authors`.id, `journal_authors`.a_email,`journal_main`.c_author";
			$condition = "`journal_main`.`id` = `journal_authors`.`journal_id` AND `journal_authors`.`journal_id` = $jid AND `journal_authors`.`a_token` = '$atoken' AND `journal_authors`.`a_status` = 'active' AND `journal_main`.submitter = '$userEmail'";
			$adetails = $Super_Class->Super_Get($fields, $table, $condition, "`journal_main`.id");
			if($adetails === false)
			{
				$errorMessage = "The verification for the author failed. Please contact support";
			}
			else if(is_array($adetails) === false)
			{
				$errorMessage = "The author verification details are not recognized type Please contact support";
			}
			else if(count($adetails) === 0)
			{
				$errorMessage = "The author you are trying to delete doesnt exist";
			}
			else if($adetails[0]["status"] !== "submitted")
			{
				$errorMessage = "You can only edit author for papers that have been submitted and not yet published";
			}
			else if($adetails[0]["a_email"] === $adetails[0]["c_author"])
			{
				$errorMessage = "you cannot delete the corresponding author. Please assign another author as corresponding author, then delete the author.";
			}
			else if($userToken === $atoken)
			{
				$errorMessage = "You cannot delete the submitter of the manuscript";
			}
			else
			{
				$table = "journal_authors";
				$fields = "a_status = 'deleted'";
				$condition ="a_token = '$atoken' AND journal_id = $jid";
				$isDelted = $Super_Class->Super_Update($table, $fields, $condition);
				if($isDelted === false)
				{
					$errorMessage = "Failed to delete the author. Please Contact support";
				}
				else
				{
					$isSuccess = true;
					$successMessage = "success";
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