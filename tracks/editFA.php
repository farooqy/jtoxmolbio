<?php session_start();
$root = $_SERVER['DOCUMENT_ROOT']."/";
$url = "http://jtoxmolbio/";
if(isset($_GET["target"]) && isset($_GET["pos"]) && isset($_GET["type"]))
{
	require_once($root."classes/functions.php");
	require_once($root."classes/SuperClass.php");
	$Super_Class = new Super_Class();
	
	$target = Validate_Int($_GET["pos"]);
	$token = Sanitize_String($_GET["target"]);
	$type = Validate_Int($_GET["type"]);
	if($target === false)
	{
		$errorMessage = "The target is invalid";
	}
	else if(empty($token))
	{
		$errorMessage = "The target token is empty";
	}
	else if($type === false )
	{
		$errorMessage = "Invalid type given";
	}
	else if($type !== 0 && $type !== 1)
	{
		$errorMessage = "Invalid type value given";
	}
	else
	{
		$table = "journal_main";
		$fields = "c_author";
		$condition ="manToken = '$token' AND id = $target AND status = 'submitted'";
		$targetData = $Super_Class->Super_Get($fields, $table, $condition, "title");
		if($targetData === false)
		{
			$errorMessage = "Failed to get the manuscript paper you are trying to edit";
			unset($targetData);
		}
		else if(is_array($targetData) === false)
		{
			$errorMessage = "The type of the paper you are trying to edit is not recognized";
			unset($targetData);
		}
		else if(count($targetData) === 1)
		{
			if($type === 0)
			{
				$table = "journal_figures";
				$fields = "*";
				$condition ="journal_id = $target AND status = 'online'";
				$faType = "figures";
			}
			else
			{
				$table = "journal_authors";
				$fields = "*";
				$condition ="journal_id = $target AND a_status = 'active'";
				$faType = "authors";
			}
			
			$faData = $Super_Class->Super_Get($fields, $table, $condition,"id");
			if($faData === false)
			{
				$errorMessage = "Failed to get the $faType of the manuscript";
				unset($faData);
			}
			else if(is_array($faData) === false)
			{
				$errorMessage = "The $faType of the manuscript is not valid";
				unset($faData);
			}
			else if(count($faData) <= 0)
			{
				$errorMessage = "The $faType of the manuscript is empty";
				unset($faData);
			}
		}
		else
			$errorMessage = "The paper you are trying to edit doesnt exist or cannot be edited";
			
		
		
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
		else if(isset($faData))
		{
			if($faType === "figures")
			{
				foreach($faData as $faKey=> $fa)
				{
					$figure = $fa['figure_url'];
					$figId = $fa["id"];
					$ftype = $fa["type"];
					$jid = $fa["journal_id"];
					?>
				<div class="row figRow">
					<img src="<?php echo $figure ?>" class="thumbnail"/>
					<span><?php echo $ftype ?></span>
					<button class="btn btn-danger removeFigure" target="<?php echo $figId.'|'.$target.'|'.$jid ?>">Remove</button>
				</div>
				
					<?php
				}
				?>
				<div class="row">
					<div class="col-md-3 col-lg-3 col-xs-12 col-sm-12">
						<button class="btn btn-success btn-addFile">
						<span class="glyphicon glyphicon-picture"></span>
						Upload New Photo</button>
					</div>
					<div class="col-md-9 col-lg-9 col-xs-0 col-sm-0"></div>
				</div>	
				<div class="row">
					<form class="uploadFormMan" enctype="multipart/form-data">
						<input type="hidden" class="hidden triggerFileOpen" name="target" value="<?php echo $token.'|'.$target ?>">
						<input type="file" class="hidden triggerFileOpen" name="FileType">
						<input type="hidden" value="hiddenMe" name="textHidden" class="targetFileName">
					</form>
				</div>
				<?php
			}
			else if($faType === "authors")
			{
				foreach($faData as $faKey=> $fa)
				{
					$atoken = $fa["a_token"];
					$a_fname = $fa["a_title"]." ".$fa["a_firstName"]." ".$fa["a_secondName"];
					$a_inst = $fa["a_institution"];
					$a_loc = $fa["a_location"];
					$a_email =$fa["a_email"];
					$jid = $fa["journal_id"];
					
					?>
				<div class="row authorRow">
					<div class="col-md-4 col-lg-4 col-sm-3 col-xs-3">
						<img src="<?php echo $url.'uploads/sitefiles/icons/male.png' ?>" class="thumbnail a-icon" />
					</div>
					<div class="col-md-7 col-lg-7 col-sm-8 col-xs-8">
						<div class="row a_name">
							<?php echo $a_fname ;
						if($targetData[0]["c_author"] === $a_email)
						{
							?>
							<span class="glyphicon glyphicon-saved cauthor-cion"></span>
							<?php
						}
							?>
						</div>
						<div class="row">
							<span class="glyphicon glyphicon-hourglass">
								<?php echo $a_inst ?>
							</span>
						</div>
						<div class="row">
							<span class="glyphicon glyphicon-map-marker">
								<?php echo $a_loc ?>
							</span>
						</div>
						<div class="row">
							<button class="btn btn-danger btn-dauthor" target="<?php echo $atoken.'|'.$jid ?>">
							<span class="glyphicon glyphicon-remove"></span>
								Remove
							</button>
							<?php
							if($targetData[0]["c_author"] !== $a_email)
							{
								?>
								<button class="btn btn-success btn-mkcauthor" target="<?php echo $atoken.'|'.$jid ?>">
									Set as Corresponding author
								</button>
								<?php
							}
							?>
						</div>
						
					</div>
						
					
					
				</div>
					<?php
				}
				?>
				
				<div class="authorInfoBoxDiv row" >
			  		<form class="authorInfoBox" method="post" id="newAuthorForm">
			  			<select class="select" name="authorTitle">
						<option value="dft">
							Select author title
						</option>
						<option value="Mr">
							Mr
						</option>
						<option value="Mrs">
							Mrs
						</option>
						<option value="Ms">
							Ms
						</option>
						<option value="Prof">
							Prof
						</option>
						<option value="Dr">
							Dr.
						</option>
					 </select>
					 
					<input type="hidden" name="atoken" class="atoken" value="<?php echo $atoken ?>">
					<input type="hidden" name="jid" class="jid" value="<?php echo $jid ?>">
					<label for="authorFirstName">Author first name<span class="superScriptStar">*</span></label>
					<input name="authorFirstName" type="text" placeholder="Author first name">
					<label for="authorLastName">Author last name<span class="superScriptStar">*</span></label>
					<input name="authorLastName" type="text" placeholder="Author last name">
					<label for="authorEmail">Author Email<span class="superScriptStar">*</span></label>
					<input name="authorEmail" type="text" placeholder="Author Email">
					<label for="authorInstitution">Author institution<span class="superScriptStar">*</span></label>
					<input name="authorInstitution" type="text" placeholder="Author institution">
					<label for="authorLocation">Author Location<span class="superScriptStar">*</span></label>
					<input name="authorLocation" type="text" placeholder="Enter Author country">
				 	<input type="submit" value="Add Author" name="" class="btn btn-success glyphicon glyphicon-save"/>
			  		</form>
				  	
				  </div>
				  <div class="row">
					<div class="col-md-3 col-lg-3 col-xs-12 col-sm-12">
						<button class="btn btn-primary toggleAuthorBox"><span class="glyphicon glyphicon-pencil"></span>
				  		New Author
				  	</button>
					</div>
					<div class="col-md-9 col-lg-9 col-xs-0 col-sm-0"></div>
				  	
				  </div>
				
				<?php
			}
//			$manTitle = $targetData[0]["title"];
//			$manAbstract = $targetData[0]["abstract"];
//			$manKeywords = $targetData[0]["keywords"];
//			$editF = $url."tracks/editFA.php?target=$token&pos=$target&type=0";
//			$editA = $url."tracks/editFA.php?target=$token&pos=$target&type=1";
			?>
			<?php
		}
		?>
			
			</div>
			<div class="col-md-3 col-lg-3 col-sm-0 col-xs-0"></div>
		</div>
	<?php require_once($root."includes/footer.html"); ?>
	</div>
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/main.js"></script>
<script src="../jQueryAssets/jquery-1.11.1.min.js"></script>
<script src="../jQueryAssets/jquery.ui-1.10.4.progressbar.min.js"></script>
<style>
	@import url("../css/footer.css");
	@import url("../css/font-awesome.min.css");
	@import url("../css/main.css");
	@import url("../css/768.css");
</style>
</body>
</html>