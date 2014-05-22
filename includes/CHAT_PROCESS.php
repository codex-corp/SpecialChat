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

class CHAT_PROCESS {
	
	public function proccess_action($data)
	{
		
        $other_options = $data['other_options'];
        
        $msg = $this->check_error($data);
		
		//if( !is_null($msg) ) return array('ERRRO_MSG' => $msg );		
		
        switch ($data['datatype']) {

            case "template":

                if ($data['other_options']['load_template'] != '') {
                   $this->load_template($data,$_POST['uniq'],$_POST['sid']);
                   return false;
                }

            break;

            case "prv_msg_send":
            
                $msg = $this->private_message_send_info($data);
                
            break;

            case "functions":

                if ($other_options['function'] == 'timebar') {

                    if ($other_options['showtimebar'] == 1) {
                        $msg = str_replace(array("#percent#"), array($other_options['percent']),
                            SHOW_TIME_BAR_FOR_MEMBERS);
                    } else {
                        $msg = NOT_SHOW_TIME_BAR_FOR_GUSET;
                    }

                } else
                    if ($other_options['function'] == 'show_whois') {

                        $msg = str_replace(array("#nickname#", "#maskip#", "#room#", "#onlinetime#",
                            "#public_idle#", "#private_idle#", "#status#"), array($other_options['nickname'],
                            $other_options['maskip'], $other_options['room'], $other_options['onlinetime'],
                            $other_options['public_idle'], $other_options['private_idle'], $other_options['status']),
                            SHOW_WHOIS);

                    } else
                        if ($other_options['function'] == 'changeip') {

                            if ($other_options['showchangeip'] == 1) {
                                $msg = str_replace(array("#nickname#", "#status_1#", "#status_2#", "#status_3#"),
                                    array($other_options['nickname'], $other_options['status_1'], $other_options['status_2'],
                                    $other_options['status_3']), SHOW_CHANGE_IP);
                            } else {
                                $msg = NOT_SHOW_TIME_BAR_FOR_GUSET;
                            }

                        } else
                            if ($other_options['function'] == 'logout') {
                                $commands_other = '<script type="text/javascript">do_logout()</script>';
								//if check the session delete any user used member
								mysql_login::delete_from_online(mysql_login::get_user_id());
								
								return array('OTHER_METHOD' => $commands_other);
                            }
         	break;

        }		
        return array('ERRRO_MSG' => $msg);
	}
	
    function message_received($row,$user_style)
    {

        if ($row->user == 'Chat System') {

            $out = "<TABLE cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td width=100%> " .$row->text."</td></tr></TABLE>";
            
	    }elseif( eregi('{#d#} /d ',$row->text) ){
    	
            $out = str_replace(array("#nickfont#", "#nickcolor#", "#user_name#" , "#font#", "#color#", "#text#"),
                               array($user_style->nickfont, $user_style->nickcolor, $user_style->nick, $user_style->font,$user_style->color,str_replace(array("/d ","{#d#} "), array("",""), $row->text) ), PUBLIC_MSG_D);

        } else {

            $out = str_replace(array("#nickfont#", "#nickcolor#", "#user_name#" , "#font#", "#color#", "#text#"),
                               array($user_style->nickfont, $user_style->nickcolor, $user_style->nick, $user_style->font,$user_style->color,$row->text), PUBLIC_MSG);
        }

        return $out;
    }
	
    function private_message_received(&$data)
    {    
    	
    	//$user_style = mysql_master::get_user_by_id($data->users_id_from);
    	
        if ($_SESSION['SP_USER_LEVEL'] <= '0' && $data->user_id !== '50') {
            $out = str_replace(array("#id#","#rights#","#nickfont#", "#nickcolor#", "#user_name#" , "#font#", "#color#", "#text#"),
	                           array($data->id,$data->rights,$data->nickfont, $data->nickcolor, $data->user, $data->font,$data->color,$data->text), PRI_1);
        
		} elseif ($_SESSION['SP_USER_LEVEL'] > '0' && $data->user_id !== '50') {
                $out = str_replace(array("#id#","#rights#","#nickfont#", "#nickcolor#", "#user_name#" , "#font#", "#color#", "#text#"),
	                           	   array($data->id,$data->rights,$data->nickfont, $data->nickcolor, $data->user, $data->font,$data->color,$data->text), PRI_2);
        
		} elseif ($data->user_id == '50') {
                $out = str_replace(array("#id#","#text#"),
	                          	   array($data->id,$data->text), PRI_3);
        }

        return $out;
    }
    
    function check_error($data)
    {

        if ($data['is_command'] == true) {
            if ($data['other_options']['type_handle'] == 'error') {
                $out = "<hr><TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\"><span style=\"font-family:arial; font-size:10pt; color:red\">" .$data['text'] . "</span></td></tr></TABLE>";
            }else{         
				$out = "<hr><TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td align=\"left\"><span style=\"font-family:arial; font-size:10pt; color:green\">" .$data['text'] . "</span></td></tr></TABLE>";            	
            }

        } # end is_command
        return $out;
    }
    
    function load_template($data,$uniq,$sid)
    {
        $options = $data['other_options'];
        //return '<script>load_template("' . $options['load_template'] . '", "' . $options['other_vars'] .'")</script>';
        $load_template = base64_encode($options['load_template']);
        $other_vars = $options['other_vars'];
        $after = sha1(base64_encode($uniq));
        
		if(!empty($options['additional'])) $additional = '&additional='.$options['additional'].'';
				
		session_write_close();
		header('Location: index.php?load_template='.$load_template.'&other_vars='.$other_vars.'&uniq='.$uniq.'&after='.$after.'&sid='.$sid.$additional.'');
		
    }
    
    function private_message_send_info($data)
    {
        if ($data['text'] == "undefined")
            $data['text'] = "";

        $options = $data['other_options'];

        $out = "<hr><TABLE cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\" ><tr><td><font color='blue' face='Arial' size='2'>>> " . $options['status'] . " :[<span style='font-family:" . $data['nickfont'] . "; color:" . $data['nickcolor'] . ";'><b>" . $options['nick'] . "</b></span>]: <span style='font-family: Tahoma; font-size: 12px; color:" . $data['color'] . ";'>" . $data['text'] . "</span></font></td></tr></TABLE>";

        return $out;
    }
    
    function build_user_list(){
    	
		$user_list = mysql_master::get_users_list();

        $users_online_drop = false;

		while ($user = mysql_master::fetch_object($user_list))	
		{
		   $get_user_color = mysql_master::get_user_color($user->level);

		   if($user->online){				
			//$users_online_list .= "<a title=".$user->rights." href=\"javascript:message('/msg ".$user->nick." ')\"><img src='img/online.gif' border=0><span style='font-family:".$user->nickfont."; color:".$get_user_color.";'>".$user->nick."</font></a><BR>";
					
			$users_online_drop .= "<option style=\" color: ".$get_user_color." \" value=\"/msg ".$user->nick." \">".$user->nick."</option>";
		   }
			
		}
		return $users_online_drop;		
    }
	
}

?>