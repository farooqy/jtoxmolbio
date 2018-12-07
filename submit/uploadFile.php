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
	$_existingAuthors = array_column($_SESSION["ManInfo"]["man_authors"], "authorEmail");
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
	else if(is_array($_SESSION["ManInfo"]["man_authors"]) === false || is_array($_existingAuthors) === false)
		$errorMessage = "The manuscript authors is initiated to invalid type. Please contact admin";
	else if(isset($_POST["submitType"]) && $_POST["submitType"] === "uploadFile")
	{
		$allowedTypes = array("manuscript", "cover", "figures", "others");
		$giveType = Sanitize_String($_POST["textHidden"]);
		if(in_array($giveType, $allowedTypes) === false)
			$errorMessage = "The given type is not valid";
		else
		{
			require_once($root."classes/uploader.php");
			$_uploadFile = array(
				"f_name" => $_FILES["FileType"]["name"],
				"f_type" => $_FILES["FileType"]["type"],
				"f_size" => $_FILES["FileType"]["size"],
				"f_temp" => $_FILES["FileType"]["tmp_name"],
				"f_cate" => $giveType,
			);
			$Uploader = new Uploader($_uploadFile);
			if($giveType === "manuscript" || $giveType === "cover")
				$_formats = array(
					"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
					"application/msword");
			else
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
					if($giveType === "figures" || $giveType === "others")
						$_SESSION["ManInfo"]["ManDocument"][$giveType] = array( 
							array(
								"url" => $fileUrl["url"],
								"type" => $fileUrl["type"],
								"size" => $fileUrl["size"],
								"dir" => $fileUrl["dir"],
								"name" => $_uploadFile["f_name"],
								"cate" => $_uploadFile["f_cate"],
							),
						);
					else
						$_SESSION["ManInfo"]["ManDocument"][$giveType] = array(
							"url" => $fileUrl["url"],
							"type" => $fileUrl["type"],
							"size" => $fileUrl["size"],
							"dir" => $fileUrl["dir"],
							"name" => $_uploadFile["f_name"],
							"cate" => $_uploadFile["f_cate"],
						);
					$isSuccess = true;
					$successMessage = "success";
				}
			}
		}
		$singleAuthor = $_uploadFile;
	}
	else
		$errorMessage = "submition type is altered. Please try again";
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"isSuccess" => $isSuccess,
		"successMessage" => $successMessage,
		"fileDetails" => $singleAuthor,
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