<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8" />
<title>Mauritius - Fix Speed Cameras</title>
<style type="text/css">
body {
	font: normal 14px Verdana;
	background-color: black;
	background-image: url('files/bg-pic.png');
	background-size: cover;
	color: white;
}
h1 {
	font-size: 28px;
	color: gold;
}
h2 {
	font-size: 18px;
}
table, th, td {
    border: 1px solid gold;
	border-collapse: collapse;
	padding: 10px;
	background-color: white;
	opacity:80%;
	color: red;
}

td:hover {
	color: black;
	background-color: red;
	font-style: italic;
	opacity:100%;
}
</style>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
	
	function makeRequest(url, callback) {
	var request;
	if (window.XMLHttpRequest) {
	request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
	} else {
	request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
	}
	request.onreadystatechange = function() {
	if (request.readyState == 4 && request.status == 200) {
	callback(request);
	}
	}
	request.open("GET", url, true);
	request.send();
	}
	

var map;

var center = new google.maps.LatLng(-20.27953056, 57.50133889);

var geocoder = new google.maps.Geocoder();
var infowindow = new google.maps.InfoWindow();

function init() {

var mapOptions = {
zoom: 10,
center: center,
mapTypeId: google.maps.MapTypeId.ROADMAP
}

map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);


var marker = new google.maps.Marker({
map: map,
position: center,
});

makeRequest('get_locations.php', function(data) {

var data = JSON.parse(data.responseText);

for (var i = 0; i < data.length; i++) {
displayLocation(data[i]);
}
});

}

function displayLocation(location) {

var content =   '<div class="infoWindow"><strong>'  + location.NAME + '</strong>'
+ '<br/>'     + location.LOCATION
+ '</div>';

if (parseInt(location.LATITUDE) == 0) {
geocoder.geocode( { 'address': location.LOCATION }, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {

var marker = new google.maps.Marker({
map: map,
position: results[0].geometry.location,
title: location.NAME
});

google.maps.event.addListener(marker, 'click', function() {
infowindow.setContent(content);
infowindow.open(map,marker);
});
}
});
} else {
var position = new google.maps.LatLng(parseFloat(location.LATITUDE), parseFloat(location.LONGITUDE));
var marker = new google.maps.Marker({
map: map,
position: position,
title: location.NAME
});

google.maps.event.addListener(marker, 'click', function() {
infowindow.setContent(content);
infowindow.open(map,marker);
});
}
}



</script>
</head>
<body onload="init();">

<h1 style="text-align: center;">Fix Speed Cameras in Mauritius</h1>

<section id="sidebar">
<div id="directions_panel"></div>
</section>

<section id="main" style="display: flex; justify-content: center;">
<div id="map_canvas" style="width: 100%; height: 500px;"></div>
</section>

<br>

<section id="table">
	<div id="locations_table" style="display: flex; justify-content: center;">
		
		<?php
		
		$servername = "dashdb-txn-sbox-yp-lon02-02.services.eu-gb.bluemix.net";
		$username = "zgh79455";
		$password = "79rf3rmc+9cg8rk2";
		$dbname = "BLUDB";
		
		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}

		$sql = "SELECT LOCATION, NAME, LATITUDE, LONGITUDE FROM LOCATIONS";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		    echo "<table>
				<tr>
					<th>LOCATION</th>
					<th>NAME</th>
					<th>LATITUDE</th>
					<th>LONGITUDE</th>
				</tr>";

		    while($row = $result->fetch_assoc()) {
		        echo "<tr>
					<td>" . $row["LOCATION"]. "</td>
					<td>" . $row["NAME"]. "</td>
					<td>" . $row["LATITUDE"]. "</td>
					<td>" . $row["LONGITUDE"]. "</td>
				</tr>";
		    }
		    echo "</table>";
		} else {
		    echo "0 results";
		}

		$conn->close();
		?>
		
	</div>
</section>
<br>
<hr>
<br>
<section id="credits">
	<div><h4>Project by:<h4><p>Hitesh Kalisetty-Appadu<br>Leenesh Sooriah<br>Neelesh Keesoondoyal</p></div>
</section>



</body>
</html>