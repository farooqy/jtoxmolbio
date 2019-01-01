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
	else if(isset($_POST["submitType"]) && $_POST["submitType"] === "newAuthor" && isset($_POST["atoken"]) && isset($_POST["jid"]))
	{
		
		$jid = $_POST["jid"]; 
		$authorFields = array(
			"authorTitle","authorFirstName", "authorLastName", 
			"authorInstitution", "authorEmail", "authorLocation"
		);
		$fieldNames = array(
			"Author title", "author first name", "author last name",
			"author institution", "author email", "author location"
		);
		
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
			else if($fieldKey === 4 )
			{
				$value = Validate_Email($value);
				$table = "journal_authors";
				$fields = "id";
				$condition = "a_email = '$value' AND a_status = 'active' AND journal_id = $jid";
				$isAuthor = $Super_Class->Super_Get($fields, $table, $condition, $fields);
				if($isAuthor === false)
				{
					$errorMessage ="Failed to validate your author. Please contact support";
					break;
				}
				else if(is_array($isAuthor) === false)
				{
					$errorMessage = "The author retrieved type is not valid";
					break;
				}
				else if(count($isAuthor) >= 1)
				{
					$errorMessage = "The author already exist and is active";
					break;
				}
				else
				{
					$singleAuthor[$fieldValue] = $value;
				}
				
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
			
			$authorToken = Get_Hash(time());
			$a_title = $singleAuthor["authorTitle"];
			$a_fname = $singleAuthor["authorFirstName"];
			$a_sname = $singleAuthor["authorLastName"];
			$a_loc = $singleAuthor["authorLocation"];
			$a_inst=$singleAuthor["authorInstitution"];
			$a_email = $singleAuthor["authorEmail"];
			$table = "journal_authors";
			$fields = "journal_id, a_token, a_email , a_title, a_firstName, a_secondName, a_institution, a_location, a_status";
			$values = "$jid, '$authorToken', '$a_email', '$a_title', '$a_fname', '$a_sname', '$a_inst',
			'$a_loc', 'active'";
			$isSaved = $Super_Class->Super_Insert($table, $fields, $values);
			if($isSaved === false)
			{
				$errorMessage = "Failed to save the author. Please contact support";
				
			}
			else
			{
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
		"author" => $singleAuthor,
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