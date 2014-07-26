<?php
define('CLIENT_CHARSET',	'UTF8');
define('TABLE_PREFIX',		'proj');

define('DB_USER',		'root');
define('DB_PASSWD',		'king317');
define('DB_NAME',		'9icase');
define('DB_HOST',		'localhost');
define('EZSQL_LIB',		'ezsql');

function &init_db()
{
	global $ezsql_mysql_str;
	static $db;

	if ( !isset($db) ) {
		include_once EZSQL_LIB. "/shared/ez_sql_core.php";
		include_once EZSQL_LIB. "/mysql/ez_sql_mysql.php";
		$db = new ezSQL_mysql(DB_USER,DB_PASSWD,DB_NAME, DB_HOST);
		if( !$db->quick_connect(DB_USER,DB_PASSWD,DB_NAME, DB_HOST) )
		{
			notify("無法連線資料庫，請確認資料庫相關設定正確。");
			exit;
		}
		$db->query("SET NAMES ". CLIENT_CHARSET);
	}
	return $db;
}
function &get_db($DB_USER, $DB_PASSWD, $DB_NAME, $DB_HOST)//模組同步
{
	global $ezsql_mysql_str;
	static $db;

	if ( !isset($db) ) {
		include_once EZSQL_LIB. "/shared/ez_sql_core.php";
		include_once EZSQL_LIB. "/mysql/ez_sql_mysql.php";
		$db = new ezSQL_mysql($DB_USER,$DB_PASSWD,$DB_NAME, $DB_HOST);
		if( !(@$db->quick_connect($DB_USER,$DB_PASSWD,$DB_NAME, $DB_HOST)) )
		{
			notify("無法連線資料庫，請確認資料庫相關設定正確。");
			redirect("admin.php?mod=collect");
		}
		@$db->query("SET NAMES ". CLIENT_CHARSET);
	}
	return $db;
}
function db_tbprefix($name)
{
	return TABLE_PREFIX. '_'. $name;
}
function db_escape($data)
{
	$output = (! get_magic_quotes_gpc ()) ? addslashes ($data) : $data;
	return $output;
}

function db_test() {
	include_once EZSQL_LIB. "/shared/ez_sql_core.php";
	include_once EZSQL_LIB. "/mysql/ez_sql_mysql.php";
	$db = new ezSQL_mysql(DB_USER,DB_PASSWD,DB_NAME, DB_HOST);
	return @$db->quick_connect(DB_USER,DB_PASSWD,DB_NAME, DB_HOST);
}
function array_msort($array, $cols)
{
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    return $ret;

}
?>