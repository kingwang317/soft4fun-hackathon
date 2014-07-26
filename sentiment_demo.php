<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
if (PHP_SAPI != 'cli') {
	echo "<pre>";
}

$strings = array(
	1 => ' 手機殼 也 太 可愛 了吧  手機殼 也 太 醜 醜 醜 難看 噁心 手機殼 也 太 可愛 了吧  手機殼 也 太 醜 醜 醜 難看 噁心 手機殼 也 太 可愛 了吧  手機殼 也 太 醜 醜 醜 難看 噁心 手機殼 也 太 可愛 了吧  手機殼 也 太 醜 醜 醜 難看 噁心 手機殼 也 太 可愛 了吧  手機殼 也 太 醜 醜 醜 難看 噁心',
	2 => 'This cake looks amazing',
	3 => 'His skills are mediocre',
	4 => 'He is very talented',
	5 => 'She is seemingly very agressive',
	6 => 'Marie was enthusiastic about the upcoming trip. Her brother was also passionate about her leaving - he would finally have the house for himself.',
	7 => 'To be or not to be?',
);
//echo __DIR__ . '/autoload.php';
require_once __DIR__ . '/autoload.php';
$sentiment = new \PHPInsight\Sentiment();

foreach ($strings as $string) {

	// calculations:
	$scores = $sentiment->score($string);
	$class = $sentiment->categorise($string);

	// output:
	echo "String: $string\n";
	echo "Dominant: $class, scores: ";
	print_r($scores);
	echo "\n";
}
