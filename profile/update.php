<?php session_start();
$root = $_SERVER['DOCUMENT_ROOT']."/";
$url = "http://jtoxmolbio";
require_once($root."classes/functions.php");

if(isset($_SESSION["isLoggedIn"]) && isset($_POST["target"]))
{
	$errorMessage = null;
	$successMessage = null;
	$isSuccess = false;
	$userToken = $_SESSION["veriftoken"];
	$userEmail = $_SESSION["email"];
	$data = null;
	$updateFields = array(
		"userTitle", "userFirstName", "userLastName", "userEmailAddress",
		"userPassword", "userInstitute", "userDepartment","userCountry"
	);
	$tableFields = array(
		"salutation", "firstName", "secondName", "email",
		"password", "Institution","Department", "country"
	);
	$target = Sanitize_String($_POST["target"]);
	$updateIndex = array_search($target, $updateFields);
	$fieldUpdate = $tableFields[$updateIndex];
//	print_r($_SESSION);
	if(empty($userToken))
	{
		$errorMessage = "Invalid user credential token Please log out and login back";
	}
	else if(empty($userEmail))
	{
		$errorMessage = "Invalid user credential email. Please log out and login back";
	}
	else 
	{
		require_once($root."classes/SuperClass.php");
		$Super_Class = new Super_Class();
		$time60days = time() - (60*24*24*60);//last 60 days
		$table = "allow_changes";
		$fields = "*";
		$condition = "column_name = '$fieldUpdate' AND email = '$userEmail' AND time > $time60days ";
		$previousChanges = $Super_Class->Super_Get($fields, $table, $condition, "id");
		if($previousChanges === false)
			$errorMessage = "failed to verify changes. ".$Super_Class->Get_Message();
		else if(is_array($previousChanges) === false)
			$errorMessage = "Changes data record is not recognized. Please contact admin";
		else if(count($previousChanges) >=  1 && $fieldUpdate !== "password")
		{
			$errorMessage = "You have made changes to this field within the last 60 days. You cannot update right now";
		}
		else
		{
			$value = $_POST["value"];
			if(isset($_POST["value_extra"]))
				$value_extra = $_POST["value_extra"];
			else
				$value_extra = null;
			$table = "users";
			$fields = "*";
			$condition = "email = '$userEmail' AND veriftoken = '$userToken'" ;
			$isValid = $Super_Class->Super_Get($fields, $table, $condition, "id LIMIT 1");

			if($isValid === false)
				$errorMessage = $Super_Class->Get_Message();
			else if(is_array($isValid) === false)
				$errorMessage = "user verification data is not recognized. Please contact admin";
			else if(count($isValid) !== 1)
				$errorMessage = "user credentials are not authentic. Please contact admin";
			if(in_array($target, $updateFields) === false)
			{
				$errorMessage = "The given field cannot be updated. Please contact the adminstator";
			}
			else if($isValid[0][$fieldUpdate] === $value || $isValid[0][$fieldUpdate] === Get_Hash($value_extra))
				$errorMessage = "You have not changed the field value";
			else if(empty($_POST["value"]))
			{
				$errorMessage = "Cannot update field to empty";
			}
			else if($target === "userEmailAddress")
			{
				$value =  Validate_Email($_POST["value"]);
				if($value === false)
					$errorMessage = "The new email address is not valid email. Please provide a valid email";
			}
			else if ($target === "userPassword")
			{
				$value = Get_Hash($value);
				if(empty($value_extra) || $value_extra === null)
				{
					$errorMessage = "Cannot update password to empty";
				}
				else if($isValid[0]["password"] !== $value)
				{
					$errorMessage = "The user credentials doesn't match with the password you have given.";
				}
				else
					$value_extra = Get_Hash($value_extra);

			}
			else
				$value = Sanitize_String($_POST["value"]);
		}
			
	}
	if($errorMessage === null && empty($errorMessage))
	{
		$table = "users";
		$time = time();
		$previousValue = $isValid[0][$fieldUpdate];
		if($target === "userPassword")
		{
			$values = "'$userToken', '$userEmail', '$fieldUpdate',
			'sensitive',$time";
			$fields = "password = '$value_extra'";
		}	
		else
		{
			$values = "'$userToken', '$userEmail', '$fieldUpdate',
			'$previousValue',$time";
			$fields = $fieldUpdate." = '$value'";
		}
		
		$condition = "email = '$userEmail' AND veriftoken = '$userToken'";
		
		$isUpdated = $Super_Class->Super_Update($table, $fields, $condition);
		if($isUpdated === true)
		{
			$table = "allow_changes";
			$fields = "token, email, column_name, changing_value, time";
			
			$isTracked = $Super_Class->Super_Insert($table, $fields, $values);
			$isSuccess = true;
			$successMessage = "success";
		}
		else
		{
			$errorMessage = $Super_Class->Get_Message();
		}
	}
	
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"successMessage" => $successMessage,
		"isSuccess" => $isSuccess,
		"data" => $data
	));
	exit(0);
}
else
{
	echo json_encode(array(
		"errorMessage" => "Missing credentials",
		"isSuccess" => false,
		"successMessage" => null
	));
	exit(0);
}
?>