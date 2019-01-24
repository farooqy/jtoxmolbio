<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$config = require_once($root."config/config.php");
$url = $config["URL"];
$morePage = true;
$aboutPage = true;
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
    
</div>
<div class="container">
    
	<div class="row aboutUsContent">
   		<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
   			<div class="row">
   				<h1>
   					About Us
   				</h1>
   			</div>
   			<div class="row">
   				<h3>
   					Aim and Scope
   				</h3>
   			</div>
   			<div class="row">
   				<p>
   					<a href="<?php echo $url ?>" target="_blank">Journal of Toxicology and Molecular Biology</a> is a peer-reviewed journal aiming to communicate high quality original research work, reviews , mini reviews that encompass all aspects of basic knowledge of the field of Toxicology, Cell and Molecular Biology. The journal welcomes outstanding contributions in any domain of toxicology and molecular biology. The journal gives researchers a faster path to publishing in a high-quality peer-reviewed journal. All work that reaches austere technical and ethics standards is published and immediately available to scientists and researchers. All articles published in this journal represent the opinion of the authors and not reflect the official policy of the Journal of Toxicology and Molecular Biology. 
   				</p>
   			</div>
   			
   			<div class="row">
   				<h3>
   					Publication fee:
   				</h3>
   				<p>
   					All the article publishing cost are currently free(limited time). As it is a open access journal, all articles will be immediately and permanently free for everyone to read and download. 
   				</p>
   			</div>
   			
   			<div class="row">
   				<p>
   					<b>Copyright statement</b>-The Journal of Toxicology and Molecular Biology holds copyright on all published paper in journal. Readers may use the content as long as the work properly cited and linked to the original source, the use is educational and not for profit and the work is not altered. The ability to copy, download, forward or otherwise distribute any material is always subject to any copyright notices displayed. Copyright notices must be displayed prominently and may not be obliterated, deleted or hidden, totally or partially.  
   				</p>
   			</div>
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