<?php
/**
 * SPECIAL_PARSER.php
 *
 * @package SPECIAL CHAT
 * @programmer Hany alsamman ('hany.alsamman@gmail.com')
 * @author Hany alsamman (Project administrator && Original founder)
 * @version $Id$
 * @pattern private
 * @access private
 */

class SPECIAL_PARSER
{
    var $LTChartCore;
    var $language_config;
    var $room;
    var $private_id;
    var $SPECIAL_CORE;
    var $title;
    var $sid;

    function __construct(&$SPECIAL_CORE,$uniq,$sid)
    {
 			   
		$this->SPECIAL_CORE = &$SPECIAL_CORE;	
		
		$this->sid = $sid;
		
		if(sha1(base64_encode($uniq)) !== $_GET['after'] && strlen($sid) !== 32) return LTTpl_fullhelp_desc;
		
		$this->SPECIAL_CORE->bulid_session($uniq);
		
		if ( !$this->SPECIAL_CORE->mysql_login->user_logged_in() ) return LTTpl_fullhelp_desc;
		
        if ($private_id >= 0) $room = '';

        $this->private_id = $private_id;
        $this->room = $room;
        
        $this->language_config = $GLOBALS['language_config'];

    }
    
  	 function command_tpl_params($template_name)
     {
	   $help = $GLOBALS['language_config']['help'];
	   foreach ($help as $commands)
	   {
	     if($commands['load_template'] == $template_name && is_callable(array(get_class($this->SPECIAL_CORE->COMMANDS_CORE),$commands['execute_tpl_function']))){
		   return call_user_func(array($this->SPECIAL_CORE->COMMANDS_CORE,$commands['execute_tpl_function']));
		 }
	   }
	   return array();
     }

    function get_tpl($tpl_name, $replace = array(), $recurrent = false)
    {
    	
        if ($recurrent == false) {
            $replace['#header#'] = $this->get_tpl("_header.tpl", $replace, true);
            $replace['#footer#'] = $this->get_tpl("_footer.tpl", $replace, true);
        }

        $replace['#CHAT_TITLE#'] = CHAT_TITLE;
        $replace['#SP_USER_NICK#'] = $_SESSION['SP_USER_NICK'];
        $replace['#uniq#'] = $_SESSION['SP_USER_NICK'];
        $replace['#sid#'] = $this->sid;
//        $replace['#room#'] = $this->room;
//        $replace['#private_id#'] = $this->private_id;
        $replace['#TemplatePath#'] = SITE_DIR.'/templates/soft/';
//        $replace['#PageEncoding#'] = ChPageEncoding;
//        $replace['#refresh_after#'] = get_ConfVar("ChRefreshAfter");

        $replace['#title#'] = $this->title;

        $tpl_ar = file(SITE_PATH . '/templates/soft/tpl/' . $tpl_name);
        if (is_array($tpl_ar))
            $tpl = implode(null, $tpl_ar);

        if (is_array($replace))
            $tpl = strtr($tpl, $replace);

        if (is_array($this->language_config[$tpl_name]))
            $tpl = strtr($tpl, $this->language_config[$tpl_name]);

		return $tpl;
    }

    function pass_params_via_tpl($template, $params)
    {
        $other_vars = urlencode(serialize($params));
        return "./index.php?load_template={$template}&other_vars={$other_vars}";
    }

    function groups_commands($command, $id)
    {
        $g_command = $this->SPECIAL_CORE->mysql_actions->whois_have_commands($id);

        if ($g_command !== false) {
            $g_command_filtred = array_filter($g_command);
            if (array_key_exists($command, $g_command_filtred))
                return 1;
        } else {
            return null;
        }
    }

    function check_view_external($template)
    {       

		$help_info = $this->language_config['help'];
        
		foreach ($help_info as $command_help) {
            if ($command_help['load_template'] == $template) {
            	
		        if ($command_help['in_disable_mode'] == false && $this->SPECIAL_CORE->mysql_actions->whois_have_action($_SESSION['SP_USER_ID'],'disable') == 1) return 1;
            	
                $check = substr($command_help['commands'][0], 1);
                $in_group = $this->groups_commands($check, $_SESSION['SP_USER_ID']);

                if ($in_group !== 1 && $command_help[$_SESSION['SP_USER_LEVEL']] !== true) return 1;
            }
        }
    }

    function get_command_tpl($template, $other_vars=false)
    {
    	
        if (!$this->SPECIAL_CORE->mysql_login->user_logged_in()) return LTTpl_fullhelp_desc;

        switch ($template) {
            case "command_configrooms.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;
                    if (count($_POST) > 0) {
                        if ($_POST['type'] == "add") {
                            $inf = $this->LTChartCore->add_room($_POST);
                            if ($inf === ChFun_croom_ErrNoCat)
                                $info = ChFun_croom_TxtRc;
                            elseif ($inf === ChFun_croom_ErrNoRoom)
                                $info = ChFun_croom_TxtRn;
                            elseif ($inf === ChFun_croom_ErrLenCat)
                                $info = str_replace("#max_room_cat_name#", LTChat_MaxRoomCatName,
                                    ChFun_croom_TxtLRc);
                            elseif ($inf === ChFun_croom_ErrLenRoom)
                                $info = str_replace("#max_room_name#", LTChat_MaxRoomName, ChFun_croom_TxtLRn);
                            elseif ($inf === ChFun_croom_ErrExists)
                                $info = ChFun_croom_TxtExists;
                            else
                                $info = ChFun_croom_RoomAdded;
                        } elseif ($_POST['type'] == "del") {
                            if (ChFun_croom_ErrNoRoomSel === $this->LTChartCore->delete_room($_POST['selected_channel']))
                                $info = ChFun_croom_TxtNoRoomSel;
                            else
                                $info = ChFun_croom_RoomDeleted;
                        } elseif ($_POST['type'] == "def") {
                            if (ChFun_croom_ErrNoRoomSel === $this->LTChartCore->set_default_room($_POST['selected_channel']))
                                $info = ChFun_croom_TxtNoRoomSelDef;
                            else
                                $info = ChFun_croom_DefaultChanged;
                        }
                    }

                    $replace['#add_room_text#'] = ChFun_configrooms_add;
                    $replace['#category_name_text#'] = ChFun_configrooms_cat_name;
                    $replace['#room_name_text#'] = ChFun_configrooms_room_name;
                    $replace['#rooms_list_text#'] = ChFun_configrooms_defined;
                    $replace['#submit#'] = ChFun_configrooms_submit;
                    $replace['#delete_text#'] = ChFun_configrooms_delete;
                    $replace['#set_default_text#'] = ChFun_configrooms_default;


                    /* pobranie dodatkowych informacji z klasy LTChatCoreFunctions */
                    $data = $this->command_tpl_params($template);

                    $optgroup_tpl = ChFun_configrooms_OotGroup;
                    $option_tpl = ChFun_configrooms_Ootion;

                    $select_data = array();
                    if (is_array($data['rooms']['defined']))
                        foreach ($data['rooms']['defined'] as $room)
                            $select_data[$room->room_cat][] = array('room_name' => $room->room_name,
                                'users_online' => count($room->users_online), 'room_id' => $room->id, 'default' =>
                                $room->default);

                    foreach ($select_data as $room_cat => $rooms) {
                        $options = "";
                        foreach ($rooms as $room_info) {
                            if ($room_info['default'] == 1)
                                $default = ChFun_croom_Default;
                            else
                                $default = "";

                            $options .= str_replace(array("#name#", "#value#", "#users_online#", "#default#"),
                                array($room_info['room_name'], $room_info['room_id'], $room_info['users_online'],
                                $default), $option_tpl);
                        }
                        $select_data .= str_replace(array("#options#", "#label#"), array($options, $room_cat),
                            $optgroup_tpl);
                    }
                    $replace['#rooms_list#'] = $select_data;
                    $replace['#info#'] = $info;

                    break;
                }

            case "command_actionlogs.tpl":
                {
                    if ($this->check_view_external($template)) return ChFunNoRights;
                    $this->title = ChFun_actionlogs_Title;
                    $actions = $this->SPECIAL_CORE->mysql_parser->get_logs();
                    $i = 0;
                    if (!is_array($actions))
                        return 'not found any reason';
                    foreach ($actions as $value) {
                        $replace['#html#'] .= '<tr>';
                        $action_time = date('l F Y h:i:s A', $value[action_time]);
                        $replace['#html#'] .= "<td>$value[reason] <font face='arial' size='2'>in room - $value[room] $action_time</font></td>";
                        $replace['#html#'] .= '</tr>';
                        $i++;
                    }
                    $replace['#lines#'] = "$i";

                    break;
                }

            case "command_actionstop.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;
                    $this->title = ChFun_actionlogs_Title;
                    $stoped = $this->LTChartCore->get_stoped_logs();
                    $i = 0;
                    if (!is_array($stoped))
                        return 'not found any reason';
                    foreach ($stoped as $value) {
                        $replace['#html#'] .= '<tr>';
                        $action_time = date('l F Y h:i:s A', $value[action_time]);
                        $replace['#html#'] .= "<td>$value[reason] <font face='arial' size='2'>in room - $value[room] $action_time</font></td>";
                        $replace['#html#'] .= '</tr>';
                        $i++;
                    }
                    $replace['#lines#'] = "$i";

                    break;
                }

            case "command_mycommand.tpl":
            
				$help = $this->SPECIAL_CORE->COMMANDS_CORE->language_config['help'];
				
				echo "<table border =\"0\" width=\"100%\">\n";
				foreach ($help as $commands){
				  
				  $command = substr( strrchr($_GET['command'], "/"), 1 );
				  
				  //if( preg_match("/^\/$command/", $commands['commands'][0]) ){
				  	
				  //if( preg_match("/$command/", $commands['commands'][0]) ){
				  	$select_command = str_ireplace($_GET['command'], "<b>" . $_GET['command'] . "</b>", ($commands['commands'][0]));
				  	
				  	if( preg_match("/^\/$command/", $commands['commands'][0]) && $commands[$_SESSION['SP_USER_LEVEL']] ){
				  	echo "<tr id=\"". $commands['commands'][0] . "\" style=\"cursor:pointer\" onmouseover=\"highlight(1,'".$commands['commands'][0]."');\" onmouseout=\"highlight(0,'". $commands['commands'][0]."');\" onclick=\"display('" .$commands['commands'][0]. "');\"><td>".$select_command."</td></tr>";
				  }
				  unset($command);		  
				}
				echo "</table>";
				
				break;


            case "command_apply.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;

                    $user_name = $_SESSION['SP_USER_NICK'];
                    $user_data = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name);
                    $date = date('l F Y', time());

                    $replace = array('#required#' => LTTpl_required_reg_mark, 
									 '#info#' => '',                     
									 '#post_login#' => stripslashes($_POST['create']), 
									 '#password#' => '', 
									 '#room#' =>$this->room
									 );

                    //$registration_fields = $this->get_registration_fields($_POST);
                    //$replace['#other_fields#'] = $registration_fields['other_fields'];
                    //$post_fields_data = $registration_fields['post_fields_data'];

                    $replace['#login#'] = ChTPL_RegLogin;
                    $replace['#pass#'] = ChTPL_RegPass;
                    $replace['#required_desc#'] = LTTpl_required_reg_desc;
                    
                    

                    if ($user_data->level >= 50) {
                        $replace['#level_select#'] .= '<select name=\'thelevel\'>';
                        foreach (range('1', '50') as $letter) {
                            $replace['#level_select#'] .= "<option value=\"$letter\">Rank $letter</option>";
                        }
                        $replace['#level_select#'] .= "</select>";
                    } else {
                        $replace['#level_select#'] = '<input type=\'hidden\' name=\'thelevel\' value=\'1\'>Rank 1 (Default)';
                    }
                    
                    if(isset($_POST['create'],$_POST['password']) && !empty($_POST['create']))
                    $info = $this->SPECIAL_CORE->mysql_master->add_user($_POST['create'],$_POST['password']);

                    if (LTChatCore_user_error_too_short_login === $info)
                        $replace['#info#'] = '#ERROR_login_too_short#';
                    if (LTChatCore_user_error_too_short_password === $info)
                        $replace['#info#'] = '#ERROR_password_too_short#';
                    if (LTChatCore_user_errro_user_exists === $info)
                        $replace['#info#'] = '#ERROR_user_exists#';
                    if (LTChatCore_user_error_fill_required === $info)
                        $replace['#info#'] = '#ERROR_fill_required_fields#';
                    if (LTChatCore_user_error_nick == $info)
                        $replace['#info#'] = '#ERROR_login_bad_chars#';
                    if (LTChatCore_user_error_email == $info)
                        $replace['#info#'] = '#ERROR_bad_email#';

                    if ($info === true) {
                        $email_status = MAILLER::email_send($_POST['create'], $_POST['password'], $_POST['email']);
                        //create apply logs
                        $msg = str_replace(array("#created#", "#created_level#", "#creating_level#","#created_time#", "#created_by#"), array($_POST['create'], $_POST['thelevel'], $user_data->level, $date, $user_data->nick), LTChatCreateOpMsg);
                        //post the apply logs
                        $this->SPECIAL_CORE->mysql_public_private->post_logs($msg, false, 'apply', false);
                        $replace['#info#'] = LTTpl_user_added;
                        $replace['#info#'] .= "<br> $email_status";
                    }

                    break;
                }

            case "command_applylogs.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;
                    $this->title = ChFun_actionlogs_Title;
                    $apply_logs = $this->SPECIAL_CORE->mysql_parser->get_apply_logs();
                    $i = 0;
                    if (!is_array($apply_logs))
                        return 'not found any reason';
                    foreach ($apply_logs as $value) {
                        $replace['#html#'] .= '<tr>';
                        $action_time = date('l F Y h:i:s A', $value[action_time]);
                        $replace['#html#'] .= "<td>$value[reason] <font face='arial' size='2'></font></td>";
                        $replace['#html#'] .= '</tr>';
                        $i++;
                    }
                    $replace['#lines#'] = "$i";

                    break;
                }

            case "command_list.tpl":
                {
                    if ($this->check_view_external($template)) return ChFunNoRights;
                    $this->title = ChFun_actionlogs_Title;
                    $online_list = $this->SPECIAL_CORE->mysql_parser->get_users_online_list();
                    $i = 0;
                    if (!is_array($online_list))
                        return 'not found any users';
                    foreach ($online_list as $value) {
                        $color = $this->SPECIAL_CORE->mysql_master->get_user_color($value['level']);
                        $replace['#html#'] .= str_replace(array("#id#", "#nickname#", "#room#",
                            "#ip_address#", "#comment#", "#mycolor#"), array($i + 1, $value['nick'], $value['room'],
                            $value['last_ip'], $value['comment'], $color), ChFun_list);
                        $i++;
                    }
                    $replace['#lines#'] = "$i";

                    break;
                }

            case "command_updologs.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;

                    $this->title = ChFun_checksaved_Title;
                    $check = $this->SPECIAL_CORE->mysql_parser->get_updologs();
                    $i = 0;
                    //check is array and not empty
                    if (is_array($check)) {
                        foreach ($check as $value) {
                            $replace['#html#'] .= '<tr>';

                            $replace['#html#'] .= "<td>$value[reason]</td>";

                            $replace['#html#'] .= '</tr>';
                            $i++;
                        }
                        $replace['#lines#'] = "$i";
                    } else {
                        $replace['#html#'] = 'not found any upgrade or downgrade saved logs';
                    }

                    break;
                }

            case "command_trace.tpl":
                {
                    if ($this->check_view_external($template)) return ChFunNoRights;
                    
                    $row = 1;
                    $handle = file(ROOT_LOGS_PATH . "trace.html");

                    krsort($handle);
                    
                    $limit = ($_GET['additional'] > 5) ? $_GET['additional'] : 20;
                    
					foreach ($handle as $line_num => $line) {
					    
						$replace['#html#'] .= $line;
					    
					    if($row == $limit) break;
					    
					    $row++;
					}					

                    $replace['#lines#'] = "$row";
                    $this->title = "Number Lines $row !";

                    break;
                }

            case "command_trace2.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;

                    $row = 1;
                    $handle = fopen(ROOT_LOGS_PATH . "trace2.html", "r");
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                        $num = count($data);
                        $row++;
                        for ($c = 0; $c < $num; $c++) {
                            $replace['#html#'] .= $data[$c];
                        }
                    }
                    fclose($handle);

                    $replace['#lines#'] = "$row";
                    $this->title = "Number Lines $row !";

                    break;
                }

            case "command_trace4.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;

                    $row = 1;
                    $handle = fopen(ROOT_LOGS_PATH . "trace4.html", "r");
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                        $num = count($data);
                        $row++;
                        for ($c = 0; $c < $num; $c++) {
                            $replace['#html#'] .= $data[$c];
                        }
                    }
                    fclose($handle);

                    $replace['#lines#'] = "$row";
                    $this->title = "Number Lines $row !";

                    break;
                }

            case "command_check.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;
                    $this->title = ChFun_checksaved_Title;
                    $check = $this->SPECIAL_CORE->mysql_actions->check_saved();
                    $i = 0;
                    foreach ($check as $value) {
                        $replace['#html#'] .= '<tr>';
                        $action_time = date('l F Y h:i:s A', $value['action_time']);
                        $my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($value['action_by']); //get users info

                        if ($value['type'] == 'abuse') {
                            $replace['#html#'] .=
                                "<td><font face='arial' size='2' color='black'>*** The he/she <b>$value[action_by]</b> in room - $value[room] has <font color='red'>saved</font> this page $action_time<a href='./loggers/saved/$my_info->id$value[action_time].html' target='_new'>(check)</a></td>";
                        } else {
                            $replace['#html#'] .= "<td>$value[reason] <font face='arial' size='2'>in room - $value[room] $action_time</font> <a href='./loggers/saved/$my_info->id$value[action_time].html' target='_new'>(check)</a></td>";
                        }

                        $replace['#html#'] .= '</tr>';
                        $i++;
                    }
                    $replace['#lines#'] = "$i";

                    break;
                }

            case "command_register.tpl":
                {
                    $this->title = ChFun_checksaved_Title;
                    $replace['#info#'] = "";
                    $replace['#admin#'] = 'This area only for admin';

                    $user = new User();
                    if ($_POST['submitted'] == true) {

                        $replace['#info#'] = $this->LTChartCore->register($_POST);
                    }
                    if ($_SESSION['SP_USER_LEVEL'] == 50) {
                        $replace['#admin#'] = $user->show_signup();
                    }

                    break;
                }

            case "command_showops.tpl":
                {
                    if ($this->check_view_external($template)) return ChFunNoRights;

                    $show = $this->SPECIAL_CORE->mysql_parser->showops();
                    $i = 0;
                    foreach ($show as $value) {

                        $rights = $this->SPECIAL_CORE->mysql_master->get_rights_by_level($value->level);
                        $color = $this->SPECIAL_CORE->mysql_master->get_user_color($value->level);
                        $registered = ($value->registered != 0) ? date('l F Y h:i:s A', $value->registered) : "No data";
                        $last_seen = ($value->last_seen != 0) ? date('l F Y h:i:s A', $value->last_seen) :"No data";

                        $replace['#members_info#'] .= str_replace(
						array("#id#", "#Nick#", "#Status#","#level#", "#Start#", "#lastlogin#", "#color#", "#nickfont#"), 
						array($value->id,$value->nick, $rights, $value->level, $registered, $last_seen, $color, $value->nickfont), ChFun_showops);

                        $i++;
                    }
                    $replace['#lines#'] = "$i";
                    $this->title = "Total Members On The Database $i !";

                    break;
                }

            case "command_showforward.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;

                    $row = 1;
                    $handle = fopen(ROOT_LOGS_PATH . "forward.html", "r");
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                        $num = count($data);
                        $row++;
                        for ($c = 0; $c < $num; $c++) {
                            $replace['#html#'] .= $data[$c];
                        }
                    }
                    fclose($handle);

                    $replace['#lines#'] = "$row";
                    $this->title = "Number Lines $row !";

                    break;
                }

            case "command_showclear.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;

                    $row = 1;
                    $handle = fopen(ROOT_LOGS_PATH . "clear.html", "r");
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                        $num = count($data);
                        $row++;
                        for ($c = 0; $c < $num; $c++) {
                            $replace['#html#'] .= $data[$c];
                        }
                    }
                    fclose($handle);

                    $replace['#lines#'] = "$row";
                    $this->title = "Number Lines $row !";

                    break;
                }

            case "command_showsus.tpl":
                {
                    if ($this->check_view_external($template)) return ChFunNoRights;

                    $show = $this->SPECIAL_CORE->mysql_parser->showsus(); //get list of suspanded opreators
                    $my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($_SESSION['SP_USER_NICK']); //get my info
                    $help_info = $this->language_config['help']['unsus'];

                    $replace['#error#'] = 'What ?';
                    $replace['#html#'] = '';
                    //check is array and not empty
                    if (is_array($show)) {
                        $i = 0;
                        foreach ($show as $value) { //foreach and while
                            //get info the user in loop
                            $user_data = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($value->action_by);
                            //get the color
                            $color = $this->SPECIAL_CORE->mysql_master->get_user_color($value->level);
                            //get the date for action
                            $date = ($value->action_time != 0) ? date('l F Y', $value->action_time) :
                                "No data";
                            //get the time for action
                            $time = ($value->action_time != 0) ? date('h:i:s A', $value->action_time) :
                                "No data";
                            //create the link
                            $checked = str_replace(array("#reason_id#", "#users_id#", "#link_title#"), array($value->id, $user_data->id, 'Active'), ChFun_stop_disabling_sus);
                            
                            if ($my_info->level >= $user_data->level && $help_info[$_SESSION['SP_USER_LEVEL']] == true) {
                                $link = $checked;
                            } else {
                                $link = 'disabled';
                            }

                            //create the reason in showsus
                            $replace['#html#'] .= str_replace(array("#id#", "#sus_user#", "#sus_by#","#level#", "#reason#", "#date#", "#time#", "#stop_disabling#"), array($value->id, $value->action_on, $value->action_by, $user_data->level, $value->reason, $date, $time, $link), ChFun_showsus);
                            $i++;
                        } ##end foreach

                    } else {
                        $replace['#error#'] = 'not found any users in sus list';
                    }
                    
                    ######################################3
                    
                    //sum the lines or the line number eq 0
                    $replace['#lines#'] = ($i != '') ? $i : "0";
                    
					//check isset for reason and users (id)
					#### stoped for next ann
                    
//                    if (isset($_GET['reason_id'], $_GET['users_id']) && $_GET['reason_id'] > 0 && $_GET['users_id'] > 0) {
//                        //check command for unsus high level
//                        $user = $this->SPECIAL_CORE->mysql_master->get_user_by_id($_GET['users_id']);
//                        
//                        if ($_SESSION['SP_USER_LEVEL'] >= $user->level && $help_info[$_SESSION['SP_USER_LEVEL']] == true) {
//                            //delete sus && create logs and post in logs table
//                            $how_delete = $this->SPECIAL_CORE->mysql_actions->delete_sus(&$user);
//                            if ($how_delete == true) {
//                                $replace['#error#'] = str_replace(array("#user#", "#reason_id#"), array($_SESSION['SP_USER_NICK'], $_GET['reason_id']), ChFun_un_sused_msg);
//                            }
//                        } else {
//                            $replace['#error#'] = 'dont have premssion to stop this sus';
//                        }
//                    }
                    break;
                }

            case "command_showban.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;

                    $show = $this->SPECIAL_CORE->mysql_parser->showban();
                    $my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($_SESSION['SP_USER_NICK']); //get my info

                    $replace['#error#'] = 'What ?';
                    $replace['#html#'] = '';
                    if ($show) {
                        $i = 0;
                        foreach ($show as $value) {
                            //get info the do action
                            $user_data = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($value->action_by);
                            //get color the do action
                            $color = $this->SPECIAL_CORE->mysql_master->get_user_color($value->level);
                            //get date the action
                            $date = ($value->action_time != 0) ? date('l F Y', $value->action_time) :
                                "No data";
                            //get time the action
                            $time = ($value->action_time != 0) ? date('h:i:s A', $value->action_time) :
                                "No data";
                            //check while and type
                            if ($value->type == 'banuser') {
                                $checked = str_replace(array("#reason_id#", "#users_id#", "#link_title#"), array
                                    ($value->id, $user_data->id, 'Active'), ChFun_stop_disabling_banip);
                                $link = ($my_info->level >= $user_data->level) ? $checked : "disable";
                                $nick_ip = $value->banip;

                            } elseif ($value->type == 'banip') {
                                $checked = str_replace(array("#reason_id#", "#users_id#", "#link_title#"), array
                                    ($value->id, $user_data->id, 'Active'), ChFun_stop_disabling_banip);
                                $link = ($my_info->level >= $user_data->level) ? $checked : "disable";
                                $nick_ip = $value->banip;
                            } ##end check type

                            //create the final link
                            $replace['#html#'] .= str_replace(array("#id#", "#nick/ip#", "#banned_By#",
                                "#level#", "#reason#", "#date#", "#time#", "#stop_disabling#"), array($value->
                                id, $nick_ip, $user_data->nick, $user_data->level, $value->reason, $date, $time,
                                $link), ChFun_showban);

                            $i++;
                        } ##end foreach

                    } else {

                        $replace['#error#'] = 'not found any nick/ip in list';
                    } ##end if show

                    $replace['#lines#'] = ($i != '') ? $i : "0";
                    //check reason_id && users_id -> and value > 0
                    if (isset($_GET['reason_id'], $_GET['users_id']) && $_GET['reason_id'] > 0 && $_GET['users_id'] >
                        0) {

                        //check the user level try to unbanned -> the action
                        $user = $this->SPECIAL_CORE->mysql_master->get_user_by_id($_GET['users_id']);
                        if ($my_info->level >= $user->level) {
                            //drop the check the row by id in actions table
                            $how_delete = $this->SPECIAL_CORE->mysql_parser->delete_ban($_GET['reason_id']);
                            if ($how_delete) {
                                $replace['#error#'] = str_replace(array("#user#", "#reason_id#"), array($my_info->
                                    nick, $_GET['reason_id']), ChFun_un_banned_msg);
                            }
                        } else {
                            $replace['#error#'] = 'dont have premssion to stop this ban';
                        }
                    } ##end if isset
                    break;
                }

            case "command_showbanpc.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;

                    $show = $this->SPECIAL_CORE->mysql_parser->showbanpc();
                    $my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($_SESSION['SP_USER_NICK']); //get my info

                    $replace['#error#'] = 'What ?';
                    $replace['#html#'] = '';
                    if ($show) {
                        $i = 0;
                        foreach ($show as $value) {
                            //get info the do action
                            $user_data = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($value->action_by);
                            //get color the do action
                            $color = $this->SPECIAL_CORE->mysql_master->get_user_color($value->level);
                            //get date the action
                            $date = ($value->action_time != 0) ? date('l F Y', $value->action_time) :"No data";
                            //get time the action
                            $time = ($value->action_time != 0) ? date('h:i:s A', $value->action_time) :"No data";
                            //check while and type
                            if ($value->type == 'banuser') {
                                $checked = str_replace(array("#reason_id#", "#users_id#", "#link_title#"), array
                                    ($value->id, $user_data->id, 'Active'), ChFun_stop_disabling_banip);
                                $link = ($my_info->level >= $user_data->level) ? $checked : "disable";
                                $nick_ip = $value->banip;

                            } elseif ($value->type == 'banip') {
                                $checked = str_replace(array("#reason_id#", "#users_id#", "#link_title#"), array
                                    ($value->id, $user_data->id, 'Active'), ChFun_stop_disabling_banip);
                                $link = ($my_info->level >= $user_data->level) ? $checked : "disable";
                                $nick_ip = $value->banip;
                            } ##end check type

                            //create the final link
                            $replace['#html#'] .= str_replace(array("#id#", "#nick/ip#", "#banned_By#",
                                "#level#", "#reason#", "#date#", "#time#", "#stop_disabling#"), array($value->
                                id, $nick_ip, $user_data->nick, $user_data->level, $value->reason, $date, $time,
                                $link), ChFun_showban);

                            $i++;
                        } ##end foreach

                    } else {

                        $replace['#error#'] = 'not found any nick/ip in list';
                    } ##end if show

                    $replace['#lines#'] = ($i != '') ? $i : "0";
                    //check reason_id && users_id -> and value > 0
                    if (isset($_GET['reason_id'], $_GET['users_id']) && $_GET['reason_id'] > 0 && $_GET['users_id'] > 0) {

                        //check the user level try to unbanned -> the action
                        $user = $this->SPECIAL_CORE->mysql_master->get_user_by_id($_GET['users_id']);
                        if ($my_info->level >= $user->level) {
                            //drop the check the row by id in actions table
                            $how_delete = $this->LTChartCore->delete_ban($_GET['reason_id']);
                            if ($how_delete) {
                                $replace['#error#'] = str_replace(array("#user#", "#reason_id#"), array($my_info->
                                    nick, $_GET['reason_id']), ChFun_un_banned_msg);
                            }
                        } else {
                            $replace['#error#'] = 'dont have premssion to stop this ban';
                        }
                    } ##end if isset
                    break;
                }

            case "command_showdisable.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;

                    $show = $this->SPECIAL_CORE->mysql_parser->showdisable();
                    $my_info = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($_SESSION['SP_USER_NICK']); //get my info

                    $replace['#error#'] = 'What ?';
                    $replace['#html#'] = '';
                    if ($show) {
                        $i = 0;
                        foreach ($show as $value) {

                            $user_data = $this->SPECIAL_CORE->mysql_master->get_user_by_id($value->users_id);

                            $color = $this->SPECIAL_CORE->mysql_master->get_user_color($value->level);

                            $date = ($value->action_time != 0) ? date('l F Y', $value->action_time) :
                                "No data";
                            $time = ($value->action_time != 0) ? date('h:i:s A', $value->action_time) :
                                "No data";

                            $checked = str_replace(array("#reason_id#", "#users_id#", "#link_title#"), array
                                ($value->id, $value->users_id, 'Active'), ChFun_stop_disabling_disable);

                            $help_info = $this->language_config['help']['enable'];
                            if ($my_info->level >= $user_data->level && $help_info[$_SESSION['SP_USER_LEVEL']] == true) {
                                $link = $checked;
                            } else {
                                $link = 'disabled';
                            }

                            $replace['#html#'] .= str_replace(array("#id#", "#nick#", "#disabled_by#",
                                "#level#", "#reason#", "#date#", "#time#", "#stop_disabling#"), array($value->
                                id, $value->action_on, $value->action_by, $user_data->level, $value->reason, $date,
                                $time, $link), ChFun_showdisable);
                            $i++;
                        } ##end foreach

                    } else {

                        $replace['#error#'] = 'not found any users in disable list';
                    }

                    $replace['#lines#'] = ($i != '') ? $i : "0";

                    if (isset($_GET['reason_id'], $_GET['users_id']) && $_GET['reason_id'] > 0 && $_GET['users_id'] > 0) {

                        //check command for stop enabled high level
                        $user = $this->SPECIAL_CORE->mysql_master->get_user_by_id($_GET['users_id']);

                        if ($my_info->level >= $user->level) {
                            $how_delete = $this->SPECIAL_CORE->mysql_parser->delete_disable($_GET['users_id']);
                            if ($how_delete) {
                                $replace['#error#'] = str_replace(array("#user#", "#reason_id#"), array($my_info->nick, $_GET['reason_id']), ChFun_stop_disable_msg);
                            }
                        } else {
                            $replace['#error#'] = 'dont have premssion to stop this disable';
                        }
                    }
                    break;
                }

            case "command_configreg.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;
                    $this->title = ChFun_configreg_Title;

                    if (isset($other_vars['delete_id']))
                        $info = $this->LTChartCore->del_reg_field($other_vars['delete_id']);

                    if (count($_POST) > 0)
                        $this->LTChartCore->add_reg_field($_POST);

                    $data = $this->command_tpl_params($template);


                    $replace['#options_text#'] = ChFun_configreg_add_options_text;
                    $replace['#add_text#'] = ChFun_configreg_add_text;
                    $replace['#field_name_text#'] = ChFun_configreg_add_field_name;
                    $replace['#field_name#'] = 'f_name';
                    $replace['#items_text#'] = ChFun_configreg_add_items_text;
                    $replace['#required_text#'] = ChFun_configreg_add_required_text;
                    $replace['#length_text#'] = ChFun_configreg_add_length_text;
                    $replace['#item_name#'] = 'item';
                    $replace['#required_name#'] = 'required';
                    $replace['#length_name#'] = 'lenght';
                    $replace['#options_name#'] = 'options';
                    $replace['#submit#'] = ChFun_configreg_add_submit;


                    foreach (explode(",", ChFun_user_var_names) as $item)
                        $items .= str_replace("#name#", $item, ChFun_configreg_add_items);

                    $replace['#items#'] = $items;


                    $fields_desc = str_replace(array("#var_name#", "#var_type#", "#var_length#",
                        "#required#", "#delete#"), array(ChFun_configreg_name, ChFun_configreg_type,
                        ChFun_configreg_length, ChFun_configreg_required, ChFun_configreg_delete),
                        ChFun_configreg_Fields_th);
                    if (is_array($data['reg_fields']))
                        foreach ($data['reg_fields'] as $field) {
                            $del_link = $this->pass_params_via_tpl($template, array('delete_id' => $field->
                                id));
                            $fields .= str_replace(array("#var_name#", "#var_type#", "#var_length#",
                                "#required#", "#delete#", "#del_link#"), array($field->var_name, $field->
                                var_type, $field->var_length, $field->required, ChFun_configreg_delete, $del_link),
                                ChFun_configreg_Fields_td);
                        }

                    $replace["#fields_desc#"] = $fields_desc;
                    $replace['#fields#'] = $fields;
                    $replace['#add#'] = $add;
                    break;
                }

            case "command_config.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;
                    $data = $this->command_tpl_params($template);

                    include_once (LTChart_path . "/include/LTChatModVars.inc.php");

                    if (count($_POST) > 0)
                        $this->LTChartCore->set_chat_variable($_POST);

                    $config = array();
                    foreach ($GLOBALS['ConfigVarsInfo'] as $var_name => $info)
                        if ($info['type'] == "int") {
                            $config[$info['category']] .= str_replace(array("#description#", "#value#",
                                "#name#", "#submit#"), array($info['description'], get_ConfVar($var_name), $var_name,
                                LTTpl_config_submit), ChFun_config_FieldInt);
                        } elseif ($info['type'] == "boolean") {
                            if (get_ConfVar($var_name))
                                $value = ChTPL_ENABLED;
                            else
                                $value = ChTPL_Disabled;

                            $config[$info['category']] .= str_replace(array("#description#", "#value#",
                                "#name#", "#submit#"), array($info['description'], $value, $var_name,
                                LTTpl_config_submit), ChFun_config_FieldBoolean);
                        }

                    foreach ($config as $c_name => $content)
                        $out .= str_replace(array("#name#", "#items#"), array($c_name, $content),
                            ChFun_config_category);

                    $this->title = LTTpl_config_title;
                    $replace['#config#'] = $out;
                    break;
                }

            case "command_fullhelp.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;
                    /* pobranie dodatkowych informacji z klasy LTChatCoreFunctions */
                    $data = $this->command_tpl_params($template);
                    $level = $_SESSION['SP_USER_LEVEL'];

                    $item_tpl = $this->get_tpl("command_fullhelp_item.tpl");

                    if (is_array($data['functions']))
                        foreach ($data['functions'] as $command)
                            $items .= str_replace("#item#", $command, $item_tpl);

                    $replace['#items#'] = $items;
                    $this->title = LTTpl_fullhelp_title;
                    $replace['#description#'] = LTTpl_fullhelp_desc;
                    $replace['#you_level#'] = "You in level $level and have premssion to use this command";
                    break;
                }
            case "command_bug_form.tpl":
                {
                    if ($this->check_view_external($template))
                        return ChFunNoRights;
                    $data = $this->command_tpl_params($template);
                    $replace['#ver#'] = Ch_VER;
                    $replace['#submit#'] = LTTpl_bug_send;
                    $this->title = LTTpl_bug_title;
                    break;
                }
            case "command_info.tpl":
                if ($this->check_view_external($template))
                    return ChFunNoRights;
                /* pobranie dodatkowych informacji z klasy LTChatCoreFunctions */
                $data = $this->command_tpl_params($template);

                $user_name = $other_vars['login'];

                $replace['#error#'] = '';
                $user_data = $this->SPECIAL_CORE->mysql_master->get_user_by_nick($user_name);

                $post_s = array();
                if (is_array($user_data->other_fields))
                    foreach ($user_data->other_fields as $field) {
                        eval("\$post_s[\"form{\$field->" . LTChat_Main_prefix . "users_var_names_id}\"] = \$field->value;");
                    }

                $registration_fields = $this->get_registration_fields($post_s);

                $replace['#other_fields#'] = $registration_fields['other_fields'];

                define(LTTpl_me_reg_date, "Y-m-d G:i:s");
                define(LTTpl_me_last_seen_date, "Y-m-d G:i:s");

                $replace['#registration_date#'] = ($user_data->registered != 0) ? date(LTTpl_me_reg_date,
                    $user_data->registered):
                "No data";
                $replace['#registration_text#'] = LTTpl_me_reg_text;

                $replace['#last_seen_value#'] = ($user_data->last_seen != 0) ? date(LTTpl_me_last_seen_date,
                    $user_data->last_seen):
                "No data";
                $replace['#last_seen_text#'] = LTTpl_me_last_seen_text;

                $replace['#posted_msg_text#'] = LTTpl_me_posted_msg_text;
                $replace['#posted_msg_value#'] = $user_data->posted_msg;

                $replace['#last_host_text#'] = LTTpl_me_last_host_text;
                $replace['#last_host_value#'] = $user_data->last_host;

                $replace['#last_ip_text#'] = LTTpl_me_last_ip_text;
                $replace['#last_ip_value#'] = $user_data->last_ip;

                $replace['#colorvalue#'] = $user_data->color;
                $replace['#nickcolorvalue#'] = $user_data->nickcolor;
                $replace['#fontvalue#'] = $user_data->font;
                $replace['#nickfontvalue#'] = $user_data->nickfont;

                if (!$user_data->picture_url)
                    $replace['#picture_url#'] = "./img/avatars/noavatar.gif";
                else
                    $replace['#picture_url#'] = $user_data->picture_url;

                $this->title = str_replace("#user#", $user_data->nick, LTTpl_me_title);
                $replace['#login#'] = $user_data->nick;

                $replace['#submit#'] = "";

                break;

            case "command_me.tpl":
                if ($this->check_view_external($template))
                    return ChFunNoRights;
                /* pobranie dodatkowych informacji z klasy LTChatCoreFunctions */
                $data = $this->command_tpl_params($template);

                $user_name = $_SESSION['SP_USER_NICK'];
                $id = $_SESSION['SP_USER_ID'];

                if ($_SESSION['SP_USER_NICK'] == $user_name)
	                if (count($_POST) > 0) {
	                    $this->SPECIAL_CORE->mysql_login->update_style_fields();
	                }

                $user_data = $this->SPECIAL_CORE->mysql_master->get_user_by_id($id);

                $post_s = array();

                //$registration_fields = $this->get_registration_fields($post_s);

                //$replace['#other_fields#'] = $registration_fields['other_fields'];

                define(LTTpl_me_reg_date, "Y-m-d G:i:s");
                define(LTTpl_me_last_seen_date, "Y-m-d G:i:s");

                $replace['#registration_date#'] = ($user_data->registered != 0) ? date(LTTpl_me_reg_date,$user_data->registered):
                "No data";
                $replace['#registration_text#'] = LTTpl_me_reg_text;

                $replace['#last_seen_value#'] = ($user_data->last_seen != 0) ? date(LTTpl_me_last_seen_date,$user_data->last_seen):"No data";
                $replace['#last_seen_text#'] = LTTpl_me_last_seen_text;

                $replace['#posted_msg_text#'] = LTTpl_me_posted_msg_text;
                $replace['#posted_msg_value#'] = $user_data->posted_msg;

                $replace['#last_host_text#'] = LTTpl_me_last_host_text;
                $replace['#last_host_value#'] = $user_data->last_host;

                $replace['#last_ip_text#'] = LTTpl_me_last_ip_text;
                $replace['#last_ip_value#'] = $user_data->last_ip;

                $replace['#colorvalue#'] = $user_data->color;
                $replace['#nickcolorvalue#'] = $user_data->nickcolor;
                $replace['#fontvalue#'] = $user_data->font;
                $replace['#nickfontvalue#'] = $user_data->nickfont;

                if (!$user_data->picture_url)
                    $replace['#picture_url#'] = "./img/avatars/noavatar.gif";
                else
                    $replace['#picture_url#'] = $user_data->picture_url;

                $this->title = str_replace("#user#", $user_data->nick, LTTpl_me_title);
                $replace['#login#'] = $user_data->nick;

                $replace['#submit#'] = str_replace('#send#', LTTpl_me_send, ChFun_me_submit);

                break;

            default:
                {
                    exit;
                }
        }
        return $this->get_tpl($template, $replace);
    }

}