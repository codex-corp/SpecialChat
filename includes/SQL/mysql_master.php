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

	class mysql_master
	{
		
		var $SPECIAL_CORE;
		
		public function __construct($SPECIAL_CORE)
		{
			$this->SPECIAL_CORE = $SPECIAL_CORE;
			//session_start();
		}
		
		function fetch_object($data){
			if(is_resource($data)) return mysql_fetch_object($data);			
		}
		
		
		function get_rights_by_level($get_rights)
		{
		$i = "$get_rights";
		do {
			if ($i == 1) {
			  $rights = "Trial op";
			  break;
			}elseif($i>=2 && $i <= 25){
			  $rights = "Operator";
			  break;
			}elseif($i>=26 && $i <= 35){
			  $rights = "Super op";
			  break;
			}elseif($i>=36  && $i <= 40){
			  $rights = "Cop";
			  break;
			}elseif($i>=41  && $i <= 44){
			  $rights = "Super cop";
			  break;
			}elseif($i>=45  && $i <= 47){
			  $rights = "Agent";
			  break;
			}elseif($i == 48){
			  $rights = "Wizard";
			  break;
			}elseif($i == 49){
			  $rights = "Monitor";
			  break;
			}elseif($i == 50){
			  $rights = "Admin";
			  break;
			}else{
			  $rights = "Guest";
			  break;
			}//end if
		} while (0); //end while
		return $rights;
		}//end function
	
	  // Colors for chat users
	   function get_user_color($get_level) {
	   
	   	$i = "$get_level";
		do {
			if ($i == 1) {
				$color = "#99A3A7";
				break;
			}else if($i >= 2 && $i <= 4) {
				$color = "#7B8589";
				break;
			}else if($i >= 5 && $i <= 15) {
				$color = "#4E5558";
				break;
			}else if($i >= 16 && $i <= 25) {
				$color = "#333632";
				break;
			}else if($i >= 26 && $i <= 34) {
				$color = "#5681AF";
				break;
			}else if($i >= 35 && $i <= 40) {
				$color = "#002B5F";
				break;
			}else if($i >= 41 && $i <= 45) {
				$color = "#7B6595";
				break;
			}else if($i == 46) {
				$color = "#FA964A";
				break;
			}else if($i == 47) {
				$color = "#DE6100";
				break;
			}else if($i == 48) {
				$color = "#2D6CC0";
				break;
			}else if($i == 49) {
				$color = "#003696";
				break;
			}else if($i == 50) {
				$color = "red";
				break;
			}else{
				$color = "#000000";
				break;
			}//end if
		 } while (0); //end while
		 return $color;
	   }
	   
	    function get_room_by_id($id){
			 $room_name = mysql_result(mysql_query("select room_name from `rooms` where `id` = '{$id}'"),0) or FUNCTIONS::debug(mysql_error(), "mysql_master", __LINE__);	
			 return	$room_name;	 
	    }
	   
//		function get_all_rooms()
//		{
//		 $this->delete_offline_guset();
//		 $undefined = $out = array();
//		
//		 $result = mysql_query("select * from ".LTChat_Main_prefix."rooms where chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
//		 while ($row = mysql_fetch_object($result))
//		   $out[] = $row;
//		
//		 $result = mysql_query("select ".LTChat_Main_prefix."users.id, nick, room from `".LTChat_Main_prefix."who_is_online`,`".LTChat_Main_prefix."users` where users_id = ".LTChat_Main_prefix."users.id and online = '1' and `".LTChat_Main_prefix."who_is_online`.`chat_id` = '".LTChat_Main_CHAT_ID."' and `".LTChat_Main_prefix."users`.`chat_id` = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
//		 while ($row = mysql_fetch_object($result))
//		 {
//		 	for($i = 0; $i < count($out); $i++)
//		 	{
//		 	  if($out[$i]->room_name == $row->room)
//		 	  {
//		 	    $out[$i]->users_online[] = array('nick' => $row->nick, 'id' => $row->id);
//		 	    break;
//		 	  }
//		 	}
//		 	if($out[$i]->room_name != $row->room)
//		 	  $undefined[$row->room][] = $row->nick;
//		 }
//		
//		
//		 return array('defined' => $out, 'undefined' => $undefined);
//		}
		
	   function get_users_list_from_array($users)
	   {
	   	
		  $time = time();
	   	  if(is_array($users))
	   	  {
	        foreach ($users as $id)
	          $where .= " or O.users_id = '{$id}' ";
			
	        $query_select = "SELECT `O`.`who_id` as id, `O`.`users_id`, `O`.`online`, `O`.`room`, `O`.`action_time`, U.`nick`,U.`picture_url`,U.`id` as user_id FROM `who_is_online` O, `users` U WHERE O.users_id = U.id and (1=2 {$where}) and O.online = '1' order by who_id asc";
	
			$result = mysql_query($query_select) or FUNCTIONS::debug(mysql_error(), "mysql_master", __LINE__);
		    while ($row = mysql_fetch_object($result))
		      $out[] = $row;
	   	  }
		  return $out;
	   }
	   
	   
	   function get_users_list($room = NULL)
	   {
//$time = time();
//		 if($who_id == 0)	   $query_select = "SELECT `O`.`who_id` as id, `O`.`users_id`, `O`.`online`, `O`.`room`, `O`.`action_time`, U.`nick`,U.`level`,U.`rights`,U.`id` as user_id FROM `who_is_online` O, `users` U WHERE O.users_id = U.id and O.online = '1' and `O`.`room` = '{$room}' order by U.`level` DESC";
//		 else				   $query_select = "SELECT `O`.`who_id` as id, `O`.`users_id`, `O`.`online`, `O`.`room`, `O`.`action_time`, U.`nick`,U.`level`,U.`rights`,U.`id` as user_id FROM `who_is_online` O, `users` U WHERE O.users_id = U.id and O.who_id > '{$who_id}' and `O`.`room` = '{$room}' group by online order by who_id asc";

		 $query_select = "SELECT `O`.`who_id` as id, `O`.`users_id`, `O`.`online`, `O`.`room`, `O`.`action_time`, U.`nick`,U.`level`,U.`nickfont`,U.`rights`,U.`id` as user_id FROM `who_is_online` O, `users` U WHERE O.users_id = U.id and O.online = '1' order by U.`level` DESC";
	
		 $result = mysql_query($query_select) or FUNCTIONS::debug(mysql_error(), "mysql_master", __LINE__);
//	     while ($row = mysql_fetch_object($result))
//	       $out[] = $row;
	     return $result;
	   }
		
		function add_user($login, $password, $other_options = array(), $guest = 0)
		{
		//$hany = $time - get_ConfVar("ChDK_delete_guest_after");
		
		   //$this->delete_offline_guset();
		
		   $login = addslashes($login);
		
		   //if((boolean)get_ConfVar("LTChat_md5_passwords"))  
		   $password = md5($password);
		     
		   //$password = addslashes($password);
		
		   $level = $_POST['thelevel'] ? $_POST['thelevel'] : '0';
		   
		   $rights = $this->get_rights_by_level($level); //get right by level
			 
		  $rand_color = array("#9900FF","#FF0000","#CC3366","#0099CC","#6600FF","#0000FF","#009900","#660000","#FF9900","#FF00CC","#FF3399","#FF66FF", "FF99FF","#CC9900","#0033FF","#CC6666","#9966FF","#000000","#003366","#339999","#CC66FF","#330099","#990099","#3366FF","#000033","#CC9999","#663300","#996666","#FFCCCC");
		  
		  //Rand color array for give user 'color'
		  $result = array_rand($rand_color);
		  
		  //Rand color array for give user 'nickcolor'
		  $result2 = array_rand($rand_color);
		
		   mysql_query("INSERT INTO `users` 
		   (nick, password, registered, rights, color, nickcolor, font, nickfont, level, email, comment) 
		   values 
		   ('{$login}', '{$password}','".time()."','{$rights}','{$rand_color[$result]}','{$rand_color[$result2]}','Tahoma','Tahoma', '{$level}', '{$antispam}','')") or FUNCTIONS::debug(mysql_error(), "mysql_master", __LINE__);
		
		   if(mysql_affected_rows() == -1)
		     return false;
		   else
		   {
		     $result = mysql_query("select * from `users` where `nick` = '{$login}' and `password` = '{$password}'") or FUNCTIONS::debug(mysql_error(), "mysql_master", __LINE__);
			 if($user = mysql_fetch_object($result))
			 {
			   if(is_array($other_options))
			     foreach ($other_options as $ot_id => $ot_ar)
			     {
			       $value = addslashes($ot_ar['value']);
			       mysql_query("INSERT INTO `users_var` 
				   (`users_var_names_id` , `users_id` , `value`) 
				   VALUES 
				   ('{$ot_id}', '{$user->id}', '{$value}');") or FUNCTIONS::debug(mysql_error(), "mysql_master", __LINE__);
			     }
			 }
			 else 
			   return false;
		   	 
		     return true;
		   }
		}
		
		function get_user_by_nick($nick, $simple = false)
		{
			 $nick = addslashes($nick);
			 $result = mysql_query("select * from users where nick = '{$nick}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_master", __LINE__);
			
			 if($row = mysql_fetch_object($result))
			 {
			   if(!$simple)
			   {
			     $result = mysql_query("SELECT * FROM `users_var` where users_id = '{$row->id}'") or FUNCTIONS::debug(mysql_error(), "mysql_master", __LINE__);
			     while ($res_vars = mysql_fetch_object($result))
			       $row->other_fields[] = $res_vars;
			   }
			   return $row;
			 }
			 else
			   return null;
		}
		
		function get_user_by_id($id, $simple = false)
		{		
			 $result = mysql_query("select * from users where id = '{$id}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_master", __LINE__);
			
			 if($row = mysql_fetch_object($result))
			 {
			   if(!$simple)
			   {
			     $result = mysql_query("SELECT * FROM `users_var` where users_id = '{$row->id}'") or FUNCTIONS::debug(mysql_error(), "mysql_master", __LINE__);
			     while ($res_vars = mysql_fetch_object($result))
			       $row->other_fields[] = $res_vars;
			   }
			   return $row;
			 }
			 else
			   return null;
		}
		

	}
			
?>