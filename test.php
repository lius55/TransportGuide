<?php 

$param = substr(strstr($_SERVER["REQUEST_URI"], '?'), 1);
$url = 'http://api.ekispert.jp/'.$param;
//echo $url.'<br/>';
$response = file_get_contents($url);
echo $response;

?>
