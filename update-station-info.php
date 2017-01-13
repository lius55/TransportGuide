<?php

include('config.php');

include('function/translator.php');

// DB接続
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if(!$link) { 
	die('Could not connect:' . mysql_error());
}

mysql_set_charset(DB_CHARSET);

$db = mysql_select_db(DB_NAME, $link);
if(!$db) {
 	die('Could not select db:' . mysql_error());
}

// 開始sid
$start = $_GET['start'];
$limit = 1000;

$result = mysql_query(
	'select sid,station_name from app_station_info order by sid asc limit ' . 
	$start . ',' . $limit);

while($row = mysql_fetch_assoc($result)) {
	$sid = $row['sid'];
	$stataion_name = $row['station_name'];

	$chinese_station_name = translate($stataion_name, 'cn');
	$update_flag = mysql_query("update app_station_info set chinese_station_name='" .
		$chinese_station_name . "' where sid=" . $sid);

	if ($update_flag) {
		echo $stataion_name . '⇨' . $chinese_station_name . '<br/>';
	}
}

mysql_close($link);
?>