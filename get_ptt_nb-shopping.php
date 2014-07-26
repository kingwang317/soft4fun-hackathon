<?php  
set_time_limit(0);
ini_set("display_errors", "On");
require_once("lib/database.inc.php");
//include_db_pkg();
$db = init_db();
require_once("lib/crawler.inc.php");
$this_date = date("Ymd");   


$this_ym = isset($_GET['ym'])?$_GET['ym']:date("Ym");   
$this_d = date("d");

			$url = "http://www.ptt.cc/bbs/nb-shopping/index.html";
			$tag = '/<div class="title">([^`]*?)<\/div>/';
			$encode = "UTF8";
			$tag_href = '/<a href="([^`]*?)"/';
			$tag_date = '/<div class="date">([^`]*?)<\/div>/';
			$tag_author = '/<div class="author">([^`]*?)<\/div>/';
		
		//get content
		//echo $url;
		$content =  curl_download($url,$encode);

		//$content = str_replace(' ', '', $content);
		//$content = str_replace('"', '', $content);
		//echo $content;
		preg_match_all($tag, $content, $matches, PREG_SET_ORDER);
/*
foreach ($matches as $val) {
	echo "<pre>";
	print_r($val);
	echo "</pre>";
}*/
preg_match_all($tag_date, $content, $matches_date, PREG_SET_ORDER);
preg_match_all($tag_author, $content, $matches_author, PREG_SET_ORDER);

foreach ($matches as $key=>$val) {

	preg_match_all( $tag_href , $val[0] , $matches_href, PREG_SET_ORDER);
	//print_r($matches_href);
	if(!isset($matches_href[0][1])){
		$matches_href[0][1] = null;
	}

	$check_sql = " SELECT COUNT(*) FROM data_case WHERE dcase_url  = '".strip_tags($matches_href[0][1])."' AND dcase_date  = '".strip_tags($matches_date[$key][1])."' AND dcase_title  = '".strip_tags($val[0])."' ";

	$check_count = $db->get_var($check_sql);

	if($check_count < 1 ){

	$sql = " INSERT INTO data_case (dcase_title,dcase_url,dcase_date,dcase_author,run_date,board)";
	$sql .= " VALUES('".strip_tags($val[0])."','".strip_tags($matches_href[0][1])."','".strip_tags($matches_date[$key][1])."','".strip_tags($matches_author[$key][1])."',NOW(),'nb-shopping')" ;

	//echo $sql;
	$db->query($sql);

	}
	//echo strip_tags($val[0].":".$matches_href[0][1].":".$matches_date[$key][1].":".$matches_author[$key][1])."<br />";
}



/*echo "<pre>";
	print_r($matches_date);
	echo "</pre>";*/
/*foreach ($matches as $val) {
	echo "<pre>";
	print_r($val);
	echo "</pre>";
}*/
/*
foreach ($matches as $val) {
	echo "<pre>";
	print_r($val);
	echo "</pre>";
}*/




?>  
