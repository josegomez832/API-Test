<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery.getJSON demo</title>
  <style>
  img {
    height: 100px;
    float: left;
  }
  </style>
</head>
<body>
<div id="results">Stuff</div>
<?php
//http://davidwalsh.name/xbox-api
$request = "https://www.kimonolabs.com/api/4g7bvve6?apikey=OOckE2QltIVVGg3RLMXx9fQque4MWaH6";
$response = file_get_contents($request);
$results = json_decode($response, TRUE);
echo "<pre>";
print_r($results);
echo "</pre>";
?>
<h1><?php echo $results['name']; ?></h1>
<h1><a href="<?php echo $results['results']['collection1']['0']['article_title']['href']; ?>" target="_blank"><?php echo $results['results']['collection1']['0']['article_title']['text']; ?></a></h1>
<p><?php echo $results['results']['collection1']['0']['excerpt']; ?></p>

</body>
</html>