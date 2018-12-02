<?php session_start();
$root = $_SERVER[ "DOCUMENT_ROOT" ] . "/";
$url = "http://jtoxmolbio/";
//if ( isset( $_SESSION[ "admin" ] ) === false ) {
//	header( "Location: $url" . "maintenance" );
//	exit( 0 );
//}

if(isset($_SESSION["isLoggedIn"]))
{
	header("Location: $url/profile");
	exit(0);
}
$registerPage = true;
?>
<!doctype html>
<html><head>
<meta charset="utf-8">

<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="../jQueryAssets/jquery.ui.progressbar.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../css/bootstrap-formhelpers-flags.css">
<link rel="stylesheet" href="../css/bootstrap-formhelpers.css">
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

<body style="padding-top: 70px">
<div class="container">
  <div class="row" id="header">
  	<?php require($root."includes/nav.php"); ?>
  </div>
  
  <div class="row registerPage">
  <div class="col-xs-0 col-sm-0 col-md-3 col-lg-3">
  	
  </div>
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
  	<div class="row registerDiv">
  		<form class="form registerForm">
  			<div class="formBlock">
				<label for="registerEmailAddress" class="textLabel">Email Address</label>
				<input type="email" name="registerEmailAddress" class="registerEmailAddress" placeholder="Enter Email Address">
				
				<label for="registerSalutation" class="textLabel">Salutation</label>
				<input type="text" name="registerSalutation" class="registerSalutation" placeholder="Enter Salutation">
				
				<label for="registerFirstName" class="textLabel">First Name</label>
				<input type="text" name="registerFirstName" class="registerFirstName" placeholder="Enter First Name">
				
				<label for="registerLastName" class="textLabel">Last Name</label>
				<input type="text" name="registerLastName" class="registerLastName" placeholder="Enter Last name">
				
				<label for="registerPassword" class="textLabel">Password</label>
				<input type="password" name="registerPassword" class="registerPassword" placeholder="Enter your password">
				
				<label for="registerPasswordConfirm" class="textLabel">Confirm Password</label>
				<input type="password" name="registerPasswordConfirm" class="registerPasswordConfirm" placeholder="Confirm your password">
				
				<label for="registerInstitution" class="textLabel">Institution</label>
				<input type="text" name="registerInstitution" class="registerInstitution" placeholder="Enter your institution">
				
				<label for="registerDepartment" class="textLabel">Department</label>
				<input type="text" name="registerDepartment" class="registerDepartment" placeholder="Enter your department">
				
  			</div>
  			
  			
			  <div class="bfh-selectbox bfh-countries" data-country="IN" data-flags="true" data-title="countryName">
				  <input type="hidden" value="" name="registerCountry"> 
				  <a class="bfh-selectbox-toggle" role="button" data-toggle="bfh-selectbox" href="#">
					  <span class="bfh-selectbox-option input-large" data-option="Select Country"></span>
					  <b class="caret"></b>
				  </a>
				  <div class="bfh-selectbox-options">
					  <input type="text" class="bfh-selectbox-filter">
					  <div role="listbox">
						  <ul role="option">

						  </ul>
				  	  </div>
				  </div>
			  </div>
  			
  			<div class="formInline row">
				<input type="checkbox" name="registerSubscriber" class="rememberMe col-md-1 col-lg-1 col-sm-2 col-xs-2">
  				
				<p for="registerEmailAddress" class=" rememberMeLabel col-md-10 col-lg-10 col-sm-9 col-xs-8">I wish to receive information and promotion offer from journal and its affiliates concerning their products</p>
  			</div>
  			<div class="formInline row">
				<p class=" rememberMeLabel col-md-10 col-lg-10 col-sm-9 col-xs-8">
					<b>By Clicking on register, you approve that you have read and understood the 
					<a href="<?php echo $url.'rua' ?>">
						Registered user Agreement
					</a>
					</b>
				</p>
  			</div>
			<div class="formBlock">
				<input type="submit" class="btn btn-primary" value="register" name="registerUser">
			</div>
			<div class="formBlock registerProgress">
				<div class="progress">
					<div class="progress progress-bar" role="progressbar" aria-valuenow="30" aria-valuemax="100" style="width: 30%">
						0% complete
					</div>
				</div>
					
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
  	</div>
				
  </div>
  <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
  	
  </div>
		
  </div>
	
</div>
<div class="container">
	<?php require_once($root."includes/footer.html") ?>
</div>

<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/main.js"></script>
<script src="../jQueryAssets/jquery-1.11.1.min.js"></script>
<script src="../jQueryAssets/jquery.ui-1.10.4.progressbar.min.js"></script>
<script src="../js/bootstrap-formhelpers-countries.js"></script>
<script src="../js/bootstrap-formhelpers-countries.en_US.js"></script>
<script src="../js/bootstrap-formhelpers-selectbox.js"></script>
<style>
	@import url("../css/main.css");
	@import url("../css/768.css");
	@import url("../css/footer.css");
	@import url("../css/font-awesome.min.css");
	
</style>
</body>

</html>