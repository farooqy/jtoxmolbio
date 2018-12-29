<?php 

$submit = $url."submit";
$archive = $url."archive";
$trackpaper = $url."tracks";
$contactus = $url."contactus";
$aboutus = $url."aboutus";
$authors = $url."authors";
$editorial = $url."editorial";
$login = $url."login";
$register = $url."register";
$profile = $url."profile";
$logout = $url."logout";
$board = $url."board";

$logo1 = $url."uploads/sitefiles/logos/jtoxLogoMain.png";
$logo2 = $url."uploads/sitefiles/logos/1xLogosmall.png";
$ccLincese = $url."uploads/sitefiles/icons/cclicense.png";

?>
	  <nav class="">
 		  <div class="container navbar navbar-inverse  navbar-fixed-top">
 		    <!-- Brand and toggle get grouped for better mobile display -->
 		    <div class="row logo2">
 		      <a class="navbar-brand mainlogo2" href="<?php echo $url ?>">
 		      	<img src="<?php echo $logo2 ?>" height="60px" class="na">	
 		      </a>
	        </div>
 		    <div class="navbar-header ">
 		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#inverseNavbar1" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
 		      <a class="navbar-brand mainlogo1" href="<?php echo $url ?>">
 		      	<img src="<?php echo $logo1 ?>" height="40px">	
 		      </a>
 		      <a class="navbar-brand mainlogo3" href="<?php echo $url ?>">
 		      	<img src="<?php echo $logo2 ?>" height="40px" class="na">	
 		      </a>
	        </div>
 		    <!-- Collect the nav links, forms, and other content for toggling -->
 		    <div class="collapse navbar-collapse" id="inverseNavbar1">
 		      <ul class="nav navbar-nav">
 		        <li class="<?php if(isset($homePage)) echo 'active' ?>"><a href="<?php echo $url ?>">Home<span class="sr-only">(current)</span></a></li>
 		        <li class="<?php if(isset($submitPage)) echo 'active' ?>"><a href="<?php echo $submit ?>">Submit Manuscript</a></li>
 		        <li class="<?php if(isset($archivePage)) echo 'active' ?>"><a href="<?php echo $archive ?>">Archive</a></li>
				<li class="<?php if(isset($editorialPage)) echo 'active' ?>"><a href="<?php echo $editorial ?>">Editorial Board</a></li>
<!--
 		        <li><a href="#">About Us</a></li>
				<li><a href="#">Authors</a></li>
				<li><a href="#">Editorial</a></li>
-->
 		        <li class="dropdown "><a href="#" class="dropdown-toggle " data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">More<span class="caret"></span></a>
 		        <ul class="dropdown-menu">
 		        <li class="<?php if(isset($trackPage)) echo 'active' ?>"><a href="<?php echo $trackpaper  ?>">Track Paper</a></li>
				<li class="<?php if(isset($aboutPage)) echo 'active' ?>"><a href="<?php echo $aboutus  ?>">About Us</a></li>
				<li class="<?php if(isset($authorPage)) echo 'active' ?>"><a href="<?php echo $authors ?>">For Authors</a></li>
 		        <li class="<?php if(isset($contactPage)) echo 'active' ?>"><a href="<?php echo $contactus  ?>">Contact</a></li>
<!-- 		            <li role="separator" class="divider"></li>-->
	            </ul>
	            </li>
	          </ul>
 		      <form class="navbar-form navbar-left" role="search">
 		        <div class="form-group">
 		          <input type="text" class="form-control " placeholder="Search">
	            </div>
 		        <button type="submit" class="btn btn-default">Submit</button>
	          </form>
 		      <ul class="nav navbar-nav navbar-right">
				<li class="<?php if(isset($profilePage)) echo 'active' ?>"><a href="<?php echo $profile ?>">Profile</a></li>
	        	<?php
				if(isset($_SESSION["isLoggedIn"]))
				{
					?>
					
		        <li class="<?php if(isset($logoutPage)) echo 'active' ?>"><a href="<?php echo $logout ?>">logout</a></li>
 		        <li class="<?php if(isset($contactPage)) echo 'active' ?>"><a href="<?php echo $contactus  ?>">Contact</a></li>
					<?php
				}
				else
				{
					?>
					
		        <li class="<?php if(isset($loginPage)) echo 'active' ?>"><a href="<?php echo $login ?>">Login</a></li>
				<li class="<?php if(isset($registerPage)) echo 'active' ?>"><a href="<?php echo $register ?>">Register</a></li>
					<?php 
				}
				  ?>
<!--
 		        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile<span class="caret"></span></a>
 		          <ul class="dropdown-menu">
 		            <li><a href="#">Login</a></li>
 		            <li><a href="#">Register</a></li>
	              </ul>
	            </li>
-->
	          </ul>
	        </div>
 		    <!-- /.navbar-collapse -->
	    </div>
 		  <!-- /.container-fluid -->
	  </nav>