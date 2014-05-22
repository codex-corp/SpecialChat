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

	class mysql_login
	{
		
		var $SPECIAL_CORE;
		
		public function __construct($SPECIAL_CORE)
		{
			$this->SPECIAL_CORE = $SPECIAL_CORE;
			//session_start();
		}
		
		//BUG:Fix double entery
		public function LOGIN_PROCESS($login)
		{						
				
				/**
				 *  ###########################
				 *  Guest Login Process Actions 
				 *  ###########################
				 */				
				if($this->SPECIAL_CORE->check_guest == true){
					
				/**
				 * select the user actions on table
				 */
				$actions = mysql_query("SELECT * FROM `actions` WHERE `action_on` = '{$login}' ORDER BY id DESC LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
					
					//select the type and reason and time
					if($action_row = mysql_fetch_object($actions))
					{
						$type = $action_row->type;
						$reason = $action_row->reason;
						$action_time = $action_row->action_time;
					}##
					
										
					switch($type){
						
						/**
						 * Check kick and flash kick for users kicked more 3 min
						 */
						case "kick":
							if(FUNCTIONS::get_date_min($action_time) >= 3)
								$this->delete_guest_from_kick($login);
							else
								return array('error' => 'KICK', 'reason' => $reason);				
						break;
						
						/**
						 * Check multi kick and flash users kicked more 3 min
						 */
						case "mkick":
							if(FUNCTIONS::get_date_min($action_time) >= 3)
								$this->delete_guest_from_mkick($login);
							else
								return array('error' => 'MKICK', 'reason' => $reason);
						break;
						
						/**
						 * check actions for ban user
						 */
						case "banuser":
							$check_ban = $this->delete_guest_from_ban($login);
							if($check_ban) return $check_ban;
						break;
						
					}					
							
					/**
					 * check actions for ban ip || pc ip
					 */
					$check_ban_ip = $this->delete_guest_from_ban($login);
					if($check_ban_ip) return $check_ban_ip;

					//insert new user to users table and insert an option
				 	$this->SPECIAL_CORE->password = rand(0,12345678);
				 	$this->SPECIAL_CORE->mysql_master->add_user($this->SPECIAL_CORE->username, $this->SPECIAL_CORE->password, array(), $this->SPECIAL_CORE->check_guest);	

					/**
					 * select an user from database by nick
					 */
					$result = mysql_query("SELECT * FROM `users` WHERE `nick` = '{$login}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);					
					$row = mysql_fetch_object($result);					

				}
				
					
				/**
				 * ############################
				 * Member Login Process Actions 
				 * ############################
				 */	
				if($this->SPECIAL_CORE->check_guest == false){
	
				/**
				 * select an user from database by nick
				 */
				$result = mysql_query("SELECT * FROM `users` WHERE `nick` = '{$login}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
				
				$row = mysql_fetch_object($result);
				
				//check repeated nick for user if online
				if( !$this->check_exists($row->nick,$row->level) ) return 'Not Found In Members List';
					
				/**
				 * select the user actions on table
				 */
				$actions = mysql_query("SELECT * FROM `actions` WHERE `users_id` = '{$row->id}' ORDER BY id DESC LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
				
					//select the type and reason and time
					if($action_row = mysql_fetch_object($actions))
					{
						$type = $action_row->type;
						$reason = $action_row->reason;
						$action_time = $action_row->action_time;
					}##
					
					
					/**
					 * Check Member Password
					 */				
					//check password for member only on login
					if( strcmp( md5($this->SPECIAL_CORE->password) , $row->password ) != 0 ){
						return array('error' => 'BAD_PASS');
					}
					
					switch($type){
						
						/**
						 * Check sus and flash users suspaneded more 7days
						 */
						case "sus":
							if(FUNCTIONS::get_date_days($action_time) >= 7){
								$this->delete_member_from_sus($row);
							}else{
								return array('error' => 'SUS', 'reason' => $reason);
							}						
						break;
						
						/**
						 * Check kick and flash kick for users kicked more 3 min
						 */
						case "kick":
							if(FUNCTIONS::get_date_min($action_time) >= 3){
								$this->delete_member_from_kick($row);
							}else{
								return array('error' => 'KICK', 'reason' => $reason);
							}					
						break;
						
					}				
					
					/**
					 * Check for howis waiting me and send wait msg!
					 */
					$this->check_who_wait_me($row);
					

				}	
				
				/**
				 * Check Member Timer
				 */
				$this->check_timer($row);
			
				
				/**
				 * Build Member Session's
				 */
			    
				$this->SPECIAL_CORE->bulid_session($row->nick);
				
				$_SESSION['SP_USER_ID'] = $row->id;			
				$_SESSION['SP_USER_NICK'] = $row->nick;
				$_SESSION['SP_USER_TITLE'] = $row->rights;
				$_SESSION['SP_USER_LEVEL'] = $row->level;
				
				//session_register("SP_USER_ID");
				//session_register("SP_USER_NICK");
				
				/**
				 * update and create new session life for who is online
				 */
				$this->enter_room($row->id,$this->SPECIAL_CORE->room);	
				
				//generate the rights for user by level
				$maskip = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($row->level);
				//generate user color by level
				$user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($row->level);
				
				if($row->mygroup == 1)	$login_rights = 'Team Members';
				else if($row->mygroup == 2) $login_rights = 'ADV Team';
				else if($row->mygroup == 0) $login_rights = 'New Login';
				
				$room_name = $this->SPECIAL_CORE->mysql_master->get_room_by_id($this->SPECIAL_CORE->room);
				
				//create the login message
				$msg = str_replace(array("#login_right#", "#user#", "#user_color#", "#rights#", "#ip#", "#room#"),
								   array($login_rights,$row->nick, $user_color, $maskip, $row->rights, $room_name), ChFun_new_login);
				
				//post the login message in public   
				$this->SPECIAL_CORE->mysql_public_private->post_reason($msg, $this->SPECIAL_CORE->room);			
				
				/**
				 * Update last login on database and ip && pcip
				 */
				mysql_query("update `users` set last_seen = '".time()."', last_host = '{$this->SPECIAL_CORE->hostname}', last_ip = '{$this->SPECIAL_CORE->realip}', last_pcip = '{$this->SPECIAL_CORE->pcip}' where `id` = '{$row->id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);	
				
				//update the trace logs (Mask ip, REMOTE_ADDR, HTTP_X_FORWARDED_FOR)
				$this->post_trace_logs($row->nick,$room_name,$row->level,$row);
				
				mysql_commands::get_team_list_online($row->id);					
			
		}
		
		public function user_logged_in()
		{
		   if($_SESSION['SP_USER_ID'] != NULL && $_SESSION['SP_USER_NICK'] != NULL)
		     return true;
		   else		  
			  return false;
		}
		
		public function get_user_id(){
			return $_SESSION['SP_USER_ID'];
		}
		
		public function get_user_nick(){
			return $_SESSION['SP_USER_NICK'];		
		}
		
		public function get_user_title(){
			return $_SESSION['SP_USER_TITLE'];		
		}
		
		public function get_user_level(){
			return $_SESSION['SP_USER_LEVEL'];		
		}								
		
		public function post_trace_logs($nick, $room, $level, $info)
		{		
			$date = date('l F Y h:i:s A', time());
				   
			$trace = str_replace(array("#rights#","#user#","#maskip#","#room#","#time#"),
			                     array($rights, $info->nick, $info->rights, $room, $date), ChFun_trace_logs);   
			$trace2 = str_replace(array("#rights#","#user#","#remote_addr#","#room#","#time#"),
			                      array($rights, $info->nick, $info->last_ip, $room, $date), ChFun_trace2_logs);
			$trace4 = str_replace(array("#rights#","#user#","#pcip#","#room#","#time#"),
			                      array($rights, $info->nick, $info->last_pcip, $room, $date), ChFun_trace4_logs);
								  
			FUNCTIONS::addmsg('trace',FALSE,$trace);
			FUNCTIONS::addmsg('trace2',FALSE,$trace2);
			FUNCTIONS::addmsg('trace4',FALSE,$trace4);
		}
		
		public function check_timer($row)
		{			
			/**
			 * check time bar if exsist dont insert row do (update) else insert row
			 */
			$check_timer = mysql_query("select * from `timer` where `users_id` = '{$row->id}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_login", __line__);
			
			if ($check = mysql_fetch_object($check_timer)) {
			    
				//check if have time rows
			    if ($check->users_id == $row->id) {
			        mysql_query("update `timer` set time_log = '" . time() ."', login_time = '" . time() . "' where `users_id` = '{$row->id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __line__);
			    } ##check if have time rows
			
			    //check monthly bar and update to date
			    if ($row->level >= from_level && $row->level <= to_level) {
			        if (is_array($range)){
			            if (in_array($row->level, $range)){
			                if ($check->date != date('m-d')){
			                    mysql_query("update `timer` set date = '" . date('m-d') ."' , monthly = monthly + 4 where `users_id` = '{$check->users_id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __line__);
			                }
			            }
			        }
			    }
			
			} else {
				
				/**
			     * create new row if not have time row
			     */			    
				mysql_query("insert into `timer` 
					(users_id, time_log, login_time, date, monthly) 
					values 
					('{$row->id}', '" . time() . "', '" . time() . "', '" . date('m-d') . "', '4')") or FUNCTIONS::debug(mysql_error(),"mysql_login", __line__);
			        
			}
			##check if have time row
			
		}
		
		public function check_session_life(){
			
		    $session_life = @mysql_result( mysql_query("select session_life from `who_is_online` where `users_id` = '{$_SESSION['SP_USER_ID']}' and `online` = '1' LIMIT 1"), 0);
			
		 	//if still online update user record on online list
		    if($session_life == $this->SPECIAL_CORE->sid){
  	   	    mysql_query("update `who_is_online` set `session_life` = '".$this->SPECIAL_CORE->sid."', `action_time` = '".time()."', online = '1' where `users_id` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
  	   	    return true;
  	   	    }else{
  	   	    //$this->delete_from_online(-1,1);
			return false;	   	    
  	   	    }
				 					
		}
		
		public function online($id)
		{	
		   $result = @mysql_result( mysql_query("select online from `who_is_online` where `users_id` = '{$id}' and `online` = '1' LIMIT 1"), 0);
		    
			if($result == 1){
			   return true;
			}else{			  				
			   return false;
			}
		}
		
		public function online_by_nick($nick)
		{	
		   $get_id = @mysql_result( mysql_query("select id from `users` where `nick` = '{$nick}' LIMIT 1"), 0);
		   $result = @mysql_result( mysql_query("select online from `who_is_online` where `users_id` = '{$get_id}' and `online` = '1' LIMIT 1"), 0);
		    
			if($result == 1){
			   return true;
			}else{			  				
			   return false;
			}
		}
		
		public function delete_from_online($id,$destroy=false)
		{		 
			  mysql_query("delete from `who_is_online` where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			  
			  if($destroy){			  	
				  unset($_SESSION['SP_USER_ID'],$_SESSION['SP_USER_NICK'],$this->SPECIAL_CORE->uniq);
				  //session_unregister('SP_USER_ID');
				  //session_unregister('SP_USER_NICK');
				  session_destroy();
			  }
			 
		}
		
		function delete_idel_member(){

			$result = mysql_query("SELECT U.id, U.level, W.users_id FROM `who_is_online` W,`users` U where W.users_id = U.id and W.online = '1' and U.level > '0'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			 
			 if(mysql_num_rows($result) > 0)			 
			 while ($row = mysql_fetch_object($result))
			 {			 	
		 		$time_log = $this->SPECIAL_CORE->mysql_actions->get_time($row->id);
			  	//check offline guest and delete from database && from online list etc..
			  	if($time_log < time()-DELETE_IDEL_MEMBER){
					$this->delete_user($row->id,$row->nick);
				}
			 }		
		}
		
		function delete_offline_guset()
		{
			 $time = time();
			 
			 $result = mysql_query("SELECT id,level,nick FROM `users` WHERE level = '0'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			//$result = mysql_query("SELECT U.id, U.level, W.users_id FROM `who_is_online` W,`users` U where W.users_id = U.id and W.online = '1' and U.level = '0'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			 if(mysql_num_rows($result) > 0)			 
			 while ($row = mysql_fetch_object($result))
			 {
		 		$time_log = $this->SPECIAL_CORE->mysql_actions->get_time($row->id);
			  	//check offline guest and delete from database && from online list etc..
			  	if($time_log < time()-DELETE_OFFLINE_GUEST){
					$this->delete_user($row->id,$row->nick);
					$this->delete_from_online($row->id);
				}
			 }
		}
		
		function delete_user($id,$nick)
		{
		    mysql_query("delete from `who_is_online` where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
		    
		    mysql_query("delete from `timer` where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
		    
		    mysql_query("delete from `talk` where `user` = '{$nick}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
		
		    mysql_query("delete from `ignore` where (`from_users_id` = '{$id}' or `to_users_id` = '{$id}')") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			
		  	mysql_query("delete from `friends` where (`from_users_id` = '{$id}' or `to_users_id` = '{$id}')") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
		  	
		  	//mysql_query("delete from `users_var` where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
		  	
		  	mysql_query("delete from `users` where `id` = '{$id}' and `level` = '0'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
		}		
		
		
		public function delete_member_from_sus($row){
			mysql_query("delete from `actions` where `type` = 'sus' and `users_id` = '{$row->id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			mysql_query("update `check` set `sus` = '0' where `users_id` = '{$row->id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
		}
		
		public function delete_member_from_kick($row){
			mysql_query("delete from `actions` where `type` = 'kick' and `users_id` = '{$row->id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			mysql_query("update `check` set `kick` = '0' where `users_id` = '{$row->id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
		}
		
		
		public function delete_guest_from_kick($login){
			mysql_query("delete from `actions` where `type` = 'kick' and `action_on` = '{$login}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			//mysql_query("delete from `check` where `kick` = '1' and `users_id` = '{$row->id}'") or FUNCTIONS::debug(mysql_error(), "LTChatDataKeeper", __LINE__);
		}
		
		public function delete_guest_from_mkick($login){			
			mysql_query("delete from `actions` where `type` = 'mkick' and `action_on` = '{$login}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			//mysql_query("delete from `check` where `mkick` = '1' and `users_id` = '{$row->id}'") or FUNCTIONS::debug(mysql_error(), "LTChatDataKeeper", __LINE__);
		}
		
		public function delete_guest_from_ban($login='1'){
		
			$c = mysql_query("SELECT * FROM `actions` WHERE `type` = 'banip' OR `type` = 'banuser'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			 
			 if(mysql_num_rows($c) > 0){
				 while ($banned = mysql_fetch_object($c))
				 {
					//check for global ip banned more 3 days and delete
					if( FUNCTIONS::get_date_days($banned->action_time) >= 3 ):
					mysql_query("delete from `actions` where `id` = '{$banned->id}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
					// check banned ip by nick
					elseif( $banned->action_on == $login ):
					return array('error' => 'BAN_NICK', 'reason' => $banned->reason);
					// check banned (real||pc) ip
					elseif( FUNCTIONS::check_banned($banned->banip) ):
					return array('error' => 'BAN_IP', 'reason' => "Sorry, your Ip address ($banned->banip) has been banned by $banned->action_by");
					elseif($banned->banip == 'NONE'):
					return array('error' => ChDK_log_err_banned, 'reason' => "Sorry, The System Not Found Ip address For Your Computer");
					endif;
					
				 }##end while
			 }##end number rows
		}
		
		public function check_who_wait_me($row)
		{
			$d = mysql_query("select * from `wait` where `users_id` = '{$row->id}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			
			if(mysql_num_rows($d) == 1){
				if ($wait = mysql_fetch_object($d))
				{
					foreach(explode(",", $wait->nick) as $idwait) 
					{
					
					$waituser = $this->SPECIAL_CORE->mysql_master->get_user_by_id($idwait);
					
					$room_id = mysql_result(mysql_query("select room from `who_is_online` where `users_id` = '{$waituser->id}' LIMIT 1"),0);
					
					$room_name = $this->SPECIAL_CORE->mysql_master->get_room_by_id($room_id);
					
					$text = str_replace(array("#waitname#","#waitright#","#joinedroom#","#nickcolor#"),
										array($waituser->nick, $waituser->rights,$room_name,$waituser->nickcolor), waitmsg);
					
					  if ($this->online($idwait)){
						$this->SPECIAL_CORE->mysql_public_private->post_private_reason($text, $row->id, 1);
					  }
					}##end foreach
				 }##end while
			}##end number rows
		}
		
		public function check_exists($nick,$level)
		{
		
		$q = mysql_query("SELECT nick FROM `users` WHERE `nick` != 'Chat System' and `nick` = '{$nick}' and `level` >= '{$level}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
		
		  if(mysql_num_rows($q) > 0){
		  	return true;
			  }else{
			return false;
		  }

		}
		
		function enter_room($id,$room)
		{
			 $time = time();
			 mysql_query("delete from `who_is_online` where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
			 mysql_query("insert into who_is_online
			 (action_time, users_id, room, online,session_life) 
			 values  
			 ('{$time}', '{$id}','{$room}','1','".$this->SPECIAL_CORE->sid."')") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
		}
		
	   function update_style_fields()
	   {
	   	   mysql_query("update `users` set color = '{$_POST['color']}', font = '{$_POST['font']}', nickcolor = '{$_POST['nickcolor']}', nickfont = '{$_POST['nickfont']}' where `id` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_login", __LINE__);
	   }
	
	}
	
?>
