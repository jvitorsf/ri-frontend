<?php
$url = "trabalhori-jvitorsf.rhcloud.com/search";
$query = $_POST['query'];

// create a new cURL resource
$ch = curl_init();
$fields = array(
	'query' => urlencode($query)
);

//url-ify the data for the POST
foreach($fields as $key=>$value) {
	$fields_string .= $key.'='.$value.'&';
}
rtrim($fields_string, '&');

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

// grab URL and pass it to the browser
$json = curl_exec($ch);
$json = utf8_encode($json);
// close cURL resource, and free up system resources
curl_close($ch);


$obj = json_decode($json, true);

$google = $obj["google"];
$bing = $obj["bing"];

// var_dump($bing);

$googleResult;
$bingResult;
$response;

foreach ($google as $key => $value) {
	$googleResult[$key]['href'] = $value['href'];
	$googleResult[$key]['description'] = $value['description'];
	$googleResult[$key]['title'] = $value['title'];
}

foreach ($bing as $key => $value) {
	$bingResult[$key]['href'] = $value['Url'];
	$bingResult[$key]['description'] = $value['Description'];
	$bingResult[$key]['title'] = $value['Title'];
}
$count;
if (count($googleResult) > count($bingResult)) {
	$count = count($bingResult) - 1;
}else{
	$count = count($googleResult) - 1;
}


$arquivo;
$response = array();


for ($i=0; $i <= $count ; $i++) { 
	if (!jaCadastrado($google[$i]['href'], $response)) {
		array_push($response, $google[$i]);
	}

	if (!jaCadastrado($bing[$i]['href'], $response)) {
		array_push($response, $bing[$i]);
	}
	unset($google[$i]);
	unset($bing[$i]);
}

// foreach ($google as $key => $value) {
// 	array_push($response, $google);
// 	unset($google[$key]);
// }

// foreach ($bing as $key => $value) {
// 	array_push($response, $bing);
// 	unset($bing[$key]);
// }

// $google = array_values($google);
// $bing = array_values($bing);
// $response = array_values($response);

$html = "";
foreach ($response as $key => $value) {
	 $html .= '<div class="result">
            <h2><a href="' . $response[$key]["href"] . '">' . utf8_decode($response[$key]["title"]) . '</a></h2>
            <p>' . utf8_decode($response[$key]["description"]) . '</p>
          </div>
          <hr>';
}
$total = count($response);
header('Content-Type: application/json');
echo json_encode(array('html' => $html, 'total' => $total));

function jaCadastrado($link, $v1){
	$response;
	$response["existe"] = false;
	$response['posicao'] = -1;
	foreach ($v1 as $key => $value) {
		if ($v1["href"] == $link) {
			return true;
		}
	}

	return false;
}

?>