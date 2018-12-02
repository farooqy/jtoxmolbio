<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$url = "http://jtoxmolbio/";

$homePage = true;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="jQueryAssets/jquery.ui.progressbar.min.css" rel="stylesheet" type="text/css">
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
    <div class="row firstContent">
   	  <div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 sliderBox">
    		<div class="row">
   			  <div id="carousel1" class="carousel slide" data-ride="carousel">
    			  <ol class="carousel-indicators">
    			    <li data-target="#carousel1" data-slide-to="0" class="active"></li>
    			    <li data-target="#carousel1" data-slide-to="1"></li>
    			    <li data-target="#carousel1" data-slide-to="2"></li>
    			    <li data-target="#carousel1" data-slide-to="3"></li>
  			      </ol>
    			  <div class="carousel-inner" role="listbox">
    			    <div class="item active"><img src="uploads/sitefiles/slide/slider1.png" alt="First slide image" class="center-block">
    			      <div class="carousel-caption">
    			        <h3>First slide Heading</h3>
    			        <p>First slide Caption</p>
  			        </div>
  			      </div>
    			  <div class="item"><img src="uploads/sitefiles/slide/slider2.png" alt="Second slide image" class="center-block">
    			      <div class="carousel-caption">
    			        <h3>Second slide Heading</h3>
    			        <p>Second slide Caption</p>
  			        </div>
  			      </div>
				  <div class="item"><img src="uploads/sitefiles/slide/slider3.png" alt="Third slide image" class="center-block">
				   <div class="carousel-caption">
					<h3>Third slide Heading</h3>
					<p>Third slide Caption</p>
				  </div>
			      </div>
				  <div class="item"><img src="uploads/sitefiles/slide/slider4.png" alt="Fourth slide image" class="center-block">
				   <div class="carousel-caption">
					<h3>Fourth slide Heading</h3>
					<p>Fifth slide Caption</p>
				  </div>
			      </div>
		        </div>
    			  <a class="left carousel-control" href="#carousel1" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="right carousel-control" href="#carousel1" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a></div>
            </div>
            
          <div class="row latestArticleBar">Latest Article</div>
          <div class="row">
           	<div class="media-object-default">
            	  <div class="media">
            	    <div class="media-left"><a href="#"><img class="media-object" src="uploads/sitefiles/slide/slider2.png" alt="placeholder image" height="160px" width="210px;"></a></div>
            	    <div class="media-body">
            	      <h3 class="media-heading">Media heading 1</h3>
            	       <div class="">
            	       	<span class="glyphicon glyphicon-calendar" ></span>
            	       	11-02-2018
            	       	<span class="glyphicon glyphicon-tasks" ></span>
            	       	Review Article
            	       </div>
            	       <div class="paperAuthor">
            	       	<span class="glyphicon glyphicon-pencil">
            	       		Sun Li | Yuan Shengtao | Liu Yang | Hou Xiaoying | Quan Xinping | Zhou Yuqi | Gong Xiaofeng | Dr. Hongzhi Du
            	       	</span>
            	       	  
            	       </div>
            	       <div class="openArticle">
            	       	<span class="glyphicon glyphicon-open-file"></span>
            	       	<a href="<?php echo 'http://soscentre' ?>" class="">Read Article </a>
            	       </div>
						
					  </div>
          	    </div>
       	    </div>
          </div>
          <div class="row">
           	<div class="media-object-default">
            	  <div class="media">
            	    <div class="media-left"><a href="#"><img class="media-object" src="uploads/sitefiles/slide/slider2.png" alt="placeholder image" height="160px" width="210px;"></a></div>
            	    <div class="media-body">
            	      <h3 class="media-heading">Media heading 1</h3>
            	       <div class="">
            	       	<span class="glyphicon glyphicon-calendar" ></span>
            	       	11-02-2018
            	       	<span class="glyphicon glyphicon-tasks" ></span>
            	       	Review Article
            	       </div>
            	       <div class="paperAuthor">
            	       	<span class="glyphicon glyphicon-pencil">
            	       		Sun Li | Yuan Shengtao | Liu Yang | Hou Xiaoying | Quan Xinping | Zhou Yuqi | Gong Xiaofeng | Dr. Hongzhi Du
            	       	</span>
            	       	  
            	       </div>
            	       <div class="openArticle">
            	       	<span class="glyphicon glyphicon-open-file"></span>
            	       	<a href="<?php echo 'http://soscentre' ?>" class="">Read Article </a>
            	       </div>
						
					  </div>
          	    </div>
       	    </div>
          </div>
           
           
          <div class="row latestArticleBar">Popular Article</div>
          <div class="row">
           	<div class="media-object-default">
            	  <div class="media">
            	    <div class="media-left"><a href="#"><img class="media-object" src="uploads/sitefiles/slide/slider2.png" alt="placeholder image" height="160px" width="210px;"></a></div>
            	    <div class="media-body">
            	      <h3 class="media-heading">Media heading 1</h3>
            	       <div class="">
            	       	<span class="glyphicon glyphicon-calendar" ></span>
            	       	11-02-2018
            	       	<span class="glyphicon glyphicon-tasks" ></span>
            	       	Review Article
            	       </div>
            	       <div class="paperAuthor">
            	       	<span class="glyphicon glyphicon-pencil">
            	       		Sun Li | Yuan Shengtao | Liu Yang | Hou Xiaoying | Quan Xinping | Zhou Yuqi | Gong Xiaofeng | Dr. Hongzhi Du
            	       	</span>
            	       	  
            	       </div>
            	       <div class="openArticle">
            	       	<span class="glyphicon glyphicon-open-file"></span>
            	       	<a href="<?php echo 'http://soscentre' ?>" class="">Read Article </a>
            	       </div>
						
					  </div>
          	    </div>
       	    </div>
          </div>
          <div class="row">
           	<div class="media-object-default">
            	  <div class="media">
            	    <div class="media-left"><a href="#"><img class="media-object" src="uploads/sitefiles/slide/slider2.png" alt="placeholder image" height="160px" width="210px;"></a></div>
            	    <div class="media-body">
            	      <h3 class="media-heading">Media heading 1</h3>
            	       <div class="">
            	       	<span class="glyphicon glyphicon-calendar" ></span>
            	       	11-02-2018
            	       	<span class="glyphicon glyphicon-tasks" ></span>
            	       	Review Article
            	       </div>
            	       <div class="paperAuthor">
            	       	<span class="glyphicon glyphicon-pencil">
            	       		Sun Li | Yuan Shengtao | Liu Yang | Hou Xiaoying | Quan Xinping | Zhou Yuqi | Gong Xiaofeng | Dr. Hongzhi Du
            	       	</span>
            	       	  
            	       </div>
            	       <div class="openArticle">
            	       	<span class="glyphicon glyphicon-open-file"></span>
            	       	<a href="<?php echo 'http://soscentre' ?>" class="">Read Article </a>
            	       </div>
						
					  </div>
          	    </div>
       	    </div>
          </div>
            
            
    	</div>
      <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 ">
    		<div class="coverpage row"></div>
    		<div class="row rightbarText">
    			Submit paper
    		</div>
    		<div class="row rightbarText">
    			Login
    		</div>
    		
    		<form class="row formHomeLogin" action="" method="post">
    			<label for="loginEmail" class="textLabel">Email</label>
    			<input class="text-input" placeholder="Enter Email" name="loginEmail" type="email">
    			<label for="loginPassword" class="textLabel">Password</label>
    			<input class="text-input" placeholder="Enter password" name="loginEmail" id="inputPassword" type="password">
    			<input type="submit" value="Login" name="homeLogin" class="btn btn-success btn-login">
    		</form>
    		
    		<div class="row openaccess">
    			
    		</div>
    		<div class="row rightbarText">
    			Contact Us
    		</div>
    		<div class="row contactUsBox">
    			<div class="">
    				<span class="glyphicon glyphicon-envelope"></span>
    				<span class="">
    				<a href="mailto:support@jtoxmolbio.com">
    					support@jtoxmolbio.com
    				</a>
    				</span>
    			</div>
    			<div class="">
    				<span class="glyphicon glyphicon-map-marker"></span>
    				<span class="">
    				 Office address
    				 India: Jessore Road, Kolkata, West Bengal, India 
    				</span>
    			</div>
    		</div>
    		
   	  </div>
    </div>
    
	<div class="row">
   		
    </div>
    <?php require_once($root."includes/footer.html");?>
</div>

<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/main.js"></script>
<script src="jQueryAssets/jquery-1.11.1.min.js"></script>
<script src="jQueryAssets/jquery.ui-1.10.4.progressbar.min.js"></script>
<style>
	@import url("css/main.css");
	@import url("css/768.css");
	@import url("css/footer.css");
	@import url("css/font-awesome.min.css");
	
</style>
</body>
</html>