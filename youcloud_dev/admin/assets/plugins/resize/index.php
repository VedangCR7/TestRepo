<html>
<head>
<title>How to Crop Image using jQuery</title>
<link rel="stylesheet" href="jquery.Jcrop.min.css" type="text/css" />
<script src="jquery.min.js"></script>
<script src="jquery.Jcrop.min.js"></script>

<style>
body {
    width: 550px;
    font-family: Arial;
}

input#crop {
    padding: 5px 25px 5px 25px;
    background: lightseagreen;
    border: #485c61 1px solid;
    color: #FFF;
    visibility: hidden;
}

#cropped_img {
    margin-top: 40px;
}
</style>
</head>
<body>
    <div>
        <img src="original-image.jpeg" id="cropbox" class="img" /><br />
    </div>
    <div id="btn">
        <input type='button' id="crop" value='CROP'>
    </div>
    <div>
        <img src="#" id="cropped_img" style="display: none;">
    </div>
    <script type="text/javascript">
  $(document).ready(function(){
        var size;
        $('#cropbox').Jcrop({
          aspectRatio: 1,
          onSelect: function(c){
           size = {x:c.x,y:c.y,w:c.w,h:c.h};
           $("#crop").css("visibility", "visible");     
          }
        });
     
        $("#crop").click(function(){
            var img = $("#cropbox").attr('src');
            $("#cropped_img").show();
            $("#cropped_img").attr('src','image-crop.php?x='+size.x+'&y='+size.y+'&w='+size.w+'&h='+size.h+'&img='+img);
        });
  });
</script>
</body>
</html>