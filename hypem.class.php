<?php
include("simple_html_dom.php");
function getHypem($item){
	$ch = curl_init ("http://hypem.com/item/$item?ax=1&ts=1295726809");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
	curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
	curl_setopt($ch, CURLOPT_COOKIE, "AUTH=".$_GET["hash"].";");
	$output = curl_exec ($ch);
	$html = str_get_html($output);
	$scripts = $html->find('script');
	$script = $scripts[1];
	$informatie = array();
	$value=$script->innertext;
	for($i=0;$i<15;$i++){
		$pat = "/\'([^\']*?)\'/";
		$value = str_replace("\'",'&#39;',$value);
		$value = str_replace("&","",$value);
		preg_match($pat, $value, $matches);
		$value = str_replace(@$matches[0],'',$value);
		$str = @$matches[1];
		$str = str_replace("&hellip;","...",$str);
		$informatie[] = $str;
	}
	$result = array("id"=>"http://hypem.com/item/".$informatie[1],"blog"=>$informatie[3],"secret"=>$informatie[7],"artist"=>$informatie[9],"song"=>$informatie[10],"songurl"=>'http://hypem.com/serve/play/'.$informatie[1].'/'.$informatie[7].'.mp3',"duration"=>$informatie[4]);
	return $result;
}
function getUserLoved($user){
	$html = file_get_contents("http://hypem.com/feed/loved/$user/1/feed.xml");
	$xml = simplexml_load_string($html);
	$results = array();
	foreach($xml->channel->item as $item){
		$link = $item->link;
		$link = str_replace("http://hypem.com/item/",'',$link);
		$code = substr($link,0,5);
		$results[] = $code;
	}
	return $results;
}
function getPopular(){
	$ch = curl_init ("http://hypem.com/feed/popular/now//1/feed.xml");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIE, "AUTH=".$_GET["hash"].";");
	curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
	curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
	$html = curl_exec ($ch);
	$xml = simplexml_load_string($html);
	$results = array();
	foreach($xml->channel->item as $item){
		$link = $item->link;
		$link = str_replace("http://hypem.com/item/",'',$link);
		$code = substr($link,0,5);
		$results[] = $code;
	}
	return $results;
}
function getLatest(){
	$ch = curl_init ("http://hypem.com/feed/time/today/1/feed.xml");
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIE, "AUTH=".$_GET["hash"].";");
	curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
	curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
	$html = curl_exec ($ch);
	$xml = simplexml_load_string($html);
	$results = array();
	foreach($xml->channel->item as $item){
		$link = $item->link;
		$link = str_replace("http://hypem.com/item/",'',$link);
		$code = substr($link,0,5);
		$results[] = $code;
	}
	return $results;
}
?>