<?php session_start();
$root = $_SERVER[ "DOCUMENT_ROOT" ] . "/";
$url = "http://jtoxmolbio/";
//if ( isset( $_SESSION[ "admin" ] ) === false ) {
//	header( "Location: $url" . "maintenance" );
//	exit( 0 );
//}
if(isset($_SESSION["isLoggedIn"]) === false)
{
	header("Location: $url"."login?redirect=submit");
	exit(0);
}
if(isset($_SESSION["ManInfo"]))
{
	$_ManType = $_SESSION["ManInfo"]["man_type"];
	$_ManTitle = $_SESSION["ManInfo"]["man_title"];
	$_ManAbstract = $_SESSION["ManInfo"]["man_abstract"];
	$_ManKeywords = $_SESSION["ManInfo"]["man_keywords"];
	$_ManStage = $_SESSION["ManInfo"]["man_stage"];
	$_ManAuthors = $_SESSION["ManInfo"]["man_authors"];
	if(isset($_SESSION["ManInfo"]["ManDocument"]))
		$_ManDocuments = $_SESSION["ManInfo"]["ManDocument"];
//	print_r($_ManDocuments)
	
}
$submitPage = true;
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
  <?php if(isset($_ManStage)) var_dump($_ManStage);?>
  <div class="row submitPageBox" id="content">
	<div class="col-md-3 col-lg-3 col-xs-12 col-sm-12 submitRightBarDiv">
		<div class="row active formTrigger currentTrigger triggerForm1" target="paperForm1" >
			Manuscript Information <span class="glyphicon <?php if(isset($_ManStage) && $_ManStage > 0 ) echo 'glyphicon-ok-sign'; else echo 'glyphicon-remove-circle' ?>  form1Approve" ></span>
		</div>
		<div class="row formTrigger triggerForm2" target="paperForm2" >
			Authors <span class="glyphicon <?php if(isset($_ManStage) && $_ManStage > 1) echo 'glyphicon-ok-sign'; else echo 'glyphicon-remove-circle' ?> form2Approve" ></span>
		</div>
		<div class="row formTrigger triggerForm3 " target="paperForm3" >
			Upload files <span class="glyphicon <?php if(isset($_ManStage) && $_ManStage > 2) echo 'glyphicon-ok-sign'; else echo 'glyphicon-remove-circle' ?> form3Approve" ></span>
		</div>
		<div class="row formTrigger triggerForm4" target="paperForm4" >
			Review and submit <span class="glyphicon <?php if(isset($_ManStage) && $_ManStage > 3) echo 'glyphicon-ok-sign'; else echo 'glyphicon-remove-circle' ?> form4Approve" ></span>
		</div>
	</div>
	<div class="col-md-8 col-lg-8 col-xs-12 col-sm-12 ">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			<div class="row">
				
				<form id="paperForm1" name="paperForm1" method="post" class="paperForm1 currentForm">
					<select class="select" name="submitionType">
						<option value="dft" >
							Select article type
						</option>
						<option value="research" <?php if(isset($_ManType) && $_ManType === "research") echo 'selected' ?>>
							Research Article
						</option>
						<option value="reviewArticle" <?php if(isset($_ManType) && $_ManType === "reviewArticle") echo 'selected' ?>>
							Review Article
						</option>
						<option value="shortCommunication" <?php if(isset($_ManType) && $_ManType === "shortCommunication") echo 'selected' ?>>
							Short Communication
						</option>
						<option value="editorial" <?php if(isset($_ManType) && $_ManType === "editorial") echo 'selected' ?>>
							Editorial
						</option>
					</select>
					<label for="paperTitle">Submition title</label>
					<input name="paperTitle" type="text" placeholder="Enter submition title" 
					value="<?php if(isset($_ManTitle)) echo $_ManTitle ?>">
					<label for="paperAbstract">Submition abstract</label>
					<textarea name="paperAbstract" placeholder="Enter submition abstract" class="paperAbstract" rows="15"><?php if(isset($_ManAbstract)) echo $_ManAbstract ?></textarea>
					<label for="paperKeywords">Keywords</label>
					<input name="paperKeywords" type="text" placeholder="Enter keywords seperated by comma. ie k1,k2" value="<?php if(isset($_ManKeywords)) echo $_ManKeywords ?>">
					<input type="reset" value="Clear" name="" class="btn btn-danger btn-reset reset-Form"/>
					<input type="submit" value="Continue" name="" class="btn btn-primary"/>
				</form>
			</div>
			<div class="row paperForm2">
				<form id="paperForm2" name="paperForm2" method="post">
				  <div class="paperForm2">

					<h3>Authors:</h3>

					Corresponding author are automatically designated by clicking respective "Corresponding Author". You are allowed to select only one Corresponding Author in each submission. Click "Add Author" to add more Co-authors.

				  </div>
				  <table class="row table tableAuthorInfo">
				  	<thead>
				  		<th>Author Information</th>
				  		<th>Corresponding</th>
				  		<th>X</th>
				  	</thead>
				  	<tbody class="authorTableBody">
				  		<?php
						if(isset($_ManAuthors) && is_array($_ManAuthors))
						{
							$numAuthors = count($_ManAuthors);
							for($i=0; $i<$numAuthors; $i++)
							{
								$title = $_ManAuthors[$i]["authorTitle"];
								$lName = $_ManAuthors[$i]["authorLastName"];
								$email = $_ManAuthors[$i]["authorEmail"];
								$isCorresponding = $_ManAuthors[$i]["isCorresponding"];
								?>
						<tr class="dynamic">
							<td>
								<?php echo $title." ".$lName." | ".$email ?>
							</td>
							<td>
										<?php
								if($isCorresponding === true)
								{
									?>
								<span class="glyphicon glyphicon-ok-circle corresPondingAuthor" target="<?php echo $email ?>"></span> 
									<?php
								}
								else
								{
									?>
								<span class="glyphicon glyphicon-remove-circle corresPondingAuthor" target="<?php echo $email ?>"></span> 
									<?php
								}
										?>
							</td>
							<td>
								<span class="glyphicon glyphicon-remove removeAuthor" target="<?php echo $email ?>"></span> 
							</td>
						</tr>
								<?php
							}
						}
						else
						{
							?>
							
				  		<tr class="auto">
				  			<td>
				  			 <?php echo $_SESSION["fullname"]." | ".
								$_SESSION["email"]?>
							</td>
				  			<td>
				  				<span class="glyphicon glyphicon-ok-circle corresPondingAuthor" target="<?php echo $_SESSION["email"] ?>"></span>
			  			
				  			</td>
				  			<td>
				  				<span class="glyphicon glyphicon-remove" ></span> 
				  			</td>
				  		</tr>
							<?php
						}
						?>
				  	</tbody>
				  </table>
				  <div class="authorInfoBoxDiv">
				  	<select class="select" name="authorTitle">
						<option value="dft">
							Select author title
						</option>
						<option value="Mr">
							Mr
						</option>
						<option value="Mrs">
							Mrs
						</option>
						<option value="Ms">
							Ms
						</option>
						<option value="Prof">
							Prof
						</option>
						<option value="Dr">
							Dr.
						</option>
					 </select>
					 
					<input type="hidden" name="cAuthor" class="cAuthor" value="<?php echo $_SESSION["email"] ?>">
					 <label for="authorFirstName">Author first name<span class="superScriptStar">*</span></label>
					 <input name="authorFirstName" type="text" placeholder="Author first name">
					 <label for="authorLastName">Author last name<span class="superScriptStar">*</span></label>
					 <input name="authorLastName" type="text" placeholder="Author last name">
					 <label for="authorEmail">Author Email<span class="superScriptStar">*</span></label>
					 <input name="authorEmail" type="text" placeholder="Author Email">
					 <label for="authorInstitution">Author institution<span class="superScriptStar">*</span></label>
					 <input name="authorInstitution" type="text" placeholder="Author institution">
					 <label for="authorLocation">Author Location<span class="superScriptStar">*</span></label>
					 <input name="authorLocation" type="text" placeholder="Enter Author country">
				 	<input type="submit" value="Add Author" name="" class="btn btn-primary "/>
				  </div>
				 <div class="toggleAuthorDiv">
				 	<div class="btn btn-primary toggleAuthorBox">Toggle Author form</div>
				 	
				 	
				 </div>
				 <div class="btn-form2">
					 
				 	<input type="reset" value="Clear" name="" class="btn btn-danger btn-reset reset-Form"/>
					 <div class="btn btn-primary  text-center continueForm2">Continue</div>
				 </div>
					 
			 </form>
			</div>
   		
	   		<div class="row uploadDivBox paperForm3">
					
	   			<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
	   				<div class="row">
						<h2>
							Upload Files
						</h2>
					</div>
					<div class="row">
						<h3>
							Upload your submission files 
						</h3>
					</div>
					<div class="row">
						<p> * Manuscript File size does not exceed than 100 MB. </p>
						<p>
							* Total size of submission files must be within 500 MB. 
						</p>
						<p>
							* Select file type in each submission file. 
						</p>
						<p>
							* Click save and continue to proceed the next step.
						</p>
						<p>
							Click the type of the file you want to upload 
						</p>
					</div>
   					
   					<div class="row uploadTriggers">
   						<button class="btn triggerUpload" target="manuscript" >
   						<span class=" glyphicon glyphicon-book"></span>
   						Manuscript
   						</button>
   						<button class="btn triggerUpload" target="cover" >
   						<span class=" glyphicon glyphicon-paperclip"></span>
   						Cover
   						</button>
   						<button class="btn triggerUpload" target="figures" >
   						<span class=" glyphicon glyphicon-camera"></span>
   						Figures
   						</button>
   						<button class="btn triggerUpload" target="others" >
   						<span class=" glyphicon glyphicon-tasks"></span>
   						Others
   						</button>
   					</div>
   					<div class="row">
   						<table class="table tableManuscript">
   							<thead class="thead">
   								<th>Name</th>
   								<th>Type</th>
   								<th>Status</th>
   								<th><b>X</b></th>
   							</thead>
   							<tbody class="manuscriptTableBody">
				<?php
				$docs = array("manuscript", "cover", "figures", "others");
				foreach($docs as $key => $docType)
				{
//					echo "checking  $docType <br> ";
					if(isset($_ManDocuments[$docType]) )
					{
//						echo "$docType is ready <br>";
						$files = $_ManDocuments[$docType];
						?>
						<tr>
							<?php
						if($key === 2 || $key === 3)
						{
							
							foreach($files as $fkey => $file)
							{
								if($fkey > 0)
								{
									?>
									<tr>
									<?php
								}
								$fname = $file["name"];
								$fcate = $file["cate"];
								$fhash = $file["fileToken"];
								?>
								<td>
									<?php echo $fname ?>
								</td>
								<td>
									<?php echo $fcate ?>
								</td>
								<td>
									uploaded
								</td>
								<td>
									<span class="glyphicon glyphicon-remove-sign file-remove <?php echo $fcate.'-castrate' ?>" target="<?php echo $fcate ?>" data="<?php echo $fname.'|'.$fhash ?>" data-role="masterFile" onclick="removeFile(this)"></span>
								</td>
								<?php
								if($fkey > 0)
								{
									?>
									</tr>
									<?php
								}
							}
						}
						else
						{
							$fname = $files["name"];
							$fcate = $files["cate"];
							$fhash = $files["fileToken"];
							?>
							<td>
								<?php echo $fname ?>
							</td>
							<td>
								<?php echo  $fcate ?>
							</td>
							<td>
								uploaded
							</td>
							<td>
								<span class="glyphicon glyphicon-remove-sign file-remove <?php echo $fcate.'-castrate' ?>" target="<?php echo $fcate ?>" data="<?php echo $fname.'|'.$fhash ?>" data-role="masterFile" onclick="removeFile(this)"></span>
							</td>
							<?php
						}
						
							?>
						</tr>
						<?php
						
					}
				}

				?>
<!--
								<tr>
									<td>Master.docx</td>
									<td>Manuscript</td>
									<td>Uploaded</td>
									<td><span class="glyphicon glyphicon-remove-sign">

									</span></td>
								</tr>
-->
							</tbody>
   						</table>
   						<form class="uploadFormMan" enctype="multipart/form-data">
   							<input type="file" class="hidden triggerFileOpen" name="FileType">
   							<input type="hidden" value="hiddenMe" name="textHidden" class="targetFileName">
   						</form>
							
   					</div>
   					<div class="row">
   						<form class="uploadForm3" action="" method="post" enctype="multipart/form-data">
   							<input type="hidden" class="manuscriptData" name="manuscriptData">
   							<input type="hidden" class="coverData" name="imageData[]">
   							<input type="hidden" class="OthersData" name="OthersData[]">
							 <input type="reset" value="Clear" name="" class="btn btn-danger btn-reset  reset-Form"/>
							 <input type="submit" value="Continue" name="" class="btn btn-primary"/>
   						</form>
   					</div>
	   			</div>
	   		</div>
	   		
	   		<div class="row reviewDivBox paperForm4">
	   			<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
	   				<div class="row">
	   					<p>
	   						Your file has been uploaded, once it will be approved, a pdf file will be uploaded to your directory. You can track the status of your submission in the track page. 
	   					</p>
	   				</div>
	   				<div class="row reviewSubmitionLink">
	   					<span class="glyphicon glyphicon-file"></span>
	   					<?php
						if(isset($_ManDocuments["manuscript"]))
						{
							$_ManUrl = $_ManDocuments["manuscript"]["url"];
							?>
							<a class="previewManUrl" href="<?php echo $_ManUrl ?>" target="_blank">Preview Document </a>
							<?php
						}
						else
						{
							?>
							<a class="previewManUrl" ="">Preview Document </a>
							<?php
						}
						?>
	   					
	   				</div>
	   				<div class="row">
	   					Submitted Files
	   				</div>
	   				<table class="row table tablePreviewSubmition">
	   					<thead>
	   						<th>Name</th>
	   						<th>Type</th>
	   						<th>Status</th>
	   						<td><b>X</b></td>
	   					</thead>
	   					<tbody class="tableReviewBody">
	   					
	   					
				<?php
				$docs = array("manuscript", "cover", "figures", "others");
				foreach($docs as $key => $docType)
				{
//					echo "checking  $docType <br> ";
					if(isset($_ManDocuments[$docType]) )
					{
//						echo "$docType is ready <br>";
						$files = $_ManDocuments[$docType];
						?>
						<tr>
							<?php
						if($key === 2 || $key === 3)
						{
							
							foreach($files as $fkey => $file)
							{
								if($fkey > 0)
								{
									?>
									</tr>
									<?php
								}
								$fname = $file["name"];
								$fcate = $file["cate"];
								$fhash = $file["fileToken"];
								?>
								<td>
									<?php echo $fname ?>
								</td>
								<td>
									<?php echo $fcate ?>
								</td>
								<td>
									uploaded
								</td>
								<td>
									<span class="glyphicon glyphicon-remove-sign file-remove <?php echo $fcate.'-castrate' ?>" target="<?php echo $fcate ?>" data="<?php echo $fname.'|'.$fhash ?>" data-role="slaveFile" onclick="removeFile(this)"></span>
								</td>
								<?php
								if($fkey > 0)
								{
									?>
									</tr>
									<?php
								}
							}
						}
						else
						{
							$fname = $files["name"];
							$fcate = $files["cate"];
							$fhash = $files["fileToken"];
							?>
							<td>
								<?php echo $fname ?>
							</td>
							<td>
								<?php echo  $fcate ?>
							</td>
							<td>
								uploaded
							</td>
							<td>
								<span class="glyphicon glyphicon-remove-sign file-remove <?php echo $fcate.'-castrate' ?>" target="<?php echo $fcate ?>" data="<?php echo $fname.'|'.$fhash ?>" data-role="slaveFile" onclick="removeFile(this)"></span>
							</td>
							<?php
						}
						
							?>
						</tr>
						<?php
						
					}
				}

				?>
	   					
<!--
	   						<tr>
	   							<td>Maaster.docx</td>
	   							<td>Manuscript</td>
	   							<td>Uploaded</td>
	   						</tr>
	   						<tr>
	   							<td>Maaster.docx</td>
	   							<td>Cover</td>
	   							<td>Uploaded</td>
	   						</tr>
	   						<tr>
	   							<td>image.png</td>
	   							<td>Figure</td>
	   							<td>Uploaded</td>
	   						</tr>
-->
	   					</tbody>
	   				</table>
	   				<div class="row ">
	   					<form class="form agreementForm paperForm4" method="post" action="">
	   						<div class="">
	   							<p>
	   								By Clicking on <b>Finish</b> you agree that you have:-

	   								<ol>
	   									<li>
	   										Followed all respective <b><a href="<?php echo  $url.'authors'?>" target="_blank">guidelines</a></b> during submission
	   									</li>
	   									<li>
	   										Carefully reviewed your submission.
	   									</li>
	   									<li>
	   										Approve it for the consideration by this journal. 
	   									</li>
	   								</ol>
	   							</p>
	   						</div>
	   						
							 <input type="reset" value="Clear" name="" class="btn btn-danger btn-reset  reset-Form"/>
							 <input type="submit" value="Finish" name="" class="btn btn-primary"/>
	   					</form>
	   				</div>
	   			</div>
	   		</div>
	   		
		   </div>
		   <div class="col-lg-2 col-md-2 right-bar">
		   	</div>
		</div>
		   
	</div>
	<div class="col-md-2 col-lg-2"></div>
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
<style>
	@import url("../css/main.css");
	@import url("../css/768.css");
	@import url("../css/footer.css");
	@import url("../css/font-awesome.min.css");
	
</style>
</body>

</html>