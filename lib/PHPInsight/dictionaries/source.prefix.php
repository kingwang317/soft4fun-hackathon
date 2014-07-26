<?php
/*
$words = array (
  0 => 'isn\'t',
  1 => 'aren\'t',
  2 => 'not',
  3 => 'isn\'t',
);*/
require_once(__DIR__."/../../database.inc.php");
$db = init_db();


$sql = " SELECT word FROM wordbase WHERE class = 'prefix' ";
$words = $db->get_results($sql,ARRAY_A);
/*
foreach ($words as $key => $value) {

	$sql = ' INSERT INTO wordbase (word,class)VALUES("'.$value.'","prefix")';
	echo $sql;
	$db->query($sql);
}*/
?>