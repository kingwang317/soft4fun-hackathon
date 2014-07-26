<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
require_once("./lib/database.inc.php");
$db = init_db();



$word = isset($_POST['word'])?$_POST['word']:"";
$class = isset($_POST['class'])?$_POST['class']:"";
$ip = $_SERVER['REMOTE_ADDR'];

if($word != "" && $class != ""){
	$update_sql = " UPDATE wordbase SET class = '$class', ip = '$ip' WHERE word = '$word'  ";
	$db->query($update_sql);
}


$sql = " SELECT word FROM wordbase where class = '' AND LENGTH(word) > 1 ORDER BY RAND() LIMIT 1 ";

$res = $db->get_var($sql);


if(isset($res)){
	
	?>
	<html lang="zh-TW">
<head>

<meta charset="UTF-8" />
</head>
<body>
	<form method="POST">
	您覺得 <?php echo $res ?> 是什麼詞性<br />

	<input type="hidden" name="word" value="<?php echo $res ?>">
	<input type="radio" name="class" value="pos">正面情緒詞<br />
	<input type="radio" name="class" value="neg">負面情緒詞<br />
	<input type="radio" name="class" value="neu">中性情緒詞<br />
	<input type="radio" name="class" value="ign">不是情緒詞(如 你我他等介係詞)<br />
	<input type="submit" value="反饋" />
	<!--<a href="senindex.php">我也要玩情感分析</a>-->
	QQ斷詞系統GG了
	</form>
	</body>
</html>
	<?php
}

?>