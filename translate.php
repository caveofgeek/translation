<meta charset="utf8">
<?php
  require("GTranslate.php");
  error_reporting(E_ALL);
  ini_set('display_error', 1);

  if(isset($_POST['submit'])) {
    $contents = file_get_contents($_FILES["source"]["tmp_name"]);
    $contents = str_split($contents, 800);
    $source = $_POST['source'];
    $target = $_POST['target'];

    try {
      $apikey = 'AIzaSyClJOuVy061SG6Mwvc7mSmqBJtbkab8Tlo';
      $gt = new Gtranslate();
      $gt->setApiKey($apikey);
      //$gt->setRequestType('curl');

      $translated = "";
      $nextround_append = "";
      foreach ($contents as $value) {
        $value = $nextround_append.$value;
        for($i=strlen($value)-1; $i >0 && $value[$i] != "<" ; $i--);
        $nextround_append = substr($value, $i);
        $value = substr($value, 0, $i);
        $translated .= $gt->{$source."_to_".$target}($value);
      }
    }
    catch (GTranslateException $ge) { echo $ge->getMessage(); }
  }
?>
<html>
  <head>
    <style>
      div.wrapper {
        margin-top: 50px;
        width: 480px;
        margin: 0 auto;
        background-color: #aaa;
      }

      div.container {
        padding: 30px;
        margin: 0 auto;
        text-align: center;
      }

      textarea {
        width: 90%;
        margin: 0 auto;
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <div class="container">
        <form action="#" method="post" enctype="multipart/form-data">
          <input type="file" name="source" required/>
          <p>
            <select name="source">
              <option value="thai">ไทย</option>
              <option value="english">อังกฤษ</option>
              <option value="vietnamse">เวียดนาม</option>
            </select>
            To
            <select name="target">
              <option value="thai">ไทย</option>
              <option value="english">อังกฤษ</option>
              <option value="vietnamse">เวียดนาม</option>
            </select>
          </p>
          <input type="submit" name="submit" value="Translate">
        </form>
        <div class="result">
          <p><textarea rows="5"><? echo $translated; ?></textarea></p>
        </div>
      </div>
    </div>
  </body>
</html>