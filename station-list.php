<?php

include 'config.php';
include('function/translator.php');

// DB接続
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_set_charset(DB_CHARSET);
$db = mysql_select_db(DB_NAME, $link);

$page_num = $_GET["page_num"];
// 1ページの表示件数
$page_size = 15;

// ページサイズ計算
$sql = "SELECT COUNT(*) AS count FROM app_station_info";
$result = mysql_query(add_search_condition($sql));
$row = mysql_fetch_array($result);
$count = $row['count'];

if ($count > 0) {
	$total_pages = ceil($count/$page_size);
} else {
	$total_pages = 0;
}

// 駅情報検索
$sql = "SELECT sid,line_name,station_name,chinese_station_name FROM app_station_info";
$result = mysql_query(
	add_search_condition($sql) . 
	" limit " . ($page_num - 1) * $page_size . ',' . $page_size . '');

// 返却結果設定
$response->page_num = $page_num;
$response->total_pages = $total_pages;

$row_num = 0;
while ($row = mysql_fetch_assoc($result)) {
	$response->station_list[$row_num]['sid'] = $row['sid'];
	$response->station_list[$row_num]['line_name'] = $row['line_name'];
	$response->station_list[$row_num]['station_name'] = $row['station_name'];
	$response->station_list[$row_num]['chinese_station_name'] = $row['chinese_station_name'];
	
	$row_num++;
}

// 検査結果返却
header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_UNICODE);

/**
 * sqlに検索条件追加
 * $ql sql文字列
 **/
function add_search_condition($sql) {
	// 検索keywordと検索言語設定された時のみ条件追加を行う
	if (isset($_GET["keyword"])) {
		$sql .= " WHERE station_name" . " like '%" . translate($_GET["keyword"]) . "%' ";
	}
	return $sql;
}
?>