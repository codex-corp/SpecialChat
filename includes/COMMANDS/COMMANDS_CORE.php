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

  class COMMANDS_CORE
  {
  	var $SPECIAL_CORE;
  	var $language_config;

  	function COMMANDS_CORE(&$SPECIAL_CORE)
  	{
  	  $this->SPECIAL_CORE = &$SPECIAL_CORE;
  	}
  	//---------------------------------------------------------------------
  	
  	function set_language_config($language_config)
  	{
  	  $this->language_config = $language_config;
  	}

  	function command_show_help_info_parse($command, $type)
  	{
  	   if($type == 'list')	$style = ChFun_help_ListStyle;
  	   else 				$style = ChFun_help_InfoStyle;
  	   
  	   if(is_array($command['commands']))
  	     foreach ($command['commands'] as $_commands)
  	       $commands .= "{$_commands} ";

  	   if(is_array($command['params']))
  	     foreach ($command['params'] as $_params)
  	       $params .= "$_params ";

  	   if(is_array($command['except_params_static']))
  	   {
  	     foreach ($command['except_params_static'] as $_except_params_static_key => $_except_params_static_value)
  	     {
  	       if(isset($except_params_static))
  	         $except_params_static .= " | ";

  	       $except_params_static .= "{$_except_params_static_value} ";
  	     }
  	     $except_params_static = "{{$except_params_static}}";
  	   }
  	   
  	   if(is_array($command['Description']))
  	   {
  	     $Description = "";
  	     foreach ($command['Description'] as $key => $desc)
  	     {
  	       $param = $command['except_params_static'][$key];
  	       $Description .= str_replace(array("#param#","#Description#"), array($param, $desc), ChFun_help_DescArStyle);
  	     }
  	   }
  	   else 
  	     $Description = $command['Description'];

  	   return str_replace(array("#commands#","#except_params_static#","#params#","#Description#"), 
	                      array($commands, $except_params_static, $params, $Description), 
						  $style);
  	}

  	function command_show_help($command_info)
  	{
  	  $params = $command_info['params'];

      $help_info = $this->language_config['help'];
      if(!is_array($help_info)) return;

      if(is_array($params))
        foreach ($params as $key => $param)
        {
          $params[$key] = trim($param);
          if($params[$key] == '')
          {  unset($params[$key]);  continue;  }

          if($params[$key][0] != '/')
             $params[$key] = '/'.$params[$key];
        }

      if(!is_array($params) || count($params) == 0)
      {
        foreach ($help_info as $command_help)
        {
          if($command_help[$_SESSION['SP_USER_LEVEL']] == true && (is_callable(array(get_class($this),$command_help['execute_function'])) || is_callable(array(get_class($this),$command_help['execute_tpl_function']))) )
            $out .= $this->command_show_help_info_parse($command_help,'list');//str_replace(array("#command#","#args#","#description#"), array($com, $args, $desc), ChFun_help_ListStyle);
        }
      }
      else
      {
        foreach ($help_info as $command_help)
        {
          if(!is_callable(array(get_class($this),$command_help['execute_function'])) && !is_callable(array(get_class($this),$command_help['execute_tpl_function']))) continue;
          if($command_help[$_SESSION['SP_USER_LEVEL']] != true) continue;

          $next = true;
      	  foreach ($command_help['commands'] as $command)
      	  {
      	  	foreach ($params as $key => $param)
      	  	  if($param == $command)
      	  	  {  $next = false;  break;  }
      	  	if($param == $command)  break;
      	  }

      	  if($next) continue;
      	  $out .= $this->command_show_help_info_parse($command_help,'info');//str_replace(array("#command#","#args#","#description#"), array($com, $args, $desc), ChFun_help_InfoStyle);
        }

        if($out == '')
	      $out = str_replace("#command#",implode(" ",$params), ChFun_help_UnknownCommand);
      }
      return array('text' => $out, 'type' => 'private');
  	}
  	//---------------------------------------------------------------------
  	function command_tpl_configreg()
  	{
  	  return array('reg_fields' =>  $this->LTChatDataKeeper->get_registration_fields());
  	}
	//---------------------------------------------------------------------
	function command_upgrade($command_info)
	{
		$row = $command_info['row']	;
		$room = $command_info['room'];
		$type = 'upgrade';
		
		if($row->user == $_SESSION['SP_USER_NICK'])
		{
		//delete the command from public
		$this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		
		$nick_name_have_upgrade = trim($command_info['params'][1]);
		unset($command_info['params'][1]);
		
		$upgrade_to_level = trim(implode(" ",$command_info['params']));
		
		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($_SESSION['SP_USER_NICK']); //get user
		
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($nick_name_have_upgrade); //get user
		
		//check for op exists on database
        if($user_info == NULL)
  	  	  return array('text' => str_replace("#user#", $user_info->nick, LTChatCore_user_doesnt_exists), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	else
  	  	{
		
		if($user_info->level == 0)
		return array('text' => str_replace(array("#user#"), array($user_info->nick), LTChatCOM_stop_upgrade_level_zero), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
				
		if($upgrade_to_level <= $user_info->level)
		return array('text' => str_replace(array("#from_level#", "#to_level#"), 
		                                   array($user_info->level, $upgrade_to_level), LTChatCOM_stop_upgrade_error_level), 
										   'type' => 'private', 
										   'other_options' => array('type_handle' => 'error'));
										   
		if($my_info->level <= 30 and $upgrade_to_level >= 15)
		return array('text' => str_replace(array("#from_level#", "#to_level#"), 
		                                   array($user_info->level, $upgrade_to_level), LTChatCOM_stop_upgrade_error_level), 
										   'type' => 'private', 
										   'other_options' => array('type_handle' => 'error'));								   
										   
		if($my_info->level > 30 && $my_info->level <= 47 && $upgrade_to_level >= 20)
		return array('text' => str_replace(array("#from_level#", "#to_level#"), 
		                                   array($user_info->level, $upgrade_to_level), LTChatCOM_stop_upgrade_error_level), 
										   'type' => 'private', 
										   'other_options' => array('type_handle' => 'error'));
										   
		if($my_info->level <= 48 && $upgrade_to_level <= 50)
		return array('text' => LTChatCOM_stop_upgrade_maximum_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
										   
		$sender_color = $this->SPECIAL_CORE->mysql_master->get_user_color($_SESSION['SP_USER_LEVEL']);
		$up_sender = $_SESSION['SP_USER_NICK'];
		
		$text = str_replace(array("#up_user#","#up_level#","#up_to_level#","#up_sender_color#","#up_sender#"), 
		                    array($user_info->nick, $user_info->level, $upgrade_to_level, $sender_color, $up_sender),LTChatCOM_upgrade_msg);
		
		//check for null reason
	    if($upgrade_to_level == NULL)
		return array('text' => LTChatCOM_upgrade_without_new_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else
		$changed = $this->SPECIAL_CORE->mysql_actions->upgrade_downgrade($user_info->id, $upgrade_to_level);
		$mailer_upgrade = MAILLER::new_upgrade_downgrade($user_info->nick, $upgrade_to_level, $user_info->email, 'upgrade');
			
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $user_info->nick);	
		$this->SPECIAL_CORE->mysql_public_private->post_private_reason($text, $user_info->id, 1);
		
		if($changed)
		return array('text' => "the user $user_info->nick upgrade from level $user_info->level to $upgrade_to_level and $mailer_upgrade", 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	}
	
		}
		else
		return array('text' => '', 'type' => 'skip');
	}
	//---------------------------------------------------------------------
	function command_downgrade($command_info)
	{
		$row = $command_info['row']	;
		$room = $command_info['room'];
		$type = 'downgrade';
		
		if($row->user == $_SESSION['SP_USER_NICK'])
		{
		//delete the command from public
		$this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		
		$nick_name_have_downgrade = trim($command_info['params'][1]);
		unset($command_info['params'][1]);
		
		$downgrade_to_level = trim(implode(" ",$command_info['params']));
		
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($nick_name_have_downgrade); //get user
		
		//check for op exists on database
        if($user_info == NULL)
  	  	  return array('text' => str_replace("#user#", $user_info->nick, LTChatCore_user_doesnt_exists), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	else
  	  	{
		
		if($user_info->level == 0)
		return array('text' => str_replace(array("#user#"), array($user_info->nick), LTChatCOM_stop_downgrade_level_zero), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		
		if($downgrade_to_level < 1)
		return array('text' => LTChatCOM_stop_downgrade_maximum_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		
		if($downgrade_to_level >= $user_info->level)
		return array('text' =>  str_replace(array("#from_level#", "#to_level#"), 
		                                    array($user_info->level, $downgrade_to_level), LTChatCOM_stop_downgrade_error_level),
										    'type' => 'private', 
										    'other_options' => array('type_handle' => 'error'));
		
		if($downgrade_to_level <= 50 && $downgrade_to_level >= 48 && $_SESSION['SP_USER_LEVEL'] != 50)
		return array('text' => LTChatCOM_stop_downgrade_only_admin, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		
		$sender_color = $this->SPECIAL_CORE->mysql_master->get_user_color($_SESSION['SP_USER_LEVEL']);
		$do_sender = $_SESSION['SP_USER_NICK'];
		
		$text = str_replace(array("#do_user#","#do_level#","#do_to_level#","#do_sender_color#","#do_sender#"), 
		                    array($user_info->nick, $user_info->level, $downgrade_to_level, $sender_color, $do_sender),
							LTChatCOM_downgrade_msg);
									
		//check for null reason
	    if($downgrade_to_level == NULL)
		return array('text' => LTChatCOM_downgrade_without_new_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else
		$changed = $this->SPECIAL_CORE->mysql_actions->upgrade_downgrade($user_info->id, $downgrade_to_level);
		$mailer_downgrade = MAILLER::new_upgrade_downgrade($user_info->nick, $upgrade_to_level, $user_info->email, 'downgrade');
		
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $user_info->nick);	
		$this->SPECIAL_CORE->mysql_public_private->post_private_reason($text, $user_info->id, 1);
			
		if($changed)
		return array('text' => "the user $user_info->nick downgrade from level $user_info->level to $downgrade_to_level and $mailer_downgrade", 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	}

		}
		else
		return array('text' => '', 'type' => 'skip');
	}
	//---------------------------------------------------------------------
	function command_changeop($command_info)
	{
		$row = $command_info['row']	;
		$room = $command_info['room'];
		$type = 'change_op';
		
		if($row->user == $_SESSION['SP_USER_NICK'])
		{
		//delete the command from public
		$this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);	
	  	
		$nick_name_have_change = trim($command_info['params'][1]);
		unset($command_info['params'][1]);
		
		$new_nick_name = trim(implode(" ",$command_info['params']));
		
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($nick_name_have_change); //get user
		
		//check for op exists on database
        if($user_info == NULL)
  	  	return array('text' => str_replace("#user#", $user_info->nick, LTChatCore_user_doesnt_exists), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	else
  	  	{
		
		if($user_info->level == 0)
		return array('text' => str_replace(array("#user#"), array($user_info->nick), LTChatCOM_changeop_level_zero), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));		
				
		//check for null reason
	    if($new_nick_name == NULL)
		return array('text' => LTChatCOM_changeop_without_new_nick, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else
		
		$text = str_replace(array("#user#","#new_nick#"), array($nick_name_have_change, $new_nick_name), LTChatCOM_changeop_msg);
		
		$changed = $this->SPECIAL_CORE->mysql_actions->change_op($user_info->id, $new_nick_name);
		//$mailer_new_pass = new_password($user_info->nick, $new_pass, $user_info->email);
		
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $user_info->nick);	
		if($changed)
		return array('text' => "the user $user_info->nick changed nick name to $new_nick_name and $mailer_new_pass", 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	}
  	  }
  	  else
  	    return array('text' => '', 'type' => 'skip');
	}
  	//---------------------------------------------------------------------
  	function command_changepass($command_info)
  	{
  	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  $type = 'change_pass';
	  
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {	  
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  	
		$user_need_change = trim($command_info['params'][1]);
		unset($command_info['params'][1]);
		
		$new_pass = trim(implode(" ",$command_info['params']));
		
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_need_change); //get user

		//check for op exists on database
        if($user_info == NULL)
  	  	  return array('text' => str_replace("#user#", $user_need_change, LTChatCore_user_doesnt_exists), 
		               'type' => 'private', 
					   'other_options' => array('type_handle' => 'error'));
  	  	else
  	  	{

		if($user_info->level == 0)
		return array('text' => str_replace(array("#user#"), array($user_need_change), LTChatCOM_changepass_level_zero), 
		             'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));		
				
		//check for null reason
	    if($new_pass == NULL)
		return array('text' => LTChatCOM_changepass_without_new_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else
		
		$text = str_replace(array("#user#","#new_pass#"), array($user_need_change, $new_pass), LTChatCOM_changepass_msg);
		$changed = $this->SPECIAL_CORE->mysql_actions->change_password($user_info->id, $new_pass);
		$mailer_new_pass = new_password($user_info->nick, $new_pass, $user_info->email);
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $user_info->nick);	
		
		if($changed)
		return array('text' => "the user $user_info->nick changed password and $mailer_new_pass", 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	}
  	  }
  	  else
  	    return array('text' => '', 'type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------
  	function command_pass($command_info)
  	{
  	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  $type = 'change_pass';
	  
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {	  
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		
		$user_name = $_SESSION['SP_USER_NICK'];
		
        $oldpass = trim($command_info['params'][1]); //get old pass
        
		$newpass = trim($command_info['params'][2]); //get new pass
		
		$newpass2 = trim($command_info['params'][3]); //get new confirm pass
		
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user

		//check for op exists on database
        if($user_info == NULL)
  	  	  return array('text' => str_replace("#user#", $user_name, LTChatCore_user_doesnt_exists), 
		               'type' => 'private', 
					   'other_options' => array('type_handle' => 'error'));
  	  	else
  	  	{

		if($user_info->level == 0)
		return array('text' => str_replace(array("#user#"), array($user_name), LTChatCOM_changepass_level_zero), 
		             'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));	
					 
		//check confirm password
		if(strcmp($newpass, $newpass2) !== 0)
		return array('text' => str_replace(array("#user#"), array($user_name), LTChatCOM_changepass_error_confirm), 
		             'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));
					 			
		//check for null reason
	    if(empty($newpass))
		return array('text' => LTChatCOM_changepass_without_new_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else
		
		$text = str_replace(array("#user#","#new_pass#"), array($user_need_change, $newpass), LTChatCOM_changepass_msg);
		$changed = $this->SPECIAL_CORE->mysql_actions->change_password_user($user_info->id, $oldpass, $newpass);
		$mailer_new_pass = MAILLER::new_password($user_info->nick, $newpass, $user_info->email);
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $user_info->nick);	
		
		if($changed == true)
		return array('text' => "Hi $user_info->nick your password has been changed and $mailer_new_pass", 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		else
		return array('text' => "Sorry your old password not correct", 'type' => 'private', 'other_options' => array('type_handle' => 'error'));	
		
  	  	}
  	  }
  	  else
  	    return array('text' => '', 'type' => 'skip');
  	}
  	//---------------------------------------------------------------------

    function command_skin_get_css()
    {
    	$out = array();
		if ($handle = opendir(LTChatTemplateSystemPath."css"))
		{
		    while (false !== ($file = readdir($handle)))
		      if ($file != "." && $file != "..")
		      	$out[] = $file;

		    closedir($handle); 
		}
		return $out;
    }

    function command_skin_get_skins()
    {
    	$out = array();
		if ($handle = opendir(LTChart_path."/templates/"))
		{
		    while (false !== ($file = readdir($handle)))
		      if ($file != "." && $file != "..")
		      	$out[] = $file;

		    closedir($handle); 
		}
		return $out;
    }

  	function command_skin($command_info)
  	{
      $row = $command_info['row'];
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {

	      $params = $command_info['params'];
	  	  $data_css = $this->command_skin_get_css();
	  	  $data_skins = $this->command_skin_get_skins();
	
	  	  if($command_info['command_help']['except_params_static']['showcss'] == trim($params[1]))
	  	    $data = $data_css;
	  	  elseif($command_info['command_help']['except_params_static']['showskins'] == trim($params[1]))
	  	    $data = $data_skins;
	  	  elseif($command_info['command_help']['except_params_static']['setskin'] == trim($params[1]))
	  	  {
	  	  	unset($params[1]);
			$name = trim(implode(" ",$params));
			if(is_array($data_skins))
			  foreach ($data_skins as $skin)
			    if($skin == $name)
			    {
			      $out = str_replace("#skin_name#",$name, ChFun_skin_SkinChanged);
			      $this->LTChatDataKeeper->set_chat_variable("LTChatTemplateName", $name);
			      $this->LTChatDataKeeper->set_chat_variable("LTTpl_css_link", LTChatTemplatePath."css/default.css");
			    }
	
			if(!$out)	$out = ChFun_skin_BadSkin;
	  	  }
	  	  elseif($command_info['command_help']['except_params_static']['setcss'] == trim($params[1]))
	  	  {
	  	  	unset($params[1]);
			$name = trim(implode(" ",$params));
			if(is_array($data_css))
			  foreach ($data_css as $css)
			  {
				if($css == $name)
			    {
			      $out = str_replace("#css_name#",$name, ChFun_skin_CssChanged);
			      $this->LTChatDataKeeper->set_chat_variable("LTTpl_css_link", LTChatTemplatePath."css/{$name}");
			    }
			  }
	
			if(!$out)	$out = ChFun_skin_BadCss;
	  	  }
	
	  	  if(is_array($data))
	  	  {
	  	    foreach ($data as $file)
	  	    {
	  	      if($out)	$out = str_replace("#name#", $file, ChFun_skin_List.ChFun_skin_ListSep).$out;
	  	  	  else		$out = str_replace("#name#", $file, ChFun_skin_List);
	  	    }
	  	    return array('text' => $out, 'type' => 'private');
	  	  }
	  	  elseif($out)
	  	    return array('text' => $out, 'type' => 'private');
	  	  else
	  	    return array('text' => str_replace("#param#", $params[1], ChFun_skin_UnParam), 'type' => 'private');
  	  }
  	  return array('type' => 'skip');
  	  
  	}
  	
  	//---------------------------------------------------------------------

  	function command_tpl_me()
  	{
  	  return array();
  	}
  	
  	//---------------------------------------------------------------------
	
  	function command_actionlogs()
  	{
	   return array();
  	}
	
  	//---------------------------------------------------------------------
	
  	function command_actionstop()
  	{
	   return array();
  	}
  	
  	//---------------------------------------------------------------------

  	function command_showclear($command_info)
  	{
    return array();
  	}
  	//---------------------------------------------------------------------

  	function command_showops($command_info)
  	{
    return array();
  	}
	
  	//---------------------------------------------------------------------

  	function command_showforward($command_info)
  	{
    return array();
  	}
	
  	//---------------------------------------------------------------------

  	function command_showsus($command_info)
  	{
    return array();
  	}
	
  	//---------------------------------------------------------------------

  	function command_showban($command_info)
  	{
    return array();
  	}
	
  	//---------------------------------------------------------------------

  	function command_showbanpc($command_info)
  	{
    return array();
  	}	
	
  	//---------------------------------------------------------------------

  	function command_showdisable($command_info)
  	{
    return array();
  	}	
	
  	//---------------------------------------------------------------------

  	function command_apply($command_info)
  	{
    return array();
  	}
	
  	//---------------------------------------------------------------------

  	function command_applylogs($command_info)
  	{
    return array();
  	}	
  	//---------------------------------------------------------------------

  	function command_list($command_info)
  	{
    return array();
  	}
	
  	//---------------------------------------------------------------------

  	function command_register($command_info)
  	{
    return array();
  	}
	
  	//---------------------------------------------------------------------

  	function command_updologs($command_info)
  	{
    return array();
  	}
	
  	//---------------------------------------------------------------------

  	function command_trace($command_info)
  	{
	return array();
  	}
	
  	//---------------------------------------------------------------------

  	function command_trace2($command_info)
  	{
    return array();
  	}
	
  	//---------------------------------------------------------------------

  	function command_trace4($command_info)
  	{
    return array();
  	}
  	//---------------------------------------------------------------------

  	function command_mycommand($command_info)
  	{
	  return array();
	}


  	function command_d($command_info)
  	{
	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  	
	  if($row->user == $_SESSION['SP_USER_NICK'])
	  {

	  	$this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		
		$message = trim(implode(" ",$command_info['params'])); //implode

		if( empty($message) ){
			return array('text' => 'Sorry, not found msg', 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		}

	  }
	  else
	  return array('type' => 'skip');
  	}
  	//---------------------------------------------------------------------

  	function command_comment($command_info)
  	{
	  $row = $command_info['row'];
	  	
	  if($row->user == $_SESSION['SP_USER_NICK'])
	  {
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);

		$user_name = $_SESSION['SP_USER_NICK'];
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user
		
		$comment = trim(implode(" ",$command_info['params'])); //implode the song
		
		if($comment == ''){
		return array('text' => ChFun_comment_msg_error, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		}else{
		
		$replaced = FUNCTIONS::load_emoticons($comment);
		
		$msg = str_replace(
		       array("#myfont#","#mycolor#","#comment#"), 
		       array($user_info->font, $user_info->color, $replaced), ChFun_comment_msg);
	   
		//change the comment
		$change = $this->SPECIAL_CORE->mysql_actions->change_comment(addslashes($msg));
		
		if($change == TRUE){
		return array('text' => 'your comment message has been changed', 
					 'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));
		}
		}

	  }
	  else
	  return array('type' => 'skip');
  	}
    //---------------------------------------------------------------------
  	function command_mk3($command_info)
  	{
	  $row = $command_info['row'];
	  $room = $command_info['room'];
	
	  if($row->user == $_SESSION['SP_USER_NICK'])
	  {
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		
		$user_name = $_SESSION['SP_USER_NICK'];
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user
		
		$mk3_msg = trim(implode(" ",$command_info['params'])); //implode
		
		if($mk3_msg == ''){
		return array('text' => ChFun_mk3_msg_error, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		}else{
		
		$msg = str_replace(
		       array("#user#","#myfont#","#mycolor#","#nickfont#","#nickcolor#","#text#"), 
		       array($user_info->nick, $user_info->font, $user_info->color, $user_info->nickfont, $user_info->nickcolor, $mk3_msg), ChFun_mk3_msg);
										   
		//post the singing message on public
		$this->SPECIAL_CORE->mysql_public_private->post_reason($msg, $room);
		
		return array('text' => 'Your marquee message has been sent', 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		}
		
	  }
	  else
	  return array('type' => 'skip');	
	}
    //---------------------------------------------------------------------
  	function command_mk2($command_info)
  	{
	  $row = $command_info['row'];
	  $room = $command_info['room'];
	
	  if($row->user == $_SESSION['SP_USER_NICK'])
	  {
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		
		$user_name = $_SESSION['SP_USER_NICK'];
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user
		
		$mk2_msg = trim(implode(" ",$command_info['params'])); //implode the song
		
		if($mk2_msg == ''){
		return array('text' => ChFun_mk2_msg_error, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		}else{
		
		$msg = str_replace(
		       array("#user#","#myfont#","#mycolor#","#nickfont#","#nickcolor#","#text#"), 
		       array($user_info->nick, $user_info->font, $user_info->color, $user_info->nickfont, $user_info->nickcolor, $mk2_msg), ChFun_mk2_msg);
										   
		//post the singing message on public
		$this->SPECIAL_CORE->mysql_public_private->post_reason($msg, $room);
		
		return array('text' => 'Your marquee message has been sent', 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		}
		
	  }
	  else
	  return array('type' => 'skip');	
	}
    //---------------------------------------------------------------------
  	function command_mk1($command_info)
  	{
	  $row = $command_info['row'];
	  $room = $command_info['room'];
	
	  if($row->user == $_SESSION['SP_USER_NICK'])
	  {
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		
		$user_name = $_SESSION['SP_USER_NICK'];
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user
		
		$mk1_msg = trim(implode(" ",$command_info['params'])); //implode the song
		
		if($mk1_msg == ''){
		return array('text' => ChFun_mk1_msg_error, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		}else{
		
		$msg = str_replace(
		       array("#user#","#myfont#","#mycolor#","#nickfont#","#nickcolor#","#text#"), 
		       array($user_info->nick, $user_info->font, $user_info->color, $user_info->nickfont, $user_info->nickcolor, $mk1_msg), ChFun_mk1_msg);
						   
		//post the singing message on public
		$this->SPECIAL_CORE->mysql_public_private->post_reason($msg, $room);
		
		return array('text' => 'Your marquee message has been sent', 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		}
		
	  }
	  else
	  return array('type' => 'skip');	
	}
    //---------------------------------------------------------------------
  	function command_id($command_info)
  	{
	  $row = $command_info['row'];
	  $room = $command_info['room'];
	
	  if($row->user == $_SESSION['SP_USER_NICK'])
	  {
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
				
		$user_name = trim(implode(" ",$command_info['params'])); //implode the song
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user
		
		//check for op exists on database
        if($user_info == NULL){
  	  	  return array('text' => str_replace("#user#", $user_name, ChFun_sus_BadNick), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	}else{
		
		if($user_info->level == 0)
		return array('text' => str_replace(array("#user#"), array($user_name), 'Not Found Inforamtion for Guest'), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
				
		//get level rights name by level
	    $maskip = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($user_info->level);
		//get user color by level
		$level_color = $this->SPECIAL_CORE->mysql_master->get_user_color($user_info->level);
		
		$msg = str_replace(
		       array("#user#","#maskip#","#level#","#rights#","#levelcolor#"), 
		       array($user_info->nick, $maskip, $user_info->level, $user_info->rights, $level_color), ChFun_msg_id);
		
		return array('text' => $msg, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		
		}
		
	  }
	  else
	  return array('type' => 'skip');	
	}
    //---------------------------------------------------------------------
  	function command_sing($command_info)
  	{
	  $row = $command_info['row'];
	  $room = $command_info['room'];
	
	  if($row->user == $_SESSION['SP_USER_NICK'])
	  {
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		
		$user_name = $_SESSION['SP_USER_NICK'];
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user
		
		$singing_msg = trim(implode(" ",$command_info['params'])); //implode the song
		
		if( empty($singing_msg) ){
		return array('text' => ChFun_sing_msg_error, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		}else{
		
		$msg = str_replace(
		       array("#user#","#my_nick_font#","#my_nick_color#","#LTChatTemplatePath#","#my_color#","#my_font#","#text#"), 
		       array($user_info->nick, $user_info->nickfont, $user_info->nickcolor, LTChatTemplatePath, $user_info->color, $user_info->font, $singing_msg), ChFun_sing_msg);
										   
		//post the singing message on public
		$this->SPECIAL_CORE->mysql_public_private->post_reason($msg, $room);
		
		return array('text' => 'your song message has been sent', 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		}
		
	  }
	  else
	  return array('type' => 'skip');	
	}
    //---------------------------------------------------------------------
  	function command_away($command_info)
  	{
  	  $row = $command_info['row'];
	  $type = 'away';
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	    $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($_SESSION['SP_USER_NICK']); //get user
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		
  	    $check = $this->SPECIAL_CORE->mysql_actions->whois_have_action($user_info->id, $type);
		
		if($check == 1){
			$text = LTChatCOM_away_disable;
			mysql_query("delete from `check` where `away` = '1' and `users_id` = '{$user_info->id}'") or FUNCTIONS::debug(mysql_error(), "LTChatDataKeeper", __LINE__);
			}else{
			$text = LTChatCOM_away_enable;
			$this->SPECIAL_CORE->mysql_actions->insert_check4action($user_info->id, $type);
		}
		
  	    return array('text' => $text, 'type' => 'private');
      }
	  else
  	  return array('type' => 'skip');
  	}
  	//---------------------------------------------------------------------

  	function command_fl($command_info)
  	{
	  $row = $command_info['row'];
	  
	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
  	    //delete the command from talk for duplicate
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		//delete the private
  	    $this->SPECIAL_CORE->mysql_public_private->delete_private();
	    
		return array('text' => 'Your private has been flushed !', 'type' => 'private');
		
	 }	
	 else 
  	    return array('text' => '', 'type' => 'skip');
  	}
  	//---------------------------------------------------------------------

  	function command_changeip($command_info)
  	{
  	  $row = $command_info['row'];
	  
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	      $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);

		  $user_name = $_SESSION['SP_USER_NICK'];

		  $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user
		   
		  $get_ip = trim(implode(" ",$command_info['params'])); //implode the ip to change
		  
		  //get level rights name by level
	      $maskip = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($user_info->level);
		  //get connection ip
		  $connection_ip = $_SERVER['REMOTE_ADDR'];
		  
		  //check ip before change
		  $check_ip = ($get_ip == 'BLOCKED' || $get_ip == $maskip || $get_ip == $user_info->nick || $get_ip == $connection_ip) ? $get_ip : 'BLOCKED';

		  //check for op exists on database
		  if($user_info == NULL){
		  return array('text' => str_replace("#user#", $user_name, LTChatCore_user_doesnt_exists), 
		               'type' => 'private', 
					   'other_options' => array('type_handle' => 'error'));
		  }else{
		  
			if(empty($get_ip)){		  	
				
				$other_options = array('function' => 'changeip', 
				                  'showchangeip' => '1',
								  'nickname' => $user_info->nick,
								  'status_1' => 'BLOCKED',
								  'status_2' => $maskip,
								  'status_3' => $user_info->last_ip
								  );
				
				return array('data_type' => 'functions', 'text' => '', 'type' => 'private', 'other_options' => $other_options);
			
			}else{
			
				$how_change = $this->SPECIAL_CORE->mysql_actions->change_ip($check_ip);
				
				$change = ($how_change == 1) ? $how_change : 0;
				if($change)		  
				return array('text' => str_replace("#change#", $check_ip, LTChatCore_change_ip), 
				           'type' => 'private', 
						   'other_options' => array('type_handle' => 'error'));		  
		  }
		 }
	  }
  	  else 
  	  return array('text' => '', 'type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------

  	function command_setip($command_info)
  	{
  	  $row = $command_info['row'];
	  
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	      $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);

		  $user_name = $_SESSION['SP_USER_NICK'];

		  $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user
		   
		  $get_ip = trim(implode(" ",$command_info['params'])); //implode the ip to change

		  //check for op exists on database
		  if($user_info == NULL){
		  return array('text' => str_replace("#user#", $user_name, LTChatCore_user_doesnt_exists), 
		               'type' => 'private', 
					   'other_options' => array('type_handle' => 'error'));
		  }else{
		  
		  $how_change = $this->SPECIAL_CORE->mysql_actions->change_ip($get_ip);
		  
		  $change = ($how_change == 1) ? $how_change : 0;
		  
		  if($change && !empty($get_ip))		  
		  return array('text' => str_replace("#change#", $get_ip, LTChatCore_change_ip), 
		               'type' => 'private'
					   );
	   	  else
		  return array('text' => 'Your ip not changed, please checked!', 
		               'type' => 'private', 
					   'other_options' => array('type_handle' => 'error'));
		 }
	  }
  	  else 
  	  return array('text' => '', 'type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------

  	function command_timebar($command_info)
  	{
      global $autoup;

  	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	       $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);

		   $user_name = $_SESSION['SP_USER_ID'];

		   $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_id($user_name); //get user

		  //check for op exists on database
		  if($user_info == NULL){
		  return array('text' => str_replace("#user#", $user_name, LTChatCore_user_doesnt_exists), 
		               'type' => 'private', 
					   'other_options' => array('type_handle' => 'error'));
		  }else{
		   
			$level = $_SESSION['SP_USER_LEVEL'];
			$color = $this->SPECIAL_CORE->mysql_master->get_user_color($level);
			
			$time_log = $this->SPECIAL_CORE->mysql_actions->get_time(0); //get time login time
			
			$time_now = time(); //time now :)
			
			$total = $time_now - $time_log;
			
			$howmytotaltime = $this->SPECIAL_CORE->mysql_actions->get_total_time(); //get total time sender
			$sumtotaltime = $howmytotaltime / 3600; //sum total time on hours
			$mytotaltime = ceil($sumtotaltime); // ceil total time
			$range = range(from_level, to_level);

			$showtimebar = 0;
			
			if($level >= from_level && $level <= to_level){
				 if(is_array($range)){
					if(in_array($level, $range)){
						$limitaz = $autoup[$level];
					}
				 }
			
			$max = $limitaz;
			
			$dopercent = ( $sumtotaltime / $max) * 100;
			
			$percent = ceil($dopercent);
			
			$showtimebar = 1;
		   }
		   		   
		   $other_options = array('function' => 'timebar', 
								  'showtimebar' => $showtimebar,
								  'percent' => $percent,
								  'LTChatTemplatePath' => LTChatTemplatePath
								  );
	
		  return array('data_type' => 'functions', 
		  			   'text' => '', 
					   'type' => 'private', 
					   'other_options' => $other_options);
		 }
	  }
  	  else 
  	  return array('text' => '', 'type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------

  	function command_whois($command_info)
  	{
  	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  $time = time();
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	       $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);

		   $user_name = trim($command_info['params'][1]);
		   unset($command_info['params'][1]);

		   $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user

		  //check for op exists on database
		  if($user_info == NULL){
		  return array('text' => str_replace("#user#", $user_name, LTChatCore_user_doesnt_exists), 
		               'type' => 'private', 
					   'other_options' => array('type_handle' => 'error'));
		  }else{
		  $online  = $this->SPECIAL_CORE->mysql_login->online($user_info->id); //get status (on)||(off) line
		  
		  //check online for stop command if offline mode!
		  if($online == FALSE){
		  return array('text' => str_replace(array("#user#"), array($user_info->nick), ChFun_offline), 
		               'type' => 'private', 
					   'other_options' => array('type_handle' => 'error'));
		  }
		   
		   $get = $this->SPECIAL_CORE->mysql_actions->show_whois($user_info->id, $room, $user_info->nick);
		   $status = ($get['online'] == 1) ? 'online' :"No data";
		   $onlinetime = FUNCTIONS::get_date($get['login_time']);
		   $public_idle = ($get['last_public_msg_time'] > 0) ? FUNCTIONS::get_date($get['last_public_msg_time']) :"No data";
		   $private_idle = ($get['last_private_msg_time'] > 0) ? FUNCTIONS::get_date($get['last_private_msg_time']) :"No data";
		  
		   $other_options = array('function' => 'show_whois', 
								  'nickname' => $user_info->nick,
								  'maskip' => $user_info->rights,
								  'room' => $room,
								  'onlinetime' => $onlinetime,
								  'public_idle' => $public_idle,
								  'private_idle' => $private_idle,
								  'status' => $status
								  );
	
		  return array('data_type' => 'functions', 'text' => '', 'type' => 'private', 'other_options' => $other_options);
		 }
	  }
  	  else 
  	  return array('text' => '', 'type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------

  	function command_remove_user($command_info)
  	{
  	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  $type = 'remove';
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
				
		$op_name = trim($command_info['params'][1]);
		unset($command_info['params'][1]);
		
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($op_name); //get user
		
		//check for op exists on database
		if($user_info == NULL){
		return array('text' => str_replace("#user#", $op_name, LTChatCore_user_doesnt_exists), 
				     'type' => 'private', 
				     'other_options' => array('type_handle' => 'error'));
		}else{
		
		if($user_info->level == 0){
		return array('text' => str_replace("#user#", $op_name, LTChatCore_user_doesnt_exists), 
				     'type' => 'private', 
				     'other_options' => array('type_handle' => 'error'));
		}
		
		if($user_info->level >= 48){
		return array('text' => str_replace("#user#", $op_name, LTChatCore_user_doesnt_exists), 
				     'type' => 'private', 
				     'other_options' => array('type_handle' => 'error'));
		}
		
		$out = "** The member name <b>$op_name</b> has been removed from database";
		
		
		//TODO: add :: remove member from actions and check
		mysql_commands::remove_member($user_info->id);
		
		//post logs
		$this->SPECIAL_CORE->mysql_public_private->post_logs($out, $room, $type, FALSE);
		
		return array('text' => $out, 
					 'type' => 'private'
					 );
		
		}
      }
	  else
  	  return array('type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------

  	function command_del($command_info)
  	{
  	  $row = $command_info['row'];
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		$level = $_SESSION['SP_USER_LEVEL']; //get sender level
		
		(int)$getid = trim($command_info['params'][1]);
		unset($command_info['params'][1]);
		
		if($level > 0){
		$getmsgid = $this->SPECIAL_CORE->mysql_public_private->delete_private_by_id();
		}else{
		$getmsgid = $this->SPECIAL_CORE->mysql_public_private->delete_private_by_id_rec($getid);
		}
		//check for id null
	    if($getmsgid == false)
		return array('text' => ChFun_fl_nomsg, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else	    
		return array('data_type' => 'refresh', 'text' => ChFun_fl_delmsg_ok, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

      }
	  else
  	  return array('type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------
  	
	//TODO: Check The user if ignore private when forward
	
  	function command_forward($command_info)
  	{
  	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  $type = 'forward';
  	  
		if($row->user == $_SESSION['SP_USER_NICK'])
  	  {	    
	    //delete the command from talk for duplicate
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		
		//get the opreator want forward
		$f_send_to = trim($command_info['params'][1]);
		unset($command_info['params'][1]);

		//get the info for forwarded to
		$f_send_to_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($f_send_to); //get sender info
		
		//check for op exists on database
        if($f_send_to_info == NULL){
  		  $u_doesnt_exists = str_replace("#user#",trim($f_send_to), LTChatCore_user_doesnt_exists);
  		  return array('text' => $u_doesnt_exists, 'type' => 'private','other_options' => array('type_handle' => 'error'));
  	  	}else{
		$online  = $this->SPECIAL_CORE->mysql_login->online($f_send_to_info->id); //get status (on)||(off)line
		
		//check command for stop forward to user with offline mode!
		if($online == FALSE){
		return array('text' => str_replace(array("#user#"), array($f_send_to), ChFun_forward_notonline), 
					 'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));
		}		
		
		if($f_send_to_info->level == 0)
		return array('text' => 'Soory, cannot alowwed forward messages to guest', 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		
		//forward the message and post in forward logs
		$check = $this->SPECIAL_CORE->mysql_actions->forward_message_id($f_send_to_info->id, $type, $room, $f_send_to);

		if($check){
  	    return array('text' => str_replace(array("#f_send_to#"), array($f_send_to), ChFun_msg_forward_ok),
		             'type' => 'private',
					 'other_options' => array('type_handle' => 'error'));
	    }else{
  	    return array('text' => 'Not have message selected to forward','type' => 'private','other_options' => array('type_handle' => 'error'));
  	    }
		
		}## check exists
		
      }##
	  else
  	  return array('type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------

  	function command_abuse($command_info)
  	{
  	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  $type = 'abuse';
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $room)
  	  {
	    //delete the command from talk for duplicate
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		//post logs for abuse room
		$this->SPECIAL_CORE->mysql_public_private->post_logs($row->user, $room, $type, FALSE);
		//save the public room for abuse
		$this->SPECIAL_CORE->mysql_public_private->abuse_public($_SESSION['SP_USER_ID'],$room);

  	    return array('text' => str_replace(array("#room#"), array($room), ChFun_abuse_msg),
		             'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));
      }
	  else
  	  return array('type' => 'skip');
  	}
  	//---------------------------------------------------------------------

  	function command_check()
  	{
      return array();
  	}
	
  	//---------------------------------------------------------------------

  	function command_flash($command_info)
  	{
  	  $params = $command_info['params'];	  
	  $room = $command_info['room'];
  	  $row = $command_info['row'];
  	  
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {

		//$user_name = str_replace(' ','_', strtolower( trim($command_info['params'][1]) ) ); //NICK
        $user_name = trim($command_info['params'][1]); //NICK
        unset($command_info['params'][1]); //unset params 1 for replace
        $flash_name = trim(implode(" ",$command_info['params'])); //implode the reason
        
        if( eregi('ar',$flash_name) || eregi('en',$flash_name)){
        	
        	$check_ext = eregi('ar',$flash_name) ? 'ar' : 'en';
        	
        	$flash_url = SITE_DIR.'/script_flash/'.$check_ext.'/'.substr($flash_name,2).'.swf';
        	
        	$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user
			        	
	        if( file_exists(SITE_PATH.'/script_flash/'.$check_ext.'/'.substr($flash_name,2).'.swf') ){			
				
				//check for op exists on database
		        if($user_info == NULL)
		  	  	  return array('text' => str_replace("#user#", $user_info->nick, LTChatCore_user_doesnt_exists), 
					  		   'type' => 'private', 
							   'other_options' => array('type_handle' => 'error')
							  );
		  	  	else
		  	  	{
	        	
				$out = str_replace(array("#nick#","#flash#","#user#","#nickfont#","#color#"), 
								   array($row->user, $flash_url,$user_info->nick,$user_info->nickfont,$user_info->color), ChFun_Flash_Style);
    			//post the singing message on public
				$this->SPECIAL_CORE->mysql_public_private->post_reason($out, $room);
				$this->SPECIAL_CORE->mysql_public_private->post_private_reason($out, $user_info->id, 1);
				
				}
				      	
	        }else{
	        	return array('text' => ERROR_flash_msg_notfound, 'type' => 'private');
	        }
	        
	    }else{
	    	return array('text' => ERROR_flash_msg_notfound, 'type' => 'private');
	    }      
	  
	  }else{
	  	
      return array('type' => 'skip');
      }      
  	}
  	//---------------------------------------------------------------------
	
  	function command_ping($command_info)
  	{
  	  $row = $command_info['row'];
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
  	  	$HOST = trim($command_info['params'][1]);
  	  	if($HOST == "")
  	  	  $text = ChFun_ping_BadHost;
  	  	elseif(!function_exists("socket_create"))
  	  	  $text = ChFun_ping_Disabled;
  	  	elseif(($ip = gethostbyname($HOST)) == $HOST && !eregi("([0-9]*)\.([0-9]*)\.([0-9]*)\.([0-9]*)", $HOST))
  	  	{
  	  	  $text = str_replace("#host#", $HOST, ChFun_ping_ResolveErr);
  	  	}
  	  	else
  	  	{
          include_once(SITE_PATH."/sources/net_ping.php");
          
		  $ping = new Net_Ping();
		  $text .= str_replace(array("#host#","#ip#"), array($HOST, $ip), ChFun_ping_Info).ChFun_ping_Separator;

		  for($i = 0; $i < 3; $i ++)
		  {
			  $ping->ping($HOST);
			  $b = 32;
		   	  if ($ping->time)		$text .= str_replace(array("#ip#","#b#","#time#"), array($ip, $b, $ping->time), ChFun_ping_Info_resp);
			  else				    $text .= ChFun_ping_Info_Timeout;
			  $text .= ChFun_ping_Separator;
		  }
  	  	}
	    return array('text' => $text,
					 'type' => 'private',
					 'other_options' => array('type_handle' => 'error')
					 );
  	  }
  	  return array('type' => 'skip');
  	}
  	//---------------------------------------------------------------------
  	
  	function command_whoami($command_info)
  	{
  	   $text = str_replace("#user#", $_SESSION['SP_USER_NICK'], ChFun_whoami);
	   return array('text' => $text, 'type' => 'private');
  	}
  	//---------------------------------------------------------------------

  	function command_logout($command_info)
  	{
	
	global $autoup;
	
  	  $row = $command_info['row'];
	  $room = $command_info['room'];
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  
	    $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($row->user); //get sender info
	    $level = $_SESSION['SP_USER_LEVEL']; //get sender level
		$enouq = time() - $user_info->last_seen;
		
		if($level>0) $quit_msg = trim(implode(" ",$command_info['params'])); //implode the reason
		
		//check the time login for stop quit before 2 min
		if ($level == 0 && $enouq <= QUIT_MSG){
        return array('text' => ChFunQuitb4twomin, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		
		}else{
		
		$quit_msg = ($quit_msg != '') ? "($quit_msg)" : '' ;
		
		$room_name = $this->SPECIAL_CORE->mysql_master->get_room_by_id($room);

		//the quit message
		$msg = str_replace(array("#user#", "#ip#", "#room#", "#quit_msg#"),
		                   array($user_info->nick, $user_info->rights, $room_name, $quit_msg), 
						   ChFun_chat_exit);
						   	   
		//post the quit message on public
		$this->SPECIAL_CORE->mysql_public_private->post_reason($msg, $room);
		
		$this->SPECIAL_CORE->mysql_actions->total_time_update();
		
		$this->SPECIAL_CORE->mysql_public_private->delete_offline_private($user_info->id);
		
		//if check the session delete any user used member
		$this->SPECIAL_CORE->mysql_login->delete_from_online($user_info->id);
		
		$other_options = array('function' => 'logout');
  	    return array('data_type' => 'functions', 'text' => '', 'type' => 'private', 'other_options' => $other_options);
  	    
		//header("Location: index.php");
		}
		
  	  }

  	  return array('type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------

  	function command_allmsg($command_info)
  	{
	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  $sender_id = $_SESSION['SP_USER_ID'];
	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {	  
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	    $msg = trim(implode(" ",$command_info['params']));
        
		if($msg == NULL)
		return array('text' => ERROR_allmsg, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else				
	    $get = $this->SPECIAL_CORE->mysql_actions->send_allmsg($sender_id, $msg, $room);
		if(isset($get['info']) && $get['info'] > 0)
		$text = str_replace(array("#count_sent#") , array($get['info']) , ChFun_allmsg_ok);
		return array('text' => $text, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	  }
	  else
	  return array('type' => 'skip');
	}
	
  	//---------------------------------------------------------------------

  	function command_guestmsg($command_info)
  	{
	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  $sender_id = $_SESSION['SP_USER_ID'];
	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {	  
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	    $msg = trim(implode(" ",$command_info['params']));
        
		if($msg == null)
		return array('text' => ERROR_guestmsg, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else				
	    $get = $this->SPECIAL_CORE->mysql_actions->send_usermsg($sender_id, $msg, $room);
		if(isset($get['info']) && $get['info'] > 0)
		$text = str_replace(array("#count_sent#") , array($get['info']) , ChFun_guestmsg_ok);
		return array('text' => $text, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	  }
	  else
	  return array('type' => 'skip');
	}
	
  	//---------------------------------------------------------------------

  	function command_opmsg($command_info)
  	{
	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  $sender_id = $_SESSION['SP_USER_ID'];
	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {	  
	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	    $msg = trim(implode(" ",$command_info['params']));
        
		if($msg == null)
		return array('text' => ERROR_opmsg, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else				
	    $get = $this->SPECIAL_CORE->mysql_actions->send_opmsg($sender_id, $msg, $room);
		if(isset($get['info']) && $get['info'] > 0)
		$text = str_replace(array("#count_sent#") , array($get['info']) , ChFun_opmsg_ok);
		return array('text' => $text, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	  }
	  else
	  return array('type' => 'skip');
	}
	
  	//---------------------------------------------------------------------

  	function command_ban($command_info)
  	{
	  $room = $command_info['room'];
  	  $row = $command_info['row'];
  	  $type = 'banip';
  	  
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
	    //delete the command from talk for duplicate
        $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
        $action_on = trim($command_info['params'][1]); //get the IP / NICK to ban
        unset($command_info['params'][1]); //unset params 1 for replace
        $reason = trim(implode(" ",$command_info['params'])); //implode the reason

		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($row->user); //get sender info
		$get_user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($my_info->level);		
		
		if( !preg_match("/^(\d+\.?)+$/", $action_on) ){
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($action_on); //get sender info
		}
	
		//check ip banned before when get IP
		if (preg_match("/^(\d+\.?)+$/", $action_on) && $this->SPECIAL_CORE->mysql_actions->check_ban_address($action_on)){
  		  	return array('text' => "*** Ban failed: Duplicate ban, $action_on IP is already banned!", 
						 'type' => 'private',
						 'other_options' => array('type_handle' => 'error'));
		}
		
		//check ip banned before when get Nickname
		if(!preg_match("/^(\d+\.?)+$/", $action_on) && $this->SPECIAL_CORE->mysql_actions->check_ban_address($user_info->last_ip)){
  		  	return array('text' => "*** Ban failed: Duplicate ban, $action_on User is already banned!",  
						 'type' => 'private',
						 'other_options' => array('type_handle' => 'error'));	
		}		
		
		//check valid ip
		if (preg_match("/^(\d+\.?)+$/", $action_on) && FUNCTIONS::is_ip($action_on) == true){
		$trueip = $action_on;
		$text = str_replace(array("#ip#","#sendercolor#","#sender#","#senderrightcolor#","#reason#"), 
		                    array($trueip, $my_info->color,$my_info->nick,$get_user_color,$reason), 
							ChFun_banip_OkReason);
							
		}else{
		
		if (!preg_match("/^(\d+\.?)+$/", $action_on)){
		$online  = $this->SPECIAL_CORE->mysql_login->online($user_info->id); //get status (on)||(off)line )	

			if($user_info == NULL){
  		  	$u_doesnt_exists = str_replace("#user#",
										   htmlspecialchars(trim($action_on)),
										   LTChatCore_user_doesnt_exists);
										   
  		  	return array('text' => $u_doesnt_exists, 
						 'type' => 'private',
						 'other_options' => array('type_handle' => 'error'));
			
			//check online for stop command if offline mode!
			}elseif($user_info->level == '0' && !$online){
			return array('text' => str_replace(array("#user#"), array($user_info->nick), ChFun_offline), 
			             'type' => 'private', 
					     'other_options' => array('type_handle' => 'error'));
			
			//check level for stop command if member!
			}elseif($user_info->level > 0){
			return array('text' => str_replace(array("#user#"), array($user_info->nick), ChFun_banuser_not), 
			             'type' => 'private', 
					     'other_options' => array('type_handle' => 'error'));
			}else{
				
				//check valid pcip
				if (FUNCTIONS::is_ip($user_info->last_pcip) == true){
				$ban_user = $user_info->last_pcip;
				$text = str_replace(array("#user#","#sendercolor#","#sender#","#senderrightcolor#","#reason#"), 
		                    		array($user_info->nick, $my_info->color,$my_info->nick,$get_user_color,$reason),ChFun_banuser_OkReason);
				
				//check valid realip (connection)
				}elseif(FUNCTIONS::is_ip($user_info->last_ip) == true){
				$ban_user = $user_info->last_ip;
				$text = str_replace(array("#user#","#sendercolor#","#sender#","#senderrightcolor#","#reason#"), 
		                    		array($user_info->nick, $my_info->color,$my_info->nick,$get_user_color,$reason),ChFun_banuser_OkReason);
				
				}else{
				return array('text' => ChFun_not_valid_ip." you can banned $user_info->last_pcip", 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
				}
			}
		}

		}
		
		if(!$trueip && !$ban_user)
		return array('text' => ChFun_not_valid_ip." you can banned $user_info->last_pcip", 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
			

		//check for not null reason
	    if($reason == NULL)
		return array('text' => ChFun_write_banip_reason, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else
		
		if($trueip != false){
		//$type = 'banip';
		$this->SPECIAL_CORE->mysql_actions->banip_address($text, $type, $trueip, FALSE);
		}
		
		if($ban_user != false){
		//$type = 'banuser';
		$this->SPECIAL_CORE->mysql_actions->ban_nick($text, $type, $ban_user, $user_info->nick, $user_info->id);
		$this->SPECIAL_CORE->mysql_actions->insert_check4action($user_info->id, $type);
		}
		
		$check_vaild = ($user_info != NULL) ? $user_info->nick : $trueip;
		
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $check_vaild);
		$this->SPECIAL_CORE->mysql_public_private->post_reason($text, $room);		
		$this->SPECIAL_CORE->mysql_public_private->post_private_logs(str_replace(array("#text#"), array($text), ChFun_private_logs_syntex));
		$this->SPECIAL_CORE->mysql_public_private->abuse_public($_SESSION['SP_USER_ID'],$room);
		
		return array('text' => "*** Now your banned ip $trueip", 
					 'type' => 'private'
					 );
		
  	  }
  	  else
  	    return array('text' => '', 'type' => 'skip');
  	}
  	
  	//---------------------------------------------------------------------
	
	function command_unban($command_info)
	{
	  $room = $command_info['room'];
  	  $row = $command_info['row'];
  	  $type = 'unbanip';
  	  
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
	    //delete the command from talk for duplicate
        $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
        $action_on = trim($command_info['params'][1]); //get the IP / NICK to ban
        unset($command_info['params'][1]); //unset params 1 for replace
        
		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_id($_SESSION['SP_USER_ID']); //get sender info
		$get_user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($my_info->level);
		
		//check ip banned before when get IP
		if (preg_match("/^(\d+\.?)+$/", $action_on) && !$this->SPECIAL_CORE->mysql_actions->check_ban_address($action_on)){
  		  	return array('text' => "*** UnBan failed: $action_on IP not found in banned list to unban!", 
						 'type' => 'private',
						 'other_options' => array('type_handle' => 'error'));
		}
		
		$get_level = $this->SPECIAL_CORE->mysql_actions->get_ban_by_level($action_on);	

		//check valid ip
		if ( !preg_match("/^(\d+\.?)+$/", $action_on) ){
			return array('text' => ChFun_not_valid_ip, 
						 'type' => 'private', 
						 'other_options' => array('type_handle' => 'error'));			
		
		}elseif($my_info->level < $get_level){
			return array('text' => '*** cannot unban action same or high rank', 
			 			 'type' => 'private', 
						 'other_options' => array('type_handle' => 'error'));
		
		}else{
			
		$this->SPECIAL_CORE->mysql_parser->delete_ban($action_on, $room);

		return array('text' => "*** Now your unbanned ip $action_on", 
					 'type' => 'private'
					 );
		}
		
  	  }
  	  else
  	    return array('text' => '', 'type' => 'skip');
	}
  	
	
  	//---------------------------------------------------------------------

  	function command_banpc($command_info)
  	{
	  $room = $command_info['room'];
	  
  	  $row = $command_info['row'];
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
	    //delete the command from talk for duplicate
        $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
        $action_on = trim($command_info['params'][1]); //get the IP / NICK to ban
        unset($command_info['params'][1]); //unset params 1 for replace
        $reason = trim(implode(" ",$command_info['params'])); //implode the reason

		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($row->user); //get sender info
		$get_user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($my_info->level);
		
		//check valid ip
		if (FUNCTIONS::is_ip($action_on) !== FALSE){
		$trueip = $action_on;
		$text = str_replace(array("#ip#","#sendercolor#","#sender#","#senderrightcolor#","#reason#"), 
		                    array($trueip, $my_info->color,$my_info->nick,$get_user_color,$reason), 
							ChFun_banip_OkReason);
		}
		
		//is not ip and please get the ip form last pc ip for user
		if(FUNCTIONS::is_ip($action_on) == FALSE){
			
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($action_on); //get sender info
		$online  = $this->SPECIAL_CORE->mysql_login->online($user_info->id); //get status (on)||(off)line )	
		
			//check valid user
			if($user_info !== NULL && $online == 1 && $user_info->last_pcip !== 'NONE'){
			$ban_user = $user_info->last_pcip;
			$text = str_replace(array("#user#","#sendercolor#","#sender#","#senderrightcolor#","#reason#"), 
			                    array($user_info->nick, $my_info->color, $my_info->nick, $get_user_color, $reason), 
								ChFun_banuser_OkReason);
			}else{
				
			return array('text' => ChFun_not_valid_ip, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
			}
		}

		//check for not null reason
	    if($reason == NULL)
		return array('text' => ChFun_write_banip_reason, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else
		
		if($trueip !== NULL){
		$type = 'banip';
		$this->SPECIAL_CORE->mysql_actions->banip_address($text, $type, $trueip, FALSE);
		}
		
		if($ban_user !== NULL){
		$type = 'banuser';
	        //check command for stop warn same level or high level
	        if ($my_info->level <= $user_info->level){
	        return array('text' => ChFun_warn_same_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	        
			}else{
	        //do the action				
			$this->SPECIAL_CORE->mysql_actions->ban_nick($text, $type, $ban_user, $user_info->nick);
	        }
		}
		
		if($user_info !== NULL){
		$this->SPECIAL_CORE->mysql_actions->insert_check4action($user_info->id, $type);
		}
		
		$check_vaild = ($user_info !== NULL) ? $user_info->nick : $trueip;
		
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $check_vaild);
		$this->SPECIAL_CORE->mysql_public_private->post_reason($text, $room);		
		$this->SPECIAL_CORE->mysql_public_private->post_private_logs(str_replace(array("#text#"), array($text), ChFun_private_logs_syntex));
		$this->SPECIAL_CORE->mysql_public_private->abuse_public($_SESSION['SP_USER_ID'],$room);
  	  }
  	  else
  	    return array('text' => '', 'type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------

  	function command_sus($command_info)
  	{
	  $room = $command_info['room'];
  	  $row = $command_info['row'];
	  $type = 'sus';
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
	    
        $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  
        $user_name = trim($command_info['params'][1]);
        unset($command_info['params'][1]);
        $reason = trim(implode(" ",$command_info['params']));
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user will be suspaned
		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($row->user); //get sender info
		$online  = $this->SPECIAL_CORE->mysql_login->online($user_info->id); //get suspaned status (on)||(off)line )
		$get_user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($my_info->level); //get sender level color
		
		//check command for stop sus self
		if($user_info->nick == $row->user)
		return array('text' => ChFun_sus_your_self, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		//check for op exists on database
        if($user_info == null)
  	  	  return array('text' => str_replace("#user#", $user_name, ChFun_sus_BadNick), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	else
  	  	{
		
		if($my_info->level < 30){
		//check command for stop sus user with offline mode!
		if($online == FALSE)
		return array('text' => str_replace(
		array("#user#"), 
		array($user_name), ChFun_sus_offline), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		}

		if($user_info->level == 0)
		return array('text' => str_replace(array("#user#"), array($user_name), ChFun_sus_offline), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));		
		
		//check command for stop sus same level or high level
		if($my_info->level <= $user_info->level)
		return array('text' => ChFun_sus_same_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		$text = str_replace(array("#user#","#rights#","#sendercolor#","#sender#","#senderrightcolor#","#reason#"), 
		                    array($user_info->nick, $user_info->rights, $my_info->color,$my_info->nick,$get_user_color,$reason), ChFun_sus_OkReason);

		//check for not null reason
	    if($reason == NULL)
		return array('text' => ChFun_write_sus_reason, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else
		$this->SPECIAL_CORE->mysql_actions->suspended_user($user_info->id, $text, $type, $user_info->nick);
		$this->SPECIAL_CORE->mysql_actions->insert_check4action($user_info->id,$type);
		$this->SPECIAL_CORE->mysql_public_private->post_reason($text, $room);	
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $user_info->nick);	
		$this->SPECIAL_CORE->mysql_public_private->post_private_logs(str_replace(array("#text#"), array($text), ChFun_private_logs_syntex));
		$this->SPECIAL_CORE->mysql_public_private->abuse_public($_SESSION['SP_USER_ID'],$room);
		$this->SPECIAL_CORE->mysql_login->delete_from_online($user_info->id);
  	  	}
  	  }
  	  else
  	    return array('text' => '', 'type' => 'skip');
  	}
  	
  	//---------------------------------------------------------------------
	
	function command_unsus($command_info)
	{
	  $room = $command_info['room'];
	  
  	  $row = $command_info['row'];
	  
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
        $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  
        $user_name = trim($command_info['params'][1]);
        unset($command_info['params'][1]);
		
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user will be disable
		$action_by_level = $this->SPECIAL_CORE->mysql_actions->action_by_level($user_info->id,'sus');
		$action_by_nick = $this->SPECIAL_CORE->mysql_actions->action_by_nick($user_info->id,'sus');
		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($_SESSION['SP_USER_NICK']); //get my info
		$get_user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($my_info->level);
		
		//check for user doesnt exists
  		if($user_info == NULL)
  		{
  		  $u_doesnt_exists = str_replace("#user#", $user_name, LTChatCore_user_doesnt_exists);
  		  return array('text' => $u_doesnt_exists, 'type' => 'private','other_options' => array('type_handle' => 'error'));
  		}
  		
		  		
		//check command for unsus same level or high level
		if($my_info->level <= $action_by_level && $action_by_nick != $my_info->nick){
		return array('text' => ChFun_unsus_same_level, 
		             'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));
		}

		if(!$this->SPECIAL_CORE->mysql_actions->whois_have_action($user_info->id, 'sus'))
		return array('text' => str_replace(array("#user#"), array($user_name), ChFun_already_unsus), 
		             'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));
					 
	    else
		$text = str_replace(array("#user#","#rights#","#sender#","#senderrightcolor#","#sender_original#"), 
		                    array($user_info->nick, $user_info->rights, $my_info->nick,$get_user_color,$action_by_nick), ChFun_un_sused);
		
		//delele an operator from suspaned and include
		$this->SPECIAL_CORE->mysql_actions->delete_sus($user_info->id);
		$this->SPECIAL_CORE->mysql_public_private->abuse_public($_SESSION['SP_USER_ID'],$room);
		
		 //post the logs on logs table
		 $this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, 'unsus', FALSE);	
		 //post private logs
		 $this->SPECIAL_CORE->mysql_public_private->post_private_logs(str_replace(array("#text#"), array($text), ChFun_private_logs_syntex));
		
		$out = str_replace(array("#user#"), array($user_info->nick), ChFun_un_sused_msg);		
		return array('text' => $out, 'type' => 'private'); 
	  
	  }else
  	    return array('text' => '', 'type' => 'skip');
	}
	
  	//---------------------------------------------------------------------

  	function command_kick($command_info)
  	{
	  $room = $command_info['room'];
	  
  	  $row = $command_info['row'];
	  $type = 'kick';
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
	    
        $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  
        $user_name = trim($command_info['params'][1]);
        unset($command_info['params'][1]);
        $reason = trim(implode(" ",$command_info['params']));
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user will be kicked
		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($row->user); //get my info
		$online  = $this->SPECIAL_CORE->mysql_login->online($user_info->id); //get status (on)||(off)line )
		$get_user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($my_info->level);
		
		//check command for stop kick self
		if($user_info->nick == $row->user)
		return array('text' => ChFun_kick_your_self, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		//check for op exists on database
        if($user_info == NULL)
  	  	  return array('text' => str_replace("#user#", $user_name, ChFun_kick_BadNick), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	else
  	  	{
		
		//check command for stop kick user with offline mode!
		if($online == 0)
		return array('text' => str_replace(array("#user#"), array($user_name), ChFun_kick_offline), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		
		//check command for stop kick same level or high level
		if($my_info->level <= $user_info->level)
		return array('text' => ChFun_kick_same_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		$text = str_replace(array("#user#","#rights#","#sendercolor#","#sender#","#senderrightcolor#","#reason#"), 
		                    array($user_info->nick, $user_info->rights, $my_info->color,$my_info->nick,$get_user_color,$reason), ChFun_kick_OkReason);

		//check for not null reason
	    if($reason == NULL)
		return array('text' => ChFun_write_kick_reason, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else 
		$this->SPECIAL_CORE->mysql_actions->kick_user($user_info->id, $text, $type, $user_info->nick);		
		$this->SPECIAL_CORE->mysql_public_private->post_reason($text, $room);	
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $user_info->nick);	
		$this->SPECIAL_CORE->mysql_public_private->post_private_logs(str_replace(array("#text#"), array($text), ChFun_private_logs_syntex));
		$this->SPECIAL_CORE->mysql_public_private->abuse_public($_SESSION['SP_USER_ID'],$room);
		$this->SPECIAL_CORE->mysql_actions->insert_check4action($user_info->id,$type);
		//$this->SPECIAL_CORE->mysql_login->delete_from_online($user_info->id, false);
			
		}
  	  }
  	  else
  	    return array('text' => '', 'type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------

  	function command_multikick($command_info)
  	{
	  $room = $command_info['room'];
	  
  	  $row = $command_info['row'];
	  $type = 'mkick';
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
	    
        $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  
        $user_name = trim($command_info['params'][1]);
        unset($command_info['params'][1]);
        $reason = trim(implode(" ",$command_info['params']));
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user will be kicked
		
		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($row->user); //get my info
		$online  = $this->SPECIAL_CORE->mysql_login->online($user_info->id); //get status (on)||(off)line )
		$get_user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($my_info->level);
		
		//check for not null reason
	    if($user_info == NULL)
		return array('text' => ChFun_write_multikick_nick, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));		
		//check command for stop kick user with offline mode!
		if($online == 0)
		return array('text' => str_replace(array("#user#"), array($user_name), ChFun_kick_offline), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		
		//check command to look for level (multi kick command not allowed kick op)
		if($user_info->level != 0)
		return array('text' => ChFun_multikick_op, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		//check for not null reason
	    if($reason == null){
		return array('text' => ChFun_write_multikick_reason, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    }
	    
	    $reason_msg = str_replace(array("#sendercolor#","#sender#","#senderrightcolor#","#reason#"), 
								 array($my_info->color,$my_info->nick,$get_user_color,$reason), ChFun_multikick_4_person);
	    
		$get = $this->SPECIAL_CORE->mysql_actions->multikick_user($user_info->id, $user_info->nick, $user_info->last_ip,$reason_msg);
		
		if(isset($get['number']) && isset($get['name']) && $get['number'] > 0){
		$text = str_replace(array("#number#","#name#","#user#","#rights#","#sendercolor#","#sender#","#senderrightcolor#","#reason#"), array($get['number'], $get['name'], $user_info->nick, $user_info->rights, $my_info->color,$my_info->nick,$get_user_color,$reason), ChFun_multikick_OkReason);
		}
				
		$this->SPECIAL_CORE->mysql_public_private->post_reason($text, $room);
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $user_info->nick);
		$this->SPECIAL_CORE->mysql_public_private->post_private_logs(str_replace(array("#text#"), array($text), ChFun_private_logs_syntex));
		$this->SPECIAL_CORE->mysql_public_private->abuse_public($_SESSION['SP_USER_ID'],$room);
  	  
	  }##end row->user
  	  else
  	    return array('text' => '', 'type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------
	
	function command_disable($command_info)
	{
	  $room = $command_info['room'];
	  
  	  $row = $command_info['row'];
	  $type = 'disable';
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
        $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  
        $user_name = trim($command_info['params'][1]);
        unset($command_info['params'][1]);
        $reason = trim(implode(" ",$command_info['params']));
		
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user will be disable
		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($row->user); //get my info
		$get_user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($my_info->level);
		
		//check command for stop disable self
		if($user_info->nick == $row->user)
		return array('text' => ChFun_disable_your_self, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		
		//check for user doesnt exists
  		if($user_info == NULL)
  		{
  		  $u_doesnt_exists = str_replace("#user#", $user_name, LTChatCore_user_doesnt_exists);
  		  return array('text' => $u_doesnt_exists, 'type' => 'private','other_options' => array('type_handle' => 'error'));
  		}
		
		//check command for stop disable same level or high level
		if($my_info->level <= $user_info->level)
		return array('text' => ChFun_disable_same_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		
		//check command to look for level (disable command not allowed disable user)
		if($user_info->level == 0)
		return array('text' => ChFun_disable_user, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		
		//check command for stop already user in disable!
		if($this->SPECIAL_CORE->mysql_actions->whois_have_action($user_info->id, $type) == 1)
		return array('text' => str_replace(array("#user#"), array($user_name), ERROR_already_disable), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		//check for null reason
	    if($reason == NULL)
		return array('text' => ChFun_write_disable_reason, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else
		$text = str_replace(array("#user#","#rights#","#sendercolor#","#sender#","#senderrightcolor#","#reason#"), 
		                    array($user_info->nick, $user_info->rights, $my_info->color,$my_info->nick,$get_user_color,$reason), ChFun_disable_Ok);
		
		$this->SPECIAL_CORE->mysql_actions->disable_member($user_info->id, $text, $type, $user_info->nick);	
		$this->SPECIAL_CORE->mysql_actions->insert_check4action($user_info->id, $type);	
		$this->SPECIAL_CORE->mysql_public_private->post_reason($text, $room);	
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $user_info->nick);	
		$this->SPECIAL_CORE->mysql_public_private->post_private_logs(str_replace(array("#text#"), array($text), ChFun_private_logs_syntex));
		$this->SPECIAL_CORE->mysql_public_private->abuse_public($_SESSION['SP_USER_ID'],$room);
	  
	  }else
  	    return array('text' => '', 'type' => 'skip');
	}
	
  	//---------------------------------------------------------------------
	
	function command_enable($command_info)
	{
	  $room = $command_info['room'];
	  
  	  $row = $command_info['row'];
	  $type = 'enable';
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
        $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  
        $user_name = trim($command_info['params'][1]);
        unset($command_info['params'][1]);
		
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user will be disable
		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($row->user); //get my info
		$get_user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($my_info->level);
		
		//check command for stop enable self
		if($user_info->nick == $row->user)
		return array('text' => ChFun_enable_your_self, 
		             'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));
		
		//check for user doesnt exists
  		if($user_info == NULL)
  		{
  		  $u_doesnt_exists = str_replace("#user#", $user_name, LTChatCore_user_doesnt_exists);
  		  return array('text' => $u_doesnt_exists, 'type' => 'private','other_options' => array('type_handle' => 'error'));
  		}
		
		//check command for stop enable same level or high level
		if($my_info->level <= $user_info->level)
		return array('text' => ChFun_enable_same_level, 
		             'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));
		
		//check command to look for level (enable command not allowed enable user)
		if($user_info->level == 0)
		return array('text' => ChFun_enable_user, 
		             'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));
		
		//check command for user in disable ro enable him!
		if($this->SPECIAL_CORE->mysql_actions->whois_have_action($user_info->id, 'disable') == 0)
		return array('text' => str_replace(array("#user#"), array($user_name), ChFun_already_enable), 
		             'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));
					 
	    else
		$text = str_replace(array("#user#","#rights#","#sendercolor#","#sender#","#senderrightcolor#"), 
		                    array($user_info->nick, $user_info->rights, $my_info->color,$my_info->nick,$get_user_color), ChFun_enable_Ok);
		
		$this->SPECIAL_CORE->mysql_actions->enable_member($user_info->id);
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $user_info->nick);	
		$this->SPECIAL_CORE->mysql_public_private->post_private_logs(str_replace(array("#text#"), array($text), ChFun_private_logs_syntex));
		$this->SPECIAL_CORE->mysql_public_private->abuse_public($_SESSION['SP_USER_ID'],$room);
		
		$out = str_replace(array("#user#"), array($user_info->nick), ChFun_enable_msg);		
		return array('text' => $out, 'type' => 'private'); 
	  
	  }else
  	    return array('text' => '', 'type' => 'skip');
	}

  	//---------------------------------------------------------------------
  	function command_warn($command_info)
  	{
	  $room = $command_info['room'];
	  
  	  $row = $command_info['row'];
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
	    
        $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  
        $user_name = trim($command_info['params'][1]);
        unset($command_info['params'][1]);
        $reason = trim(implode(" ",$command_info['params']));
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user will be kicked
		$my_self = $_SESSION['SP_USER_NICK']; //get my name from session for get my info
		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($my_self); //get my info
		$get_user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($my_info->level);
		$online  = $this->SPECIAL_CORE->mysql_login->online($user_info->id); //get status (on)||(off)line )
		
		//check command for stop warn self
		if($user_info->nick == $row->user)
		return array('text' => ChFun_warn_your_self, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		//check for op exists on database
        if($user_info == null)
  	  	  return array('text' => str_replace("#user#", $user_name, ChFun_warn_BadNick), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	else
  	  	{
		
		//check command for stop warn user with offline mode!
		if($online == FALSE)
		return array('text' => str_replace(array("#user#"), array($user_name), ChFun_warn_offline), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		
		//check command for stop warn same level or high level
		if($my_info->level <= $user_info->level)
		return array('text' => ChFun_warn_same_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));


		//check for not null reason
	    if($reason == NULL)
		return array('text' => ChFun_write_warn_reason, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else 
		$text = str_replace(array("#user#","#rights#","#sendercolor#","#sender#","#senderrightcolor#","#reason#"), 
		                    array($user_info->nick, $user_info->rights, $my_info->color,$my_info->nick,$get_user_color,$reason), 
						   ChFun_warn_Ok);
		
		$this->SPECIAL_CORE->mysql_public_private->post_reason($text, $room);
        $this->SPECIAL_CORE->mysql_public_private->post_private_reason($text, $user_info->id, 1);
		$this->SPECIAL_CORE->mysql_public_private->post_private_logs(str_replace(array("#text#"), array($text), ChFun_private_logs_syntex));
		$this->SPECIAL_CORE->mysql_public_private->abuse_public($_SESSION['SP_USER_ID'],$room);
  	  	}
  	  }
  	  else
  	    return array('text' => '', 'type' => 'skip');
  	}
  	//---------------------------------------------------------------------

  	function command_jail($command_info)
  	{
	  $room = $command_info['room'];
	  
  	  $row = $command_info['row'];
	  $type = 'jail';
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
	    
        $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  
        $user_name = trim($command_info['params'][1]);
        unset($command_info['params'][1]);
        $reason = trim(implode(" ",$command_info['params']));
		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user will be kicked
		$my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($row->user); //get my info
		$online  = $this->SPECIAL_CORE->mysql_login->online($user_info->id); //get status (on)||(off)line )
		$get_user_color = $this->SPECIAL_CORE->mysql_master->get_user_color($my_info->level);
		
		//check command for stop jail self
		if($user_info->nick == $row->user)
		return array('text' => ChFun_jail_your_self, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		//check for op exists on database
        if($user_info == NULL)
  	  	  return array('text' => str_replace("#user#", $user_name, ChFun_jail_BadNick), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	else
  	  	{
		
		//check command for stop kick user with offline mode!
		if($online == 0)
		return array('text' => str_replace(array("#user#"), array($user_name), ChFun_jail_offline), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		//check command for stop already user in jail!
		if($this->SPECIAL_CORE->mysql_actions->whois_have_action($user_info->id, $type) == 1)
		return array('text' => str_replace(array("#user#"), array($user_name), ERROR_msg_already_jail), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
		
		//check command for stop kick same level or high level
		if($my_info->level <= $user_info->level)
		return array('text' => ChFun_jail_same_level, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));

		$text = str_replace(array("#user#","#rights#","#sendercolor#","#sender#","#senderrightcolor#","#reason#"), 
		                    array($user_info->nick, $user_info->rights, $my_info->color,$my_info->nick,$get_user_color,$reason), 
						   ChFun_jail_OkReason);

		//check for not null reason
	    if($reason == NULL)
		return array('text' => ChFun_write_jail_reason, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	    else 
		$this->SPECIAL_CORE->mysql_actions->jail_user($user_info->id, $text, $type, $user_info->nick);		
		$this->SPECIAL_CORE->mysql_public_private->post_reason($text, $room);	
		$this->SPECIAL_CORE->mysql_public_private->post_logs($text, $room, $type, $user_info->nick);	
		$this->SPECIAL_CORE->mysql_public_private->post_private_logs(str_replace(array("#text#"), array($text), ChFun_private_logs_syntex));
		$this->SPECIAL_CORE->mysql_public_private->abuse_public($_SESSION['SP_USER_ID'],$room);
		$this->SPECIAL_CORE->mysql_actions->insert_check4action($user_info->id,$type);
  	  	}
  	  }
  	  else
  	    return array('text' => '', 'type' => 'skip');
  	}
		
  	//---------------------------------------------------------------------

  	function command_private_msg($command_info)
  	{
  	  $params = $command_info['params'];
  	  $row = $command_info['row'];
  	  $room = $command_info['room'];
  	  $private_id = $command_info['private_id'];
	  
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
  		
	    //$this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, $private_id);
  		$user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick(trim($params[1]));
  		
  		if($user_info == null)
  		{

  		  $u_doesnt_exists = str_replace("#user#",htmlspecialchars(trim($params[1])), LTChatCore_user_doesnt_exists);
  		  return array('text' => $u_doesnt_exists, 'type' => 'private','other_options' => array('type_handle' => 'error'));
  		}
  		elseif ($this->SPECIAL_CORE->mysql_login->online($user_info->id) != 1)
  		{
  		  return array('text' => str_replace("#user#", $user_info->nick, offline), 'type' => 'private','other_options' => array('type_handle' => 'error'));
  		}
//  		elseif ($user_info->nick == $row->user)
//  		{
//  		  return array('text' => ChFun_prv_msgtome, 'type' => 'private','other_options' => array('type_handle' => 'error'));
//  		}

  		unset($params[1]);
  		$text = implode(" ",$params);
  		
        $msg_text = $this->SPECIAL_CORE->mysql_public_private->post_private_msg($text, $user_info->id, 1);
        $error_exp = explode(" ",$msg_text);

		if($error_exp[0] == "/ERROR")
		{
		  $error_out = $this->command_ERROR(array('params'=> $error_exp));
		  $out = $error_out['text'];
		}
		else 
		{
	      $link = "./private.php?private_id={$user_info->id}";
	      $text = FUNCTIONS::load_emoticons($text); //replace the *48*
	      //$text = load_internal_letters_emoticons($text); //replace *h*
	      $out = $text;
	      $data_type = "prv_msg_send";
		  
		  $get_user_status = $this->SPECIAL_CORE->mysql_actions->whois_have_action($user_info->id, 'away');
		  
		  if($get_user_status == 1){
		  $status = "System alert, the user $user_info->nick is in the away mode but the message has been sent!";
		  }else{
		  $status = "The message is delivered to";
		  }
		  
	      $other_options = array('status' => $status, 'link' => $link, 'nick' => $user_info->nick);
		}

	  	  $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);

          return array('data_type' => $data_type, 'text' => $out, 'type' => 'private', 'other_options' => $other_options);        
  	  }
  	  else 
  	  {
  	  	return array('text' => '', 'type' => 'skip');
  	  }
  	}
  	//---------------------------------------------------------------------
    function command_emoticons($command_info)
    {
  	   if(file_exists(LTChatTemplateSystemPath."tpl_emoticons.txt"))
  	   {
		  $tpl_emoticons = file(LTChatTemplateSystemPath."tpl_emoticons.txt");
		  foreach ($tpl_emoticons as $line)
		  {
		  	$lines = explode("\t",$line);
		  	if(count($lines) <2) continue;

		  	$from = htmlspecialchars($lines[0]);
		  	$emoticons .= str_replace(array("#path#","#info#"),array(LTChatTemplatePath."img/emoticons/".$lines[count($lines)-1],$from), ChFun_emoticons_Style);
		  }
  	   }
  	   return array('text' => $emoticons, 'type' => 'private');
    }
  	//---------------------------------------------------------------------
    function command_removefriend($command_info)
    {
  	  $params = $command_info['params'];
      $params_new = array();
      $params_new[1] = $this->language_config['help']['friend']['except_params_static']['del'];
	  foreach ($params as $param)
	  	$params_new[] = $param;

	  $command_info['params'] = $params_new;
	  $command_info['command_help'] = $this->language_config['help']['friend'];
	  
	  return $this->command_friend($command_info);
    }
	
  	//---------------------------------------------------------------------

  	function command_unteam($command_info)
  	{
  	  $params = $command_info['params'];
      $params_new = array();
      $params_new[1] = $this->language_config['help']['team']['except_params_static']['del'];
	  foreach ($params as $param)
	  	$params_new[] = $param;

	  $command_info['params'] = $params_new;
	  $command_info['command_help'] = $this->language_config['help']['team'];
	  
	  return $this->command_team($command_info);
  	}
	
  	//---------------------------------------------------------------------

  	function command_showteam($command_info)
  	{
  	  $params = $command_info['params'];
      $params_new = array();
      $params_new[1] = $this->language_config['help']['team']['except_params_static']['show'];
	  foreach ($params as $param)
	  	$params_new[] = $param;

	  $command_info['params'] = $params_new;
	  $command_info['command_help'] = $this->language_config['help']['team'];
	  
	  return $this->command_team($command_info);
  	}
	
  	//---------------------------------------------------------------------
	
  	function command_team($command_info)
  	{
  	  $row = $command_info['row'];
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
	  	  $params = $command_info['params'];
	  	  $row = $command_info['row'];
	
	  	  $add_team = true;
	  	  if($command_info['command_help']['except_params_static']['add'] == trim($params[1]))
	  	  {
	  	    unset($params[1]);
	  	  }
	  	  elseif($command_info['command_help']['except_params_static']['del'] == trim($params[1]))
	  	  {
	  	    unset($params[1]);
	  	  	$add_team = false;
	  	  }
	  	  elseif($command_info['command_help']['except_params_static']['show'] == trim($params[1]))
	  	  {	
		  
			$res = mysql_commands::get_team_list();
			if($res == NULL)
			{
	  		  return array('text' => ChFun_team_list_empty, 'type' => 'private');
			}
			else 
			{
			  if(is_array($res['list']))
			   foreach ($res['list'] as $info){
				  $out .= str_replace(array("#team_user#", "#team_group_title#", "#team_group_name#", "#team_user_level#"), 
				                     array($info->nick, $info->g_title, $info->g_name, $info->level), ChFun_team_Show);
			    }
	  		  return array('text' => $out, 'type' => 'private');
			}
	  	  }
	
	  	  $u_name = implode(" ", $params);
	      $u_name = trim($u_name);
	
	      $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($u_name);
	  	  $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, $private_id);
	
	  	  if($user_info == NULL)
	  	  {
	  		$u_doesnt_exists = str_replace("#user#", $u_name, LTChatCore_user_doesnt_exists);
	  		return array('text' => $u_doesnt_exists, 
			             'type' => 'private', 
						 'other_options' => array('type_handle' => 'error'));
	  	  }
	
	  	  if($add_team)
	  	  {
		    $check_exists = mysql_commands::team_user_exists($user_info->id);
		    
			if($check_exists == TRUE){
	  	  	$out = str_replace(array("#user#", "#group_name#"), array($user_info->nick, 'Team Members'), ChFun_Team_Add);
	  	    mysql_commands::team_user(1, $user_info->id);
			}else{
			$out = str_replace("#user#", $user_info->nick, ChFun_team_user_exists);
			}
			
	  	  }
	  	  else
	  	  {
	  	  	$out = str_replace(array("#user#", "#group_name#"), array($user_info->nick, 'Team Members'), ChFun_Team_Del);
	  	    mysql_commands::team_user(0, $user_info->id);
	  	  }
	
	  	  return array('text' => $out, 'type' => 'private');
  	  }
  	  else 
  	    return array('text' => '', 'type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------
	
  	function command_friend($command_info)
  	{
  	  $row = $command_info['row'];
  	  if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $command_info['room'])
  	  {
	  	  $params = $command_info['params'];
	  	  $row = $command_info['row'];
	
	  	  $add_friend = true;
	  	  if($command_info['command_help']['except_params_static']['add'] == trim($params[1]))
	  	  {
	  	    unset($params[1]);
	  	  }
	  	  elseif($command_info['command_help']['except_params_static']['del'] == trim($params[1]))
	  	  {
	  	    unset($params[1]);
	  	  	$add_friend = false;
	  	  }
	  	  elseif($command_info['command_help']['except_params_static']['show'] == trim($params[1]))
	  	  {	
			$res = mysql_commands::get_friend_list();
			if($res == null)
			{
	  		  return array('text' => ChFun_friend_Eempty, 'type' => 'private');
			}
			else 
			{
			  if(is_array($res['from']))
			    foreach ($res['from'] as $info)
			      if($friend_from == null)
			        $friend_from = $info->nick;
			      else 
			        $friend_from .= ChFun_friend_ShowSep.$info->nick;
			       
			  if(is_array($res['to']))
			    foreach ($res['to'] as $info)
			      if($friend_to == null)
			        $friend_to = $info->nick;
			      else
			        $friend_to .= ChFun_friend_ShowSep.$info->nick;
	
			  $out = str_replace(array("#friend_to#", "#friend_from#","#friend_from_text#","#friend_to_text#"), array($friend_to, $friend_from,ChFun_friend_from_text,ChFun_friend_to_text), ChFun_friend_Show);
	  		  return array('text' => $out, 'type' => 'private');
			  		
			}
	  	  }
	
	  	  $u_name = implode(" ", $params);
	      $u_name = trim($u_name);
	
	      $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($u_name);
	  	  $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, $private_id);
	
	  	  if($user_info == null)
	  	  {
	  		$u_doesnt_exists = str_replace("#user#", $u_name, LTChatCore_user_doesnt_exists);
	  		return array('text' => $u_doesnt_exists, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	  	  }
	
	  	  if($add_friend)
	  	  {
	  	  	$out = str_replace("#user#", $user_info->nick, ChFun_friend_Add);
	  	    mysql_commands::friend_user_add($user_info->id);
	  	  }
	  	  else
	  	  {
	  	  	$out = str_replace("#user#", $user_info->nick, ChFun_friend_Del);
	  	    mysql_commands::friend_user_del($user_info->id);
	  	  }
	
	  	  return array('text' => $out, 'type' => 'private');
  	  }
  	  else 
  	    return array('text' => '', 'type' => 'skip');
  	}
  	//---------------------------------------------------------------------

  	function command_unignore($command_info)
  	{
  	  $params = $command_info['params'];
      $params_new = array();
      $params_new[1] = $this->language_config['help']['ignore']['except_params_static']['del'];
	  foreach ($params as $param)
	  	$params_new[] = $param;

	  $command_info['params'] = $params_new;
	  $command_info['command_help'] = $this->language_config['help']['ignore'];
	  
	  return $this->command_ignore($command_info);
  	}

  	function command_ignore($command_info)
  	{
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  	return array('text' => '', 'type' => 'skip');

  	  $params = $command_info['params'];
  	  $row = $command_info['row'];
	  $private_id = $command_info['private_id'];

  	  $add_ignore = true;
  	  if($command_info['command_help']['except_params_static']['add'] == $params[1])
  	    unset($params[1]);
  	  elseif($command_info['command_help']['except_params_static']['del'] == $params[1])
  	  {
  	    unset($params[1]);
  	  	$add_ignore = false;
  	  }

  	  $u_name = implode(" ", $params);
      $u_name = trim($u_name);
      
      if($u_name == false && mysql_commands::check_ignore(0) == false){      	
  	  	$out = ChFun_ignore_All;
  	    mysql_commands::ignore_user_add(0);	
		return array('text' => $out, 'type' => 'private');	        
      }
      
      $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($u_name);
  	  $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, $private_id);

  	  if($user_info == null)
  	  {
  		$u_doesnt_exists = str_replace("#user#",$u_name, LTChatCore_user_doesnt_exists);
  		return array('text' => $u_doesnt_exists, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  }
  	  
  	  if(mysql_commands::check_ignore($user_info->id) == true)
  	  {
  		return array('text' => "The user $u_name allready exset", 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  }
  	  
  	  if($add_ignore)
  	  {
  	  	$out = str_replace("#user#", $user_info->nick, ChFun_ignore_Add);
  	    mysql_commands::ignore_user_add($user_info->id);
  	  }
  	  else
  	  {
  	  	$out = str_replace("#user#", $user_info->nick, ChFun_ignore_Del);
  	    mysql_commands::ignore_user_del($user_info->id);
  	  }

  	  return array('text' => $out, 'type' => 'private');
  	}
	
  	//---------------------------------------------------------------------

  	function command_unwait($command_info)
  	{
  	  $params = $command_info['params'];
      $params_new = array();
      $params_new[1] = $this->language_config['help']['wait']['except_params_static']['del'];
	  foreach ($params as $param)
	  	$params_new[] = $param;

	  $command_info['params'] = $params_new;
	  $command_info['command_help'] = $this->language_config['help']['wait'];
	  
	  return $this->command_wait($command_info);
  	}
	
  	//---------------------------------------------------------------------
  	
	function command_wait($command_info)
  	{
  		  	    	 
  	  $params = $command_info['params'];
  	  $row = $command_info['row'];
	  $private_id = $command_info['private_id'];
	  
	  if($row->user != $_SESSION['SP_USER_NICK']) return array('text' => '', 'type' => 'skip');

  	  $add_wait = true;
  	  if($command_info['command_help']['except_params_static']['add'] == $params[1])
  	    unset($params[1]);
  	  elseif($command_info['command_help']['except_params_static']['del'] == $params[1])
  	  {
  	    unset($params[1]);
  	  	$add_wait = false;
  	  }

  	  $u_name = implode(" ", $params);
      $u_name = trim($u_name);
	
      $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($u_name);
  	  $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, $private_id);

  	  if($user_info == NULL)
  	  {
  		$u_doesnt_exists = str_replace("#user#",$u_name, LTChatCore_user_doesnt_exists);
  		return array('text' => $u_doesnt_exists, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  }
	  
	  $check_wait = mysql_commands::check_wait_list($user_info->id);
	  
  	  if($add_wait)
  	  {
	    
		if($check_wait == false){
	  	$out = str_replace("#user#", $user_info->nick, ChFun_wait_Add);
	    mysql_commands::wait_user_add($user_info->id);
		}else{
		$out = str_replace("#user#", $user_info->nick, ChFun_wait_exists);
		}
  	  }
  	  else
  	  {
  	  	if($check_wait == true){
  	  	$out = str_replace("#user#", $user_info->nick, ChFun_wait_Del);
     	mysql_commands::wait_user_del($user_info->id);
     	}else{
     	$out = str_replace("#user#", $user_info->nick, ChFun_wait_exists);	
        }
  	  }

  	  return array('text' => $out, 'type' => 'private');
  	}
	
  	//---------------------------------------------------------------------
	 	
  	function command_clear_all_public($command_info)
  	{
  	  $row = $command_info['row'];
	  
	  if($row->user == $_SESSION['SP_USER_NICK']){
	  
  	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
		
		$this->SPECIAL_CORE->mysql_actions->truncate();
		
		//$check = $this->LTChatDataKeeper->clear_all_public();

		return array('text' => '** All public rooms has been cleared', 'type' => 'private');
	  }
	  else
	  return array('text' => '', 'type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------
   function show_help_groups($command, $id){
        $my_command = substr($command, 1);
		$g_command = $this->SPECIAL_CORE->mysql_actions->whois_have_commands($id);
		
		if($g_command !== false){
			$g_command_filtred = array_filter($g_command);	
			if(array_key_exists($my_command, $g_command_filtred))
			   return 1;
		}else{
		     return NULL;
		}
   }
 
  	function command_tpl_fullhelp()
  	{
      $help_info = $this->language_config['help'];
	  $id = $_SESSION['SP_USER_ID'];
	  
      foreach ($help_info as $key => $command_help)
        
		if($this->show_help_groups($command_help['commands'][0], $id) == 1 || $command_help[$_SESSION['SP_USER_LEVEL']] == true && ( is_callable(array(get_class($this),$command_help['execute_function'])) || is_callable(array(get_class($this),$command_help['execute_tpl_function']))))
          
		$functions[$key] = $this->command_show_help_info_parse($command_help,'info');//str_replace(array("#command#","#args#","#description#"), array($com, $args, $desc), ChFun_help_ListStyle);

  	  return array('functions' => $functions);
  	}

  	function command_tpl_bug()
  	{
	  return array();
  	}

  	function command_tpl_config()
  	{
	  return array();
  	}
  
  	function load_tpl($command_info)
  	{
  	  $row = $command_info['row'];

  	  if(is_object($row))
  	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);

  	  $other_vars = urlencode(serialize($command_info['other_vars']));
  	  $other_options = array('load_template' => $command_info['command_help']['load_template'], 
							 'other_vars' => $other_vars, 
							 'additional' => $command_info['params'][1]
							 );

  	  return array('data_type' => 'template', 'text' => '', 'type' => 'private', 'other_options' => $other_options);
  	}
  	//---------------------------------------------------------------------

  	function command_info($command_info)
  	{
	  $row = $command_info['row'];
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	  	  $params = $command_info['params'];

	  	  $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);

	  	  $nick = implode(" ", $params);
	      $nick = trim($nick);

	      $user = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($nick);
	      $command_info['other_vars']['login'] = $nick;

	      if($user == null)
	  	    return array('text' => str_replace("#user#", $nick, ChFun_info_BadUserName), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	      else
	        return $this->load_tpl($command_info);
  	  }

  	  return array('type' => 'skip');
  	}
  	//---------------------------------------------------------------------
  	
  	function command_room($command_info)
  	{
	  $row = $command_info['row'];
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	  	  $params = $command_info['params'];
	
	  	  $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);

	  	  $room = implode(" ", $params);
	      $room = trim($room);

	  	  if(count($params) > 1 || $room == null)
	  	  {
	  	    return array('text' => ChFun_room_BadName, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	  	  }
	
	  	  $text = str_replace("#room#", $room, ChFun_room_Changed);
	  	  $other_options = array('new_room' => $room);
	
	  	  return array('data_type' => 'change_room','text' => $text, 'type' => 'private', 'other_options' => $other_options);
  	  }
  	  return array('type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------
  	
	function command_clear($command_info)
  	{
	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  $type = 'clear';
	  
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	  $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  
	  $user_name = trim($command_info['params'][1]);
      unset($command_info['params'][1]); 
	  $my_self = $_SESSION['SP_USER_NICK']; //get my name from session
	  $level_color = $this->SPECIAL_CORE->mysql_master->get_user_color($_SESSION['SP_USER_LEVEL']);	  
	  
	  $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user
	  
		if($user_info == NULL)
		{
			  $u_doesnt_exists = str_replace("#user#",$user_name, LTChatCore_user_doesnt_exists);
			  return array('text' => $u_doesnt_exists, 'type' => 'private','other_options' => array('type_handle' => 'error'));
			
		}else{
			
		//check for not null username
		if($user_name == NULL){
		return array('text' => ChFun_write_multikick_reason, 
					 'type' => 'private', 
					 'other_options' => array('type_handle' => 'error'));
		}else{
			
			$text = str_replace(array("#user#","#levelcolor#","#sender#"),
								array($user_name,$level_color,$my_self), ChFun_msg_clear);
			
			$this->SPECIAL_CORE->mysql_actions->clear_user_message($user_info->nick, $my_self, $type);
			$this->SPECIAL_CORE->mysql_public_private->post_reason($text, $room);
			
		}##null user
	
			return array('data_type' => 'clear', 
						 'text' => '', 
						 'type' => 'private'
						 );
		}##null user info
  	  }
	  else
  	  return array('type' => 'skip');
  	}
	
  	//---------------------------------------------------------------------
  	
	function command_filter($command_info)
  	{
	  $row = $command_info['row'];
	  $room = $command_info['room'];
	  $type = 'filter';
	  
  	  if($row->user == $_SESSION['SP_USER_NICK'])
  	  {
	  $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  
	  $word = trim($command_info['params'][1]);
      unset($command_info['params'][1]); 
	  
	  $my_self = $_SESSION['SP_USER_NICK']; //get my name from session
	  
	  $level_color = $this->SPECIAL_CORE->mysql_master->get_user_color($_SESSION['SP_USER_LEVEL']);	  
	  
	  $user_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name); //get user

	  //check for not null username
	  if($word == NULL){
	  return array('text' => ChFun_write_multikick_reason, 
				   'type' => 'private', 
				   'other_options' => array('type_handle' => 'error'));
	  }else{
			
	  $text = str_replace(array("#word#","#levelcolor#","#sender#"),
						  array($word,$level_color,$my_self), ChFun_msg_filter);
	
	  $this->SPECIAL_CORE->mysql_actions->filter_user_message($word, $my_self, $type);
	  $this->SPECIAL_CORE->mysql_public_private->post_reason($text, $room);
	
	  return array('data_type' => 'clear', 
				   'text' => '', 
				   'type' => 'private',
				   );
  	  }
	  }
	  else
  	  return array('type' => 'skip');
  	}

  	//---------------------------------------------------------------------

  	function command_url($command_info)
  	{
  	  $params = $command_info['params'];
  	  $param = implode(" ", $params);
      $param = trim($param);

      if(eregi("(http.?://)(.*)",$param, $r))
        $out .= str_replace(array("#link#","#title#","#text#"), array($r[0].urlencode($param), htmlspecialchars($param),$r[2]), ChFun_url_Style);
      else
        $out .= str_replace(array("#link#","#title#","#text#"), array("http://".urlencode($param),htmlspecialchars($param), $param), ChFun_url_Style);
        
      //$this->SPECIAL_CORE->mysql_public_private->post_reason($out, $command_info['room']);

      return array('text' => 'Url Has been Sent', 'type' => 'private');
  	}
  	//---------------------------------------------------------------------
  	function command_tpl_configrooms()
  	{
  	  return array('rooms' => $this->LTChatDataKeeper->get_all_rooms());
  	}
  	//---------------------------------------------------------------------

  	function command_ERROR($command_info)
  	{
	  $out['type'] = 'private';
	  $out['text'] = "Unknown error";

  	  if(is_array($command_info['params']))
  	  {
  	  	if($command_info['params'][1] == "ignore" && $command_info['params'][2] == ERROR_IGNORE_FROM)
  	  	  $out = array('type' => 'private', 'text' => ERROR_IGNORE_FROM_MSG);

  	  	if($command_info['params'][1] == "ignore" && $command_info['params'][2] == ERROR_IGNORE_TO)
  	  	  $out = array('type' => 'private', 'text' => ERROR_IGNORE_TO_MSG);
  	  	  
  	  	if($command_info['params'][1] == "ignore" && $command_info['params'][2] == ERROR_IGNORE_FROM_ALL)
  	  	  $out = array('type' => 'private', 'text' => ERROR_IGNORE_FROM_ALL_MSG);	  
  	  	  
  	  	if($command_info['params'][1] == "jail" && $command_info['params'][1] == 'jail')
  	  	  $out = array('type' => 'private', 'text' => ERROR_msg_jail);
  	  }

	  return $out;
  	}
	
	function groups_commands($command, $id){
        
		$my_command = substr($command, 1);
		$g_command = $this->SPECIAL_CORE->mysql_actions->whois_have_commands($id);

		if($g_command !== false){
			$g_command_filtred = array_filter($g_command);	
			if(array_key_exists($my_command, $g_command_filtred)){
			   return TRUE;
			}
		}else{
		   return NULL;
		}
	}
	
	
  	//---------------------------------------------------------------------

  	function command($row, $room, $private_id)
  	{
	  //delete the last error command
	  $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, -1);
	  	  
  	  $row->nick = "Chat Core";
  	  $command_ar = explode(" ",$row->text);
  	  
	  //trim whitespace and convert char to lower :: nick
	  $command_ar[1] = trim($command_ar[1]);
	  //trim whitespace and convert char to lower :: command  
      $_command = strtolower( trim($command_ar[0]) );
      
      unset($command_ar[0]);
	  $params = $command_ar;
	  
	 //print_r($row);
	  
	  $function_params = array('params' => $params, 'row' => $row, 'room' => $room, 'private_id' => $private_id);

	  if($_command == "/ERROR")
	  {
  	    $this->SPECIAL_CORE->mysql_public_private->delete_message_id($row->id, $private_id);
		return $this->command_ERROR($function_params);
	  }
	    
	  $out['type'] = 'private';
	  $out['text'] = str_replace("#command#", $_command, ChFunBadCommand);
	  $out['other_options']['type_handle'] = 'error';
	  $in_group = $this->groups_commands($_command, $_SESSION['SP_USER_ID']);
	    
	  $help = $this->language_config['help'];
	  
	  foreach ($help as $commands){

	  if(in_array($_command, $commands['commands'])) {

			  if($commands[$_SESSION['SP_USER_LEVEL']] !== true && $in_group == NULL) 
		      {
			  	$out['type'] = 'private';
	  			$out['text'] = ChFunNoRights;
			  	$out['other_options']['type_handle'] = 'error';
		      }
			  
			  elseif($this->SPECIAL_CORE->mysql_actions->whois_have_action($_SESSION['SP_USER_ID'], 'disable') == 1 && $commands['in_disable_mode'] == false)
			  {
			  	$out['type'] = 'private';
	  			$out['text'] = ChFunNoRights;
			  	$out['other_options']['type_handle'] = 'error';
			  }
			  
			  elseif(is_callable(array(get_class($this),$commands['execute_function'])))
			  {
			  	$function_params['command_help'] = $commands;
			    $out = call_user_func(array($this,$commands['execute_function']),$function_params);
			  }
			  
			  elseif(is_callable(array(get_class($this),$commands['execute_tpl_function'])))
			  {
			  	if($row->user == $_SESSION['SP_USER_NICK'] && $row->room == $room)
			  	{
			  	  $function_params['command_help'] = $commands;
			      $out = $this->load_tpl($function_params);
			  	}
			  	else 
			  	  $out['type'] = 'skip';
			  }
			  
			  else
			  {
			  	$function_params['command_help'] = $commands;
	  			$out['text'] = ChFunBadFunction;
			  }

			  if(!isset($out['other_options']['type_handle']))
				$out['other_options']['type_handle'] = 'info';

			  return $out;
		}
	  }
	  return $out;
  	}
  }
?>