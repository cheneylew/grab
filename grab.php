<?php
include_once '3rdPartyClass/simple_html_dom.php';
header("Content-type:text/html;charset=utf-8;");
$html = file_get_html('http://sh.ganji.com/iphone/o1/');
$ret = $html->find('dl[class=list-bigpic]');
echo "<pre>";
foreach ($ret as $item){
	$text=$item->plaintext;
	echo "ok$text<br/>";
}
echo count($ret);