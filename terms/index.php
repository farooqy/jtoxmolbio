<?php
if(!isset($_SESSION["loggedIN"]))
  $loginStatus = "Login";
else
  $loginStatus = "Log out";

$root = $_SERVER["DOCUMENT_ROOT"]."/";
$config = require_once($root."config/config.php");
$url = $config["URL"];
?>
<!DOCTYPE HTML>
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
  </head>
  <body>
    <div class="container">
      <div class="row">
        <?php require_once($root."includes/nav.php"); ?>
      </div>
      <div class="row">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
          
        </div>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
          <div class="row center termspage">
            <h2 class="size-18">
              <b>Terms of Use</b>
            </h2>
          </div>
          <div class="row termsparagraph">
            <p class="p-about ">
              By accessing this web site, downloading, printing, or reading
              any article published in our journal, you are stating that you
              agree to all of the following terms and conditions:
              <li>
                In no event shall the Journal, its publisher, editors or
                anyone involved in the Journal be liable to you or any other
                party on any legal theory, for any special, incidental,
                consequential, punitive, exemplary or any damages whatsoever
                arising out of or in connection with the use of any material
                in this web site or material published in
                the Journal, whether or not advised of the possibility of 
                damage.
              </li>
              <li>
                The content of this web site and the materials published in
                the Journal are provided "as is" without warranty of any
                kind, either expressed or implied, including, but not limited
                to, the implied warranties of merchantability, fitness for a
                particular purpose, non-infringement, accuracy, completeness,
                or absence of errors.
              </li>
              <li>
                Statements or methods presented in the articles are those of
                the authors and do not constitute an endorsement by the
                editors or the publisher. The information contained in the
                articles must not be used as medical or any other advice.
                Nothing in the Journal or on this web site shall be deemed to 
                be a recommendation of, endorsement of, or a representation
                as to a third party's qualifications, services, products, 
                offerings, or any other information or claim.
              </li>
              <li>
                You agree to indemnify and hold the Journal and its editors,
                publisher, and authors harmless from any claim or demand,
                including legal and accounting fees, made by you or any third
                party due to or arising out of your use of this web site,
                your access, reading or transmitting of the Journal articles, 
                or your violation of these Terms of Use.
              </li>
              <li>
                The Journal reserves the right, at its sole discretion, to
                change the terms and conditions of this agreement at any time
                without notice and your access of this web site will be
                deemed to be your acceptance of and agreement to any changed
                terms and conditions.
              </li>
            </p>
          </div>
          <div class="row termsparagraph">
            <p class="p-about">
              As a condition to your use of journal sites, you agree not to:
              <li>
                Upload, post, email, transmit or otherwise make available any
                information, materials or other content that is illegal,
                harmful, threatening, abusive, harassing, defamatory,
                obscene, pornographic or offensive; or that infringes 
                another’s rights, including any intellectual property rights.
              </li>
              <li>
                Impersonate any person or entity or falsely state or
                otherwise misrepresent your affiliation with a
                person or entity; or obtain, collect, store or modify
                personal information about other users
              </li>
              <li>
                Upload, post, email, transmit or otherwise make available any
                unsolicited or unauthorized advertising, promotional
                materials, “junk mail,” “spam,” “chain letters,” “pyramid 
                schemes” or any other form of solicitation.
              </li>
              <li>
                Modify, adapt or hack the journal sites or falsely imply that
                some other site is associated with Journal of Toxicology and
                Molecular Biology site.
              </li>
              <li>
                Use this sites of any API for any illegal purpose. 
                You must not , in the use of the journal sites, API, 
                violate any laws in your jurisdiction.
              </li>
            </p>
          </div>
          <div class="row termsparagraph">
            <h2 class="size-18">
              <b>MODIFICATION OF THE JOURNAL SITES AND TERMS OF USE</b>
            </h2>
          </div>
          <div class="row termsparagraph">
            <p class="p-about">
              Journal of Toxicology and Molecular Biology reserves the right
              to modify or discontinue temporarily or permanently the journal
              sites(or any part thereof) with or without any prior notice.
              You must agree that Journal of Toxicology and Molecular Biology
              shall not be liable to you or to any of third party for any
              modification, suspension or discontinue the site of the
              journal. By using this sites or API, you agree to be bound by
              any such revisions and should therefore periodically visit this
              page to determine the then-current Terms of Use to which you 
              are bound.
            </p>
          </div>
          <div class="row termsparagraph">
            <h2 class="size-18">
              <b>SPECIAL CONSIDERATION FOR INTERNATIONAL USE</b>
            </h2>
          </div>
          <div class="row termsparagraph">
            <p class="p-about">
              Recognizing the global nature of the Internet, you agree to
              comply with all local rules regarding online conduct. 
              Specifically, you agree to comply with all applicable laws
              regarding the transmission of technical data exported from the
              China/India or the country in which you reside.
            </p>
          </div>
          <div class="row termsparagraph">
            <h2 class="size-18">
              <b>INTELLECTUAL PROPERTY RIGHTS</b>
            </h2>
          </div>
          <div class="row termsparagraph">
            <p class="p-about">
              These rights include, without limitation, patents, trademarks,
              trade names, design rights, copyright (including rights in
              computer software), database rights, rights in know-how and 
              other intellectual property rights, in each case whether
              registered or unregistered, which may subsist anywhere in the
              world. The Authorized Users acknowledge that the Electronic
              Products and the Intellectual Property Rights contained therein
              are protected by law. All rights not specifically licensed to
              the Licensee are expressly reserve by Journal of Toxicology and
              Molecular Biology
            </p>
          </div>
          <div class="row termsparagraph">
            <h2 class="size-18">
              <b>Additional Services</b>
            </h2>
          </div>
          <div class="row termsparagraph">
            <p class="p-about">
              In addition Journal of Toxicology and Molecular Biology may
              offer additional services, including optional E-mail Alerting
              Services, which are opted into by registration and may be opted 
              out of at any time. By choosing to take advantage of this and
              other services offered by Journal of Toxicology and Molecular
              Biology Authorized Users consent to the use of their
              information for the purposes of providing these services.
            </p>
          </div>
          <div class="row termsparagraph">
            <h2 class="size-18">
              <b>Use of Cookies</b>
            </h2>
          </div>
          <div class="row termsparagraph">
            <p class="p-about">
              A cookie is a small piece of information that a website puts on
              a hard drive so that it can remember information about a user
              at a later date. In Journal of Toxicology and Molecular Biology
              cookies are used in two ways: as a temporary Session Control
              cookie to validate access privileges and, at the Authorized 
              User's option, as a permanent cookie to facilitate login to
              Journal of Toxicology and Molecular Biology via the Remember Me
              option. Cookies are not used to gather or provide usage
              statistics. By choosing to take advantage of these services,
              Authorized Users consent to the use of their information for 
              the purposes of providing these services.
            </p>
          </div>
          <div class="row termsparagraph">
            <h2 class="size-18">
              <b>Session Control Cookie</b>
            </h2>
          </div>
          <div class="row termsparagraph">
            <p class="p-about">
              Session control cookies are used on most Web sites today
              because they facilitate navigation. In order to use Journal of
              Toxicology and Molecular Biology Authorized Users must have
              their browsers set to accept cookies.
            </p>
            <p class="p-about">
              Once an Authorized User is signed onto Journal of Toxicology
              and Molecular Biology, journal web server uses a temporary
              cookie to help server manage the visit to the service. This
              Session Control Cookie is deleted when the Authorized User
              clicks on the Logout button in Journal of Toxicology and
              Molecular Biology or when the Authorized User quits the
              browser. This cookie allows Wiley to quickly determine access 
              control rights and personal preferences during the online
              session. The Session Control Cookie is set out of necessity and
              not out of convenience.
            </p>
          </div>
          <div class="row termsparagraph">
            <h2 class="size-18">
              <b>Remember Me Cookie</b>
            </h2>
          </div>
          <div class="row termsparagraph">
            <p class="p-about">
              When an Authorized User registers to gain access to Journal of
              Toxicology and Molecular Biology or its personalization
              features, the Authorized User is asked to choose a user name 
              and password. Every time the Authorized User logs into Journal
              of Toxicology and Molecular Biology, he/she will be asked to
              enter this unique user name and password. Authorized Users have
              the option of storing this information on their computers as a
              permanent cookie by selecting the 'Remember Me' option when
              logging in. This feature is optional and user controlled. 
              The Remember Me cookie can be deleted at any time by clicking
              on the Logout button in Journal of Toxicology and Molecular
              Biology. Authorized Users must be careful not to store their
              user name and password as a cookie on any computer that is not
              their own, since doing so would enable other users coming to
              that computer to access online library under their name and to 
              have access to their Journal of Toxicology and Molecular
              Biology My Profile page.
            </p>
          </div>
          <div class="row termsparagraph">
            <h2 class="size-18">
              <b>Warranty Limitations</b>
            </h2>
          </div>
          <div class="row termsparagraph">
            <p class="p-about">
              JOURNAL OF TOXICOLOGY AND MOLECULAR BIOLOGY(JTMB) ONLINE
              LIBRARY AND THE ELECTRONIC PRODUCTS AND ALL MATERIALS CONTAINED
              THEREIN ARE PROVIDED ON AN "AS IS" BASIS, WITHOUT WARRANTIES OF
              ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED
              TO, WARRANTIES OF TITLE, OR IMPLIED WARRANTIES OF 
              MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE; THE USE OF
              THE ELECTRONIC PRODUCTS, JTMB ONLINE LIBRARY AND ALL MATERIALS
              IS AT THE AUTHORIZED USER'S OWN RISK; ACCESS TO JTMB ONLINE
              LIBRARY AND THE ELECTRONIC PRODUCTS MAY BE INTERRUPTED AND MAY
              NOT BE ERROR FREE; AND NEITHER US NOR ANYONE ELSE INVOLVED IN
              CREATING, PRODUCING OR DELIVERING THE ELECTRONIC PRODUCTS OR
              THE MATERIALS CONTAINED IN JTMB ONLINE LIBRARY, SHALL BE LIABLE
              FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, CONSEQUENTIAL OR
              PUNITIVE DAMAGES ARISING OUT OF THE AUTHORIZED USER'S USE OF OR
              INABILITY TO USE JOURNAL ONLINE LIBRARY, THE ELECTRONIC
              PRODUCTS AND ALL MATERIALS CONTAINED THEREIN.
            </p>
          </div>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
          
        </div>
      </div>

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
      .termspage {
        margin-top: 150px;
      }

      .termsparagraph {
        text-align:justify;
        font-family: Times New Roman , Cambria, Hoefler Text, Liberation Serif, Times, serif;
      }
    </style>
  </body>
</html>
