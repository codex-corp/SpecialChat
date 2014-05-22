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
	class mysql_public_private
	{
		
		var $SPECIAL_CORE;
		
		public function __construct($SPECIAL_CORE)
		{
			$this->SPECIAL_CORE = $SPECIAL_CORE;
			//session_start();
		}
		
		function post_reason($text, $room)
		{
			 $user = 'Chat System';
			 $user = $user;
			 $room = $room;
			 $text = addslashes($text);
			 $time = time();
			
			 if(trim($text) != "")
			 {
				mysql_query("INSERT INTO `talk` 
				(`user` , `room` , `text` , `time`) 
				VALUES 
				('{$user}','{$room}', '{$text}', '{$time}')") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
				return true;
			 }
			 else 
			   return false;
		}
		
		function post_logs($reason, $room, $type, $action_on)
		{
			 $reason = addslashes($reason);
			 $type = $type;
			 $room = $room;
			 $action_time = time();
			 $action_by = $_SESSION['SP_USER_NICK'];
			 $action_on = $action_on;
			
			 if(trim($reason) != "")
			 {
				mysql_query("INSERT INTO `logs` 
				(`reason` , `type` , `room` , `action_time`, `action_by`, `action_on`) 
				VALUES 
				('{$reason}','{$type}', '{$room}', '{$action_time}', '{$action_by}', '{$action_on}')") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
				return true;
			 }
			 else 
			   return false;
		}
		
		function post_private_logs($text)
		{
		    $users_data = $this->SPECIAL_CORE->mysql_master->get_user_by_id($sender_id);
		    $maskip = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($users_data->level); //get right by level
		
			$result = mysql_query("SELECT `W`.`users_id`, `W`.`online`,U.`nick`,U.`level`,U.`id` FROM `who_is_online` W, `users` U WHERE W.users_id = U.id and W.online = '1'") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
		
		    while ($row = mysql_fetch_object($result)){
			  if($row->level > 0){
			  
			  $final = addslashes($text);
			  mysql_query("INSERT INTO `private_talk` 
			  (`users_id_from` , `users_id_to` , `text` , `time`, `delivered_from`) 
			  VALUES 
		      ('50','{$row->id}', '{$final}', '".time()."', '1')") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
		      
			  }	
			}
		}
		
		function post_private_reason($text, $private_id, $delivered)
		{		
			 if($delivered)		$delivered = 1;
			 else				$delivered = 0;
			
			 $text = addslashes($text);
			 $time = time();
			
			 if($private_id >= 0 && trim($text) != "")
			 {
			
			   $insert_msg = "INSERT INTO `private_talk` 
			   (`users_id_from` , `users_id_to` , `text` , `time`, `delivered_from`) 
			   VALUES 
			   ('50','{$private_id}', '{$text}', '{$time}', '{$delivered}')";
			   mysql_query($insert_msg) or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
			   return $text;
			   
			 }
			 else
			 {
			   return $text;
			 }
		}
		
		function abuse_public($id,$room)
		{
		 $result = mysql_query("SELECT * from talk WHERE text NOT REGEXP '^[[.slash.]]' AND room = '{$room}' order by id desc limit 30") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
		
				 while ($row = mysql_fetch_object($result))
				 {
			 	 
				 if( eregi('{#d#} /d ',$row->text) ) 
				 $row->text = str_replace(array("/d ","{#d#} "), array("",""), $row->text );
				 			 	 
				 $msg = str_replace(array("#mynick#","#text#"),array($row->user,$row->text), abuse);			
					if ($msg) {
				        $filename = $id.time();
						// 1.file name 2.user name 3.message
				        FUNCTIONS::add($filename,FALSE,$msg);
					}			
			     }
		}
		
		function delete_private()
		{
		mysql_query("delete from `private_talk` where `users_id_to` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
		}
	   
		function delete_over_public_messages(){
		
			$lines = mysql_result(mysql_query("SELECT COUNT(id) FROM `talk` WHERE `room` = '{$this->SPECIAL_CORE->room}'"),0) or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
			//sum the messages numbers and delete
			if($lines > 150){
			mysql_query("delete FROM `talk` WHERE `room` = '{$this->SPECIAL_CORE->room}' ORDER BY id ASC LIMIT ".($lines - 150)." ") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
			}
					
		}
	   
	   
		function delete_offline_private($id)
		{
		   mysql_query("delete from `private_talk` WHERE `users_id_to` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
		}

	   function delete_private_by_id_rec($id)
	   {
	 		 mysql_query("delete from `private_talk` where `id` = '{$id}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
			 //check affected rows (update, delete)
			 if(mysql_affected_rows() == 1){
		     return true;
			 }else{
			 return false;
			 }
	   }
	   

	   function delete_private_by_id()
	   {
	mysql_query("delete from `private_talk` where `users_id_to` = '{$_SESSION['SP_USER_ID']}' and `changed` = '1'") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
			 //check affected rows (update, delete)
			 if(mysql_affected_rows() > 0){
		     return true;
			 }else{
			 return false;
			 }
	
	   } 
		
		function delete_message_id($id, $private_id)
		{
			 if($private_id < 0)	mysql_query("delete from talk where id = '{$id}' and user = '{$_SESSION['SP_USER_NICK']}'") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
			 else					mysql_query("delete from `private_talk` where id = '{$id}' and `users_id_from` = '{$_SESSION['SP_USER_ID']}' or `users_id_to` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
		}
		
		function check_private_id($id)
		{
			 if(is_null($id) || $id == false) return false;
			 if(sizeof($id) > 0)
			 {
			   foreach($id as $value)
				 {
				  if(!empty($value))
			mysql_query("UPDATE `private_talk` set changed = '1' where users_id_to = '{$_SESSION['SP_USER_ID']}' and id = '{$value}'") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
			      
				 }
			 }
		}
		
		function post_private_msg($text, $private_id, $delivered)
		{
		 mysql_query("update users set posted_msg = posted_msg + 1 where id = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
		
		 if($delivered)		$delivered = 1;
		 else				$delivered = 0;
		
		 $user = $_SESSION['SP_USER_NICK'];
		
		 $room = $room;
		 $user = $user;
		 $text = addslashes($text);
		 $time = time();
		
		
		 if($private_id >= 0 && trim($text) != "")
		 {

			$result = mysql_query("select * from `ignore` where 
			(from_users_id = '{$_SESSION['SP_USER_ID']}' and to_users_id = '{$private_id}') or 
			(from_users_id = '{$private_id}' and to_users_id = '{$_SESSION['SP_USER_ID']}') or 
			(from_users_id = '{$private_id}' and to_users_id = '0')
			") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
						
			if($row = mysql_fetch_object($result))
			{
				if($row->to_users_id == $_SESSION['SP_USER_ID']){
					$text = "/ERROR ignore ".ERROR_IGNORE_FROM;
				}
				if($row->to_users_id == $private_id){
					$text = "/ERROR ignore ".ERROR_IGNORE_TO;
				}
				
				$res = mysql_commands::get_friend_list();

				if($row->to_users_id == '0' && $res['to'][0]->users_id != $private_id){
					$text = "/ERROR ignore ".ERROR_IGNORE_FROM_ALL;
				}
			
			}

			if(!eregi('ERROR',$text)){
				$insert_msg = "INSERT INTO `private_talk` 
				(`users_id_from` , `users_id_to` , `text` , `time`, `delivered_from`) 
				VALUES 
				('{$_SESSION['SP_USER_ID']}','{$private_id}', '{$text}', '{$time}', '{$delivered}')";
				mysql_query($insert_msg) or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);		
			}
			
		  	return $text;
		  	
		  }else{
		  	
			return $text;
			
		  }
		}
		
		function post_msg($text, $room, $private_id_checked)
		{	 
			mysql_query("update users set posted_msg = posted_msg + 1 where id = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
			
			$user = $_SESSION['SP_USER_NICK'];
			$user = $user;
			$room = $room;
			$text = addslashes($text);
			$time = time();
			
			$this->check_private_id($private_id_checked);
			
			if(trim($text) != "")
			{

			mysql_query("INSERT INTO `talk` 
			(`user` , `room` , `text` , `time`) 
			VALUES 
			('{$user}','{$room}', '{$text}', '{$time}')") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
				return true;
			}
			else 
				return false;
		}
		
		function get_public_elements($room)
		{
			
			$limit = MAX_MSG_ON_ENETER;

			$result = mysql_query("SELECT * FROM (select * from `talk` WHERE `room` = '{$room}' and text NOT REGEXP '^[[.slash.]]' order by id desc limit 0, $limit) AS h order by h.id asc") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
			
			return $result;
		}
		

		function get_commands_elements($room)
		{
			 $limit = MAX_MSG_ON_ENETER;

			 $result = mysql_query("select * from `talk` where room = '{$room}' and text REGEXP '^[[.slash.]]' order by id desc limit 0, {$limit}") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);

			 return $result;
		}
		
		function delete_expired_msg()
		{
			
		    $time = time();
			//delete all private message out the expired time
			mysql_query("delete from `private_talk` WHERE `users_id_to` = '{$_SESSION['SP_USER_ID']}' and time < {$time}-".MESSAGE_EXPIRED_AFTER."") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
		}
		
		function restart_flooder()
		{			
			mysql_query("update `check` set `flood` = '0' where `users_id` = '{$_SESSION['SP_USER_ID']}' and `flood` = '1' and `action_time` <= ".(time()-2)." ") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
		}
		
		function get_my_new_private_messages()
		{
			 $result = mysql_query("SELECT U.nick as user, U.rights, U.nickfont, U.nickcolor, U.color, U.font, U.id as user_id, PT.id, PT.users_id_from, PT.users_id_to, PT.text, PT.time, PT.delivered_from, PT.delivered_to FROM `users` U , `private_talk` PT WHERE PT.users_id_from = U.id and PT.users_id_to = '{$_SESSION['SP_USER_ID']}' and delivered_from = '1' and delivered_to = '0' order by id asc") or FUNCTIONS::debug(mysql_error(), "mysql_public_private", __LINE__);
			
//			 while ($row = mysql_fetch_object($result)){
//			   $out[] = $row;
//			 }
			   
			 return $result;
		}
		
		
		
	}	
	
?>