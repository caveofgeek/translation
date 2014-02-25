<?php
  require("GTranslate.php");
  error_reporting(E_ALL);
  ini_set('display_error', 1);

  if(isset($_POST['submit'])) {
    $contents = file_get_contents($_POST['input_file']);

    try {
      # $apikey = 'AIzaSyClJOuVy061SG6Mwvc7mSmqBJtbkab8Tlo';
      $gt = new Gtranslate();
      # $gt->setApiKey($apikey);

      if($_POST['from'] == "th" && $_POST['to'] == "en")
        $translated =  $gt->thai_to_english($contents);
      elseif($_POST['from'] == "th" && $_POST['to'] == "vi")
        $translated =  $gt->thai_to_vietnamse($contents);
      elseif($_POST['from'] == "en" && $_POST['to'] == "th")
        $translated =  $gt->english_to_thai($contents);
      elseif($_POST['from'] == "en" && $_POST['to'] == "vi")
        $translated =  $gt->english_to_vietnamse($contents);
      elseif($_POST['from'] == "vi" && $_POST['to'] == "th")
        $translated =  $gt->vietnamse_to_thai($contents);
      elseif($_POST['from'] == "vi" && $_POST['to'] == "en")
        $translated =  $gt->vietnamse_to_en($contents);
    }
    catch (GTranslateException $ge) { echo $ge->getMessage(); }
  }
?>

<meta charset="utf8">
<html>
  <head>
    <style>
      div.wrapper {
        margin-top: 50px;
        width: 480px;
        margin: 0 auto;
        background-color: #aaa;
      }

      form.container {
        padding: 30px;
        margin: 0 auto;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <form action="#" method="post" class="container">
        <input type="file" name="input_file" id="input_file" required/>
        <p>
          <select name="from">
            <option value="th">ไทย</option>
            <option value="en">อังกฤษ</option>
            <option value="vi">เวียดนาม</option>
          </select>
          To
          <select name="to">
            <option value="th">ไทย</option>
            <option value="en">อังกฤษ</option>
            <option value="vi">เวียดนาม</option>
          </select>
        </p>
        <input type="submit" name="submit" value="Translate">
      </form>
      <div class="result">
        <p><? echo $translated; ?></p>
      </div>
    </div>
  </body>
</html>
