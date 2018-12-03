<?php session_start();
$root = $_SERVER[ "DOCUMENT_ROOT" ] . "/";
$url = "http://jtoxmolbio/";
//if ( isset( $_SESSION[ "admin" ] ) === false ) {
//	header( "Location: $url" . "maintenance" );
//	exit( 0 );
//}
if(isset($_SESSION["isLoggedIn"]) === false)
{
	header("Location: $url".'login?redirect=profile');
	exit(0);
}
$profilePage = true;
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

<body style="padding-top: 70px">
<div class="container">
  <div class="row" id="header">
  	<?php require($root."includes/nav.php"); ?>
  </div>
  
  <div class="row errorDiv mar-top-90">
  	
  </div>
  <div class="row profilePage">
  <div class="col-xs-0 col-sm-0 col-md-3 col-lg-3">
  	
  </div>
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 profileDiv">
  	<div class="row ">
  		<label for="userTitle" class="textLabel">Salutation</label>
  		<input type="text" class="userTitle" name="userTitle" placeholder="first name" value="">
  		<button class="btn btn-primary changeProfile" target="userTitle">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userFirstName" class="textLabel">First Name</label>
  		<input type="text" class="userFirstName" name="userFirstName" placeholder="first name" value="">
  		<button class="btn btn-primary changeProfile" target="userFirstName">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userLastName" class="textLabel"> Last Name</label>
  		<input type="text" class="userLastName" name="userLastName" placeholder="last name" value="">
  		<button class="btn btn-primary changeProfile" target="userLastName">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userEmailAddress" class="textLabel">Email Address</label>
  		<input type="text" class="userEmailAddress" name="userEmailAddress" placeholder="email address" value="">
  		<button class="btn btn-primary changeProfile" target="userEmailAddress">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userPasswordOld" class="textLabel">Old Password</label>
  		<input type="password" class="userPasswordOld" name="userPasswordOld" placeholder="old password" value="">
  	</div>
  	<div class="row ">
  		<label for="userPasswordNew" class="textLabel">New Password</label>
  		<input type="password" class="userPasswordNew" name="userPasswordNew" placeholder="new password" value="">
  		<button class="btn btn-primary changeProfile" target="userPassword">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userInstitute" class="textLabel">Institue</label>
  		<input type="text" class="userInstitute" name="userInstitute" placeholder="Institute" value="">
  		<button class="btn btn-primary changeProfile" target="userInstitute">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userDepartment" class="textLabel">Department</label>
  		<input type="text" class="userDepartment" name="userDepartment" placeholder="UserFirstName" value="">
  		<button class="btn btn-primary changeProfile" target="userDepartment">Save</button>
  	</div>
  	<div class="row ">
  		<label for="userCountry" class="textLabel">Country</label>
  		<input type="text" class="userCountry" name="userCountry" placeholder="Country" value="">
  		<button class="btn btn-primary changeProfile" target="userCountry">Save</button>
  	</div>
  	<div class="row redirectPage">
  		<p>
  			Not a member? 
  			<a href="<?php echo $url.'register' ?>">Register here</a>
  		</p>
  	</div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
  	
  </div>
		
  </div>
	
</div>
<div class="container">
	<?php require_once($root."includes/footer.html") ?>
</div>
<div class="container-fluid loader-gif">
	<img src="../uploads/sitefiles/icons/tv_loading.gif">
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