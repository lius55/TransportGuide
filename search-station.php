<?php 
/* 駅情報検索API */

// 検索駅名取得(url encodeされたもの)
$station_name = $_GET["name"];

// 翻訳apiのurl設定
//$translate_api_url = 'http://kanconvit.ta2o.net/api.cgi?format=json&ctext='.$station_name;
$translate_api_url = 'http://tony56.sakura.ne.jp/app/transportGuide/translate.php?text='.$station_name;

// 中国語⇨日本語への変換結果取得
$translated_station_name = urlencode(json_decode(file_get_contents($translate_api_url))->str);

/*
 * ----------------------------
 * リクエストパラメータ書き換え
 * ----------------------------
 */

// リクエストパラメーター取得
$param = substr(strstr($_SERVER["REQUEST_URI"], '?'), 1);
// nameパラメーターの開始終了位置取得
$name_start_pos = strpos($param, "name=");
$name_sub_str = substr($param, $name_start_pos);
$name_end_pos = $name_start_pos + strpos($name_sub_str, "&");

// 書き換え後のリクエストパラメーター
$replaced_param = substr($param, 0, $name_start_pos+5).$translated_station_name.substr($param, $name_end_pos);	

// 結果取得&返却
echo file_get_contents('http://api.ekispert.jp/'.$replaced_param);
?>
