<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
require_once("../lib/database.inc.php");
//include_db_pkg();
$db = init_db();

$url = isset($_POST['url'])?$_POST['url']:"";
$this_words =  "";
$words_arr = array();
//print_r($url);

if($url != ""){

	foreach ($url as $key => $value) {
		$get_prod_words_sql = " SELECT prod_words FROM prodkw_forum WHERE url = '$value' LIMIT 1 ";
		$res = $db->get_var($get_prod_words_sql);
		if(isset($res)){
			$this_words = $this_words.$res;
		}
		# code...
	}


	if($this_words != ""){
		$this_words = explode(",", $this_words);
		echo "<ul>";
		foreach ($this_words as $key => $value) {
			if($value != "" && !in_array($value, $words_arr)){
				$words_arr[$value] = $value;
				echo "<li>";
				echo $value;
				echo "</li>";
			}
			
		}
		echo "</ul>";
	}

	
	
}






?>