$( document ).ready(function() {
  var filename, content;

  $("a#swap").click(function(){
    event.stopPropagation();
    event.preventDefault();
    var source = $("select#source");
    var target = $("select#target");
    var tmp = source.val();
    source.val(target.val());
    target.val(tmp);
  });

  $("input#source_file").change(function(e){
    size = (this.files[0].size/1024).toFixed(2);
    var name = this.files[0].name+" <i>"+size+" kb</i>";
    $("p#sourcefile").html(name);
    filename = this.files[0].name;
  });

  $("a#download").hover(function(){
    $("a#download").tooltip('toggle');
  });

  $('input#submit').click(function(){
    event.stopPropagation();
    event.preventDefault();
    var formData = new FormData($('form#file')[0]);

    $.ajax({
      url: 'translate.php',  //Server script to process data
      type: 'POST',
      //Ajax events
      beforeSend: showProgessBar,
      success: computeTranslate,
      // Form data
      data: formData,
      //Options to tell jQuery not to process data or worry about content-type.
      cache: false,
      contentType: false,
      processData: false
    });
  });

  $('button#download').click(function(){
    $("form#download").submit();
  });

  function showProgessBar(e) {
    $("form#file").css("border-bottom", "1px solid #eee");
    $("div.progress").fadeIn();
    $("form#download").hide();
  }

  function computeTranslate(data){
    $("div.progress").hide();
    var name = $("select#target").val()+"_"+filename;
    $("input#download-name").val(name);
    $("input#download-content").val(data);
    $("form#download").fadeIn();
  }
});