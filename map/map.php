<?php
require_once '../db/DbAccess.php';
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
        <link rel="stylesheet" href="../css/mapCss.css" type="text/css" />
        <script type="text/javascript"
            src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAXoyzE3QfIexjkyJz9T9WSgMCMtoXK2Ok&sensor=true">
        </script>
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/mapJs.js"></script>
        <script type="text/javascript">
            function onBaloonclicked(){
                document.getElementById("selectFile").style.display="inline";
            }
            var markersArray = [];
            var map = null;
            var latitude;
            var longitude;
            var successCallback = function(position2) {
                latitude = position2.coords.latitude;
                longitude = position2.coords.longitude;
                var latlng = new google.maps.LatLng(position2.coords.latitude, position2.coords.longitude);
                map.setCenter(latlng);
                google.maps.event.addListener(map, 'click', function(event) {
                    placeMarker(event.latLng);
                });
                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: 'Current Location'
                });
                markersArray.push(marker);
                google.maps.event.addListener(marker, 'click', function() {
                    onBaloonclicked();
                });
            };

            function errorCallback(error) {
                google.maps.event.addListener(map, 'click', function(event) {
                    placeMarker(event.latLng);
                });
                alert("現在位置情報を取得できひんかったよん！");
            }
            function initialize() {
                var mapOptions = {
                    center: new google.maps.LatLng(-34.397, 150.644),
                    zoom: 17,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                map = new google.maps.Map(document.getElementById("map_canvas"),
                        mapOptions);

                if (typeof (navigator.geolocation) == 'undefined') {
                    geolocation = google.gears.factory.create('beta.geolocation');
                } else {
                    geolocation = navigator.geolocation;
                }
                var option = {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                };
                geolocation.getCurrentPosition(successCallback, errorCallback, option);
                
                var markers = [
EOL;
    $result = get_image_list($getdata);
    $rows = mysql_num_rows($result);
    
    if($rows){
        while($row = mysql_fetch_array($result)) {
            $src = '"'.$row['imagePath'].'"';
            $html.="['".$row['userName']."<br/><img src=".$src.">',".$row['lat'].",".$row['lon']."],";
        }
    }
$html.=<<< EOL
                ];
                for (var i = 0; i < markers.length; i++) {
                    var name = markers[i][0];
                    var latlng = new google.maps.LatLng(markers[i][1],markers[i][2]);
                    createMarker(latlng,name,map)
                }
            }
            function createMarker(latlng,name,map)
            {
                var infoWindow = new google.maps.InfoWindow();
                var marker = new google.maps.Marker({position: latlng,map: map});
                google.maps.event.addListener(marker, 'click', function() {
                    infoWindow.setContent(name);
                    infoWindow.open(map,marker);   
                });
            } 
        
            function placeMarker(location) {
                latitude = location.latitude;
                longitude = location.longitude;
                var clickedLocation = new google.maps.LatLng(location);
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
                markersArray.push(marker);
                google.maps.event.addListener(marker, 'click', function() {
                    onBaloonclicked();
                });
                // 余分なマーカーを消す
                if (markersArray) {
                    var marker_length = markersArray.length;
                    for (i = 0; i < marker_length - 1; i++) {
                        markersArray.shift().setMap(null);
                    }
                }
            }
        
            function upload(form){
                document.getElementById('lat').value = latitude;
                document.getElementById('lon').value = longitude;
EOL;
                $html.='$form = '."$('#upload-form');";
                $html.='fd = new FormData($form[0]);';
$html.=<<<EOL
                $.ajax(
                        'http://localhost/CatchTheLaugh/api/upload.php',
                {
                    type: 'post',
                    processData: false,
                    contentType: false,
                    data: fd,
                    dataType: "json",
                    success: function(data){
                        alert(data.message);
                        document.getElementById("selectFile").style.display="none";
                    },
                    error: function(XMLHttpRequest,
                    textStatus, errorThrown){
                        alert("error");
                    }
                });
                return false;
            }
        </script>
    </head>
    <body onLoad="initialize()">
        <div id="selectFile">
            <form id="upload-form" method="post" enctype="multipart/form-data" onSubmit="return upload(this);">
                <input type='file' id='file' name='file'/>
                <input type='submit' value='submit'/>
                <input type='hidden' id='lat' name='lat'/>
                <input type='hidden' id='lon' name='lon'/>
                <input type='hidden' id='username' name='username' value='$id'/>
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