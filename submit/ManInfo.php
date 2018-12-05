<?php session_start();
$root = $_SERVER[ "DOCUMENT_ROOT" ] . "/";
$url = "http://jtoxmolbio/";
require_once($root."classes/functions.php");
if(isset($_SESSION["isLoggedIn"]))
{
	$errorMessage = null;
	$isSuccess = false;
	$successMessage = null;
	
	$userToken = $_SESSION["veriftoken"];
	$userEmail = $_SESSION["email"];
	
	if(empty($userToken))
		$errorMessage = "Incomplete data token to verify account";
	else if(empty($userEmail))
		$errorMessage = "Incomplete data to verify account";
	else
	{
		require_once($root."classes/SuperClass.php");
		$Super_Class = new Super_Class();
		
		$ManInfo = array(
			"man_completed" => false,
			"man_token" => Get_Hash(time()),
			"man_number" => '',
			"man_stage" => 0
		);
		
		$table = "users";
		$fields = "*";
		$condition = "email = '$userEmail' AND veriftoken = '$userToken'";
		$isValid = $Super_Class->Super_Get($fields, $table, $condition, "id");
		if($isValid === false)
			$errorMessage = $Super_Class->Get_Message();
		else if(is_array($isValid) === false)
			$errorMessage = "The verification data is not recognzied. Please contact admin";
		else if(count($isValid) !== 1)
			$errorMessage = "The user for the submition is not authentic";
		else
		{
			$man_type = Sanitize_String($_POST["submitionType"]);
			$man_title = Sanitize_String($_POST["paperTitle"]);
			$man_abstract = Sanitize_String($_POST["paperAbstract"]);
			$man_keywords = Sanitize_String($_POST["paperKeywords"]);
			
			$manFieldNames = array(
				"Paper type", "paper title", "paper abstract", "keywords"
			);
			$manFields = array($man_type, $man_title, $man_abstract, $man_keywords);
			$sessionNames = array("man_type", "man_title", "man_abstract", "man_keywords");
			
			foreach($manFields as $manKey => $manValue)
			{
				if(empty($manValue))
				{
					$errorMessage = "The ".$manFieldNames[$manKey]." is empty";
					break;
				}	
				else
				{
					$sessKey = $sessionNames[$manKey];
					$ManInfo[$sessKey] = $manValue;
				}
			}
		}
		if($errorMessage === null &&  empty($errorMessage))
		{
			$ManInfo["man_stage"] = $ManInfo["man_stage"]+1;
			$_SESSION["ManInfo"] = $ManInfo;
			$isSuccess = true;
			$successMessage = "success";
		}	
	}
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"isSuccess" => $isSuccess,
		"successMessage" => $successMessage
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