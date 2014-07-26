<?php
/**
 * ckip-test-driver.php
 *
 * PHP version 5
 *
 * @category PHP
 * @package  /
 * @author   Fukuball Lin <fukuball@gmail.com>
 * @license  No Licence
 * @version  Release: <1.0>
 * @link     http://fukuball@github.com
 */

require_once "lib/ckip/src/CKIPClient.php";

// change to yours
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

$raw_text = "單機活動記錄連續2日1.案件說明：單機 活動記錄拍攝+訪問+後製剪輯10分鐘內
2.配合時間：4/25(星期五) 約半天  4/26(星期六) 時間約07:30~16:00 拍攝
3.配合地點：台北
4.注意事項：兩日都可以配合者，請自備器材，有經驗佳!";

$return_text = $ckip_client_obj->send($raw_text);
echo $return_text;

$return_sentence = $ckip_client_obj->getSentence();
print_r($return_sentence);

$return_term = $ckip_client_obj->getTerm();
print_r($return_term);

?>