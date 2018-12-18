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
	$ManInfo = $_SESSION["ManInfo"];
	if(isset($_SESSION["ManInfo"]["ManDocument"]))
		$uploadFiles = $_SESSION["ManInfo"]["ManDocument"];
	else
		$uploadFiles = array();
	if(empty($userToken))
		$errorMessage = "Incomplete data token to verify account";
	else if(empty($userEmail))
		$errorMessage = "Incomplete data to verify account";
	else if(isset($_SESSION["ManInfo"]["corresPondingAuthor"]) === false)
		$errorMessage = "Please provide a corresponding author among the authors ";
	else if(isset($uploadFiles["manuscript"]) === false )
		$errorMessage = "Please upload manuscript";
	else if(isset($uploadFiles["cover"]) === false )
		$errorMessage = "Please upload cover";
	else if(isset($uploadFiles["figures"]) === false )
		$errorMessage = "Please upload at least one figure";
	else if(is_array($uploadFiles["figures"]) === false)
		$errorMessage = "The figures are not set. Please contact admin";
	else if(count($uploadFiles["figures"]) <= 0)
		$errorMessage = "Please upload at least one figure to continue";
	else if($_stage !== 3)
	{
		$errorMessage = "Please complete the Upload Files stage first";
	}
	else if(isset($_SESSION["ManInfo"]["man_authors"]) === false )
		$errorMessage = "The manuscript authors have  not been initiated";
	else if(is_array($_SESSION["ManInfo"]["man_authors"]) === false || is_array($_existingAuthors) === false)
		$errorMessage = "The manuscript authors is initiated to invalid type. Please contact admin";
	else if(isset($_POST["submitType"]) && $_POST["submitType"] === "finalSubmition" )
	{
		$firstStage = array("man_type", "man_title", "man_abstract", "man_keywords");
		$uploadStage = array("manuscript", "cover", "figures", "others");
		foreach($firstStage as $key => $manData)
		{
			if(empty($ManInfo[$manData]) || $ManInfo[$manData] === "dft")
			{
				$errorMessage = "The manuscript information stage is not complete. Please recheck you have all the required information filled";
				break;
			}
		}
		if(empty($errorMessage) && $errorMessage === null)
		{
			foreach($uploadStage as $stageKey => $stageValue)
			{
				if(isset($uploadFiles[$stageValue]))
				{
					if(isset($uploadFiles[$stageValue][0]) && $stageKey >= 2)
					{
						$figOtherFiles = $uploadFiles[$stageValue];
						foreach($figOtherFiles as $figKey => $figData)
						{
							if(isset($figData["dir"]) === false)
							{
								$errorMessage = "The $stageValue directory doesn't exist. Please ensure you have uploaded first.";
								break 2;
							}
							else if(file_exists($figData["dir"]) === false)
							{
								$errorMessage = "The $stageValue doesn't exist in the site. Please ensure you have uploaded it";
								break 2;
							}
							else
								continue;
						}
					}
					else if(isset($uploadFiles[$stageValue]["dir"]))
					{
						if(file_exists($uploadFiles[$stageValue]["dir"]) === false)
						{
							$errorMessage = "The $stageValue was not uploaded. Its directory doesn't exist please ensure you have uploaded it";
							break;
						}
					}
					else if($stageKey !== 3)
					{
						$errorMessage = "The $stageValue directory doesn't exist. Please ensure you have uploaded the file";
						break;
					}
					else
					{
						$errorMessage = "Uncaught error for validating existance of $stageValue . Please contact admin for assistance if error persist.";
						break;
					}
				}
				else if($stageKey !== 3)
				{
					$errorMessage = "Please upload $stageValue to continue";
					break;
				}
			}
		}
		if(empty($errorMessage) && $errorMessage === null)
		{
			require_once($root."classes/SuperClass.php");
			$Super_Class = new Super_Class();
			//get the man and generate new man number
			$time = time();
			$year = date('y', strtotime(gmdate('Y-m-d', $time)));
			$month = date('m', strtotime(gmdate('Y-m-d', $time)));
			$day = date('d', strtotime(gmdate('Y-m-d', $time)));
			$table = "ma_numbers";
			$fields = "count(*) as numMans";
			$condition = "month = $month AND year = $year";
//			$isSuccess = true;
//			$successMessage = "success";
			$manCount = $Super_Class->Super_Get($fields, $table, $condition, "numMans");
			$manNumber=  null;
			if($manCount === false)
				$errorMessage = "Failed to get manuscript numbers. Please contact admin";
			else if(is_array($manCount) === false)
				$errorMessage = "The manuscript count returned uknown record type. Please contact admin";
			else if(count($manCount) <= 0)
				$errorMessage = "The manuscript returned no record to generate number";
			else
			{
				$currentNum = $manCount[0]["numMans"];
				if($currentNum <=9)
					$manNumber = "JTMB".$month.$year."-00".($currentNum+1);
				else if($currentNum <= 99)
					$manNumber = "JTMB".$month.$year."0-".($currentNum+1);
				else 
					$manNumber = "JTMB".$month.$year."-".($currentNum+1);
				
				$manType = $_SESSION["ManInfo"]["man_type"];
				$manTitle = $_SESSION["ManInfo"]["man_title"];
				$manAbstract = $_SESSION["ManInfo"]["man_abstract"];
				$manKeywords = $_SESSION["ManInfo"]["man_keywords"];
				$manToken = $_SESSION["ManInfo"]["man_token"];
				$submitter = $userEmail;
				$manCAuthor = $_SESSION["ManInfo"]["corresPondingAuthor"];
				$manCoverUrl = $uploadFiles["cover"]["url"];
				$manManUrl = $uploadFiles["manuscript"]["url"];
				$status = "submitted";
				$views = 0;
				
				$table = "journal_main";
				$fields = "man_num, j_type, title,manToken, abstract, 
				keywords, submitter,c_author, cover_url,manuscript_url,
				status, views, time";
				$values = "'$manNumber', '$manType', '$manTitle', '$manToken', '$manAbstract', '$manKeywords','$submitter', '$manCAuthor', '$manCoverUrl', '$manManUrl', '$status', '$views', $time";
				
				$isSaved = $Super_Class->Super_Insert($table, $fields, $values);
				if($isSaved === false)
					$errorMessage = "Failed to save the manuscript. Please contact admin for support";
				else
				{
					$fields = "id";
					$condition = "man_num = '$manNumber' AND submitter = '$submitter'";
					$manId = $Super_Class->Super_Get($fields, $table, $condition, $fields);
					if($manId === false)
						$errorMessage = "Failed to retrieve inserted manuscript. Please contact admin";
					else if(is_array($manId) === false)
						$errorMessage = "The retrieved manuscript contains invalid record type. Please contact admin";
					else if(count($manId) <= 0)
						$errorMessage = "The manuscript inserted could not be retrieved as it doesn't exist. Please contact admin for support";
					else
					{
						$manuscriptID = $manId[0]["id"];
						$_existingAuthors = $_SESSION["ManInfo"]["man_authors"];
						foreach($_existingAuthors as $akey => $aData)
						{
							$authorTitle = $aData["authorTitle"];
							$authorFName = $aData["authorFirstName"];
							$authorSName = $aData["authorLastName"];
							$authorLocation = $aData["authorLocation"];
							$authorInstitute = $aData["authorInstitution"];
							$authorEmail = $aData["authorEmail"];
							$authorToken = $aData["authorToken"];
							
							$table = "journal_authors";
							$fields = "journal_id, a_token, a_email, a_firstName, a_secondName, a_institution, a_location, a_title, a_status";
							$values = "$manuscriptID,'$authorToken', '$authorEmail', '$authorFName', '$authorSName', '$authorInstitute', '$authorLocation', '$authorTitle', 'active'";
							$isSaved = $Super_Class->Super_Insert($table, $fields, $values);
							if($isSaved === false)
								$errorMessage = "Failed to save the authors for the manuscript. Please contacta admin";
						}
						if(empty($errorMessage) && $errorMessage === null)
						{
							$figures = $uploadFiles["figures"];
							foreach($figures as $fKey => $fData)
							{
								$furl = $fData["url"];
								$table = "journal_figures";
								$fields = "journal_id, figure_url, type, status";
								$values = "$manuscriptID,'$furl', 'figure', 'online'";
								$isSaved = $Super_Class->Super_Insert($table, $fields, $values);
								if($isSaved === false)
								{
									$errorMessage = "Failed to save the manuscript figures. Please contact admin";
								}

							}
							if(isset($uploadFiles["others"]) && empty($errorMessage) && $errorMessage === null)
							{
								$others = $uploadFiles["others"];
								foreach($others as $oKey => $oData)
								{
									$furl = $oData["url"];
									$table = "journal_figures";
									$fields = "journal_id, figure_url, type, status";
									$values = "$manuscriptID,'$furl', 'other', 'online'";
									$isSaved = $Super_Class->Super_Insert($table, $fields, $values);
									if($isSaved === false)
									{
										$errorMessage = "Failed to save the manuscript other files. Please contact admin";
									}

								}
							}
						}
					}
						
				}
			}
		}
		
		if(empty($errorMessage) && $errorMessage === null)
		{
			$isSuccess = true;
			$successMessage = "success";
		}
	}
	else
		$errorMessage = "submition type is altered. Please try again";
	echo json_encode(array(
		"errorMessage" => $errorMessage,
		"isSuccess" => $isSuccess,
		"successMessage" => $successMessage,
		"mantoken" => $manToken,
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