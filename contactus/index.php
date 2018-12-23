<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$url = "http://jtoxmolbio/";

$contactPage = true;
require_once($root."includes/lib/simple-botdetect.php");
// create & configure the Captcha object
$ContactCaptcha = new SimpleCaptcha("ContactCaptcha");
require_once("feedback.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="../jquery-mobile/jquery.mobile.theme-1.3.0.min.css" rel="stylesheet" type="text/css">
<link href="../jquery-mobile/jquery.mobile.structure-1.3.0.min.css" rel="stylesheet" type="text/css">
<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.progressbar.min.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
<div class="container page" id="page">
 	<div class="row">
   	<?php require_once($root."includes/nav.php"); ?>
    </div>
    
	<div class="row contactusPageBox " id="">
		<div class="col-md-3 col-lg-3 col-sm-0 col-xs-0"></div>
		<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
			<div class="row errorDiv">
			</div>
			<form class="formContactUs row " name="form" method="post" action="" id="">
				<label for="senderName" class="textLabel">Your name</label>
				<input type="text" name="senderName" class=" " placeholder="Enter your name" <?php if(isset($_SESSION["fullname"])) echo "value=\"".$_SESSION["fullname"]."\" " ?> required/>
				<label for="emailAddress" class="textLabel">Email Address</label>
				<input type="email" name="emailAddress" class=" " placeholder="Enter your email address" <?php if(isset($_SESSION["email"])) echo "value=\"".$_SESSION["email"]."\" " ?> required/>
				<label for="feedbackTitle" class="textLabel">Message title</label>
				<input type="text" name="feedbackTitle" class=" " placeholder="Enter message title" required/>
				<label for="feedbackContent" class="textLabel">Your message</label>
				<textarea name="feedbackContent" class=" " placeholder="Enter message or feedback " required></textarea>
				<?php echo $ContactCaptcha->Html(); ?>
				<input type="text" name="CaptchaCode" id="CaptchaCode" class="textbox" required/>
				<input type="submit" name="submitFeedBack" value="Send" class="btn btn-feedBack">

			 </form>
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
	@import url("../css/font-awesome.min.css");
	@import url("../css/main.css");
	@import url("../css/768.css");
	@import url("../css/footer.css");
</style>
</body>
</html>