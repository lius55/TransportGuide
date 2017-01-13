<?php

include 'config.php';

// DB接続
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_set_charset(DB_CHARSET);
$db = mysql_select_db(DB_NAME, $link);

$page_num = $_GET["page_num"];
$page_size = 40;

// ページサイズ計算
$result = mysql_query('SELECT COUNT(*) AS count FROM app_station_info');
$row = mysql_fetch_array($result);
$count = $row['count'];

if ($count > 0) {
	$total_pages = ceil($count/$page_size);
} else {
	$total_pages = 0;
}

$result = mysql_query(
	'SELECT sid,line_name,station_name FROM app_station_info limit ' .
	($page_num - 1) * $page_size . ',' . $page_size . '');

$response->page_num = $page_num;
$response->total_pages = $total_pages;

$row_num = 0;
while ($row = mysql_fetch_assoc($result)) {
	$response->station_list[$row_num]['sid'] = $row['sid'];
	$response->station_list[$row_num]['line_name'] = $row['line_name'];
	$response->station_list[$row_num]['station_name'] = $row['station_name'];
	$row_num++;
}

header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>