<?php 
set_time_limit(0);
ini_set("display_errors", "On");
require_once("lib/database.inc.php");
$db = init_db();

$sql = " SELECT * FROM data_case_detail WHERE board = 'macshop' ";

$result = $db->get_results($sql);
$count = 1;
if(isset($result))
	foreach ($result as $key => $value) {
		echo $count++."-".$value->cd_title."<br />".$value->cd_content."<br />";
	}

?>