<?php
/* 中国語⇨日本語へ変換用api */

include('function/translator.php');

// 変換前の文字列取得
$text = urldecode($_GET["text"]);

// 変換処理行う
$response_json->str = translate($text);

// 結果返却	
header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');
echo json_encode($response_json, JSON_UNESCAPED_UNICODE);
?>
