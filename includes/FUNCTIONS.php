<?php
/**
 *
 * @programmer Hany alsamman ('hany.alsamman@gmail.com')
 * @author Hany alsamman (Project administrator && Original founder)
 * @version $Id$
 * @pattern private
 * @access private
 * @date 2007-2008
 */

if ( ! defined( 'IN_SCRIPT' ) )
{
        print "<h1>Incorrect access</h1>You cannot access this file directly.";
        exit();
}

class FUNCTIONS
{
	
	function get_date_min($date){
	
				$diff = time()-$date;
				
				$total = ceil($diff/60);
							
				return $total;
	}
	
	function get_date_days($date){
	
				$diff = time()-$date;
				
				if($diff < 86400) $total = ceil($diff/3600);
		
				return $total;
	}
	
	function get_date_week($date){
	
				$diff = time()-$date;
				
				if($diff < 3024000) $total = ceil($diff/604900);
							
				return $total;
	}
	
	function check_alphabets($username){
			//arabic letters
			$ArabicLetters = array('�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�');
			//check user name login length
			$NickLength = strlen($username);
			//check user name for anything else arabic/english/number
			$result = ereg("^([" . implode('',$ArabicLetters) . "]|[A-Za-z0-9_])+$", $username, $arr);
			//when error return message
			if ( $result != $NickLength ) {
				return ChTPL_RegErrUserBadNick;
			}
			
			if ( $NickLength < 2) {
				return ChTPL_RegErrUserBadNick;
			}
	}
	
	function addmsg($file,$user,$text){
		
			// Prepare the message (remove \')
			$text = eregi_replace("\\\\'","'",$text);
			$time = time();
			$log_file = ROOT_LOGS_PATH."$file.html";
			$fh = fopen($log_file,"a");
			flock($fh,2);
			fwrite($fh,"$user$text\n");
			flock($fh,3);
			fclose($fh);
		
	}
	
	// add forward to a log
	function addforward($file,$user,$text){
		
			// Prepare the message (remove \')
			$text = eregi_replace("\\\\'","'",$text);
			$time = time();
			$log_file = ROOT_LOGS_PATH."$file.html";
			$fh = fopen($log_file,"a");
			flock($fh,2);
			fwrite($fh,"$user$text\n");
			flock($fh,3);
			fclose($fh);
		
	}
	
	function add($file,$user,$text){
		
			// Prepare the message (remove \')
			$text = eregi_replace("\\\\'","'",$text);
			$time = time();
			$log_file = ROOT_LOGS_PATH."saved/$file.html";
			$fh = fopen($log_file,"a");
			flock($fh,2);
			fwrite($fh,"$user$text\n");
			flock($fh,3);
			fclose($fh);
		
	}	
	
	function some_changes($text)
	{
		$text = preg_replace("/\-bo(.+?)\/bo/i", "<b>\${1}</b>", $text);
	    $text = preg_replace("/\-it(.+?)\/it/i", "<i>\${1}</i>", $text);
	    $text = preg_replace("/\-un(.+?)\/un/i", "<u>\${1}</u>", $text);
	    
	    $text = preg_replace("/\-bo(\S+)/i", "<b>\${1}</b>", $text);
	    $text = preg_replace("/\-it(\S+)/i", "<i>\${1}</i>", $text);
	    $text = preg_replace("/\-un(\S+)/i", "<u>\${1}</u>", $text);
		
		$mycolor = array('red','blue','yellow','green','black','gray','grey','navy','orange','pink','silver','yellow','gold','aqua');
		
		for ($i = 0; $i < count($mycolor); $i++) {
			$text = preg_replace("/\-$mycolor[$i](.+?)\/$mycolor[$i]/i", "<font color=\"$mycolor[$i]\">\${1}</font>", $text);
			$text = preg_replace("/\-$mycolor[$i](\S+)/i", "<font color=\"$mycolor[$i]\">\${1}</font>", $text);
	    }
	    
	    return $text;
	}
	
	function html2txt($document){
	$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript
				   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
				   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
				   '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
	);
	$text = preg_replace($search, '', $document);
	return $text;
	}

	function advfinder($text)
	{
			if ($text) {
				$MESSAGE = $text;
				$Sites = array(
							   'syriantalk',
							   'arabtalk',
							   'arabhearts',
							   'roomarab',
							   'arabmasterz'
							   );
				$length = strlen($MESSAGE);	
				foreach ($Sites as $Site_Value) {
					$Array	 = str_split($Site_Value);		
					$Site_Name = implode('.*',$Array);
					$MESSAGE = eregi_replace("$Site_Name",'ADV',$MESSAGE);
				}
			
				if ( strlen($MESSAGE) != $length ) {
					$text = "ADV Found";
				}
				return $text;
			}
	}
	
	function check_banned($BannedIP) {
	
		if ( preg_match("/$BannedIP/",$_SERVER['HTTP_X_FORWARDED_FOR']) || preg_match("/$BannedIP/",$_SERVER['REMOTE_ADDR'])) {
			return true;
		}else{
			return false;
		}
	}
	
//	function check_banned_pc($BannedIP) {
//	
//		if ( preg_match("/$BannedIP/",$_SERVER['HTTP_X_FORWARDED_FOR']) ) {
//			return true;
//		}else{
//			return false;
//		}
//	}

	function is_ip($ip) 
	 {  
	if (preg_match("/^(\d+\.?)+$/", $ip)) {
		$valid = TRUE; 
			foreach(explode(".", $ip) as $block) 
			 { 
			  if( $block<0 || $block>255 ) 
			   {            
				$valid = FALSE; 
			   } 
			 } 
		}
	  else 
	   { 
		$valid = FALSE; 
	   } 
	  return $valid; 
	 }
	
	function load_emoticons($MSG) {				
		$MSG = preg_replace_callback ("/\*(\d+)\*/", 
			create_function( '$matches', '$matches[1] = ceil($matches[1]); if( $matches[1] > 8 && $matches[1] < 1086  )  return "<img src=\"./emoticons/smiles/icon$matches[1].gif\">";' ), $MSG);			
		return $MSG;
	}
	
	function discoverPCIP()
	{
		if (isset($_SERVER))
		{
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
				$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			elseif(isset($_SERVER["HTTP_CLIENT_IP"]))
				$ip = $_SERVER["HTTP_CLIENT_IP"];
			else
				$ip = 'NONE';
		}
		else
		{
			if (getenv('HTTP_X_FORWARDED_FOR'))
				$ip = getenv('HTTP_X_FORWARDED_FOR');
			elseif (getenv('HTTP_CLIENT_IP'))
				$ip = getenv('HTTP_CLIENT_IP');
			else
				$ip = 'NONE';
		}		
		return $ip;
	}
	
	function discoverIP()
	{
		if (isset($_SERVER))
		{
			if (isset($_SERVER["REMOTE_ADDR"]))
				$ip = $_SERVER["REMOTE_ADDR"];
			else
				$ip = 'NONE';
		}
		else
		{
			if (getenv('REMOTE_ADDR'))
				$ip = getenv('REMOTE_ADDR');
			else
				$ip = 'NONE';
		}
		
		return $ip;
	}
	
	public function debug($var, $class = null, $line = null)
	{
		@chmod("./_SQLDebug.txt",0777);
		
		$f = fopen("_SQLDebug.txt","a");
		
		fwrite($f,date("M j, g:i a ")."CLASS: {$class} ($line)".$var."\n");
		fclose($f);
		
		@chmod("./_SQLDebug.txt",0444);
	}
	
	
	/**
	 * functions::add_slashes()
	 * filter source for SQL injection
	 * 
	 * @param mixed $t
	 * @return
	 */
	public function add_slashes( $t )
	{
		$u = trim( htmlspecialchars($t) );
		##filter source for SQL injection
		return mysql_real_escape_string($u);
	}
	
	/**
	 * functions::get_date()
	 * 
	 * @param mixed $t
	 * @return
	 */
	public function get_date ($t) {
		$s = time() - $t;
		if ($s<60) return 'moments ago';
		$m = $s/60;
		if ($m<60) return floor($m) . ' minutes ago';
		$h = $m/60;
		if ($h<24) return floor($h) . ' hours ago';
		$d = $h/24;
		if ($d<2) return 'Yesterday, ' . date('h:iA',$t);
		if ($d<=7) return floor($d) . ' days ago';
		return date("M jS, Y",$t);
	}
		
	/**
	 * functions::get_date_ex()
	 * 
	 * @param mixed $date
	 * @param bool $min
	 * @param bool $hours
	 * @param bool $days
	 * @param bool $week
	 * @return
	 */
	function get_date_ex($date, $min=true, $hours=true, $days=true, $week=true){
	
			$diff = $date;
			
			if($diff == time()){
				return 'NOW';
			}
			
			if ($diff < 3600 )
			{
				if ( $diff < 120 )
				{
					return intval($diff); //time_less_minute
				}
				else
				{
					return intval($diff / 60).' Minutes'; //time_minutes_ago
				}
			}
			else if ($min && $diff < 7200 )
			{
				return intval($diff / 3600).' Hour'; //time_less_hour
			}
			else if ($hours && $diff < 86400 )
			{
				return intval($diff / 3600).' Hours'; //time_hours_ago
			}
			else if ($days && $diff < 172800 )
			{
				return intval( ($diff/24) / (3600)).' Day'; //time_less_day
			}
			else if ($days && $diff <= 604800 )
			{
				return intval( ($diff/24) / (3600)).' Days'; //time_less_day
			}
			else if ($week && $diff < 1209600 )
			{
				return 'time_less_week'; //time_less_week
			}
			else if ($week && $diff < 3024000 )
			{
				return intval($diff / 604900); //time_weeks_ago
			}
	}
	
 	/**
 	 * functions::fetch_assoc()
 	 * 
 	 * @param mixed $result
 	 * @return
 	 */
 	public function fetch_assoc($result)
    {
    	return mysql_fetch_assoc($result);
    }
	
	/**
	 * functions::fetch_data_array()
	 * 
	 * @param mixed $result
	 * @return
	 */
	public function fetch_data_array($result) 
   	{
		$data=array();
	    while( $row = $this->fetch_assoc($result) )
	        { $data[]=$row; } 
	    return $data;
   	}
}
?>