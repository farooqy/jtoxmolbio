<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$url = "http://jtoxmolbio/";
if(isset($_SESSION["isLoggedIn"]) && isset($_SESSION["email"]) && isset($_SESSION["veriftoken"]))
{
	$userEmail = $_SESSION["email"];
	$userToken = $_SESSION["veriftoken"];
	if(empty($userEmail) || empty($userToken))
	{
		header("Location: $url.'login?redirect=tracks&extra=biased'");
		exit(0);
	}
	else if(isset($_GET["sb"]) && isset($_GET["token"]))
	{
		$sb = $_GET["sb"];
		$token = $_GET["token"];
		if(empty($sb) || empty($token))
		{
			$errorTrigger = "empty parameters. cannot verify anything";
		}
		else if($sb !== "success")
		{
			$errorTrigger = "The submition is not valid. Please contact admin if error persist";
		}
		else
		{
			require_once($root."classes/SuperClass.php");
			$Super_Class = new Super_Class();
			$table = "journal_main";
			$fields = "*";
			$condition = "manToken = '$token'";
			$Manuscript = $Super_Class->Super_Get($fields, $table, $condition, "id");
			if($Manuscript === false)
			{
				$errorTrigger = "Failed to get the given manuscript. Please contact support for assistance";
				$Manuscript = null;
				unset($Manuscript);
			}
			else if(is_array($Manuscript) === false)
			{
				$errorTrigger = "The returned manuscript type is not recognized. Please contact support for assistance";
				$Manuscript = null;
				unset($Manuscript);
			}
			else if(count($Manuscript) <= 0)
			{	
				$errorTrigger = "The manuscript you are searching for doesn't exist. Please ensure you have submitted it.";
				$Manuscript = null;
				unset($Manuscript);
			}
			else if(count($Manuscript) > 1) 
			{
				$errorTrigger = "The manuscript you are searching contaiins a collision data. Please contact admin for assistance";
				$Manuscript = null;
				unset($Manuscript);
			}
			else
			{
				$manNum = $Manuscript[0]["man_num"];
				$manid = $Manuscript[0]["id"];
				$table ="published_journals";
				$fields = "j_time, j_url";
				$condition = "j_id = $manid AND j_man_num = '$manNum'";
				$publishData = $Super_Class->Super_Get($fields, $table, $condition, "id");
				if($publishData === false)
				{
					$errorTrigger = "Failed to get the publish details for the manuscript. Please contact admin";
					$Manuscript = null;
					unset($Manuscript);
				}
				else if(is_array($publishData) === false)
				{
					$errorTrigger = "The manuscript published type is not valid. Please contact admin";
					$Manuscript = null;
					unset($Manuscript);
				}
				else if(count($publishData) <= 0)
				{
					$errorTrigger = "The manuscript published doesn't exist. Please ensure your manuscript is published";
					$Manuscript = null;
					unset($Manuscript);
				}
				else
				{
					$Manuscript[0]["manuscript_url"] = $publishData[0]["j_url"];
					$Manuscript[0]["time"] = $publishData[0]["j_time"];
				}
				
			}
		}
	}
	else
	{
		echo "Someting else";
	}
}
else
{
	header("Location: $url.'login?redirect=tracks'");
	exit(0);
}
$trackPage = true;
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
<title>Journal Of Toxicology and Molecular Biology</title>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div class="container">
 	<div class="row nav-margin">
   	<?php require_once($root."includes/nav.php"); ?>
    </div>
    <?php
	if(isset($errorTrigger))
	{
		?>
	<div class="row errorDiv" style="display: block">
		<div class="col-md-3 col-lg-3 col-md-1 col-sm-1 ">
		</div>
		<div class="col-md-6 col-lg-6 col-md-10 col-sm-10 ">
			<div class="row">
				<?php
		echo $errorTrigger;
				?>
			</div>
		</div>
		<div class="col-md-3 col-lg-3 col-md-1 col-sm-1 ">
		</div>
	</div>
	<?php
	}
	else if(isset($Manuscript))
	{
//		print_r($Manuscript);
		?>
	<div class="row manuscriptDiv">
		<div class="col-md-2 col-lg-2 col-sm-0 col-xs-0">
		</div>
		<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12 manuscriptDetails">
			<div class="row manTitle">
				<h2><b>
					<u><?php echo $Manuscript[0]["title"] ?></u>
				</b></h2>
			</div>
			<div class="row">
				<span class="glyphicon glyphicon-calendar" ></span>
				<?php echo gmdate("Y-m-d", $Manuscript[0]["time"]); ?>
			</div>
			<div class="row">
				<h4><b><u>Abstract</u></b></h4>
			</div>
			<div class="row">
				<?php echo $Manuscript[0]["abstract"] ?>
			</div>
			<div class="row mancover">
				<block>
					
					<a href="<?php echo $Manuscript[0]["manuscript_url"] ?>" class="manurl">
						<span class="glyphicon glyphicon-file"></span>
						View Manuscript
					</a>
				</block>
				<block>
					
					
					<a href="<?php echo $Manuscript[0]["cover_url"] ?>"  class="coverurl">
						<span class="glyphicon glyphicon-file"></span>
						View Cover
					</a>
				</block>
				<block>
					<span class="glyphicon glyphicon-stats">
						<?php echo $Manuscript[0]["status"]?>
					</span>
						
				</block>
				<?php
				if($Manuscript[0]["status"] === "submitted")
				{
					?>
				<block >
					<?php
					$token = $Manuscript[0]["manToken"];
					$manid = $Manuscript[0]["id"];
					?>
					<a href="<?php echo $url.'tracks/edit?target='.$token.'pos='.$manid ?>"  class="editUrl">
						<span class="glyphicon glyphicon-edit"></span>
						Edit paper
					</a>
						
				</block>
				<?php 
				}
				?>
				
					
			</div>
			<div class="row">
				
			</div>
		</div>
		<div class="col-md-2 col-lg-2 col-sm-0 col-xs-0">
		</div>
	</div>
	<?php
	}
	?>
	<div class="row">
   		
    </div>
    <?php require_once($root."includes/footer.html"); ?>
</div>
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