<?php session_start();
$_SESSION["ManInfo"] = null;
unset($_SESSION["ManInfo"]);
echo json_encode(array(
	"errorMessage" => null,
	"successMessage" => "success",
	"isSuccess" => true
));
?>