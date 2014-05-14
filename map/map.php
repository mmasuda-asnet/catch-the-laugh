<?php
session_start();
$id = $_SESSION['id'];
$eid = $_SESSION['eid'];
$getdata = $_GET['id'];
$pw = $_SESSION['pw'];
$html = <<< EOL
               <!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <script type="text/javascript"
            src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAXoyzE3QfIexjkyJz9T9WSgMCMtoXK2Ok&sensor=true">
        </script>
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/mapJs.js"></script>
        <link rel="stylesheet" href="../css/mapCss.css" type="text/css" />
    </head>
    <body onLoad="initialize('$id', '$pw')">
        <div id="selectFile">
            <form id="upload-form" method="post" enctype="multipart/form-data" onSubmit="return upload(this);">
                <input type='file' id='file' name='file'/>
                <input type='submit' value='submit'/>
                <input type='hidden' id='lat'/>
                <input type='hidden' id='lon'/>
                <input type='hidden' id='username' value='$id'/>
            </form>
            <input type='textarea' id='idtext' readonly="readonly"/>
        </div>
        <div id="map_canvas" style="width:100%; height:100%"></div>
        <script>
            var id = getData();
            document.getElementById("idtext").value=id;
        </script>
    </body>
</html>          
                    
EOL;
if (md5($id) === $eid) {
//    session_destroy();
    
    
    echo $html;
} else {
    echo 'out';
}
?>