<?php
  $filename = $_POST["filename"];
  header("Content-type: text/html");
  header('Content-Disposition: attachment; filename="'.$filename.'"');
  echo "<meta charset='utf8'>";
  echo $_POST["content"];
?>