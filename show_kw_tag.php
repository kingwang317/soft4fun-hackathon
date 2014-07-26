<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);
require_once("lib/database.inc.php");

$db = init_db();

$case_id = isset($_GET['cate_id'])?htmlspecialchars($_GET['cate_id']):"31";
$get_case = " SELECT cd_id,kw_tag,cd_title FROM data_case_detail WHERE `board` = '518case' and `real_cate` = '$case_id' ";

$result = $db->get_results($get_case);
$tags4case = array();

if(isset($result)){
    foreach ($result as $key => $value) {
   		$tag = explode(",",$value->kw_tag);
   		foreach ($tag as $k => $v) {
	   		if($v != ""){
		   		  if(isset($tags4case[$v])){
		            $tags4case[$v]["count"] = $tags4case[$v]["count"] + 1;
		          }else{
		            $tags4case[$v]["count"] = 1;
		          }
	      	}
   			# code...
   		}
          
    }
    $sorted = array_msort($tags4case, array('count'=>SORT_DESC,'count'=>SORT_DESC));
   // echo "<pre>";
   // print_r($sorted);
   // echo "</pre>";

}

 
?> 

<!DOCTYPE html>
<html>
  <head>
    <title>jQCloud Example</title>
    <link rel="stylesheet" type="text/css" href="/js/jqcloud.css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jqcloud-1.0.4.js"></script>
    <script type="text/javascript">
      /*!
       * Create an array of word objects, each representing a word in the cloud
       */
      var word_array = [
      <?php 
        foreach ($sorted as $key => $value) {

          echo "{text: '$key', weight: ".$value['count']."},";
        }
        echo '{text: "", weight: 0}';

      ?>
          /*{text: "Lorem", weight: 15},
          {text: "Ipsum", weight: 9, link: "http://jquery.com/"},
          {text: "Dolor", weight: 6, html: {title: "I can haz any html attribute"}},
          {text: "Sit", weight: 7},
          {text: "Amet", weight: 5}*/
          // ...as many words as you want
      ];

      $(function() {
        // When DOM is ready, select the container element and call the jQCloud method, passing the array of words as the first argument.
        $("#example").jQCloud(word_array);
      });
    </script>
  </head>
  <body>
    <!-- You should explicitly specify the dimensions of the container element -->
    <div id="example" style="width: 550px; height: 350px;"></div>
  </body>
</html>