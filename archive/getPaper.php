<?php session_start();
$root = $_SERVER["DOCUMENT_ROOT"]."/";
$config = require_once($root."config/config.php");
$url = $config["URL"];
require_once($root."classes/functions.php");
if(isset($_POST["key"]) && isset($_POST["value"]))
{
	
    $errorMessage = null;
    $isSuccess = false;
    $successMessage = null;
    $Data = array();
    $key = Sanitize_String($_POST["key"]);
    $value = explode("|",Sanitize_String($_POST["value"]));
    if($key !== "retreive")
        $errorMessage = "uknown key type";
    else if(is_array($value) === false)
        $errorMessage = "unregonized data type";
    else if(count($value) !== 3)
        $errorMessage = "data length is invalid";
    else
    {
		
        $man_id = $value[0];
        $man_time = $value[1];
        $man_num = $value[2];
        
        require_once($root."classes/SuperClass.php");
        $table = array("journal_main","published_journals", "journal_authors");
        $fields = "
        `journal_main`.id,`journal_main`.submitter, `journal_main`.c_author,title,abstract, keywords,`published_journals`.j_url,
        `published_journals`.j_time, `journal_main`.views 
        ";
        $conditions = "
        `published_journals`.j_id= $man_id AND `journal_main`.id = $man_id 
        AND `published_journals`.j_time = $man_time
        AND `journal_main`.`man_num` = '$man_num'
        ";
        $sortby = "`published_journals`.j_time DESC LIMIT 1";
        $Super_Class = new Super_Class();
        $Paper = $Super_Class->Super_Get($fields, $table, $conditions, $sortby);
        if($Paper === false)
		{
			$errorMessage = "Failed to get the paper : ".$Super_Class->Get_Message();
		}    
        else if(count($Paper) === 0)
		{
			$errorMessage = "The paper you are looking for has been removed or protected. Please contact admin/support";
		}    
        else if(count($Paper) === 1)
        {
			
            $man_id = $Paper[0]["id"];
            $man_title = $Paper[0]["title"];
            $man_abstract = $Paper[0]["abstract"];
            $man_keywords = $Paper[0]["keywords"];
            $man_submitter = $Paper[0]["submitter"];
            $man_cauthor = $Paper[0]["c_author"];
            $man_jurl = $Paper[0]["j_url"];
            $man_time = $Paper[0]["j_time"];
            $man_views = $Paper[0]["views"];
            
            $table = "journal_authors";
            $fields = " id, a_firstName, a_secondName, a_title";
            $conditions = " journal_id = $man_id";
            $sortby = "id";
            $authors = $Super_Class->Super_Get($fields, $table, $conditions, $sortby);
//			$authors = true;
            if($authors === false)
                $errorMessage = "Error getting authors, contact admin/support for assistance ";
            else if(is_array($authors) === false)
                $errorMessage = "The data type of the authors returned is not recognized";
            else
            {
				
                $table = "journal_figures";
                $fields = "*";
                $conditions ="journal_id = $man_id";
                $sortby = "id";
                $Figures = $Super_Class->Super_Get($fields, $table, $conditions, $sortby);
                if($Figures === false)
                    $errorMessage = "Failed to get the paper figures/images, please contact admin/support for assistance";
                else if(is_array($Figures) === false)
                    $errorMessage= "The data type of the figures returned is not recognized";
                else
                {
                    $pAuthors ="";
                    for($i=0; $i<count($authors); $i++)
                    {
                        if(empty($pAuthors))
						{
							 $pAuthors = $authors[$i]["a_title"]." ".$authors[$i]["a_firstName"]." ".$authors[$i]["a_secondName"];
						}  
                        else
						{	
						   $pAuthors = $pAuthors.", ".$authors[$i]["a_title"]." ".$authors[$i]["a_firstName"]." ".$authors[$i]["a_secondName"];
						}
                       
                    }
                    $pFigures = "";
                    for($i=0; $i<count($Figures); $i++)
                     {   
						 $pFigures = $pFigures."<img src=\"".$Figures[$i]["figure_url"]."\" class=\"col-md-4 col-lg-4\">";
                     }
					
                    $Data = array(
                        "man_id" => $man_id,
                        "man_title" => $man_title,
                        "man_abstract" => utf8_encode($man_abstract),
                        "man_keywords" => $man_keywords,
                        "man_authors" => "",
                        "man_figures" => "",
                        "man_jurl" => $man_jurl,
                        "man_time" => format_time($man_time),
                        "man_views" => $man_views,
                        );
					$_SESSION["viewID"] = $man_id;
                    $isSuccess = true;
                    $successMessage = "success";
                }
            }
                    
            
        }
        else
            $errorMessage = "The paper contains invalid length of data. please contact admin/support";
    }
//   	print_r($Data);
$x =  json_encode(
	array(
	"isSuccess"=>$isSuccess,
	"errorMessage"=>$errorMessage,
	"successMessage"=>$successMessage,
	"data"=>$Data
	)
);
	echo $x;
//	echo "something 127";
exit(0);
}
else
{
    echo json_encode(array(
        "isSuccess"=>false,
        "errorMessage"=>"Incomplete request",
        "successMessage"=>null,
        "data"=>null
        ));
        exit(0);
}

?>