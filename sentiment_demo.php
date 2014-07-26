<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
if (PHP_SAPI != 'cli') {
	echo "<pre>";
}
/*
$strings = array(
	1 => ' 手機殼 也 太 可愛 了吧  手機殼 也 太 醜 醜 醜 難看 噁心 手機殼 也 太 可愛 了吧  手機殼 也 太 醜 醜 醜 難看 噁心 手機殼 也 太 可愛 了吧  手機殼 也 太 醜 醜 醜 難看 噁心 手機殼 也 太 可愛 了吧  手機殼 也 太 醜 醜 醜 難看 噁心 手機殼 也 太 可愛 了吧  手機殼 也 太 醜 醜 醜 難看 噁心',
	2 => 'This cake looks amazing',
	3 => 'His skills are mediocre',
	4 => 'He is very talented',
	5 => 'She is seemingly very agressive',
	6 => 'Marie was enthusiastic about the upcoming trip. Her brother was also passionate about her leaving - he would finally have the house for himself.',
	7 => 'To be or not to be?',
);
*/
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
require_once("lib/ckip/src/CKIPClient.php");
require_once("lib/database.inc.php");

$db = init_db();

define("CKIP_SERVER", "140.109.19.104");
define("CKIP_PORT", 1501);
define("CKIP_USERNAME", "kingwang317");
define("CKIP_PASSWORD", "king317");

$ckip_client_obj = new CKIPClient(
   CKIP_SERVER,
   CKIP_PORT,
   CKIP_USERNAME,
   CKIP_PASSWORD
);

/*$get_case = " SELECT cd_id,cd_title,cd_content FROM data_case_detail WHERE  kw_analytics is null and board='gossiping' LIMIT 1 ";

$result = $db->get_results($get_case);
*/
$raw_text = isset($_POST['content'])?$_POST['content']:null;
if(isset($raw_text)){
    //foreach ($result as $key => $value) {*/
        # code...
      $this_id = $value->cd_id;
        

	$raw_text = str_replace("，", "\n", $raw_text);
	$raw_text = str_replace("。", "\n", $raw_text);
	$raw_text = str_replace(",", "\n", $raw_text);
	$raw_text = str_replace(".", "\n", $raw_text);

	$raw_text_array = explode("\n", $raw_text);
	$raw_text_array = array_filter($raw_text_array);

	$return_text = "";
	$return_term = array();
	$strings = "";
	$total_words = 0;
	foreach ($raw_text_array as $key1=>$raw_sentence) {

	   $return_text .= $ckip_client_obj->send($raw_sentence);
	   $return_term = $ckip_client_obj->getTerm();

	   //$strings += " ".$return_term;
	   //print_r($return_term);
	   sleep(2);

	   foreach ($return_term as $key2 => $value) {
          $strings[$key1] .= " ".$value["term"];

          $check_sql = " SELECT COUNT(*) FROM wordbase WHERE word ='".$value["term"]."'  ";
          $res = $db->get_var($check_sql);

          if($res == 0){
          	$sql = ' INSERT INTO wordbase (word,class)VALUES("'.$value["term"].'","")';
			$db->query($sql);
          }

          


          $total_words++;
       
        }
        //$strings[$key1]['count'] = sizeof($return_term);

	}


     /*   if(!isset($return_text) || $return_text == "" || $return_text == null ){
          exit;
        }

        
        print_r($return_term);
        $arr = array();

        foreach ($return_term as $key => $value) {
          $this_word = urlencode($value["term"]);
          if(isset($arr[$this_word])){
            $arr[$this_word]["count"] = $arr[$this_word]["count"] + 1;
          }else{
            $arr[$this_word]["count"] = 1;
            $arr[$this_word]["tag"] = $value["tag"];
          }
        }
        $sorted = array_msort($arr, array('count'=>SORT_DESC, 'tag'=>SORT_ASC));

        if(isset($sorted)){
          
          $a = json_encode($sorted);
          $update_sql = " UPDATE data_case_detail set kw_analytics = '$a' WHERE cd_id = '".$this_id."'";
          echo $update_sql;
          $db->query($update_sql);
        }*/
  //  }

}




//print_r($strings);
$total_scores = array();
$total_count = 0;
//echo __DIR__ . '/autoload.php';
require_once __DIR__ . '/autoload.php';
$sentiment = new \PHPInsight\Sentiment();
if($strings)
foreach ($strings as $string) {

	// calculations:
	$words = explode(" ", $string);
	$scores = $sentiment->score($string);
	$class = $sentiment->categorise($string);

	// output:
/*	echo "Dominant: $class, scores: ";
	print_r($scores);
	echo "\n";
*/
	$type = array('pos','neu','neg');

	foreach($type as $class){
		if(!isset($total_scores[$class]) || $total_scores[$class] == null || $total_scores[$class] == ''){
			$total_scores[$class] = 0;
		}
		$total_scores[$class] = $total_scores[$class] + $scores[$class]*sizeof($words);
	}


	//$total_count++;

}
echo "情感分數:<br />";
echo "正面比例:".round($total_scores["pos"]/$total_words,2)."<br />";
echo "中性比例:".round($total_scores["neu"]/$total_words,2)."<br />";
echo "負面比例:".round($total_scores["neg"]/$total_words,2)."<br />";

echo "原文:<br />".$_POST["content"];


?>


<form method="POST">
<textarea name="content" cols="40" rows="20"></textarea>
<input type="submit" value="送出"/>
</form>