function saveData(id, pw){
    localStorage.setItem("id", id);
    localStorage.setItem("pw", pw);
}

function getData(){
    return localStorage.getItem("id");
   
}
function onBaloonclicked(){
    document.getElementById("idtext").value="clicked";
}
var map = null;
var successCallback = function(position2) {
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
}

function errorCallback(error) {
    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
    });
    alert("現在位置情報を取得できひんかったよん！");
}
function initialize(id, pw) {
    saveData(id, pw);
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
}