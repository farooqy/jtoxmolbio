<?php session_start();
$root = $_SERVER['DOCUMENT_ROOT']."/";
$url = "http://jtoxmolbio/";
if(isset($_GET["target"]) && isset($_GET["pos"]))
{
	require_once($root."classes/functions.php");
	require_once($root."classes/SuperClass.php");
	$Super_Class = new Super_Class();
	
	$target = Validate_Int($_GET["pos"]);
	$token = Sanitize_String($_GET["target"]);
	
	if($target === false)
	{
		$errorMessage = "The target is invalid";
	}
	else if(empty($token))
	{
		$errorMessage = "The target token is empty";
	}
	else
	{
		$table = "journal_main";
		$fields = "title, abstract, keywords";
		$condition ="manToken = '$token' AND id = $target";
		$targetData = $Super_Class->Super_Get($fields, $table, $condition, "title");
		if($targetData === false)
		{
			$errorMessage = "Failed to get the manuscript paper you are trying to edit";
			unset($targetData);
		}
		else if(is_array($targetData) === false)
		{
			$errorMessage = "Failed to get the manuscript paper you are trying to edit";
			unset($targetData);
		}
		
		
	}
}
else
{
	$errorMessage = "You have not provided any info to edit a paper";
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.progressbar.min.css" rel="stylesheet" type="text/css">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>
	<?php  ?>
</title>
</head>
<body>
	<div class="container">
		<div class="row nav-margin">
		<?php require_once($root."includes/nav.php"); ?>
		</div>
	</div>
	<div class="container ">
		<div class="row">
			<div class="col-md-3 col-lg-3 col-sm-0 col-xs-0"></div>
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 manEditDiv">
				
		<?php
		if(isset($errorMessage))
		{
			?>
				<div class="row displayError">
					<?php echo $errorMessage ?>
				</div>
			<?php
		}
		else if(isset($targetData))
		{
			$manTitle = $targetData[0]["title"];
			$manAbstract = $targetData[0]["abstract"];
			$manKeywords = $targetData[0]["keywords"];
			$editF = $url."tracks/editFA.php?target=$token&pos=$target&type=0";
			$editA = $url."tracks/editFA.php?target=$token&pos=$target&type=1";
			?>
				<div class="row">
					<input type="text" name="manTitle" value="<?php echo $manTitle ?>" class="editManTitle">
					<button class="btn btn-primary editMan" target="manTitile">Change</button>
				</div>
				<div class="row">
					<textarea type="text" name="manAbstract"  class="editManAbstract"><?php echo $manAbstract ?></textarea>
					<button class="btn btn-primary editMan" target="manTitile">Change</button>
				</div>
				<div class="row">
					<input type="text" name="manKeywords" value="<?php echo $manKeywords?>" class="editManKeywords">
					<button class="btn btn-primary editMan" target="manTitile">Change</button>
				</div>
				<div class="row editAuthors">
					<a href="<?php echo $editA ?>">
						<span class="glyphicon glyphicon-edit">Edit Authors</span>
					</a>
				</div>
				<div class="row editFigures">
					<a href="<?php echo $editF ?>">
						<span class="glyphicon glyphicon-camera">Edit Figures</span>
					</a>
				</div>
			<?php
		}
		?>
				
			</div>
			<div class="col-md-3 col-lg-3 col-sm-0 col-xs-0"></div>
		</div>
	</div>
	<?php require_once($root."includes/footer.html"); ?>
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/main.js"></script>
<script src="../jQueryAssets/jquery-1.11.1.min.js"></script>
<script src="../jQueryAssets/jquery.ui-1.10.4.progressbar.min.js"></script>
<style>
	@import url("../css/768.css");
	@import url("../css/footer.css");
	@import url("../css/font-awesome.min.css");
	@import url("../css/main.css");
</style>
</body>
</html>