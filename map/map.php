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
    <script type="text/javascript" src="../js/mapJs.js"></script>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map_canvas { height: 100% }
    </style>
    <script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAXoyzE3QfIexjkyJz9T9WSgMCMtoXK2Ok&sensor=true">
    </script>
    <script type="text/javascript">
      function initialize(id, pw) {
        saveData(id, pw);
        var mapOptions = {
          center: new google.maps.LatLng(-34.397, 150.644),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),
            mapOptions);
      }
    </script>
    </head>
    <body onLoad="initialize('$id', '$pw')">
        <form action='./map.php' method='post'>
            <input type='file' id='file' name='file'/>
            <input type='submit' value='submit'/>
        </form>
        <div id="map_canvas" style="width:100%; height:100%"></div>
        <input type='text' id='idtext'/>
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