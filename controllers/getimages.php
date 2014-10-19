<html>
	<head>
		<link type="text/css" rel="stylesheet" href="../content/stylesheet.css"/>
		<title>Byld</title>
	</head>

<body>
	<div id = "head">	
			<form action = "../controllers/getimages.php" method = "GET">
				<input name = "string" type="search" placeholder="Translate" >
			</form>
 			<ul>
 				<a href = "../views/about.html"><li>About Site</li></a>
 				<a href = "../views/index.html"><li>Let's Begin</li></a>
 			</ul>
		</div>
<form action = "<?php echo $_SERVER["PHP_SELF"]; ?>" method = "post">
<?php
$searchedstring = "";
$word;
$url;
$urls = [];
$first = 1; //checking first iteration in printing. 1 = yes.
$badimage = 1; 		//variable for storing bad image index. initializing to a random acceptable value. no logic
$i; //index fot the for loop.
$no = 0; // image no to retireve from the api.
$commons = ["he","hello","how","me","she","what","when","who","is"];
$subarray = []; //helper array for matching.
$flag = 0;

if ($_SERVER["REQUEST_METHOD"] == "GET"){
	
	//echo "you submitted something bro.";
	if(empty($_GET["string"])){
		echo " empty! ";
	}
	else{
		$words = (explode(" ",$_GET["string"]));
		//print_r($words);
		//count($words)
		for($i = 0;$i < count($words);$i++){
			foreach ($commons as $subarray)
			{
				$flag = 0;
				//print_r($subarray);
				//echo $words[$i];
				//echo strcmp($words[$i], $subarray); 
			   if(strcmp($words[$i], $subarray) == 0){
			   
			      $url = "../content/pics/".$words[$i].".jpg";//retireve photo from folder.
			      break;
			   }
			   else{
			 		$flag = 1;  		
			   }
			}
			
			if($flag == 1){
				$url = get_image($words[$i],0);
			}
			array_push($urls,$url);
		}
		
		
		printing($first,$words,$urls,$badimage);
		$first = 1;
	}
	

}

function printing($first,$words,$urls,$badimage){
	$i;
	$url;
	$no = 0;
	echo "<br><br><br><br><br>";
	for($i = 0;$i < count($words);$i++){
			if($first == 1){
				echo "<img src = '".$urls[$i]."' alt = 'image not found. its probably blocked!!' width = '304' height = '228'>";
				if($i != count($words) - 1){
					echo "<img src = '../content/plus.png' alt = 'image not found. its probably blocked!!' width = '210' height = '210'>";
				}
			}
			else{
				if($i == $badimage-1){
					$no = random_number();
					$url = get_image($words[$i],$no);
					echo "<img src = '".$url."' alt = 'image not found. its probably blocked!!' width = '304' height = '228'>";
				}
			}
		}
		//echo $urls[1];
		//echo "<img src = '".$urls[1]."' alt = 'blah' width = '300' height = '200'>";
}

function get_image($word,$no){
	//echo $word;
	$url = "https://ajax.googleapis.com/ajax/services/search/images?" .
	       "v=1.0&q=$word&userip=INSERT-USER-IP";

	// sendRequest
	// note how referer is set manually
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_REFERER, "http://127.0.0.1/GoogleImageAPI/image.php");
	$body = curl_exec($ch);
	curl_close($ch);
	//print_r($body);
	
	// now, process the JSON string
	$json = json_decode($body);
	return $json->responseData->results[$no]->unescapedUrl;
	// now have some fun with the results...

	//print_r($json["results"]);
	//$result = get_object_vars($json)
	//print_r($result);
	//echo $json["responseData"]["results"][0]["unescapedUrl"];

}

function random_number(){
	return rand(0,3);
}

?>


</body>
</html>
