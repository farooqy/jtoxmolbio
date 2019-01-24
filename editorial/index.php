<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$config = require_once($root."config/config.php");
$url = $config["URL"];

require_once($root."classes/SuperClass.php");
$Super_Class = new Super_Class();
$table = array("editors", "roles");
$fields = "`editors`.*, `roles`.role_name";
$condtion = "`editors`.`role_id` = `roles`.`role_id` AND `roles`.role_status = 'active' AND `editors`.`ed_status` = 'active'";
$sortby = "`editors`.role_id, `editors`.`role_index`";
$editorsList = $Super_Class->Super_Get($fields, $table, $condtion, $sortby);

if($editorsList === false)
{
	$errorMessage = "Failed to get the list of editors. Please contact support";
	$editorsList = null;
	unset($editorsList);
}
else if(is_array($editorsList) === false)
{
	$errorMessage = "The list of editors returned is not of valid type";
	$editorsList = null;
	unset($editorsList);
}
$editorialPage = true;
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
	<div class="row editorDiv">
		<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 editorBox">
			<div class="row">
				
				<?php
	if(isset($errorMessage))
	{
		?>
				<div class="row  mar-top-90 displayError" style="display: block">
					<?php echo $errorMessage ?>
				</div>
	
	<?php
	}
	else if(isset($editorsList) && is_array($editorsList))
	{
		
		$passedRoles = array();
		foreach($editorsList as $edKey => $editor)
		{
			$roleId = $editor["role_id"];
			$edRole = $editor["role_name"];
			if(in_array($roleId, $passedRoles) === false)
			{
				if($edKey > 0)
				{
					$openTable = false;
					?>
				</body>
			</table>
				<?php
				}
				?>
				<div class=" roleTitle">
					<?php echo $edRole ; $openTable = true;?>
				</div>
				<table class="table editorDetails">
					<thead>
						<th>Name</th>
						<th>Email</th>
						<th>Institute</th>
						<th>Department</th>
						<th>Location</th>
					</thead>
					<tbody>
	<?php
					array_push($passedRoles, $roleId);
			}
			$edName = $editor["ed_title"]." ".$editor["ed_name"];
			$edEmail = $editor["ed_email"];
			$edLocation = $editor["ed_location"];
			$edInstitute = $editor["ed_institute"];
			$edDepartment = $editor["ed_department"];
				?>
					<tr>
						<td><?php echo $edName  ?></td>
						<td><?php echo $edEmail  ?></td>
						<td><?php echo $edInstitute ?></td>
						<td><?php echo $edDepartment ?></td>
						<td><?php echo $edLocation ?></td>
					</tr>
	<?php
		}
		if(isset($openTable) && $openTable === true)
		{
			?>
					</tbody>
		</table>
						<?php
		}
		?>
	<?php
	}
	?>
				
			</div>
		</div>
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