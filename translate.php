<meta charset="utf8">
<html>
  <body>
    <form action="#" method="post">
      <input type="file" name="input_file" id="input_file">
      <input type="submit" name="submit" value="Translate">
    </form>
  </body>
</html>

<?php
  require("GTranslate.php");
  error_reporting(E_ALL);
  ini_set('display_error',1);

  if(isset($_POST['submit'])){
    $contents = file_get_contents($_POST['input_file']);

    try{
      $gt = new Gtranslate;
      $translated =  $gt->english_to_thai($contents);
    }
    catch (GTranslateException $ge) { echo $ge->getMessage(); }

    echo "<textarea rows='20'>$string</textarea>";
    echo "<textarea rows='20'>$translated</textarea>";
  }
?>