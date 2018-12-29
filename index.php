<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$url = "http://jtoxmolbio/";

require_once($root."classes/SuperClass.php");
require_once($root."classes/functions.php");

$Super_Class = new Super_Class($root."errors/");
$table = array("journal_main","published_journals");
$fields = "`journal_main`.id, manToken, title, j_type, views, `published_journals`.j_url, `published_journals`.j_time";
$condition = "`published_journals`.j_id = `journal_main`.id AND status = 'published'";
$Manuscripts = $Super_Class->Super_Get($fields, $table, $condition, "`published_journals`.j_time DESC LIMIT 5");

$popularManuscripts = $Super_Class->Super_Get($fields, $table, $condition, "views DESC LIMIT 5");
if($Manuscripts === false)
{
	$errorMessage = "Failed to get the publsihed manuscript. Please contact support ".$Super_Class->Get_Message();
	$Manuscripts = null;
	unset($Manuscripts);
}
else if(is_array($Manuscripts) === false)
{
	$errorMessage = "The retrieved publishes are not of recognized types. Please contact support for assistance";
	$Manuscripts = null;
	unset($Manuscripts);
}
else if($popularManuscripts === false)
{
	$errorMessage = "Failed to get the popular publsihed manuscript. Please contact support ".$Super_Class->Get_Message();
	$Manuscripts = null;
	$popularManuscripts = null;
	unset($popularManuscripts);
	unset($Manuscripts);
}
else if(is_array($popularManuscripts) === false)
{
	$errorMessage = "The retrieved popular publishes are not of recognized types. Please contact support for assistance";
	$Manuscripts = null;
	$popularManuscripts = null;
	unset($popularManuscripts);
	unset($Manuscripts);
}
else
{
	foreach($Manuscripts as $manKey => $manData)
	{
		$manID = $manData["id"];
		$manToken = $manData["manToken"];
		$table = "journal_authors";
		$fields = "id, a_title, a_secondName";
		$condition = "journal_id = $manID";
		$Authors = $Super_Class->Super_Get($fields, $table, $condition, "id");
		$Manuscripts[$manKey]["authors"] ="";
		$Manuscripts[$manKey]["j_time"]=format_time($manData["j_time"]);
		if($Authors === false)
		{
			$Manuscripts[$manKey]["authors"] = "Failed to get authors";
		}
		else if(is_array($Authors) === false)
		{
			$Manuscripts[$manKey]["authors"] = "unrecognized author type";
		}
		else
		{
			foreach($Authors as $akey => $adata)
			{
				if(empty($Manuscripts[$manKey]["authors"]))
				{
					$Manuscripts[$manKey]["authors"] = $Manuscripts[$manKey]["authors"]." | ".$adata["a_title"]." ".$adata["a_secondName"];
				}
				else
				{
					$Manuscripts[$manKey]["authors"] = $adata["a_title"]." ".$adata["a_secondName"];
				}
			}
		}
		$table = "journal_figures";
		$fields = "figure_url";
		$condition = "journal_id = $manID";
		$Figure = $Super_Class->Super_Get($fields, $table, $condition, $fields);
		if($Figure === false || is_array($Figure) === false || count($Figure) <= 0)
		{
			$Manuscripts[$manKey]["figureurl"] = $url."uploads/sitefiles/icons/close_red.png";
		}
		else 
			$Manuscripts[$manKey]["figureurl"] = $Figure[0]["figure_url"];
		
		
	}
	foreach($popularManuscripts as $manKey => $manData)
	{
		$manID = $manData["id"];
		$manToken = $manData["manToken"];
		$table = "journal_authors";
		$fields = "id, a_title, a_secondName";
		$condition = "journal_id = $manID";
		$Authors = $Super_Class->Super_Get($fields, $table, $condition, "id");
		$popularManuscripts[$manKey]["authors"] ="";
		$popularManuscripts[$manKey]["j_time"]=format_time($manData["j_time"]);
		if($Authors === false)
		{
			$popularManuscripts[$manKey]["authors"] = "Failed to get authors";
		}
		else if(is_array($Authors) === false)
		{
			$popularManuscripts[$manKey]["authors"] = "unrecognized author type";
		}
		else
		{
			foreach($Authors as $akey => $adata)
			{
				if(empty($popularManuscripts[$manKey]["authors"]))
				{
					$popularManuscripts[$manKey]["authors"] = $popularManuscripts[$manKey]["authors"]." | ".$adata["a_title"]." ".$adata["a_secondName"];
				}
				else
				{
					$popularManuscripts[$manKey]["authors"] = $adata["a_title"]." ".$adata["a_secondName"];
				}
			}
		}
		$table = "journal_figures";
		$fields = "figure_url";
		$condition = "journal_id = $manID";
		$Figure = $Super_Class->Super_Get($fields, $table, $condition, $fields);
		if($Figure === false || is_array($Figure) === false || count($Figure) <= 0)
		{
			$popularManuscripts[$manKey]["figureurl"] = $url."uploads/sitefiles/icons/close_red.png";
		}
		else 
			$popularManuscripts[$manKey]["figureurl"] = $Figure[0]["figure_url"];
		
		
	}
}

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
<!--
    			        <h3>First slide Heading</h3>
    			        <p>First slide Caption</p>
-->
  			        </div>
  			      </div>
    			  <div class="item"><img src="uploads/sitefiles/slide/slider2.png" alt="Second slide image" class="center-block">
    			      <div class="carousel-caption">
<!--
    			        <h3>Second slide Heading</h3>
    			        <p>Second slide Caption</p>
-->
  			        </div>
  			      </div>
				  <div class="item"><img src="uploads/sitefiles/slide/slider3.png" alt="Third slide image" class="center-block">
				   <div class="carousel-caption">
<!--
					<h3>Third slide Heading</h3>
					<p>Third slide Caption</p>
-->
				  </div>
			      </div>
				  <div class="item"><img src="uploads/sitefiles/slide/slider4.png" alt="Fourth slide image" class="center-block">
				   <div class="carousel-caption">
<!--
					<h3>Fourth slide Heading</h3>
					<p>Fifth slide Caption</p>
-->
				  </div>
			      </div>
		        </div>
    			  <a class="left carousel-control" href="#carousel1" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">Previous</span></a><a class="right carousel-control" href="#carousel1" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">Next</span></a></div>
            </div>
            
          <div class="row latestArticleBar">Latest Article</div>
          <?php
		  if(isset($errorMessage))
		  {
			  ?>
		<div class="row displayError">
			<?php echo $errorMessage ?>
		</div>
			  <?php
		  }
		  else if(isset($Manuscripts) && is_array($Manuscripts))
		  {
			  foreach($Manuscripts as $manKey => $manData)
			  {
				  $manTitle = $manData["title"];
				  $manFigure = $manData["figureurl"];
				  $manAuthor = $manData["authors"];
				  $manType = $manData["j_type"];
				  $manUrl = $manData["j_url"];
				  $manTime = $manData["j_time"];
				  $manViews = $manData["views"];
				  ?>
		  
          <div class="row">
           	<div class="media-object-default">
            	  <div class="media">
            	    <div class="media-left"><a href="#"><img class="media-object" src="<?php echo $manFigure ?>" alt="placeholder image" height="160px" width="210px;"></a></div>
            	    <div class="media-body">
            	      <h3 class="media-heading"><?php echo $manTitle ?></h3>
            	       <div class="">
            	       	<span class="glyphicon glyphicon-calendar" ></span>
            	       	<?php echo $manTime ?>
            	       	<span class="glyphicon glyphicon-tasks" ></span>
            	       	<?php echo $manType ?>
            	       	<span class="glyphicon glyphicon-eye-open" ></span>
            	       	<?php echo $manViews ?> Views
            	       </div>
            	       <div class="paperAuthor">
            	       	<span class="glyphicon glyphicon-pencil">
            	       		<?php echo $manAuthor ?>
            	       	</span>
            	       	  
            	       </div>
            	       <div class="openArticle">
            	       	<span class="glyphicon glyphicon-open-file"></span>
            	       	<a href="<?php echo $manUrl ?>" class="">Read Article </a>
            	       </div>
						
					  </div>
          	    </div>
       	    </div>
          </div>
				  <?php
			  }
		  }
		  
		  ?>
<!--
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
           
-->
           
          <div class="row latestArticleBar">Popular Article</div>
          <?php 
		  if(isset($popularManuscripts) && is_array($popularManuscripts))
		  {
			  
			  foreach($popularManuscripts as $manKey => $manData)
			  {
				  $manTitle = $manData["title"];
				  $manFigure = $manData["figureurl"];
				  $manAuthor = $manData["authors"];
				  $manType = $manData["j_type"];
				  $manUrl = $manData["j_url"];
				  $manTime = $manData["j_time"];
				  $manViews = $manData["views"];
				  ?>
		  
          <div class="row">
           	<div class="media-object-default">
            	  <div class="media">
            	    <div class="media-left"><a href="#"><img class="media-object" src="<?php echo $manFigure ?>" alt="placeholder image" height="160px" width="210px;"></a></div>
            	    <div class="media-body">
            	      <h3 class="media-heading"><?php echo $manTitle ?></h3>
            	       <div class="">
            	       	<span class="glyphicon glyphicon-calendar" ></span>
            	       	<?php echo $manTime ?>
            	       	<span class="glyphicon glyphicon-tasks" ></span>
            	       	<?php echo $manType ?>
            	       	<span class="glyphicon glyphicon-eye-open" ></span>
            	       	<?php echo $manViews ?> Views
            	       </div>
            	       <div class="paperAuthor">
            	       	<span class="glyphicon glyphicon-pencil">
            	       		<?php echo $manAuthor ?>
            	       	</span>
            	       	  
            	       </div>
            	       <div class="openArticle">
            	       	<span class="glyphicon glyphicon-open-file"></span>
            	       	<a href="<?php echo $manUrl ?>" class="">Read Article </a>
            	       </div>
						
					  </div>
          	    </div>
       	    </div>
          </div>
				  <?php
			  }
		  
		  }
		  ?>
<!--
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
            	       	<span class="glyphicon glyphicon-eye-open" ></span>
            	       	8 Views
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
-->
            
            
    	</div>
      <div class="col-md-4 col-lg-4 col-xs-12 col-sm-12 ">
    		<div class="coverpage row"></div>
    		<div class="row rightbarText">
    			Submit paper
    		</div>
    		<?php
			if(isset($_SESSION["isLoggedIn"]) === false)
			{
				?>
    		<div class="row rightbarText">
    			Login
    		</div>
    		
    		<form class="row formHomeLogin" action="" method="post">
    			<label for="loginEmail" class="textLabel">Email</label>
    			<input class="text-input" placeholder="Enter Email" name="loginEmailAddress" type="email">
    			<label for="loginPassword" class="textLabel">Password</label>
    			<input class="text-input" placeholder="Enter password" name="loginPassword" id="inputPassword" type="password">
    			<input type="submit" value="Login" name="homeLogin" class="btn btn-success btn-login">
    		</form>
    		<?php
			}
		  ?>
    		
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