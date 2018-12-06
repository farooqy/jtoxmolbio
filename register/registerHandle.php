<?php session_start();
$root = $_SERVER['DOCUMENT_ROOT']."/";
$url = "http://jtoxmolbio/";
require_once($root."classes/functions.php");
if(isset($_POST["registerUser"]))
{
	$reqParamNames = array(
		"registerEmailAddress", "registerSalutation",
		"registerFirstName", "registerLastName", "registerPassword",
		"registerPasswordConfirm", "registerInstitution", 
		"registerDepartment", "registerCountry","registerSubscriber"
	);
	$paramNames = array(
		"Email Address", "Salutation", "First name", "Last Name",
		"Password", "Password confirmation", "Institution",
		"Department", "Country","Subscription option"
	);
	$errorMessage = null;
	$isSuccess = false;
	$successMessage = null;
	
	$userData = array();
	foreach($reqParamNames as $keyName =>$reqNames )
	{
		if($keyName === 9 )
		{
			if(isset($_POST[$reqNames]))
			{
				$value = "true";
			}
			else
				$value = "false";
		}	
		else
			$value = $_POST[$reqNames];
		if(empty($value) && $keyName !== 9)
		{
			$errorMessage = "Please enter the ".$paramNames[$keyName];
			break;
		}
		if($keyName === 0)
		{
			$value = Validate_Email($value);
			if($value === false)
			{
				$errorMessage = "Invalid email address ";
				break;
			}
			else
				array_push($userData, $value);
		}
			
		else if($keyName === 5)
		{
			if(strlen($value) <= 8)
			{
				$errorMessage = "The password length must be greater than 8 character";
				break;
			}
			else if($_POST['registerPassword'] !== $value)
			{
				$errorMessage = "The passwords you entered do not match";
				break;
			}
			else
				array_push($userData, Sanitize_String(Get_Hash($value)));
		}	
		
		else
			array_push($userData, Sanitize_String($value));
		
			
	}
	if($errorMessage === null && empty($errorMessage))
	{
		$regTime = time();
		$verifToken = Get_Hash($regTime);
		require_once($root."classes/SuperClass.php");
		$Super_Class = new Super_Class();
		//verify user doesnt exist first
		$table = "users";
		$fields = "id, email";
		$condition = "email = '".$userData[0]."'";
		
		$isExisting = $Super_Class->Super_Get($fields, $table, $condition, "id");
		if($isExisting === false)
			$errorMessage = $Super_Class->Get_Message ();
		else if(is_array($isExisting) === false)
			$errorMessage = "Failed to verify email address, data record type is unrecognized";
		else if(count($isExisting) >= 1)
			$errorMessage = "another user has registered with the email address";
		else
		{
			$fields = "email, salutation, firstName, secondName, password, Institution, Department, country, RegDate, subscriber_status, status, veriftoken";
			$value = "'$userData[0]','$userData[1]','$userData[2]','$userData[3]', '$userData[5]','$userData[6]','$userData[7]','$userData[8]', '$regTime', '$userData[9]','active', '$verifToken'";
			
			$isRegistered = $Super_Class->Super_Insert($table, $fields, $value);
			if($isRegistered === true)
			{
				$successMessage = "success";
				$isSuccess = true;
				$_SESSION["isLoggedIn"] = true;
				$_SESSION["veriftoken"] = $verifToken;
				$_SESSION["email"] = $userData[0];
				$_SESSION["salutation"] = $user[0]["salutation"];
				$_SESSION["firstname"] = $user[0]["firstName"];
				$_SESSION["lastname"] = $user[0]["secondName"];
				$_SESSION["fullname"] = $userData[1]." ".$userData[3];
				$_SESSION["country"] = $userData[8];
				$_SESSION["institute"] = $userData[6];
				$_SESSION["department"] = $userData[7];
			}
			else
				$errorMessage = $Super_Class->Get_Message();
			
		}
		
	}
	
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
		"errorMessage" => "Incomplete content request",
		"successMessage" => null,
		"isSuccess" => false,
		"data" => $_POST
	));
}
?>