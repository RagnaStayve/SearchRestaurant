$(document).ready(function(){
	if(navigator.geolocation){
		navigator.geolocation.getCurrentPosition(
			successCallback, errorCallback, {}
		);
	} else {
		alert("このブラウザは Geolocation をサポートしていません。");
	}
	function successCallback(pos){
		var lat = pos.coords.latitude, lon = pos.coords.longitude, acc = pos.coords.accuracy;
		// alert('Latitude = ' + lat + ', ' + 'Longitude = ' + lon + ' (' + acc + ')');
		document.getElementById("lat").value = lat;
		document.getElementById("lon").value = lon;
	}
	function errorCallback(err){
		alert( err.message + ' (' + err.code + ')' );
	}
	
});

function valueCheck(){
	var lat = document.getElementById('lat').value;
	var lon = document.getElementById('lon').value;
	if(lat == "" || lon == ""){
		alert('緯度・経度を入力してください');
		return false;
	} else {
		return true;
	}
}
