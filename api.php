<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery.getJSON demo</title>
  <style>
  html, body,  { height: 100%; margin: 0; padding: 0;}
  img {
    height: 100px;
    float: left;
  }
  #map-canvas{
  	width:50%;
  	height:400px;
  }
  </style>
  
</head>
<body>
<?php
//http://davidwalsh.name/xbox-api
$client_id = '9544d2a52af545ea911ea49e6c17e3a1';
$client_secret = '4a95cc1c09664b16b0ed17d105144d85';
$request = "https://api.instagram.com/v1/media/search?lat=29.817178&lng=-95.4012915&client_id=".$client_id;
$response = file_get_contents($request);
$results = json_decode($response, TRUE);
echo '<div style="height:800px;overflow:scroll;">';
echo "<pre>";
print_r($results);
echo "</pre>";
echo '</div>';
?>
<div id="map-canvas"></div>
<h1>Hashtag</h1>
<ul>
<?php foreach($results['data'] as $info){ ?>
<li style="display:inline-block;width:150px;margin:40px;">
	
<p><a href="<?php echo $info['link']; ?>" target="_blank"><?php echo $info['caption']['text']; ?></a></p>
<img src="<?php echo $info['images']['standard_resolution']['url']; ?>" /><p><?php echo $info['user']['username']; ?></p>
	<p>
	<?php foreach($info['tags'] as $tags){ ?>
		<strong>#<?php echo $tags; ?></strong>, 
	<?php } ?>
	</p></li>
<?php }?>
</ul>
</div>



<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKB7Oy4gwlex36Tm9Pq676FR6C8fwJq7k"></script>
  <script type="text/javascript">
      function initialize() {
      	var instgram_location = new google.maps.LatLng(<?php echo $results['data'][0]['location']['latitude']; ?>,<?php echo $results['data'][0]['location']['longitude']; ?>);
      	var styles = [
			  {
			    stylers: [
			      { hue: "#00ffe6" },
			      { saturation: -20 }
			    ]
			  },{
			    featureType: "road",
			    elementType: "geometry",
			    stylers: [
			      { lightness: 100 },
			      { visibility: "simplified" }
			    ]
			  },{
			    featureType: "road",
			    elementType: "labels",
			    stylers: [
			      { visibility: "off" }
			    ]
			  }
			];
		var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});
        var mapOptions = {
          center: instgram_location,
          zoom: 12,
          mapTypeControlOptions: {
     		 mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
    		}
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions );
         	map.mapTypes.set('map_style', styledMap);
  			map.setMapTypeId('map_style');
        var marker = new google.maps.Marker({
      		position:instgram_location,
      		map:map,
      		title: "<?php echo $results['data'][0]['location']['name'];?>"
      	});
      	var homeWindow = new google.maps.InfoWindow({
      		content: "<?php echo $results['data'][0]['location']['name'];?>"
      	});
  		google.maps.event.addListener(marker, 'click', function() {
      	homeWindow.open(map, marker);
      	map.getBounds()
  		console.log(map.getBounds());

  		});

      }
      
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</body>
</html>