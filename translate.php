<?php
  require("GTranslate.php");
  error_reporting(E_ALL);
  ini_set('display_error', 1);

  if(isset($_GET['file'])){
    $contents = file_get_contents($_GET['file']);
    $contents = str_split($contents, 800);
    $source = $_GET['source'];
    $target = $_GET['target'];
    $output = $_GET['output'];
  }else {
    $contents = file_get_contents($_FILES["source_file"]["tmp_name"]);
    $contents = str_split($contents, 800);
    $source = $_POST['source'];
    $target = $_POST['target'];
  }

  try {
    $apikey = 'AIzaSyClJOuVy061SG6Mwvc7mSmqBJtbkab8Tlo';
    //$apikey = 'PUT YOU API KEY';
    $gt = new Gtranslate();
    $gt->setApiKey($apikey);
    //$gt->setRequestType('curl');

    $translated = "";
    $nextround_append = "";
    foreach ($contents as $value) {
      $value = $nextround_append.$value;
      for($i = strlen($value) - 1;$i > 0 && $value[$i] != "<";$i--);
      $nextround_append = substr($value, $i);
      $value = substr($value, 0, $i);
      $translated .= $gt->{$source."_to_".$target}($value);
    }

    if(isset($_GET['file'])){

      $file = "output/$output";
      file_put_contents($file, "<meta charset='utf8'>$translated");
      echo htmlentities($translated, "UTF-8");
    }else echo $translated;
  }
  catch (GTranslateException $ge) { echo $ge->getMessage(); }
?>
