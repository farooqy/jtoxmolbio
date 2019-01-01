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
	else if(isset($_POST["submitType"]) && $_POST["submitType"] === "uploadFile" && isset($_FILES["FileType"]) && isset($_POST["textHidden"]) && isset($_POST["target"]))
	{
		$target = explode("|",Sanitize_String($_POST["target"]));
		if(is_array($target) === false)
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
		else
		{
			$jid = $target[1];
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
				$errorMessage = "The manuscript you are trying to add a file to doenst exist. Please contact support";
			}
			else if($isValid[0]["status"] !== "submitted")
			{
				$errorMessage = "You cannot add files to this manuscript. Contact support if necessary";
			}
			else
			{
				require_once($root."classes/uploader.php");
				
				$_uploadFile = array(
					"f_name" => $_FILES["FileType"]["name"],
					"f_type" => $_FILES["FileType"]["type"],
					"f_size" => $_FILES["FileType"]["size"],
					"f_temp" => $_FILES["FileType"]["tmp_name"],
				);
				$Uploader = new Uploader($_uploadFile);
				$_formats = array("image/jpg", "image/png",
										"image/jpeg");
				$Uploader->_set_format($_formats);
				$isValid = $Uploader->check_validity();
				if($isValid === false)
					$errorMessage = $Uploader->Get_Message();
				else
				{

					$userRootDir = $root."uploads/users/$userToken/";
					if(is_dir($userRootDir) === false)
					{
						if(mkdir($userRootDir, "0755", false) === false)
							$errorMessage = "Failed to initiate your upload folder. Please contact admin";
					}

				}
				if(empty($errorMessage) && $errorMessage === null)
				{
					$Uploader->_set_upload_dir($userRootDir);
					$Uploader->_set_url_path( $url."uploads/users/$userToken/");
					$isUploaded = $Uploader->upload();
					if($isUploaded === false)
					{
						$errorMessage = $Uploader->Get_Message();
						$Uploader->_unlink_files();
					}
					else
					{
						$fileUrl = $Uploader->get_file_url();
						$furl = $fileUrl["url"];
						$fileToken = Get_Hash(time());
						$table = "journal_figures";
						$fields = "journal_id, 	figure_url, type, status";
						$values = "$jid, '$furl', 'figure', 'online'";
						
						$isSaved = $Super_Class->Super_Insert($table, $fields, $values);
						if($isSaved === false)
						{
							$errorMessage = "Failed to save the image ";
						}
						else
						{
							$isSuccess = true;
							$successMessage = "success";
						}
						
							
					}
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