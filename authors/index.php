<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$url = "http://jtoxmolbio/";

$authorPage = true;
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
 	<div class="row">
   	<?php require_once($root."includes/nav.php"); ?>
    </div>
    
	<div class="row authorsPageBox">
   		<div class="col-md-3 col-lg-3 col-sm-1 col-xs-1">
   			
   		</div>
   		<div class="col-md-6 col-lg-6 col-sm-9 col-xs-9">
   			<div class="row">
   				<h2>Guideline for Author </h2>
   			</div>
   			<div class="row">
				<p>
					Are you ready to submit your manuscript? Please review the submission guidelines for publication in <i>Journal of Toxicology and Molecular Biology.</i>
				</p>
				<p>
					Journal of Toxicology and Molecular Biology open access journal invites authors from all over the world. We now differentiate between the requirements for new and revised submissions. You may choose to submit your manuscript as a Word file to be used in the refereeing process. Only when your paper is at the revision stage, will you be requested to put your paper in to a 'correct format' for acceptance and provide the items required for the publication of your article. 
				</p>
   			</div>
   			<div class="row">
   				<a href="../uploads/sitefiles/pdf/Guide for Authors jtox mol bio.pdf">
   					<span class="glyphicon glyphicon-open-file pdf-Authors"></span>  
   				</a>
   			</div>
   		</div>
   		<div class="col-md-3 col-lg-3 col-sm-1 col-xs-1">
   			
   		</div>
    </div>
    <?php require_once($root."includes/footer.html"); ?>
</div>
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/main.js"></script>
<script src="../jQueryAssets/jquery-1.11.1.min.js"></script>
<script src="../jQueryAssets/jquery.ui-1.10.4.progressbar.min.js"></script>
<style>
	@import url("../css/main.css");
	@import url("../css/768.css");
	@import url("../css/footer.css");
	@import url("../css/font-awesome.min.css");
</style>
</body>
</html>