<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$config = require_once($root."config/config.php");
$url = $config["URL"];
require_once($root."classes/functions.php");
if(isset($_POST["paper"]) && isset($_POST["type"]))
{
	
	$paper = $_POST["paper"];
	$views = $_POST["type"];
	$paper = filter_var($paper, FILTER_VALIDATE_INT);
	
	if(Validate_Int($paper) && $views === "sweiv"  && isset($_SESSION["viewID"]) && Validate_Int($_SESSION["viewID"]) === $paper)
	{

		require_once($root."classes/SuperClass.php");
		$Super_Class = new Super_Class($root.'errors/');
		$table="journal_main";
		$fields = "views = views +1";
		$condition = "id = $paper";
		$is_viewed = $Super_Class->Super_Update($table, $fields, $condition);
		if($is_viewed === false)
		{
		  echo json_encode(array(false, $Journal->get_message()));
		  exit(0);
		}
		else
		{
//		  	echo json_encode(array(true, "success"));
			$x =  json_encode(
				array(
				"isSuccess"=>true,
				"errorMessage"=>null,
				"successMessage"=>"success",
//				"data"=>$Data
				)
			);
			echo $x;
		  exit(0);
		}
	}
	else
	{
//		echo json_encode(array(false, "INVALID DATA", $_SESSION["viewID"]));
		exit(0);
	}
}
else
{
	echo json_encode(array(false, "INVALID REQUEST"));
	exit(0);
}
?>
