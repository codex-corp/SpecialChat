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

	class mysql_actions
	{

		var $SPECIAL_CORE;

		public function __construct($SPECIAL_CORE)
		{
			$this->SPECIAL_CORE = $SPECIAL_CORE;
			//session_start();
		}

		/**
		 * 	Check and manage actions and commands
		 */

	   public function check_actions($id)
	   {
	     $result = mysql_query("SELECT `C`.users_id,`C`.jail,`C`.kick,`C`.mkick,`C`.banuser,`C`.banip,`C`.xban,`C`.sus,`A`.users_id,`A`.type,`A`.action_by,`A`.reason from `check` C, `actions` A WHERE  `A`.users_id = '{$id}' and `C`.users_id = '{$id}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

	      if($row = mysql_fetch_array($result)){
		  $out[] = $row;
		  }
		  
	      return $out[0];
	   }
	   
	   public function delete_check_row($id){
	   		mysql_query("delete from `check` where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	   }

		public function whois_have_commands($id)
		{
			 $result = mysql_query("SELECT * FROM `groups` WHERE `g_id` = (SELECT `mygroup` FROM `users` WHERE `id` = '{$id}') LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			 if(mysql_num_rows($result) == 1){
			 	 if($row = mysql_fetch_object($result))

				 return array('crlogs' => $row->crlogs,        'actionstop' => $row->actionstop,   'upgrade' => $row->upgrade,
							  'downgrade' => $row->downgrade,  'changepass' => $row->changepass,   'create' => $row->create,
							  'showclear' => $row->showclear,  'showfilter' => $row->showfilter,   'check' => $row->check,
							  'actionlogs' => $row->actionlogs,'showforward' => $row->showforward, 'usermsg' => $row->usermsg,
							  'opmsg' => $row->opmsg
							  );
			 }else{

			     return false;

			 }
		}

		public function whois_have_action($id,$row_name)
		{
			 $result = @mysql_result(mysql_query("SELECT $row_name from `check` WHERE `$row_name` = '1' AND `users_id` = '{$id}' LIMIT 1"),0);
			 
			 if($result == true)
			 return true; 
			 else 
			 return false;
		}

		public function action_by_level($id,$type)
		{
			 $result = mysql_query("SELECT action_by from `actions` WHERE `type` = '{$type}' AND `users_id` = '{$id}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			 if(@mysql_num_rows($result) > 0){

			 	 if ($row = mysql_fetch_object($result))
				 return mysql_result(mysql_query("SELECT level from `users` WHERE `nick` = '{$row->action_by}' LIMIT 1"),0);

			 }else{

			 return false;

			 }
		}

		public function action_by_nick($id,$type)
		{
			 $result = mysql_query("SELECT * from `actions` WHERE `type` = '{$type}' AND `users_id` = '{$id}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			 if(@mysql_num_rows($result) > 0){
			 	 if ($row = mysql_fetch_object($result))
				 return $row->action_by;
			 }else{

			 return false;

			 }
		}

	   function check_saved()
	   {
	   	$result = mysql_query("select * from `logs` where `type` = 'abuse' OR `type` = 'kick' OR `type` = 'banuser' OR `type` = 'mkick' OR `type` = 'banpcuser' OR `type` = 'banpcip'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

	     while ($row = mysql_fetch_array($result))
			$out[] = $row;

	     return $out;
	   }

		function insert_check4action($id,$row_name)
		{
			$insert_check = mysql_query("select users_id,$row_name from `check` where `users_id` = '{$id}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			if($how = mysql_fetch_object($insert_check))
			{
			  if($how->users_id == $id){
				mysql_query("update `check` set `$row_name` = '1' ,`action_time` = '".time()."'  where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			  }

			}else{

			mysql_query("insert into `check`
			(users_id, action_time, $row_name)
			values
			('{$id}', '".time()."', '1')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			}

		}

		function flood_control()
		{

			 //check the level for flood control
			 if($_SESSION['SP_USER_LEVEL'] >= 0 && $_SESSION['SP_USER_LEVEL'] <= 10)
			 {
			 //$result = mysql_query("SELECT time FROM `talk` WHERE `user` = '{$_SESSION['SP_USER_NICK']}' and `room` = '{$room}' order by id DESC LIMIT 1");
				 	$result = $this->get_time(0);
				    //echo $result.'last update'.'<br>';
				    //echo time();
					if ($result >= (time() - 2)){
					 $this->insert_check4action($_SESSION['SP_USER_ID'], 'flood'); //insert check for flood
					 return 1;
					}
			 }##end check the level for flood control
			 return false;
		}

		/**
		 * #################################
		 * 	Timer and Days Counter functions
		 *  Start
		 * #################################
		 */

		function get_time($id=0)
		{
			 $id = ($id>0) ? $id : $_SESSION['SP_USER_ID'];
			 $result = mysql_query("select time_log from `timer` where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			 if($row = mysql_fetch_object($result))
			 {
			    $time_log = $row->time_log;
			 }

			 return $time_log;
		}

		function get_total_time()
		{
			 $total_time = mysql_result(mysql_query("select total_time from timer where users_id = '{$_SESSION['SP_USER_ID']}' LIMIT 1"),0) or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			 
			 return $total_time;
		}

		function insert_total_time($do_total_time, $upgrade)
		{

		  if($do_total_time){
			 //update total time and reset the time log for refresh total time
			 mysql_query("update timer set total_time = total_time + $do_total_time, `time_log` = '".time()."' where `users_id` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
		  }

		  if($upgrade){

			 mysql_query("update users set level = level + 1 where id='{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			 mysql_query("update timer set total_time = '0', `time_log` = '".time()."' where `users_id` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

		  }

		}

		function total_time_update()
		{
		 global $autoup;

		    $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_id($_SESSION['SP_USER_ID']); //get sender info

		    $level = $_SESSION['SP_USER_LEVEL']; //get sender level

			$time_log = $this->get_time(0); //get time login time

			$time_now = time(); //time now :)

			$total = $time_now - $time_log;

			// update the total time and time log without upgrade level
			$this->insert_total_time($total, FALSE);

			$howmytotaltime = $this->get_total_time(); //get total time sender
			$sumtotaltime = $howmytotaltime / 3600; //sum total time on hours
			$mytotaltime = ceil($sumtotaltime); // ceil total time
			$range = range(from_level, to_level);

			if($level >= from_level && $level <= to_level){
				 if(is_array($range)){
					if(in_array($level, $range)){
						$limitaz = $autoup[$level];
					}
				 }

				 if($mytotaltime >= $limitaz){
				     //upgrade message
					 $upgrade_msg = str_replace(array("#user#"), array($user_info->nick), UPGRADE);
					 //upgrade the level and set total time zero(0)
					 $this->insert_total_time(FALSE, TRUE);
					 //post upgrade msg on public room
					 $this->SPECIAL_CORE->mysql_public_private->post_reason($upgrade_msg, 1);
				 }
			}
		}

		/**
		 * #################################
		 * 	Timer and Days Counter functions
		 *  end
		 * #################################
		 */

		/**
		 * 	################################
		 *  user command actions
		 * 	start
		 *  ################################
		 */


		function delete_jail_finish()
		{
			 $time = time();

			 $result = mysql_query("select action_time from `check` where `jail` = '1' and `users_id` = '{$_SESSION['SP_USER_ID']}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			   if($row = mysql_fetch_object($result))
				  if(FUNCTIONS::get_date_min($row->action_time) >= 5){ // after 1 min
					  mysql_query("DELETE FROM `actions` WHERE `type` = 'jail' and `users_id` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
					  mysql_query("update `check` set `jail` = '0' where `users_id` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			      }
		}

	   function kick_user($user_id, $reason, $type, $nick)
	   {
	     $reason = addslashes($reason);
		 $type = $type;
		 $action_time = time();
	   	 $user_id = (int)$user_id;
		 $nick = $nick;
		 $action_by = $_SESSION['SP_USER_NICK'];

		 mysql_query("INSERT INTO `actions`
		 (`reason` , `type` , `action_time`, `users_id`, `action_by`, `action_on`)
		 VALUES
		 ('{$reason}','{$type}', '{$action_time}', '{$user_id}', '{$action_by}', '{$nick}')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
	   }

		function upgrade_downgrade($id, $new_level)
		{

			mysql_query("UPDATE `users` SET `level` = '{$new_level}' WHERE `id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			$users_data = $this->SPECIAL_CORE->mysql_master->get_user_by_id($id);
		    $maskip = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($users_data->level); //get right by level

			mysql_query("UPDATE `users` SET `rights` = '{$maskip}' WHERE `id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			if(mysql_affected_rows() == -1){
		     return false;
		    }else{
		     return true;
		    }
		}

		function change_op($id, $new_nick_name)
		{
			$id = (int)$id;

			mysql_query("UPDATE `users` SET `nick` = '{$new_nick_name}' WHERE `id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			if(mysql_affected_rows() == -1){
			 return false;
			}else{
			 return true;
			}
		}


		function change_password($id, $password)
		{
			//check hash
			$password = md5($password);

			mysql_query("UPDATE `users` SET `password` = '{$password}' WHERE `id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			if(mysql_affected_rows() == -1){
		     return false;
		    }else{
		     return true;
		    }
		}


		function change_password_user($id, $oldpass, $password)
		{
			//check hash MD5( 'hany' )
			$password = md5($password);

			$result = mysql_query("SELECT id FROM `users` WHERE `level` > '0' and `id` = '{$id}' and `password` = MD5('$oldpass') LIMIT 1");

			if(mysql_num_rows($result) == 1){
			mysql_query("UPDATE `users` SET `password` = '{$password}' WHERE `id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			}

			if(mysql_affected_rows() > 0){
		     return true;
		    }else{
		     return false;
		    }
		}

		function change_comment($comment)
		{

		mysql_query("UPDATE `users` SET `comment` = '{$comment}' WHERE `id` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			if(mysql_affected_rows() == -1){
		     return false;
		    }else{
		     return true;
		    }
		}

		function change_ip($setip)
		{

		mysql_query("UPDATE `users` SET `rights` = '{$setip}' WHERE `id` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			if(mysql_affected_rows() == -1){
		     return false;
		    }else{
		     return true;
		    }
		}

		function show_whois($id, $room, $nick)
		{
		 $a = mysql_query("SELECT `W`.`users_id`, `W`.`online`,`U`.`last_seen`,`U`.`id` FROM `who_is_online` W, `users` U WHERE W.online = '1' and W.users_id = '{$id}' and `W`.users_id = `U`.id LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
		    if ( mysql_num_rows($a) == 1 ) {
		        if($row = mysql_fetch_object($a)) {
			    $online = $row->online;
			    $login_time = $row->last_seen;
			    }
			}

		$b = mysql_query("select time from `talk` where `room` = '{$room}' and `user` = '{$nick}' order by id desc LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			if ( mysql_num_rows($b) == 1 ) {
				if($talk = mysql_fetch_object($b)) {
				$last_public_msg_time = $talk->time;
				}
			}

		$c = mysql_query("select time from `private_talk` where `users_id_from` = '{$id}' order by id desc LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			if ( mysql_num_rows($c) == 1 ) {
				if($talk = mysql_fetch_object($c)) {
				$last_private_msg_time = $talk->time;
				}
			}

			return array('online' => $online,
			             'login_time' => $login_time,
						 'last_public_msg_time' => $last_public_msg_time,
						 'last_private_msg_time' => $last_private_msg_time
						 );
		}

		function forward_message_id($f_send_to_id, $type, $room, $f_send_to)
		{
			$name = $_SESSION['SP_USER_NICK']; //forward sender name
			$f_send_to_info = $this->SPECIAL_CORE->mysql_master->get_user_by_id($f_send_to_id); //get info for op forward send

			if($_SESSION['SP_USER_LEVEL'] > 0){

			//select the user info on private table for send msg
			$result = mysql_query("SELECT * from `private_talk` WHERE `users_id_to` = '{$_SESSION['SP_USER_ID']}' and `changed` = '1'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			if(mysql_num_rows($result) == 0) return false;

			}else{

			//select the user info on private table for send msg
			$result = mysql_query("SELECT * from `private_talk` WHERE `users_id_to` = '{$_SESSION['SP_USER_ID']}'  ORDER BY id DESC LIMIT 10") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			}


			$i = 0;

			while($row = mysql_fetch_object($result)){ //fetch the select

				$users_info = $this->SPECIAL_CORE->mysql_master->get_user_by_id($row->users_id_from); //get sender forward info
				$maskip = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($users_info->level); //get right by level

				//replace the message forward for insert syntex
				$text = str_replace(array("#f_sender#","#text#","#nickcolor#","#nickfont#","#user_name#","#rights#","#font#","#color#"), array($name ,$row->text, $users_info->nickcolor, $users_info->nickfont, $users_info->nick, $maskip, $users_info->font, $users_info->color), ChFun_msg_forward);

				if($i < 1){ //replace the message with start syntex
					 $start = str_replace(array("#f_sender#", "#f_send_to#"), array($name, $f_send_to_info->nick), ChFun_msg_forward_logs_start);

					 FUNCTIONS::addforward($type,FALSE,$start);
				}

				//replace the message for insert in forward.html logs
				$msg .= str_replace(array("#text#","#nickcolor#","#nickfont#","#user_name#","#rights#","#font#","#color#"),
									array($row->text, $users_info->nickcolor, $users_info->nickfont, $users_info->nick, $maskip, $users_info->font, $users_info->color), ChFun_msg_forward_logs);

				$text = addslashes($text);
				//insert the message's in private table
				mysql_query("INSERT INTO `private_talk`
					   (`id`, `users_id_from` , `users_id_to` , `text` , `time`, `delivered_from`)
					   VALUES
					   (NULL, '50', '{$f_send_to_id}', '{$text}', '".time()."', '1')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			$i++;
			}##end while

			mysql_query("UPDATE `private_talk` SET `changed` = '0' WHERE `users_id_to` = '{$_SESSION['SP_USER_ID']}' and `changed` = '1'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			FUNCTIONS::addforward($type,FALSE,$msg);
			return true;
		}

		function send_allmsg($sender_id, $text, $room)
		{
		        $users_data = $this->SPECIAL_CORE->mysql_master->get_user_by_id($sender_id);
		        $maskip = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($users_data->level); //get right by level

				$result = mysql_query("SELECT `W`.`users_id`, `W`.`online`,U.`nick`,U.`level`,U.`id`,U.`rights` FROM `who_is_online` W, `users` U WHERE W.online = '1' and W.users_id = U.id") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			    $i = 0;
			    while ($row = mysql_fetch_object($result)){

					  if($row->level >= 0){
					  $msg = str_replace(array("#nickcolor#","#nickfont#","#sender_name#","#rights#","#color#","#font#","#text#"),
					                    array($users_data->nickcolor ,$users_data->nickfont , $users_data->nick, $maskip, $users_data->color, $users_data->font, $text), ChFun_allmsg);

					  $final = addslashes($msg);
					  mysql_query("INSERT INTO `private_talk`
					  (`users_id_from` , `users_id_to` , `text` , `time`, `delivered_from`)
					  VALUES
			          ('50','{$row->id}', '{$final}', '".time()."', '1')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
					  $i++;
				  }
				}
				$this->SPECIAL_CORE->mysql_public_private->post_logs($msg, $room, 'allmsg', FALSE);
				return array('info' => $i);
		}

		################## all msg #############################################

		//----------------- user msg --------------------------------------------

		function send_usermsg($sender_id, $text, $room)
		{
				$users_data = $this->SPECIAL_CORE->mysql_master->get_user_by_id($sender_id);
		        $maskip = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($users_data->level); //get right by level

				$result = mysql_query("SELECT `W`.`users_id`, `W`.`online`,U.`nick`,U.`level`,U.`id`,U.`rights` FROM `who_is_online` W, `users` U WHERE W.online = '1' and W.users_id = U.id") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			    $i = 0;
			    while ($row = mysql_fetch_object($result)){
					  if($row->level == 0){

					  $msg = str_replace(array("#nickcolor#","#nickfont#","#sender_name#","#rights#","#color#","#font#","#text#"),
					                    array($users_data->nickcolor ,$users_data->nickfont , $users_data->nick, $maskip, $users_data->color, $users_data->font, $text), ChFun_guestmsg);

					  $final = addslashes($msg);
					  mysql_query("INSERT INTO `private_talk`
					  (`users_id_from` , `users_id_to` , `text` , `time`, `delivered_from`)
					  VALUES
			          ('50','{$row->id}', '{$final}', '".time()."', '1')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
					    $i++;
				  }

				}
				$this->SPECIAL_CORE->mysql_public_private->post_logs($msg, $room, 'usermsg', FALSE);
				return array('info' => $i);
		}

		################## user msg #############################################

		//----------------- operator msg --------------------------------------------

		function send_opmsg($sender_id, $text, $room)
		{
				$users_data = $this->SPECIAL_CORE->mysql_master->get_user_by_id($sender_id);
		        $maskip = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($users_data->level); //get right by level

				$result = mysql_query("SELECT `W`.`users_id`, `W`.`online`,U.`level`,U.`id`,U.`rights` FROM `who_is_online` W, `users` U WHERE W.online = '1' and W.users_id = U.id ") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			    $i = 0;
			    while ($row = mysql_fetch_object($result)){

					  if($row->level > 0){

					  $msg = str_replace(array("#nickcolor#","#nickfont#","#sender_name#","#rights#","#color#","#font#","#text#"),
					                    array($users_data->nickcolor ,$users_data->nickfont , $users_data->nick, $maskip, $users_data->color, $users_data->font, $text), ChFun_opmsg);

					  $final = addslashes($msg);
					  mysql_query("INSERT INTO `private_talk`
					  (`users_id_from` , `users_id_to` , `text` , `time`, `delivered_from`)
					  VALUES
			          ('50','{$row->id}', '{$final}', '".time()."', '1')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
					    $i++;
						}
				}
				$this->SPECIAL_CORE->mysql_public_private->post_logs($msg, $room, 'opmsg', FALSE);
				return array('info' => $i);
		}

		function check_ban_address($banip)
		{
			$my_ban = @mysql_result(@mysql_query("SELECT id FROM `actions` WHERE `banip` REGEXP '^{$banip}$' LIMIT 1"),0) or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			if($my_ban == false) return false; else return $my_ban;
		}

		function get_ban_by_level($banip)
		{
			$ban_by = @mysql_result(@mysql_query("SELECT action_by FROM `actions` WHERE `banip` REGEXP '^{$banip}$' LIMIT 1"),0) or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			if($ban_by == true){
				$ban_by_level = @mysql_result(@mysql_query("SELECT level FROM `users` WHERE `level` > '0' and `nick` = '{$ban_by}' LIMIT 1"),0) or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
			    return $ban_by_level;
			}

			return false;
		}

		function banip_address($reason, $type, $banip, $action_on)
		{
			 $reason = addslashes($reason);
			 $action_time = time();
			 $action_by = $_SESSION['SP_USER_NICK'];

			 mysql_query("INSERT INTO `actions` (`reason` , `type` , `action_time`, `banip`, `action_by`, `action_on`) VALUES ('{$reason}','{$type}', '{$action_time}', '{$banip}', '{$action_by}', '{$action_on}')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
		}

		function ban_nick($reason, $type, $banip=false, $action_on, $users_id=false)
		{
			 $reason = addslashes($reason);
			 $action_time = time();
			 $action_by = $_SESSION['SP_USER_NICK'];

			 mysql_query("INSERT INTO `actions`
			 (`reason` , `type` , `action_time`, `banip`, `users_id` ,`action_by`, `action_on`)
			 VALUES
			 ('{$reason}','{$type}', '{$action_time}', '{$banip}', '{$users_id}', '{$action_by}', '{$action_on}')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
		}

	   function suspended_user($user_id, $reason, $type, $nick)
	   {
	     $reason = addslashes($reason);
		 $action_time = time();
	   	 $user_id = (int)$user_id;
	     $action_by = $_SESSION['SP_USER_NICK'];

		 mysql_query("INSERT INTO `actions`
		 (`reason` , `type` , `action_time`, `users_id`, `action_by`, `action_on`)
		 VALUES
		 ('{$reason}','{$type}', '{$action_time}', '{$user_id}', '{$action_by}', '{$nick}')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
	   }

	   function delete_sus($users_id)
	   {
		     //the user id well be stop the sus
		     $users_id = (int)$users_id;

			 //delete the sus from action's table
			 mysql_query("delete from `actions` where `type` = 'sus' and `users_id` = '{$users_id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			 //delete the sus for this member from check table
		     mysql_query("update `check` set `sus` = '0' where `users_id` = '{$users_id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			 //check affected rows (update, delete)
			 if(mysql_affected_rows() == -1){
		     return false;
			 }else{
			 return true;
			 }
	   }

	   function multikick_user($user_id, $nick, $last_ip, $reason)
	   {

		 $reason = addslashes($reason);

	     $g = mysql_query("SELECT `W`.`users_id`,`W`.action_time,`W`.`online`,U.`nick`,U.`last_ip`,U.`level`,U.`id` FROM `who_is_online` W, `users` U WHERE W.users_id = U.id and W.online = '1'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			$i = 0;
		    while ($row = mysql_fetch_object($g)){

				if(($row->level == 0) and ($row->last_ip == $last_ip)){
				$name .= $row->nick . ',';

				mysql_query("INSERT INTO `actions`
		        (`reason` , `type` , `action_time`, `users_id`, `action_by`, `action_on`)
		        VALUES
		        ('{$reason}','mkick', '{$row->action_time}', '{$row->id}', '{$_SESSION['SP_USER_NICK']}', '{$row->nick}')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

				mysql_query("delete from `who_is_online` where `online` = '1' and `users_id` = '{$row->id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

				$this->SPECIAL_CORE->mysql_actions->insert_check4action($row->id, 'mkick');
				$i++;
				}

			}##end while loop

			return array('number' => $i, 'name' => $name);
	   }


	   function disable_member($user_id, $reason, $type, $nick)
	   {
	     $reason = addslashes($reason);
		 $action_time = time();
	     $action_by = $_SESSION['SP_USER_NICK'];

		 mysql_query("INSERT INTO `actions`
		 (`reason` , `type` , `action_time`, `users_id`, `action_by`, `action_on`)
		 VALUES
		 ('{$reason}','{$type}', '{$action_time}', '{$user_id}', '{$action_by}', '{$nick}')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
	   }

	   function enable_member($users_id)
	   {
		 mysql_query("delete from `actions` where `type` = 'disable' and `users_id` = '{$users_id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

	     mysql_query("update `check` set `disable` = '0' where `users_id` = '{$users_id}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

			 if(mysql_affected_rows() > 0){
		     return true;
			 }else{
			 return false;
			 }
	   }

		function jail_user($user_id, $reason, $type, $nick)
		{
			 $reason = addslashes($reason);
			 $action_time = time();
			 $action_by = $_SESSION['SP_USER_NICK'];

			 mysql_query("INSERT INTO `actions`
			 (`reason` , `type` , `action_time`, `users_id`, `action_by`, `action_on`)
			 VALUES
			 ('{$reason}','{$type}', '{$action_time}', '{$user_id}', '{$action_by}', '{$nick}')") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
		}

	   function truncate(){
		 mysql_query("TRUNCATE TABLE `talk`") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);
		 $this->SPECIAL_CORE->mysql_public_private->post_reason('The Public Has Been Cleaned', '1');
	   }


	   function clear_user_message($nick,$sender,$type)
	   {

	    $q = mysql_query("SELECT * from `talk` WHERE `user` = '{$nick}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

		if(mysql_num_rows($q) > 0){

		 $i = 0;
		 while($clear = mysql_fetch_object($q)){

		    $users_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($clear->user); //get user
			$maskip = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($users_info->level);

			if($i == 0){ //replace the message with start syntex
				 $start = str_replace(array("#user#","#sender#"), array($nick,$sender), ChFun_msg_clear_logs_start);
			}
			
			if( eregi('{#d#} /d ',$clear->text) ) $clear->text = str_replace(array("/d ","{#d#} "), array("",""), $clear->text );
		     //replace the message for insert in clear.html logs
			 $msg .= str_replace(array("#text#","#nickcolor#","#nickfont#","#user_name#","#rights#","#font#","#color#"),
								array($clear->text, $users_info->nickcolor, $users_info->nickfont, $users_info->nick, $maskip, $users_info->font, $users_info->color), ChFun_msg_clear_logs);
		 }

		  //add the message with start syntex
		  FUNCTIONS::addmsg($type,FALSE,$start);
		  //add the message in in clear.html logs
		  FUNCTIONS::addmsg($type,FALSE,$msg);
	    }

		 mysql_query("delete from `talk` where `user` = '{$nick}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

	   }

	   function filter_user_message($word,$sender,$type)
	   {

	    $q = mysql_query("SELECT * from `talk` WHERE `user` != 'Chat System' and `text` REGEXP '{$word}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

		if(mysql_num_rows($q) > 0):
		$i = 0;

		 while($filter = mysql_fetch_object($q)):

		    $users_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($filter->user); //get user
			$maskip = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($users_info->level);

			if($i == 0){ //replace the message with start syntex
				 $start = str_replace(array("#word#","#sender#"), array($word,$sender), ChFun_msg_filter_logs_start);
			}
			
			if( eregi('{#d#} /d ',$filter->text) ) $filter->text = str_replace(array("/d ","{#d#} "), array("",""), $filter->text );
		     //replace the message for insert in filter.html logs
			 $msg .= str_replace(array("#text#","#nickcolor#","#nickfont#","#user_name#","#rights#","#font#","#color#"),
								 array($filter->text, $users_info->nickcolor, $users_info->nickfont, $users_info->nick, $maskip, $users_info->font, $users_info->color), ChFun_msg_filter_logs);
		 endwhile;

		  //add the message with start syntex
		  FUNCTIONS::addmsg($type,FALSE,$start);
		  //add the message in in clear.html logs
		  FUNCTIONS::addmsg($type,FALSE,$msg);
	     endif;

		 mysql_query("delete from `talk` WHERE `text` REGEXP '{$word}'") or FUNCTIONS::debug(mysql_error(), "mysql_actions", __LINE__);

	   }

	}

?>