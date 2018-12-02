<?php session_start();
if(!isset($_SESSION["loggedIN"]))
  $loginStatus = "Login";
else
  $loginStatus = "Log out";
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$url = $_SERVER["SERVER_HOST"]."/";

$jquery = $url.'js/jQuery.js';
$bootstrapjs = $url.'bts/js/bootstrap.js';
$mainjs =  $url.'js/main.js';
$homecss = $url.'css/home.css';
$bootstrapmin = $url.'bts/css/bootstrap.min.css';
$boostrapcss = $url.'bts/css/bootstrap.css';
$gen = $url.'css/gens.css';
$Dater = new DateTime("now", new DateTimeZone("Asia/Shanghai"));
?>
<script src="<?php echo $jquery?>"></script>
<script src="<?php echo $bootstrapjs ?>"></script>
<script src="<?php echo $mainjs?>"></script>
<link rel="stylesheet" href="<?php echo $homecss?>">
<link rel="stylesheet" href="<?php echo $bootstrapmin?>">
<link rel="stylesheet" href="<?php echo $boostrapcss?>">
<link rel="stylesheet" href="<?php echo $gen ?>">
<!DOCTYPE HTML>
<html>
  <head>
    <title>Jtoxmolbio | Privacy</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <?php require_once($doc_root."/headers/menuOneWithLogo.php");?>
      </div>
      <div class="row">
        <?php require_once($doc_root."/headers/menuTwo.php");?>
      </div>
      <div class="row">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
          
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
          <div class="row center">
            <h2 class="size-18">
              <b>Privacy Policy</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about ">
             The Journal of Toxicology and Molecular Biology is dedicated to
              protecting your personal information and will make every 
              reasonable effort to handle collected information 
              appropriately. All information collected will be handled with
              care in accordance with journal standards for rectitude and
              objectivity.
            </p>
            <p class="p-about">
              Users are asked to provide the following details for
              registration on website:-
            </p>
            <li>Email, full name, postal address, telephone number</li>
            <li>IP address</li>
            <li>Educational and professional interests and background
              information</li>
            <li>Username and passwords</li>
            <li>Payment information including 3rd party API service</li>
            <li>Communication preference</li>
            <p class="p-about">
              The information is used to provide the service requested by the
              user and to ensure standards of scientific integrity.
            </p>
          </div>
          
          <div class="row ">
            <h2 class="size-18">
              <b>USE OF YOUR INFORMATION</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about">
              The Journal of Toxicology and Molecular Biology may use your
              personal information in the following ways:
            </p>
            <li>To carry out our obligations arising from any contracts
              entered into between you and us and to provide you with
              information about products and services that you request from
              us.</li>
            <li>To send you periodic catalogues from journal, if you have
              consented to receive them.</li>
            <li>To provide you with information about other products, events
              and services we offer that are similar to those you have
              already purchased or inquired about or other communications
              containing information about new products and services or
              upcoming events of ours, our affiliates and non-affiliated 
              third parties such as societies and sponsors, if you have
              consented to receive this information.</li>
            <li>For internal business and research purposes and to help
              enhance, evaluate and develop our websites, products and 
              services and to develop new products and services.</li>
            <li>To notify you about changes or updates to our websites.</li>
            <li>To notify you about changes or updates to our products and
              services if you have consented to receive this information.</li>
            <li>To respond to your requests, inquiries, comments or 
              concerns.</li>
            <li>To administer our services and for internal operations,
              including troubleshooting, data analysis, testing, statistical
              and survey purposes.</li>
            <li>To allow you to participate in interactive features of our
              service, when you choose to do so.</li>
            <li>As part of our efforts to keep our site safe and secure.</li>
            <p class="p-about">
              For any other purpose that we may notify you of from time to
              time, providing that we have sought your consent.
            </p>
          </div>
          <div class="row ">
            <h2 class="size-18">
              <b>Submission and publication of a manuscript</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about">
              Authors are asked to provide the following personal details
              when submitting a manuscript. These details are used to
              facilitate scientific communication. When a manuscript is 
              published, certain details of the first and corresponding
              authors (names, e-mail address, postal address) and all authors
              (names, affiliations) are made available. 
              Visitors to the website and subscribers to our journals can
              view this information.
            </p>
          </div>
          <div class="row ">
            <h2 class="size-18">
              <b>General</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about">
              Information is held for as long as it is relevant, or until you
              request that we remove it. Users may decline to provide
              personal information, but we may not be able to deliver the 
              service requested. Payment for publication and submission is
              carried out via bank transfer or credit card using a third
              party, so we do not collect or store payment information.
            </p>
          </div>
          <div class="row ">
            <h2 class="size-18">
              <b>Disclosure of Information</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about">
             Information about users of the website is not disclosed or sold
              except as described. Information may be disclosed without your
              consent：
              <li>If required by law to law enforcement authorities following
                a reasonable request to prevent, investigate or take action
                against actual or suspected illegal activity, physical harm
                or financial loss if part or all of the company or its assets
                are sold or transferred.</li>
            </p>
          </div>
          <div class="row ">
            <h2 class="size-18">
              <b>Security</b>
            </h2>
          </div>
          <div class="row">
            <p class="p-about">
             The information we collect is kept secure via the use of
              administrative, technical and physical safeguards to protect
              from loss, misuse, unauthorized access, disclosure or
              alteration.
            </p>
          </div>
          
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
          
        </div>
      </div>

    </div>
  </body>
    <footer class="container footer mar-top-10 border-7">
      <?php require_once($doc_root."/includes/footer.php");?>
    </footer>
</html>
