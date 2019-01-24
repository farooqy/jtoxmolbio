<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$config = require_once($root."config/config.php");
$url = $config["URL"];

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
	else if($_stage < 2)
	{
		$errorMessage = "Please complete the manuscript and the author informaton stage first";
	}
	else if(isset($_SESSION["ManInfo"]["man_authors"]) === false )
		$errorMessage = "The manuscript authors have  not been initiated";
	else if(is_array($_SESSION["ManInfo"]["man_authors"]) === false || is_array($_existingAuthors) === false)
		$errorMessage = "The manuscript authors is initiated to invalid type. Please contact admin";
	else if(isset($_POST["submitType"]) && $_POST["submitType"] === "fileLevelAlter" && isset($_POST["target"]))
	{
		$target = $_POST["target"];
		$allowedTargets = array("manuscript", "cover", "figures", "others");
		$_existingFiles = $_SESSION["ManInfo"]["ManDocument"];
		if(in_array($target, $allowedTargets) === false)
		{
			$errorMessage = "The type of file you are trying to remove is not valid or existing type";
		}
		else if(isset($_existingFiles[$target]))
		{
			$targetFiles = $_existingFiles[$target];
			$fileData = explode("|",$_POST["data"]);
			if(is_array($fileData) === false)
				$errorMessage = "The file sent to remove is not valid";
			else if(count($fileData) !== 2)
				$errorMessage = "The file data sent contains more/less of required data. probably alteration. Please contact admin";
			else
			{
				$fileToken = $fileData[1];
				$fileName = $fileData[0];
				if($target === "manuscript" || $target === "cover")
				{
					
					if($fileToken !== $targetFiles["fileToken"] || $fileName !== $targetFiles["name"])
					{
						$errorMessage = "The file you are trying to remove has invalid data. Please contact admin if error persist";
					}
					else
					{
						if(file_exists($targetFiles["dir"]) === false)
							$errorMessage = "The file you are trying to remove is not an existing file or has been already altered. Please contact admin if error persist";
						else
						{
							unlink($targetFiles["dir"]);
							unset($_SESSION["ManInfo"]["ManDocument"][$target]);
							$isSuccess = true;
							$successMessage = "success";
							if($_stage > 2 )
								$_SESSION["ManInfo"]["man_stage"] = 2;
						}
							
							
					}
				}
				else
				{
					$isRemoved = false;
					foreach($targetFiles as $fkey => $ftarget)
					{
						if($fileToken === $ftarget["fileToken"] && $fileName === $ftarget["name"])
						{
							if(file_exists($ftarget["dir"]) === false)
							{
								$errorMessage = "The file has already been deleted. If error persist please contact admin";
								break;
							}	
							else
							{
								unlink($ftarget["dir"]);
								unset($_SESSION["ManInfo"]["ManDocument"][$target][$fkey]);
								$_SESSION["ManInfo"]["ManDocument"][$target] = array_values($_SESSION["ManInfo"]["ManDocument"][$target]);
								$isSuccess = true;
								$successMessage = "success";
								if($_stage > 2 && $target === "figures")
									$_SESSION["ManInfo"]["man_stage"] = 2;
								$isRemoved = true;
								break;
							}
							
						}
					}
					if($isRemoved === false)
					{
						$errorMessage = "The file you are trying to remove is not an existing file or has been already altered. Please contact admin if error persist ";
					}
				}
			}
		}
		else
		{
			$errorMessage = "The file you are trying to remove has not been uploaded yet.";
		}
		   
	}
	else
		$errorMessage = "submition type is altered. Please try again";
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"isSuccess" => $isSuccess,
		"successMessage" => $successMessage,
		"target" => $target
//		"author" => $_SESSION["ManInfo"]["man_authors"],
//		"target" => $authorIndex
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