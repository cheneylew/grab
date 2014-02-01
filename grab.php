<?php
include_once '3rdPartyClass/simple_html_dom.php';
header("Content-type:text/html;charset=utf-8;");
//Target site url
$targetUrl='http://sh.ganji.com/iphone-iphone-5/o3/';
$itemBaseUrl='http://sh.ganji.com';

$html = file_get_html($targetUrl);
$ret = $html->find('dl[class=list-bigpic]');
echo "<pre>";
foreach ($ret as $item){
	$yuan = $item->children(2)->children(0)->children(0)->plaintext;
	$title = $item->children(1)->children(0)->children(0)->children(0)->children(0)->plaintext;
	
	$link = $item->children(1)->children(0)->children(0)->children(0)->children(0);
	$linkSite=$itemBaseUrl.$link->href;
	
	$content = $item->children(1)->children(1)->plaintext;
	//$date = $item->children(2)->children(2)->plaintext;
	//$location = $item->children(2)->children(3)->children(0)->plaintext;
	//$date=$item->find('i[class=mr8]')->outertext;
	$dates=$item->find('i[class=mr8]');
	$date=$dates[0]->plaintext;
	
	$addses=$item->find('a[class=adds]');
	$adds=$addses[0]->plaintext;
	
	echo "$content<br/>";
}
echo count($ret);