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

class mysql_commands{
	
	
//----------------- friend ---------------------------------------------
  /**
   * mysql_commands::friend_user_del()
   *
   * @param mixed $user_id
   * @return
   */
   function friend_user_del($user_id)
   {
     mysql_query("delete from friends where `from_users_id` = '{$_SESSION['SP_USER_ID']}' and `to_users_id` = '{$user_id}'") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
   }

  /**
   * mysql_commands::friend_user_add()
   *
   * @param mixed $user_id
   * @return
   */
   function friend_user_add($user_id)
   {
     mysql_query("insert into friends
	 (from_users_id, to_users_id) 
	 values 
	 ('{$_SESSION['SP_USER_ID']}','{$user_id}')") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
   }
 
################### friend #############################################

   function get_friend_list()
   {
   	
   	 $result = mysql_query("select U.id as users_id, U.nick from users as U, friends as F where F.from_users_id = '{$_SESSION['SP_USER_ID']}' and F.to_users_id = U.id") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
	 while($row = mysql_fetch_object($result))
	   $out['from'][] = $row;

	 $result = mysql_query("select U.nick, F.from_users_id as users_id from users as U, friends as F where F.to_users_id = '{$_SESSION['SP_USER_ID']}' and F.from_users_id = U.id") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
	 while($row = mysql_fetch_object($result))
	   $out['to'][] = $row;

	 return $out;
   }
   
################### friend #############################################
	
	//----------------- ignore ---------------------------------------------

	function check_ignore($check){
		$result = @mysql_result( mysql_query("SELECT from_users_id FROM `ignore` WHERE `to_users_id` = '{$check}' and `from_users_id` = '{$_SESSION['SP_USER_ID']}' LIMIT 1") ,0);	
		
		if($result == true) return true; else return false;
	}
	

	function ignore_user_del($user_id)
	{
	 mysql_query("delete from `ignore` where `from_users_id` = '{$_SESSION['SP_USER_ID']}' and `to_users_id` = '{$user_id}'") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
	}
	
	function ignore_user_add($user_id)
	{
	 mysql_query("INSERT INTO `ignore` (from_users_id, to_users_id) values ('{$_SESSION['SP_USER_ID']}','{$user_id}')") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
	}
	
	################## ignore #############################################
	
		
	//----------------- wait ---------------------------------------------
	
	function check_wait_list($id)
	{
	   $all_nicks = @mysql_result( @mysql_query("select nick from `wait` where nick REGEXP '{$id}' and `users_id` = '{$_SESSION['SP_USER_ID']}' LIMIT 1"),0);
		   
	   if(in_array($id, explode(",", $all_nicks))) return true; else return false;	   
	}
	

	function wait_user_add($newmember)
	{
	 $result = mysql_query("select nick from `wait` where `users_id` = '{$_SESSION['SP_USER_ID']}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
		 
		if ( mysql_num_rows($result) == 1 ) {
		  
		  if($WAIT = mysql_fetch_object($result)){
			$Array = explode(",", $WAIT->nick);
			array_push($Array,"$newmember");
			$NewNicks = implode(",", $Array);
		
		mysql_query("update `wait` set `nick` = '{$NewNicks}' where `users_id` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
		  }
		
		}else{
		
		mysql_query("INSERT INTO `wait` 
		(nick , ip, users_id) 
		values 
		('{$newmember}', '', '{$_SESSION['SP_USER_ID']}')") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
		
		}
	
		}
	
	function wait_user_del($removemember)
	{
	
	 $result = mysql_query("select nick from `wait` where `users_id` = '{$_SESSION['SP_USER_ID']}' LIMIT 1") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
	 
	if ( mysql_num_rows($result) == 1 ) { 
		
		if($WAIT = mysql_fetch_object($result)){
		$Array = explode(",", $WAIT->nick);
		$NewArray = array();
		}
		
		if ( in_array($removemember, $Array) ) {
	        foreach ( $Array as $Value ) {
				if ( $Value != $removemember ) {
					array_push($NewArray, "$Value");
					$NewNicks = implode(",", $NewArray);
				}
			}
			
	mysql_query("update `wait` set `nick` = '{$NewNicks}' where `users_id` = '{$_SESSION['SP_USER_ID']}'") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
	
		}##in_array
	 }##num rows
	}
	
	################## wait #############################################
	
//----------------- Team ---------------------------------------------

  /**
   * mysql_commands::team_user_add()
   *
   * @param mixed $g_id
   * @param mixed $user_id
   * @return
   */
   function team_user($g_id, $user_id)
   {
     mysql_query("UPDATE `users` set `mygroup` = '{$g_id}' WHERE `id` = '{$user_id}'") or debug(mysql_error(), "mysql_commands", __LINE__);
   }

  /**
   * mysql_commands::team_user_exists()
   *
   * @param mixed $user_id
   * @return
   */
   function team_user_exists($user_id)
   {
     $result = mysql_query("SELECT id FROM `users` WHERE `id` = '{$user_id}' and `mygroup` != '0' LIMIT 1") or debug(mysql_error(), "mysql_commands", __LINE__);
	 
		 if(mysql_num_rows($result) > 0){
		 return FALSE;
		 }else{
		 return TRUE;
		 }
   }
      
  /**
   * mysql_commands::get_team_list()
   *
   * @return
   */
   function get_team_list()
   {
   	 $result = mysql_query("SELECT `U`.id, `U`.nick, `U`.level, `U`.mygroup, `G`.g_id, `G`.g_title, `G`.g_name FROM `users` U, `groups` G WHERE `U`.level > '0' and `U`.mygroup = `G`.g_id ORDER BY `U`.level") or debug(mysql_error(), "mysql_commands", __LINE__);
	 while($row = mysql_fetch_object($result))
	   $out['list'][] = $row;
	   
	 return $out;
   }
   
  /**
   * mysql_commands::get_team_list_online()
   *
   * @return
   */
   function get_team_list_online($id)
   {
   	 $result = mysql_query("SELECT `U`.nick, `U`.level, `U`.nickfont, `W`.online FROM `users` U, `groups` G, `who_is_online` W WHERE `U`.mygroup != '0' and `U`.mygroup = `G`.g_id and `U`.id = `W`.users_id ORDER BY `U`.level") or debug(mysql_error(), "mysql_commands", __LINE__);
	 
	if( mysql_num_rows($result) > 0 ) {
		while($row = mysql_fetch_object($result)){
		 
			 $levelcolor = mysql_master::get_user_color($row->level); //get right by level
	
			 $text .= str_replace(array("#levelcolor#", "#nickfont#", "#nick#"), 
								 array($levelcolor, $row->nickfont, $row->nick), ChFun_team_members_online);
	    }
	    
			 $create_team .= str_replace(array("#all_nickname#"), 
								 		 array($text), ChFun_create_team_nickname);
									
		mysql_public_private::post_private_reason($create_team, $id, 1);
	}
	 
   }
################### Team #############################################
	
		function remove_member($id)
		{
		    mysql_query("delete from `who_is_online` where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
		    
		    mysql_query("delete from `timer` where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
		
		    mysql_query("delete from `ignore` where (`from_users_id` = '{$id}' or `to_users_id` = '{$id}')") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
			
		  	mysql_query("delete from `friends` where (`from_users_id` = '{$id}' or `to_users_id` = '{$id}')") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
		  	
		  	mysql_query("delete from `wait` where `id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
		  	
		  	mysql_query("delete from `check` where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);		  	
		  	
		  	mysql_query("delete from `users_var` where `users_id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
		  	
		  	mysql_query("delete from `users` where `id` = '{$id}'") or FUNCTIONS::debug(mysql_error(), "mysql_commands", __LINE__);
		}
	
		
}
	
	
?>