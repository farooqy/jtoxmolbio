<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$config = require_once($root."config/config.php");
$url = $config["URL"];
//if ( isset( $_SESSION[ "admin" ] ) === false ) {
//	header( "Location: $url" . "maintenance" );
//	exit( 0 );
//}

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
  <head>
    
  </head>
  <body>
    <div class="container">
		<div class="row" id="header">
		<?php require($root."includes/nav.php"); ?>
		</div>
  
      <div class="row text-center rua-agreement">
        <h3 class="size-18">
          <b> Registered user Agreement</b>
        </h3>
      </div>
      <div class="row">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
          
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
          <div class="row">
            <p class="p-about">
              This Registered User Agreement ("Agreement") sets forth the
              terms and conditions governing the use of the Journal of
              Toxicology and Molecular Biology websites, online services and
              interactive applications (each, a "Service") by registered
              users. By becoming a registered user, completing the online
              registration process and checking the box "I have read and 
              understand the Registered User Agreement and agree to be bound
              by all of its terms" on the registration page, and using the
              Service, you agree to be bound by all of the terms and
              conditions of this Agreement.
            </p>
            <p class="p-about">
              This Agreement is between you and the journal affiliate that
              owns the respective Service. This Agreement expressly
              incorporates by reference and includes the respective Service's
              Terms and Conditions. In the event of any conflicts or
              inconsistencies between those terms and this Agreement, this
              Agreement will control.
            </p>
            <p class="p-about">
              Please carefully review this Agreement before ticking the
              relevant check box on the registration form. If you do not wish
              to accept this Agreement, do not proceed with the registration.
            </p>
          </div>
          <div class="row">
            <h2 class="size-18">
              <b>Changes</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about">
              Journal of Toxicology and Molecular Biology reserves the right
              to update, revise, supplement and otherwise modify this
              Agreement from time to time. Any such changes will be effective
              immediately and incorporated into this Agreement.
              Registered users are encouraged to review the most current
              version of the Agreement on a periodic basis for changes. 
              Your continued use of a Service following the posting of any
              changes constitutes your acceptance of those changes.
            </p>
          </div>
          <div class="row">
            <h2 class="size-18">
              <b>Password Use and Security</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about">
              You must not reveal your password and must take reasonable
              steps to keep your password confidential and secure.
              You agree to immediately notify Journal of Toxicology and
              Molecular Biology if you become aware of or have reason to
              believe that there is any unauthorized use of your password or
              account or any other breach of security. 
              Journal of Toxicology and Molecular Biology is in no way liable
              for any claims or losses related to the use or misuse of your
              password or account due to the activities of any third party
              outside of our control or due to your failure to maintain their
              confidentiality and security.
            </p>
          </div>
          <div class="row">
            <h2 class="size-18">
              <b>Grant of License</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about">
              As a registered user of a Service, Journal of Toxicology and
              Molecular Biology grants to you a non-transferable,
              non-exclusive and revocable license to use the Service
              according to the terms and conditions set forth in this
              Agreement. Except as expressly granted by this Agreement or
              otherwise by Journal of Toxicology and Molecular Biology or its
              licensors in writing, you acquire no right, title or license in 
              the Service or any data, content, application or materials 
              accessed from or incorporated in the Service.
            </p>
          </div>
          <div class="row">
            <h2 class="size-18">
              <b>Term and Termination</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about">
              The license is effective until it expires, until Elsevier
              terminates it, or until you provide notice to Journal of 
              Toxicology and Molecular Biology of your decision to terminate
              it. Your rights under this license will terminate automatically
              without notice to you if you fail to comply with any of the
              provisions of this Agreement. Journal of Toxicology and
              Molecular Biology reserves the right to suspend, discontinue or 
              change a Service, or its availability to you, at any time
              without notice. Upon termination of the license to a Service,
              you shall cease all use of the Service.
            </p>
          </div>
          <div class="row">
            <h2 class="size-18">
              <b>No Assignment</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about size-18">
              THIS AGREEMENT IS PERSONAL TO YOU, AND YOU MAY NOT ASSIGN YOUR
              RIGHTS OR OBLIGATIONS TO ANYONE.
            </p>
          </div>
          <div class="row">
            <h2 class="size-18">
              <b>No Waiver</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about ">
              Neither failure nor delay on the part of Journal of Toxicology
              and Molecular Biology to exercise or enforce any right, remedy,
              power or privilege hereunder nor course of dealing between the
              parties shall operate as a waiver thereof, or of the exercise
              of any other right, remedy, power or privilege.
              No term of this Agreement shall be deemed waived, and no breach
              consented to, unless such waiver or consent shall be in writing
              and signed by the party claimed to have waived or consented. 
              No waiver of any rights or consent to any breaches shall 
              constitute a waiver of any other rights or consent to any other
              breach.
            </p>
          </div>
          <div class="row">
            <h2 class="size-18">
              <b>Severability</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about ">
              If any provision in this Agreement is held invalid or
              unenforceable under applicable law, the remaining 
              provisions shall continue in full force and effect.
            </p>
          </div>
          <div class="row">
            <h2 class="size-18">
              <b>Governing Law an Venue</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about ">
              This Agreement will be governed by and construed in accordance
              with the laws of the Nanjing, China, without regard to
              conflicts of law principles, The exclusive jurisdiction and
              venue with respect to any action or suit arising out of or
              pertaining to this Agreement shall be the courts of competent 
              jurisdiction located in Nanjing, China, except if you reside 
              outside of the China, then the journal will not responsible any
              of matter. This Agreement will not be governed by the United 
              Nations Convention on Contracts for the International 
              Sale of Goods.
            </p>
          </div>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
          
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