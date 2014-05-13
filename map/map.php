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
        <style type="text/css">
            html { height: 100% }
            body { height: 100%; margin: 0; padding: 0 }
            #map_canvas { height: 100% }
        </style>
    </head>
    <body onLoad="initialize('$id', '$pw')">
        <form action='./map.php' method='post'>
            <input type='file' id='file' name='file'/>
            <input type='submit' value='submit'/>
        </form>
        <input type='textarea' id='idtext' readonly="readonly"/>
        <div id="map_canvas" style="width:100%; height:100%"></div>
        <script>
            var id = getData();
            document.getElementById("idtext").value=id;
        </script>
    </body>
</html>          
                    
EOL;
if (md5($id) === $eid) {
    session_destroy();
    
    
    echo $html;
} else {
    echo 'out';
}
?>