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
        <!-- <div id="camera_popup">
            <div style="width:120px; padding:5px" class="center-block">
                <button class="btn btn-primary" type="button" onClick="zoom('+');">확대</button>
                <button class="btn btn-default" type="button" onClick="zoom('-');">축소</button>
            </div>
        </div> -->
        <img class="img-responsive" id="camera_img" src="../images/noimage.jpg" style="opacity: 1.0; filter: alpha(opacity=100); margin:auto">

        <div class="text-center pt-2">
            <button class="btn btn-danger" type="button" onClick="end();">닫기</button>
        </div>
    </body>
</html>

<script language="javascript">

    //var now_zoom = 100;

    document.addEventListener("DOMContentLoaded", function(){
        let img_obj = document.getElementById("camera_img");
        opener.camera_load(img_obj);
    });

    // function zoom(comm){
    //     switch(comm){
    //         case "+":
    //             now_zoom += now_zoom <= 490 ? 10 : 0
    //             break;

    //         case "-":
    //             now_zoom -= now_zoom >= 60 ? 10 : 0
    //             break;
    //     }

    //     document.getElementById("camera_img").style.zoom = now_zoom + "%";
    // };

    function end(){
        let img_obj = document.getElementById("camera_img");
        opener.camera_close(img_obj);
    };

</script>
