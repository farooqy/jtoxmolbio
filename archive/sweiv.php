<?php
if(isset($_POST["paper"]) && isset($_POST["type"]))
{
  $paper = $_POST["paper"];
  $views = $_POST["type"];
  $paper = filter_var($paper, FILTER_VALIDATE_INT);
  if($paper && $views === "sweiv")
  {
    require_once("../classes/journal.php");
    $Journal = new journal();
    $is_viewed = $Journal->update_views($paper);
    if($is_viewed === false)
    {
      echo json_encode(array(false, $Journal->get_message()));
      exit(0);
    }
    else
    {
      echo json_encode(array(true, "success"));
      exit(0);
    }
  }
  else
  {
    echo json_encode(array(false, "INVALID DATA"));
    exit(0);
  }
}
else
{
  echo json_encode(array(false, "INVALID REQUEST"));
  exit(0);
}
?>
