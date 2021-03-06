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
else if(isset($_GET["forgot"]) && isset($_GET["token"]))
{
	require_once($root."classes/functions.php");
	$token = Sanitize_String($_GET["token"]);
	$forgot = Validate_Int($_GET["forgot"]);
	if($forgot === false || $forgot !== 1)
	{
		$errorMessage = "Invalid data given";
	}
	else if(empty($token))
	{
		$errorMessage = "Empty token passed";
	}
	else
	{
		require_once($root."classes/SuperClass.php");
		$Super_Class = new Super_Class($root);
		$table = "recovers";
		$fields = "email, time, status";
		$condition = "token = '$token'";
		$recoverInfo = $Super_Class->Super_Get($fields, $table, $condition, "time DESC LIMIT 1");
		if($recoverInfo === false)
		{
			$errorMessage = "Failed to get the recovery details. Please contact support";
		}
		else if(is_array($recoverInfo) === false)
		{
			$errorMessage = "The recovery data is not of recognized type";
		}
		else if(count($recoverInfo) !== 1)
		{
			$errorMessage = "The recovery token doesn't exist. Please request a new recovery token";
		}
		else if($recoverInfo[0]["status"] !== "active")
		{
			$errorMessage = "The recovery token requested is no longer active. Please request a new one";
		}
		else
		{
			$allowPassChange = true;
			$recoverEmail = $recoverInfo[0]["email"];
		}
	}

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
  		<?php 
  		if(isset($allowPassChange) === true && $allowPassChange === true)
  		{
  			?>

  		<form class="form recoverForm">
  			<div class="formBlock">
				<label for="loginEmailAddress" class="textLabel">New Password</label>
				<input type="password" name="recoverPassword" class="loginEmailAddress" placeholder="Enter New passowrd">
  			</div>
  			<div class="formBlock">
				<label for="loginEmailAddress" class="textLabel">Repeat Password</label>
				<input type="password" name="recoverPasswordRepeat" class="loginEmailAddress" placeholder="Repeat New Password">
  			</div>
  			<div class="formBlock">
				<input type="hidden" name="ptoken" value="<?php echo $token ?>">
				<input type="hidden" name="ptype" value="<?php echo $recoverEmail ?>">
  			</div>
			<div class="formBlock">
				<input type="submit" class="btn btn-primary" value="Login">
			</div>
			<div class="formBlock registerProgress">
					
				<div class="errorDiv">
               		
                </div>
					
                <div class="row memberNotMember">
				</div>
			</div>
				
			
		</form>
  			<?php
  		}
  		else if(isset($errorMessage))
  		{
  			?>
  		<div class="displayError" style="display: block">
  			<?php echo $errorMessage ?>
  		</div>
  		<form class="form forgotForm">
  			<div class="formBlock">
				<label for="loginEmailAddress" class="textLabel">Email Address</label>
				<input type="email" name="loginEmailAddress" class="loginEmailAddress" placeholder="Enter Email Address">
  			</div>
  			<div class="formInline">
  			</div>
			<div class="formBlock">
				<input type="submit" class="btn btn-primary" value="Login">
			</div>
			<div class="formBlock registerProgress">
					
				<div class="errorDiv">
               		
                </div>
					
                <div class="row memberNotMember">
					<p>
						Already a member?
						<a href="<?php echo $url.'login' ?>">Login here</a>
					</p>
				</div>
			</div>
				
			
		</form>
  			<?php
  		}
  		else
  		{
  			?>
  		<form class="form forgotForm">
  			<div class="formBlock">
				<label for="loginEmailAddress" class="textLabel">Email Address</label>
				<input type="email" name="loginEmailAddress" class="loginEmailAddress" placeholder="Enter Email Address">
  			</div>
  			<div class="formInline">
  			</div>
			<div class="formBlock">
				<input type="submit" class="btn btn-primary" value="Login">
			</div>
			<div class="formBlock registerProgress">
					
				<div class="errorDiv">
               		
                </div>
					
                <div class="row memberNotMember">
					<p>
						Already a member?
						<a href="<?php echo $url.'login' ?>">Login here</a>
					</p>
				</div>
			</div>
				
			
		</form>
  			<?php
  		}
  		?>
  		
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