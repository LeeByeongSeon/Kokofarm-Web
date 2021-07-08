<?
    $title = $_REQUEST["title"];
?>

<html lang="en-us">
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
	    <link rel="stylesheet" type="text/css" media="screen" href="../../common/library/bootstrap/bootstrap.min.css">
    </head>

    <body>
        <div id="camera_popup">
            <div style="width:120px; padding:5px" class="center-block">
                <button class="btn btn-primary" type="button" onClick="zoom('+')">확대</button>
                <button class="btn btn-default" type="button" onClick="zoom('-')">축소</button>
            </div>
        </div>
        <img class="img-responsive center-block" id="camera_img" src="../images/noimage.jpg" style="opacity: 1.0; filter: alpha(opacity=100); margin:auto">
    </body>
</html>

<script language="javascript">
    //let img_obj = document.getElementById("camera_img");

    var now_zoom = 100;

    document.addEventListener("DOMContentLoaded", function(){
        let img_obj = document.getElementById("camera_img");
        opener.camera_load(img_obj);

        //opener.camera_stream(img_obj);
    });

    function zoom(comm){
        switch(comm){
            case "+":
                now_zoom += now_zoom <= 490 ? 10 : 0
                break;

            case "-":
                now_zoom -= now_zoom >= 60 ? 10 : 0
                break;
        }

        document.getElementById("camera_img").style.zoom = now_zoom + "%";
    };

</script>