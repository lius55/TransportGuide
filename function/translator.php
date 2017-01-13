<?php
/* 中国語⇨日本語へ変換用function */

require_once(dirname(__FILE__) . '/../config.php');

/**
 * 漢字変換処理
 * 
 * $text 変換前のtext
 * $language 1(jp),2(cn)
 * @return 変換後のテキスト
 **/
function translate($text, $to_language = 'jp') {

	$response = '';

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

	// 文字列ごとの変換
	foreach(mb_str_split($text) as $char) {
		
		$translated_char = $char;

		// 英数字以外の場合DB検索
		if(!preg_match('/[a-zA-Z0-9]/', $char)) {

			$from_char_column_name = ($to_language == 'jp') ? 'chinese_char' : 'japanese_char';
			$to_char_column_name = ($to_language == 'jp') ? 'japanese_char' : 'chinese_char';

		 	// DB検索
	 		$result = mysql_query("select " . $to_char_column_name . 
	 			" from app_char_exchange where " . 
	 			$from_char_column_name . "='" . $char . "'");
	 		if (!$result) {
	 			echo mysql_error();
	 		}
	 		if($row = mysql_fetch_array($result)) {
	 			$translated_char = $row[$to_char_column_name];			
	 		}
		}
	    
	    $response .= $translated_char;  
	}

	return $response;
}


/**
 * マルチバイト文字列を指定文字数ごとに分解
 *
 * $str ターゲット文字列
 * $split_len 分割間隔
 **/
function mb_str_split($str, $split_len = 1) {

    mb_internal_encoding('UTF-8');
    mb_regex_encoding('UTF-8');

    if ($split_len <= 0) {
        $split_len = 1;
    }

    $strlen = mb_strlen($str, 'UTF-8');
    $ret    = array();

    for ($i = 0; $i < $strlen; $i += $split_len) {
        $ret[ ] = mb_substr($str, $i, $split_len);
    }
    return $ret;
}

?>
