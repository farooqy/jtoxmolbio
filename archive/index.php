<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$url = "http://jtoxmolbio/";
require_once($root."classes/SuperClass.php");
$Super_Class = new Super_Class();
$table = array("journal_main","published_journals");
$fields = "`journal_main`.id, title, man_num, 
        `published_journals`.j_time";
$condition = "`published_journals`.j_id=`journal_main`.id ";
$sortby = "`published_journals`.j_time ASC";
$JournalList = $Super_Class->Super_Get($fields, $table, $condition, $sortby);
if($JournalList === false)
{
	$errorMessage = "Failed to get the list of journals published. Please contact support";
}
else if(is_array($JournalList) === false)
{
	$errorMessage = "The retrieved list of journals published is not recognized type";
}
else
{
	$numprevs = count($JournalList);
	$Volume = array();
	$VolumeTrack = array();
	$VolumeCount = 0;
	$IssueTrack = array();
	$issueCount = 0;
	$normalview = true;
	$Months = array ( "0" => "None",
		"01"=> "January", "02"=> "Febraury",
		"03"=> "March", "04"=> "April",
		"05"=> "May", "06"=> "June",
		"07"=> "July", "08"=> "August",
		"09"=> "September", "10"=> "Octobar",
		"11"=> "November", "12"=> "December"
		);
	for($i=0; $i<$numprevs; $i++)
	{
		$id = $JournalList[$i]["id"];
		$title = $JournalList[$i]["title"];
		$man_num = $JournalList[$i]["man_num"];
		$man_time = $JournalList[$i]["j_time"];
		$year = gmdate("Y", $man_time); //==volume
		$month = gmdate("m", $man_time); //==issue
		$paper = array(
			"man_id" => $id,
			"man_title" => $title,
			"man_num" => $man_num,
			"man_time" => gmdate("d-m-Y", $man_time),
			"man_link" => $id."|".$man_time."|".$man_num
			);
		if(array_key_exists($year, $VolumeTrack))
		{
			$vIndex = $VolumeTrack[$year];
			// echo "found existing volume $year at index $vIndex"."<br>";
			if(array_key_exists($year.$month , $IssueTrack))
			{
				$issueIndex = $IssueTrack[$year.$month];
				// echo "found existing issue $year.$month at index $issueIndex"."<br>";

				array_push($Volume[$vIndex]["issue"][$issueIndex]["papers"], $paper);
			}
			else
			{
				// echo "creating new issue $year.$month at index $issueCount"."<br>";
				array_push($Volume[$vIndex]["issue"],
					array(
						"name" => $month,
						"papers" => array($paper),
						)

				) ;
				$IssueTrack[$year.$month] = $issueCount;
				$issueCount +=1;
			}
		}
		else
		{
			// $Volume[$year][$month] = array($paper);
			// echo "creating new volume $year at index $VolumeCount"."<br>";
			// echo "creating new issue $year.$month at index $issueCount"."<br>";
			array_push($Volume, array(
				"name"=>$year,
				"issue" => array(
					array(
						"name" => $month,
						"papers" => array($paper),
						) 
					),
				)
			);
			$IssueTrack[$year.$month] = $issueCount;
			$issueCount +=1;
			$VolumeTrack[$year] = $VolumeCount;
			$VolumeCount += 1;
		}
	}
	
}
$archivePage = true;
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
    <?php
	if(isset($errorMessage))
	{
		?>
	<div class="row mar-top-90">
		<div class="col-md-2 col-lg-2 col-xs-0 col-sm-0"></div>
		<div class="col-md-8 col-lg-8 col-xs-12 col-sm-12">
			<div class="row displayError">
				<?php echo $errorMessage ?>
			</div>
		</div>
		<div class="col-md-2 col-lg-2 col-xs-0 col-sm-0"></div>
	</div>
	<?php
	}
	else if(isset($Volume))
	{
		?>
	<div class="row archiveDiv">
		<div class="col-md-3 col-lg-3 col-xs-3 col-sm-3">
			<?php
		$numvs = count($Volume);
		for($i=0; $i<$numvs; $i++)
		{
			$numissues = count($Volume[$i]["issue"])."<br>";
			?>
		<ul class="row volume">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<li class="row vname" target="<?php echo "volume$i"?>" >
					+Volume <?php echo ($i+1)." (".$Volume[$i]["name"].")";?>
				</li>
			<?php
			for($j=0; $j<$numissues; $j++)
			{
				$numpapers = count($Volume[$i]["issue"][$j]["papers"]);
				?>
				<ul class="row issue hide <?php echo "volume$i"?>">
					<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
						<li class="row issuename " target="<?php echo "issue$i$j" ?>">
							+Issue <?php echo ($j+1)." (".$Months[$Volume[$i]["issue"][$j]["name"]].")"; ?>
						</li>
						<ul class="row hide <?php echo "issue$i$j"?>">
				<?php
				for($k=0; $k<$numpapers; $k++)
				{
					$paperLink = $Volume[$i]["issue"][$j]["papers"][$k]["man_link"];
					$paperID = $Volume[$i]["issue"][$j]["papers"][$k]["man_id"];
					$paperTitle = $Volume[$i]["issue"][$j]["papers"][$k]["man_title"];
					?>
					<li class="row  paper_title mar-top-5 Times-roman" data="<?php echo $paperID ?>"
					target="<?php echo $paperLink ?>">
						<?php echo ($k+1).". ".$paperTitle; ?>
						<div class="underline"></div>
					</li>
					<?php
				}
				?>
						</ul>
					</div>
				</ul>
				<?php
			}

			// echo $Volume[$i]["name"]."<br>";
			// echo "num issues: $numissues"."<br>" ;
			// echo "num papers: $numpapers"."<br>" ;
			?>
			</div>
		</ul>
			<?php
		}?>
		</div>
		<div class="col-md-8 col-lg-8 col-xs-9 col-sm-9 archiveBox">
			
			
                <div class="row">
                    <div class="col-md-4 col-lg-4"></div>
                    <div class="col-md-4 col-lg-4 paperLoader">
                        <div class="row ">Fetching paper, please wait</div>
                        <div class="row lds-facebook">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            
                        </div>
                        
                    </div>
                    <div class="col-md-4 col-lg-4"></div>
                </div>
                <div class="row ">
                    <div class="col-md-1 col-lg-1"></div>
                    <div class="col-md-11 col-lg-11">
                        <div class="row paperDivError errorDiv"></div>
                        <div class="row paperDiv">
                            <div class="col-md-12 col-lg-12">
                                <div class="row mar-top-10 submit_title size-18">
                                    Click on the paper you want to display.
                                </div>
                                <div class="row mar-top-10 submit_date size-18"></div>
                                <div class="row mar-top-10 Times-roman submit_authors size-18 glyphicon glyphicon-edit"></div>
                                <div class="row mar-top-10 submit_abstract"></div>
                                <div class="row mar-top-10 submit_images">
                                </div>
                                <div class="row mar-top-10 submit_pdf openViews">
                                    <a href="" target="_blank" class="submit_pdfLink col-md-4 col-lg-4">
                                        <img src="../uploads/sitefiles/icons/pdf.png" height="30px" /> <span class="size-18">Open Paper</span>
                                    
                                    </a>
                                    <a href="" class="submit_pdfLink col-md-4 col-lg-4 DownloadPdf" download="jtoxmolbioPaper">
                                        <img src="../uploads/sitefiles/icons/download.ico" height="30px" /> <span class="size-18">Download Paper</span>
                                    
                                    </a>
                                    <span class="col-md-4 col-lg-4">
                                        
                                        <img src="../uploads/sitefiles//icons/views.png" height="20px" /> 
                                        <span  class="submit_views size-18"></span> <span class="size-18">Views</span>
                                    </span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
			
		</div>
	</div>
	<?php
	}
	?>
	<div class="row">
   		
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