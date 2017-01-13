<?php 
/** 駅情報や経路検索の中間API **/

include('config.php');

// パラメーター取得
$param = substr(strstr($_SERVER["REQUEST_URI"], '?'), 1);

// 結果返却
echo file_get_contents(REDIRECT_API_TARGET_HOST . $param);
?>
