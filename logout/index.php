<?php session_start();

$url = "http://jtoxmolbio/";

$_SESSION["isLoggedIn"] = false;
$_SESSION["veriftoken"] = null;
$_SESSION["email"] = null;
$_SESSION["fullname"] = null;
$_SESSION["country"] = null;
$_SESSION["institute"] = null;
$_SESSION["department"] =null;

$_SESSION["ManInfo"] = null;

unset($_SESSION["isLoggedIn"]) ;
unset($_SESSION["veriftoken"]);
unset($_SESSION["email"]) ;
unset($_SESSION["fullname"]);
unset($_SESSION["country"]) ;
unset($_SESSION["institute"]) ;
unset($_SESSION["department"]);
unset($_SESSION["ManInfo"]);

header("Location: $url");
exit(0);
?>