<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
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

$get_case = " SELECT cd_id,cd_title,cd_content FROM data_case_detail WHERE  kw_analytics is null and board='gossiping' LIMIT 1 ";

$result = $db->get_results($get_case);


if(isset($result)){
    foreach ($result as $key => $value) {
        # code...
      $this_id = $value->cd_id;
        $raw_text = $value->cd_title."\n".$value->cd_content;
//echo $raw_text;
        $raw_text = str_replace("，", "\n", $raw_text);
$raw_text = str_replace("。", "\n", $raw_text);
$raw_text = str_replace(",", "\n", $raw_text);
$raw_text = str_replace(".", "\n", $raw_text);

$raw_text_array = explode("\n", $raw_text);
$raw_text_array = array_filter($raw_text_array);

$return_text = "";
$return_term = array();

foreach ($raw_text_array as $raw_sentence) {

   $return_text .= $ckip_client_obj->send($raw_sentence);
   $return_term = array_merge($return_term ,$ckip_client_obj->getTerm());
   //echo $return_text;
   sleep(2);

}
        if(!isset($return_text) || $return_text == "" || $return_text == null ){
          exit;
        }

        
        print_r($return_term);
        $arr = array();

        foreach ($return_term as $key => $value) {
          // print_r($value);
          $this_word = urlencode($value["term"]);
       //   echo $this_word;
          if(isset($arr[$this_word])){
            $arr[$this_word]["count"] = $arr[$this_word]["count"] + 1;
          }else{
            $arr[$this_word]["count"] = 1;
            $arr[$this_word]["tag"] = $value["tag"];
          }
          # code...
        }
        $sorted = array_msort($arr, array('count'=>SORT_DESC, 'tag'=>SORT_ASC));

        if(isset($sorted)){
          
          $a = json_encode($sorted);
          $update_sql = " UPDATE data_case_detail set kw_analytics = '$a' WHERE cd_id = '".$this_id."'";
          echo $update_sql;
          $db->query($update_sql);
        /*  echo $a;
          $b = json_decode($a);

          foreach ($b as $k => $v) {
            echo urldecode($k) . " =". $v->count;
          }*/
        }
       
        //print_r($sorted);

    }

}
 
?> 