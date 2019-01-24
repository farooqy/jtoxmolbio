<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$config = require_once($root."config/config.php");
$url = $config["URL"];

//if ( isset( $_SESSION[ "admin" ] ) === false ) {
//	header( "Location: $url" . "maintenance" );
//	exit( 0 );
//}
if(isset($_SESSION["isLoggedIn"]))
{
	header("Location: $url".'profile');
	exit(0);
}
$loginPage = true;
?>
<!doctype html>
<html><head>
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

<body style="">
<div class="container">
  <div class="row" id="header">
  	<?php require($root."includes/nav.php"); ?>
  </div>
  
  
	
</div>
<div class="container">
 <div class="row loginPage">
  <div class="col-xs-0 col-sm-0 col-md-3 col-lg-3">
  	
  </div>
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
  	<div class="row loginDiv">
  		<form class="form loginForm">
  			<div class="formBlock">
				<label for="loginEmailAddress" class="textLabel">Email Address</label>
				<input type="email" name="loginEmailAddress" class="loginEmailAddress" placeholder="Enter Email Address">
				<label for="loginPasswrod" class="textLabel">Password</label>
				<input type="password" name="loginPassword" class="loginPasswrod" placeholder="Enter password">
  			</div>
  			<div class="formInline">
  				<input type="checkbox" name="rememberMe" class="rememberMe">
				<label for="loginEmailAddress" class="textLabel rememberMeLabel">Remember Me</label>
  			</div>
			<div class="formBlock">
				<input type="submit" class="btn btn-primary" value="Login">
			</div>
			<div class="formBlock registerProgress">
					
				<div class="errorDiv">
               		
                </div>
                <?php 
				if(isset($_GET["redirect"]))
				{
					?>
					<div class="redirect" target="<?php echo $_GET['redirect'] ?>"> 

					</div>
					<?php 
				}
				?>
					
                <div class="row memberNotMember">
					<p>
						Already a member?
						<a href="<?php echo $url.'login' ?>">Login here</a>
					</p>
				</div>
			</div>
			<div class="">
				<a href="<?php echo $url.'forgot' ?>">Forgot password?</a>
			</div>
				
			
		</form>
  	</div>
<!--
  	<div class="row redirectPage">
  		<p>
  			Not a member? 
  			<a href="<?php echo $url.'register' ?>">Register here</a>
  		</p>
  	</div>
-->
  </div>
  <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
  	
  </div>
		
 </div>
	<?php require_once($root."includes/footer.html") ?>
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