<?php
/**
 * SPECIAL_CORE.php
 *
 * @package SPECIAL CHAT
 * @programmer Hany alsamman ('hany.alsamman@gmail.com')
 * @author Hany alsamman (Project administrator && Original founder)
 * @version $Id$
 * @pattern private
 * @access private
 */


if ( ! defined( 'IN_SCRIPT' ) )
{
        print "<h1>Incorrect access</h1>You cannot access this file directly.";
        exit();
}

class SPECIAL_CORE
{
	
    var $error = array();
    var $sid;
    var $room;
    var $username;
    var $password;
    var $userid;
    var $pcip;
    var $realip;
    var $uniq;
    var $check_guest;
    var $host_name;
    
    var $mysql_login;
    var $mysql_public_private;
    var $mysql_actions;
    var $mysql_master;
    var $mysql_parser;
    
    var $COMMANDS_CORE;
    var $CHAT_PROCESS;

    /**
     * SPECIAL_CORE_CORE::connection()
     *
     * @return void
     */
    private function connection()
    {
        SPECIAL_DB::getInstance();
    }


    /**
     * SPECIAL_CORE_CORE::__construct()
     *
     * @return void
     */
    
    public function __construct()
    {

        $this->connection(); //create new connection

        $secure = new SECURITY(); //SECURITY
        $secure->parse_incoming();

    	$this->room = ($_POST['room'] != false) ? $_POST['room'] : 1;
    	$this->username = str_replace(' ','_', strtolower( trim($_POST['user_name']) ) );
		$this->password = ($_POST['user_password'] != false) ? $_POST['user_password'] : false;
		$this->host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
		$this->realip = FUNCTIONS::discoverIP();
		$this->pcip = FUNCTIONS::discoverPCIP();
		$this->check_guest = ($_POST['guest'] == 1) ? 1 : 0;
		$this->uniq = ($_POST['uniq']) ? $_POST['uniq'] : 0;                                              

		$this->mysql_login = new mysql_login($this);

		$this->mysql_public_private = new mysql_public_private($this);

		$this->mysql_actions = new mysql_actions($this);

		$this->mysql_master = new mysql_master($this);

		$this->mysql_parser = new mysql_parser($this);

		$this->COMMANDS_CORE = new COMMANDS_CORE($this);

		$this->CHAT_PROCESS = new CHAT_PROCESS();
		
		$this->sid = ( $_POST['sid'] && $_POST['interface'] ) ? md5(uniqid(rand(), true)) : $_POST['sid'];

		$this->COMMANDS_CORE->set_language_config($GLOBALS['language_config']);

    }

	function user_action($room)
	{
		if( $this->mysql_login->check_session_life()){

		   /**
		    * check user's by the session for flood checked
		    */
		   $this->mysql_public_private->restart_flooder();

		   /**
		    * delete all private message out the expired time
		    */
		   $this->mysql_public_private->delete_expired_msg();

		   /**
		    * check lines over head
		    */
		   $this->mysql_public_private->delete_over_public_messages();
		   
		   /**
		    * check offline guest and delete from database && from online list etc..
		    */
	   	   $this->mysql_login->delete_offline_guset();
	   	   
		   /**
		    * check offline member and delete from from online list etc..
		    */
	   	   $this->mysql_login->delete_idel_member();

	   	   /**
	   	    * check how finshed jail time
	   	    */
		   $this->mysql_actions->delete_jail_finish();

		   return true;

	   }else{
	   	   //$this->mysql_login->delete_from_online(-1,1);
	   	   //echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL=index.php?">';
	   	   return false;
	   }

	}

     public function post_msg($text, $room, $private_id_checked=false)
     {
		//Rain effects
		//$text = preg_replace("/\-rain(.+?)\/rain/ie", "rain(\"$1\");", $text);

		$check_flood = $this->mysql_actions->flood_control();

		$check_jail = $this->mysql_actions->whois_have_action($this->mysql_login->get_user_id(), 'jail');
		
		//if(!$check_jail) $this->mysql_actions->total_time_update();
				
		// update the total time and time log without upgrade level
		if(!$check_jail) $this->mysql_actions->insert_total_time(time()-$this->mysql_actions->get_time(0), FALSE);

		if(!empty($text) and !$check_flood and !$check_jail){ //check flood && jail
		
			$text = FUNCTIONS::html2txt($text);

			$text = FUNCTIONS::some_changes($text);
			// ADV Finder
			$text = FUNCTIONS::advfinder($text);

			//check text for /d command :)
			if( $this->mysql_login->get_user_level() > 0 && preg_match('/^\/d (.*)/',$text) ) $text = '{#d#} '.$text;

			$this->mysql_public_private->post_msg($text, $room, $private_id_checked);

		}   
     }

    private function show_actions(){

		//$action = $this->check_user_actions();
		$action = $this->mysql_actions->check_actions( $this->mysql_login->get_user_id() );
		
		$action = @array_filter($action);

	    if (is_array($action) and sizeof($action) > 0) {
            if ($action['kick'] || $action['mkick'] || $action['banuser'] || $action['banip'] || $action['sus']) {

                  //$user_commands = str_replace("#reason#",htmlentities($action['reason'],ENT_QUOTES),ACTION_BOX);

				  $this->mysql_login->delete_from_online($this->mysql_login->get_user_id());
				  
				  if($this->mysql_login->get_user_level() == 0) $this->mysql_actions->delete_check_row($this->mysql_login->get_user_id());
				  
				  $this->mysql_login->delete_user($this->mysql_login->get_user_id(),$this->mysql_login->get_user_nick());
				  
				  return array('COMMANDS_CODE' => $action['reason']);
            }
            
            //if ($action['flood'] == 1) $error = FLOOD_MSG;

            if ($action['jail'] == 1) $error = JAIL_MSG;

            return array('ERRRO_MSG' => $error);
	    }
    }

	private function show_private()
	{
		$data = $this->mysql_public_private->get_my_new_private_messages();

		//check result if array
		while ($private = $this->mysql_master->fetch_object($data) )
		{
		    $private->text = FUNCTIONS::load_emoticons($private->text);

            $private_msg .= $this->CHAT_PROCESS->private_message_received($private);

		}
		return $private_msg;
	}

	private function show_public_elements($room){

		 $commands = $this->mysql_public_private->get_commands_elements($room);
		 
		 $is_command = "true";
		 $other_options = array();
		 $all_data = array();
		 
		 if(mysql_num_rows($commands) > 0)
		 while ($row = $this->mysql_master->fetch_object($commands))
		 {
			//get user style
			$user_style = $this->mysql_master->get_user_by_nick($row->user);
						
			$command = $this->COMMANDS_CORE->command($row, $room, $private_id);
			
			if(is_array($command['other_options'])) $other_options = $command['other_options'];
			
			if(isset($command['data_type'])) $data_type = $command['data_type'];
			
			if($command['type'] == 'private' && $row->user == $this->mysql_login->get_user_nick())	$row->text = $command['text'];			
			elseif($command['type'] == 'public') $row->text = $command['text'];
			elseif($command['type'] == 'skip') continue;			
			else continue;
			
			if($command['type'] == 'public') $is_command = "false";
			
			if($other_options == NULL) $other_options = '';
			
			$needed = array( "other_options" => $other_options,
							 "user_name" => $row->user,
							 "user_id" => $row->user_id,
							 "time_stamp" => $row->time,
							 "text" => $row->text,
							 "id" => $row->id,
							 "is_command" => $is_command,
							 "datatype" => $data_type,
							 "nickfont" => $user_style->nickfont,
							 "nickcolor" => $user_style->nickcolor,
							 "font" => $user_style->font,
							 "color" => $user_style->color,
							 "rights" => $user_style->rights
						   );
						   
			if( sizeof($this->CHAT_PROCESS->proccess_action($needed)) > 0 ) $all_data['WHAT'] = $this->CHAT_PROCESS->proccess_action($needed);
		}
		
		unset($row);
		
		
	   /**
	    *  When Match Simple Public Line
	    */
	    
		$public = $this->mysql_public_private->get_public_elements($room);
		
		if(mysql_num_rows($public) > 0)
		while ($row = $this->mysql_master->fetch_object($public))
		{			
			//get user style
			$user_style = $this->mysql_master->get_user_by_nick($row->user);
		
			$row->text = FUNCTIONS::load_emoticons($row->text,$user_style);
	
			$mydata .= $this->CHAT_PROCESS->message_received($row,$user_style);		
		}
		
		
		$all_data['PUBLIC_MSG'] = $mydata;
		
		return $all_data;		
	}

    private function _LOGIN(){

		//check for guest account if not enable
		if($this->check_guest == 1 && GUEST_ACCOUNT == false){
		     return $this->error[] = ChDK_log_err_guest_account;
		}

		if($this->check_guest == 1 && GUEST_ACCOUNT == true){
			$check = FUNCTIONS::check_alphabets($this->username);
			if($check) return $check;
		}

		//check repeated nick for user if online
		if( $this->check_guest == 1 && $this->mysql_login->check_exists($this->username,0) ){
			return ChCore_guest_user_exists;
		}

		$this->error[] = $this->mysql_login->LOGIN_PROCESS($this->username);

		return array_filter($this->error);

    }

    private function LOGIN_SHOW(){

		if(!empty($this->username) && !empty($this->password)){

			//check the session if not registered
			if ( !$this->mysql_login->user_logged_in() ) {

				$errors = $this->_LOGIN();

				if( !is_null($errors[0]) ){
					include (SITE_PATH.'/templates/soft/login_form.php');
					//print_r($errors);
					exit();
				}

			}
		}


		if(isset($_POST['uniq'])) $this->bulid_session($_POST['uniq']);

		if ( $this->mysql_login->user_logged_in() ){

			/**
			 * Show the login form when session null
			 * Transfer the user to chat login form when session null
			 */

			$my_actions = $this->show_actions();
			//print $my_actions['COMMANDS_CODE'];
			if ( !$this->mysql_login->online_by_nick($_POST['uniq']) && !$_POST['interface'] ){

				$my_actions['COMMANDS_CODE'] = ($my_actions['COMMANDS_CODE'] == false) ? 'Your Quit From Chat' : $my_actions['COMMANDS_CODE'];

				$this->mysql_login->delete_from_online($this->mysql_login->get_user_id(),1);
	        	include (SITE_PATH.'/templates/soft/login_form.php');
				return false;
	        }

			if(!$this->user_action($this->room)) {
				include (SITE_PATH.'/templates/soft/login_form.php');
				return false;
			}

			/**
			 * Check user login :: if guest do that
			 */

			if( $_POST['interface'] && isset($this->check_guest) && $this->check_guest == '1'){
				include (SITE_PATH.'/templates/soft/login_guest.php');
			}

			/**
			 * Check user login :: if member do that
			 */

			if( $_POST['interface'] && isset($this->check_guest) && $this->check_guest == '0'){
				include (SITE_PATH.'/templates/soft/login_member.php');
			}

			if( $this->mysql_login->get_user_nick() == $_POST['uniq'] && isset($_POST['get_chat_view']) && $_POST['get_chat_view'] == '1'){

				$this->post_msg(stripslashes($_POST['message']),stripslashes($this->room), $_POST['msg']);
				
				//check for flood on public and private
				if($this->mysql_actions->whois_have_action($this->mysql_login->get_user_id(), 'flood')) $my_actions['ERRRO_MSG'] = FLOOD_MSG;
				
				$my_list = $this->CHAT_PROCESS->build_user_list();
				
				$my_commands = $this->show_public_elements($this->room);				

				$my_private = $this->show_private();

                if (count($my_private) > 0 && $this->mysql_login->get_user_level() > 0) $checkall = CHECK_ALL_FOR_MEMBERS;

                if (count($my_private) > 0 && $this->mysql_login->get_user_level() == 0) $checkall = CHECK_ALL_FOR_GUSET;

              	/**
				 * Dont show the chat view when session null
				 */
				include (SITE_PATH.'/templates/soft/chat_view.php');
			}

		}

		if(!$_POST['uniq']&& !$_POST['interface']) include (SITE_PATH.'/templates/soft/login_form.php');

    }

	public function bulid_session($uniq)
	{
    	/**
		 * Build Member Session's
		 */
		if(!is_null($uniq)){
			/* set the cache limiter to 'private' */
			session_cache_limiter('private');
			session_name($uniq);			
			@session_start();
		}
	}

    /**
     * SPECIAL_CORE_CORE::MAIN_DISPLAY()
     *
     * @return
     */
    public function MAIN_DISPLAY()
    {

		if( isset($_GET['load_template']) && $_GET['after'] == sha1(base64_encode($_GET['uniq'])) ){

			if( @strrchr($_GET['load_template'], '.') == NULL ) $_GET['load_template'] = base64_decode($_GET['load_template']);

			$_GET['other_vars'] = unserialize(stripslashes(urldecode($_GET['other_vars'])));

			$SPECIAL_PARSER = new SPECIAL_PARSER($this,$_GET['uniq'],$_GET['sid']);
			echo $SPECIAL_PARSER->get_command_tpl($_GET['load_template'], $_GET['other_vars']);
			
    	}else{
    		$this->LOGIN_SHOW();
    	}

    }

    // this will be called automatically at the end of scope
    public function __destruct()
    {
        unset($this->mysql_login,
        	  $this->mysql_public_private,
			  $this->mysql_actions,
			  $this->mysql_master,
			  $this->COMMANDS_CORE,
			  $this->CHAT_PROCESS
			 );
    }
}

?>
