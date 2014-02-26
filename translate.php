<meta charset="utf8">
<?php
  function getSource($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }

  function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
  }

  if(isset($_POST['submit'])) {
    $contents = file_get_contents($_FILES["source"]["tmp_name"]);
    $contents = preg_replace('/<!--.+?-->/s', '', $contents);
    $contents = str_replace(array('\n','\r\n',PHP_EOL),array('','',''), $contents);
    $contents = urlencode($contents);
    $contents = str_split($contents, 100);
    $from = $_POST['from'];
    $to = $_POST['to'];

    /*
    $doc = new DOMDocument();
    $doc->loadHTMLFile('test.html');
    $divs = $doc->getElementsByTagName('div');
    foreach($divs as $n) {
        echo $n->nodeValue;
    }
    */

    foreach ($contents as $value) {
      $url = "http://translate.google.com/translate_a/t?";
      $url .= "client=t&q=$value&hl=$to&sl=$from&tl=$to";
      $url .= "&ie=UTF-8&oe=UTF-8&multires=1&otf=1&pc=1&trs=1&ssel=3&tsel=6&sc=1";

      $translated = getSource($url);
      preg_match('/\[{3}"(.+?)",/', $translated, $translated);
      $translated = str_replace("\\\"", "\"", rtrim($translated[1], "."));

      $whole_word .= $translated;
    }

    $translated = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $whole_word);
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
          <input type="file" name="source" required>
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
          <p><textarea rows="5"><? echo $translated; ?></textarea></p>
        </div>
      </div>
    </div>
  </body>
</html>
