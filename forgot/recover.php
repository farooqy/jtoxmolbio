<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$config = include($root."config/config.php");
$url = $config["URL"];

require_once($root."classes/functions.php");
if(isset($_SESSION["isLoggeIn"]) === false)
{
	$errorMessage = null;
	$isSuccess = false;
	$successMessage = null;

	if(isset($_POST["recoverPassword"]) && isset($_POST["recoverPasswordRepeat"]) && 
	isset($_POST["ptoken"]) && isset($_POST["ptype"]))
	{
		$p1 = Get_Hash($_POST["recoverPassword"]);
		$p2 = Get_Hash($_POST["recoverPasswordRepeat"]);
		$userEmail = Validate_Email($_POST["ptype"]);
		$recoverToken = Sanitize_String($_POST["ptoken"]);

		if($p1 !== $p2)
		{
			$errorMessage = "passwords do not match";
		}
		else if(strlen($_POST["recoverPassword"]) <= 8)
		{
			$errorMessage ="Please use passwords longer than 8 characters";
		}
		else if($userEmail === false)
		{
			$errorMessage = "The data passed for this recovery is not valid";
		}
		else if(empty($recoverToken))
		{
			$errorMessage = "The data passed on this recovery is not complete";
		}
		else
		{
			require_once($root."classes/SuperClass.php");
			$Super_Class = new Super_Class();
			$table = "recovers";
			$fields = "*";
			$condition = "email = '$userEmail'";
			$RecoverData = $Super_Class->Super_Get($fields, $table, $condition, "time DESC LIMIT 1");
			if($RecoverData === false)
			{
				$errorMessage = "Failed to verify your recovery data. Please contact support";
			}
			else if(is_array($RecoverData) === false)
				$errorMessage = "The verification of recovery data contains unknown data type";
			else if(count($RecoverData) !== 1)
			{
				$errorMessage = "The recovery data seems to not exist. Please request a new recovery token";
			}
			else if($RecoverData[0]["token"] !== $recoverToken)
				$errorMessage = "The recovery token passed is not valid. Please try again with valid token";
			else if($RecoverData[0]["status"] !== "active")
				$errorMessage = "The recovery token has expired. Please request a new recovery token";
			else
			{
				$fields = "status = 'inactive'";
				$condition = "token ='$recoverToken' ";
				$Diactivated = $Super_Class->Super_Update($table, $fields, $condition);
				if($Diactivated === false)
					$errorMessage = "Failed to clean up the recovery data. Please contact support";
				else
				{
					$table = "users";
					$fields = "password = '$p1'";
					$condition = "email = '$userEmail'";
					$isRecoverd = $Super_Class->Super_Update($table, $fields, $condition);
					if($isRecoverd === true)
					{
						$isSuccess = true;
						$successMessage = "success";
					}
					else
					{
						$errorMessage = "Failed to recover your account. Please contact support";
					}
				}
					
			}
		}
	}
	else
		$errorMessage = "You have some unfinished business ";
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"successMessage" => $successMessage,
		"isSuccess" => $isSuccess
	));
	exit(0);
}
else
{
	echo json_encode(array(
		"errorMessage" => "You seem to have the keys to the DEN",
		"isSuccess" => false,
		"successMessage" => null
	));
	exit(0);
}
 
?>