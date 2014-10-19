<?php
$url = "https://ajax.googleapis.com/ajax/services/search/images?" .
       "v=1.0&q=pen&userip=INSERT-USER-IP";

// sendRequest
// note how referer is set manually
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, "http://localhost/GoogleImageAPI/image.php");
$body = curl_exec($ch);
curl_close($ch);

// now, process the JSON string
$json = json_decode($body);
// now have some fun with the results...


print_r($json);


?>