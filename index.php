<?php
/**
 * index.php
 *
 * @package SPECIAL CHAT
 * @programmer Hany alsamman ('hany.alsamman@gmail.com')
 * @author Hany alsamman (Project administrator && Original founder)
 * @version $Id$
 * @pattern private
 * @access private
 */

## Site internal path
define("SITE_PATH", __DIR__);

//ini_set('session.cookie_lifetime',1440);
//ini_set('session.use_only_cookies',1);
			
if( !isset($_COOKIE['UNVISABLE_BAN']) ){
	//set cookie for real ip
	$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
	if (isset($_SERVER["REMOTE_ADDR"])) $ip = $_SERVER["REMOTE_ADDR"]; else $ip = 'NONE';
	setcookie('UNVISABLE_BAN',$ip, time()+60*60*24*365, '/', $domain, false);
}

require_once ('./sources/configs.php'); //configs for site

require_once ('./lang/english/lang_config.php'); //lang_config for site

require_once ('./includes/COMMANDS/RELATIONS_CORE.php'); //RELATIONS_CORE for COMMANDS

require_once ('./templates/soft/mask.php'); //mask for site

if (ini_get('zlib.output_compression')){
	ob_start();
}elseif (function_exists('ob_gzhandler')){
	ob_start('ob_gzhandler');
}else{
	ob_start();
}

//$PROFILER = new PROFILER();

//print $PROFILER->mark( 'afterLoad' );

// Safely initialize an object from the class
$core = new SPECIAL_CORE();

$core->MAIN_DISPLAY();

//print $PROFILER->mark( 'afterRoute' );

ob_end_flush();

