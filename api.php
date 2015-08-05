<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery.getJSON demo</title>
  <style>
  html, body,  { height: 100%; margin: 0; padding: 0;}
  img.img,a img.img {
    height: auto;
    width:100%;
    float: left;
  }
  a img.img{
    display: block;
  }
  ul{
    margin:0;
    padding:0;
    width:100%;
    display: block;
  }
  ul li{
    width:25%;
    margin:0;
    display: inline-block;
  }
  #map-canvas{
  	width:50%;
  	height:400px;
  }
  </style>
  <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  <script src="moment.js"></script>
  <script src="livestamp.js"></script>
  <script src="Chart.min.js"></script>
</head>
<body>
<?php
    /*
        To create your own client id, client secret and token visit https://instagram.com/developer/
        Then go to Manage Clients
        Register a New Client
        Use "http://localhost" as your website uri and redirect uri
        new id and secret should be given to you
        to get token visit https://api.instagram.com/oauth/authorize/?client_id=CLIENT-ID&redirect_uri=REDIRECT-URI&response_type=token
        Replace CLIENT_ID with your id and REDIRECT-URI with http://localhost, press enter and should redirect to you a url with your token
    */
    //http://davidwalsh.name/xbox-api
    $client_id = '9544d2a52af545ea911ea49e6c17e3a1';
    $client_secret = '4a95cc1c09664b16b0ed17d105144d85';
    $token = "31266149.9544d2a.8030b2bbca864d009801eab4646ff5c2";
    //http://jelled.com/instagram/access-token
    //if getting a 403 error visit https://teamtreehouse.com/forum/oauth-error-403

    //Need to create lat and lng as variables
    $request = "https://api.instagram.com/v1/media/search?lat=29.817178&lng=-95.4012915&client_id=".$client_id;
    $response = file_get_contents($request);
    $results = json_decode($response, TRUE);
    echo '<div style="height:400px;overflow:scroll;">';
    echo "<pre>";
    //print_r($results);
    echo "</pre>";
    echo '</div>';
 
?>
<div id="map-canvas"></div>
<div class="tags"></div>
  <h1>Hashtag</h1>
  <ul>
    <?php foreach($results['data'] as $info){ ?>
    <li>	
      <span data-livestamp="<?php echo $info['created_time']; ?>"></span>
      <a href="<?php echo $info['link']; ?>" target="_blank">
        <img src="<?php echo $info['images']['standard_resolution']['url']; ?>" class="img" />
      </a>
      <img src="https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678087-heart-128.png" width="25px" height="25px" />
      <h4><?php echo $info['likes']['count']; ?></h4>
	   <p>
	     <?php //foreach($info['tags'] as $tags){ 
		      //<strong>#<?php echo $tags; </strong>, 
	    //} ?>
	</p></li>
<?php }?>
</ul>
</div>
<div id="canvas-holder">
      <canvas id="chart-area" width="300" height="300"/>
    </div>
<script type="text/javascript">

  var interval = setInterval(function(){
    refresh_box()}, 1000);
  function refresh_box() {
    $(".tags").load('tags.php');
  }

</script>

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
      		title: ""
      	});
      	var homeWindow = new google.maps.InfoWindow({
      		content: "<img src='<?php echo $results['data'][0]['images']['thumbnail']['url'];?>' />"
      	});
  		google.maps.event.addListener(marker, 'click', function() {
      	homeWindow.open(map, marker);
      	

  		});

      }
      
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script>

    var pieData = [
        {
          value: <?php echo $results['data'][0]['likes']['count'];?>,
          color:"#F7464A",
          highlight: "#FF5A5E",
          label: "<?php echo $results['data'][0]['user']['username'];?>"
        },
        {
          value: <?php echo $results['data'][1]['likes']['count'];?>,
          color: "#46BFBD",
          highlight: "#5AD3D1",
          label: "<?php echo $results['data'][1]['user']['username'];?>"
        },
        {
          value: <?php echo $results['data'][2]['likes']['count'];?>,
          color: "#FDB45C",
          highlight: "#FFC870",
          label: "<?php echo $results['data'][2]['user']['username'];?>"
        },
        {
          value: <?php echo $results['data'][3]['likes']['count'];?>,
          color: "#949FB1",
          highlight: "#A8B3C5",
          label: "<?php echo $results['data'][3]['user']['username'];?>"
        },
        {
          value: <?php echo $results['data'][4]['likes']['count'];?>,
          color: "#4D5360",
          highlight: "#616774",
          label: "<?php echo $results['data'][4]['user']['username'];?>"
        }

      ];

      window.onload = function(){
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myPie = new Chart(ctx).Pie(pieData);
      };



  </script>
</body>
</html>