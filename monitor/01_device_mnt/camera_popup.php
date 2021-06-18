<?
    $title = $_REQUEST["title"];
?>

<html lang="en-us">
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    </head>

    <body>
        <div id="camera_popup">
            <img id="camera_img" src="../images/noimage.jpg" style="opacity: 1.0; filter: alpha(opacity=100);">
        </div><!--modal -->
    </body>
</html>

<script language="javascript">
    //let img_obj = document.getElementById("camera_img");

    document.addEventListener("DOMContentLoaded", function(){
        let img_obj = document.getElementById("camera_img");
        opener.camera_load(img_obj);
    });

</script>
