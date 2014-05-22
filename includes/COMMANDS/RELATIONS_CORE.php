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


  $GLOBALS['language_config'] = array();
  $GLOBALS['language_config']['command_apply.tpl']['#login#'] = ChTPL_RegLogin;
  $GLOBALS['language_config']['command_apply.tpl']['#pass#'] = ChTPL_RegPass;
  $GLOBALS['language_config']['command_apply.tpl']['#submit#'] = ChTPL_RegSub;

  $GLOBALS['language_config']['command_apply.tpl']['#ERROR_login_too_short#'] = str_replace("#chars#", LTChatCore_user_min_login_chars, ChTPL_RegErrLogTooShort);
  $GLOBALS['language_config']['command_apply.tpl']['#ERROR_password_too_short#'] = str_replace("#chars#", LTChatCore_user_min_password_chars , ChTPL_RegErrPasTooShort);
  $GLOBALS['language_config']['command_apply.tpl']['#ERROR_user_exists#'] = ChTPL_RegErrUserExists;
  $GLOBALS['language_config']['command_apply.tpl']['#ERROR_fill_required_fields#'] = ChTPL_RegErrFillAllFields;
  $GLOBALS['language_config']['command_apply.tpl']['#ERROR_login_bad_chars#'] = ChTPL_RegErrUserBadNick;
  $GLOBALS['language_config']['command_apply.tpl']['#ERROR_bad_email#'] = ChTPL_RegErrBadEmail;



  $GLOBALS['language_config']['login_form.tpl']['#login#'] = ChTPL_LogLogin;
  $GLOBALS['language_config']['login_form.tpl']['#pass#'] = ChTPL_LogPass;
  $GLOBALS['language_config']['login_form.tpl']['#submit#'] = ChTPL_LogSub;
  $GLOBALS['language_config']['login_form.tpl']['#guest#'] = ChTPL_LogGuest;



  $GLOBALS['language_config']['months']['January'] = ChFun_January;
  $GLOBALS['language_config']['months']['February'] = ChFun_February;
  $GLOBALS['language_config']['months']['March'] = ChFun_March;
  $GLOBALS['language_config']['months']['April'] = ChFun_April;
  $GLOBALS['language_config']['months']['May'] = ChFun_May;
  $GLOBALS['language_config']['months']['June'] = ChFun_June;
  $GLOBALS['language_config']['months']['July'] = ChFun_July;
  $GLOBALS['language_config']['months']['August'] = ChFun_August;
  $GLOBALS['language_config']['months']['September'] = ChFun_September;
  $GLOBALS['language_config']['months']['October'] = ChFun_October;
  $GLOBALS['language_config']['months']['November'] = ChFun_November;
  $GLOBALS['language_config']['months']['December'] = ChFun_December;


  $GLOBALS['language_config']['help']['mycommand'] = array('commands' => array("/mycommand"),
  												'execute_tpl_function' => 'command_mycommand',
  												'params' => array(),
		  										'load_template'	=> 'command_mycommand.tpl',
  												'Description' => LTChatCOM_actionstop_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['reg'] = array('commands' => array("/reg"),
  												'execute_tpl_function' => 'command_register',
  												'params' => array(),
		  										'load_template'	=> 'command_register.tpl',
  												'Description' => LTChatCOM_actionstop_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['prv'] = array(	'commands' => array("/msg","/private","/prv"),
					  									'execute_function' => 'command_private_msg',
					  									'in_disable_mode' => true,
	  													'params' => array("{ ".LTChatCOM_prv_param." }"),
	  													'Description' => LTChatCOM_prv_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['me'] = array('commands' => array("/style","/nickcolor","/nickfont","/color","/font"),
  												'execute_tpl_function' => 'command_tpl_me',
		  										'load_template'	=> 'command_me.tpl',
		  										'in_disable_mode' => true,
  												'Description' => LTChatCOM_me_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['whoami'] = array('commands' => array("/whoami"),
  												'execute_function' => 'command_whoami',
  												'Description' => LTChatCOM_whoami_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);


  $GLOBALS['language_config']['help']['fl'] = array('commands' => array("/fl","/flush"),
	  											'execute_function' => 'command_fl',
	  											'in_disable_mode' => true,
	  											'Description' => LTChatCOM_fl_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['list'] = array('commands' => array("/list"),
  												'execute_tpl_function' => 'command_list',
  												'params' => array(),
  												'in_disable_mode' => true,
		  										'load_template'	=> 'command_list.tpl',
  												'Description' => LTChatCOM_showforward_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['forward'] = array(		'commands' => array("/forward"),
	  											'execute_function' => 'command_forward',
												'params' => array(),
	  											'Description' => LTChatCOM_forward_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['room'] = array(		'commands' => array("/room","/join","/myroom"),
  															'execute_function' => 'command_room',
  															'params' => array("{ ".LTChatCOM_room_param." }"),
  															'Description' => LTChatCOM_room_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['ignore'] = array('commands' => array("/ignore","/igr"),
  												'execute_function' => 'command_ignore',
  												'params' => array("{ ".LTChatCOM_ignore_param." }"),
  												'except_params_static' => array("add" => "-add", "del" => "-del"),
  												'Description' => array('add' => LTChatCOM_ignore_desc_add,
  																	   'del' => LTChatCOM_ignore_desc_del),
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['unignore'] = array('commands' => array("/unignore","/noigr"),
		  										'execute_function' => 'command_unignore',
		  										'params' => array("{ ".LTChatCOM_unignore_param." }"),
		  										'Description' => LTChatCOM_unignore_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['fullhelp'] 	= array('commands' => array("/help"),
  												'execute_tpl_function' => 'command_tpl_fullhelp',
  												'params' => array(),
		  										'load_template'	=> 'command_fullhelp.tpl',
												'in_disable_mode' => true,
  												'Description' => LTChatCOM_fullhelp_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['help'] = array('commands' => array("/?"),
  												'params' => array("[ ".LTChatCOM_help_param." ]"),
	  											'execute_function' => 'command_show_help',
												'in_disable_mode' => true,
	  											'Description' => LTChatCOM_help_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['logout'] = array(	'commands' => array("/quit","/logout","/exit"),
  															'execute_function' => 'command_logout',
												            'in_disable_mode' => true,
  															'Description' => LTChatCOM_logout_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['bug'] = array(	'commands' => array("/bug","/suggest"),
		  													'execute_tpl_function' => 'command_tpl_bug',
  															'params' => array(),
		  													'load_template'	=> 'command_bug_form.tpl',
  															'Description' => LTChatCOM_bug_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);

  $GLOBALS['language_config']['help']['del'] = array(		'commands' => array("/del"),
	  											'execute_function' => 'command_del',
	  											'in_disable_mode' => true,
												'params' => array(),
	  											'Description' => LTChatCOM_del_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true,'0' => true);


  $GLOBALS['language_config']['help']['d'] = array(	'commands' => array("/d"),
  														'execute_function' => 'command_d',
  														'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['showops'] = array('commands' => array("/showops"),
  												'execute_tpl_function' => 'command_showops',
  												'params' => array(),
		  										'load_template'	=> 'command_showops.tpl',
  												'Description' => LTChatCOM_showops_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['showsus'] = array('commands' => array("/showsus"),
  												'execute_tpl_function' => 'command_showsus',
  												'params' => array(),
		  										'load_template'	=> 'command_showsus.tpl',
  												'Description' => LTChatCOM_showsus_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['abuse'] = array(		'commands' => array("/abuse"),
	  											'execute_function' => 'command_abuse',
	  											'in_disable_mode' => true,
	  											'Description' => LTChatCOM_abuse_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['pass'] = array(	'commands' => array("/pass"),
  														'execute_function' => 'command_pass',
  														'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['profile'] = array(	'commands' => array("/info", "/profile"),
  												'execute_tpl_function' => 'command_tpl_info',
  												'execute_function' => 'command_info',
  												'load_template'	=> 'command_info.tpl',
  												'params' => array("{ ".LTChatCOM_whois_param." }"),
  												'Description' => LTChatCOM_whois_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['sing'] = array(	'commands' => array("/sing"),
  															'execute_function' => 'command_sing',
  															'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['comment'] = array(	'commands' => array("/comment"),
  															'execute_function' => 'command_comment',
  															'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['ip'] = array(	'commands' => array("/ip"),
  														'execute_function' => 'command_changeip',
  														'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['wait'] = array(	'commands' => array("/wait"),
  												'execute_function' => 'command_wait',
  												'in_disable_mode' => true,
  												'params' => array("{ ".LTChatCOM_wait_param." }"),
  												'except_params_static' => array("add" => "-add", "del" => "-del"),
  												'Description' => array('add' => LTChatCOM_ignore_desc_add,
  																	   'del' => LTChatCOM_ignore_desc_del),
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);


  $GLOBALS['language_config']['help']['unwait'] = array(	'commands' => array("/unwait","/nowait"),
		  										'execute_function' => 'command_unwait',
		  										'in_disable_mode' => true,
		  										'params' => array("{ ".LTChatCOM_unwait_param." }"),
		  										'Description' => LTChatCOM_unwait_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['away'] = array(	'commands' => array("/away"),
  												'execute_function' => 'command_away',
  												'params' => array(),
  												'Description' => LTChatCOM_away_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['showteam'] = array(	'commands' => array("/showteam", "/whoteam"),
		  										'execute_function' => 'command_showteam',
		  										'params' => array("{ ".LTChatCOM_unwait_param." }"),
		  										'Description' => LTChatCOM_unwait_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['timebar'] = array(	'commands' => array("/timebar"),
  															'execute_function' => 'command_timebar',
  															'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['id'] = array(	'commands' => array("/id"),
  														'execute_function' => 'command_id',
  														'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['removefriend'] = array(	'commands' => array("/removefriend", "/removebuddy"),
			  													'execute_function' => 'command_removefriend',
  																'params' => array("{ ".LTChatCOM_removefriend_param." }"),
  																'Description' => LTChatCOM_removefriend_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['friend'] = array(	'commands' => array("/allow","/friend", "/buddy"),
			  												'execute_function' => 'command_friend',
			  												'params' => array("[ Username ]"),
			  												'except_params_static' => array("add" => "-add", "del" => "-del", "show" => "-show"),
			  												'Description' => array('add' => LTChatCOM_friend_desc_add,
					  															   'del' => LTChatCOM_friend_desc_del,
					  															   'show' => LTChatCOM_friend_desc_show),
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true,'1' => true);

  $GLOBALS['language_config']['help']['clear'] = array('commands' => array("/clear"),
  												'execute_function' => 'command_clear',
  												'Description' => LTChatCOM_clear_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true);

  $GLOBALS['language_config']['help']['showbanpc'] = array('commands' => array("/showbanpc","/showxban"),
  												'execute_tpl_function' => 'command_showbanpc',
  												'params' => array(),
		  										'load_template'	=> 'command_showbanpc.tpl',
  												'Description' => LTChatCOM_showban_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true);

  $GLOBALS['language_config']['help']['showdisable'] = array('commands' => array("/showdisable"),
  												'execute_tpl_function' => 'command_showdisable',
  												'params' => array(),
		  										'load_template'	=> 'command_showdisable.tpl',
  												'Description' => LTChatCOM_fullhelp_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true);

  $GLOBALS['language_config']['help']['warn'] = array(		'commands' => array("/warn"),
  												'execute_function' => 'command_warn',
  												'params' => array("{ ".LTChatCOM_warn_param." }"),
  												'Description' => LTChatCOM_warn_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true);

  $GLOBALS['language_config']['help']['jail'] = array(		'commands' => array("/jail"),
  												'execute_function' => 'command_jail',
  												'params' => array("{ ".LTChatCOM_jail_param." }"),
  												'Description' => LTChatCOM_jail_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true);

  $GLOBALS['language_config']['help']['url'] = array(		'commands' => array("/url"),
				  											'execute_function' => 'command_url',
	  														'params' => array("{ ".LTChatCOM_url_param." }"),
	  														'Description' => LTChatCOM_url_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true,'2' => true);

  $GLOBALS['language_config']['help']['kick'] = array('commands' => array("/kick"),
  												'execute_function' => 'command_kick',
  												'params' => array("{ ".LTChatCOM_kick_param1." }","[ ".LTChatCOM_kick_param2." ]"),
  												'Description' => LTChatCOM_kick_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true);


  $GLOBALS['language_config']['help']['showban'] = array('commands' => array("/showban"),
  												'execute_tpl_function' => 'command_showban',
  												'params' => array(),
		  										'load_template'	=> 'command_showban.tpl',
  												'Description' => LTChatCOM_showban_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true,'3' => true);

  $GLOBALS['language_config']['help']['ban'] = array(		'commands' => array("/ban","/xban","/banpc"),
  												'execute_function' => 'command_ban',
  												'params' => array("{ ".LTChatCOM_kick_param1." }","[ ".LTChatCOM_kick_param2." ]"),
  												'Description' => LTChatCOM_ban_desc,

'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true);

  $GLOBALS['language_config']['help']['unban'] = array('commands' => array("/unban","/noban"),
                                                     'execute_function' => 'command_unban',
  												     'params' => array("User Name"),
  												     'Description' => LTChatCOM_unsus_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true);

  $GLOBALS['language_config']['help']['mk3'] = array(	'commands' => array("/mk3"),
  															'execute_function' => 'command_mk3',
  															'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true);

  $GLOBALS['language_config']['help']['mk2'] = array(	'commands' => array("/mk2"),
  															'execute_function' => 'command_mk2',
  															'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true);

  $GLOBALS['language_config']['help']['mk1'] = array(	'commands' => array("/mk1"),
  															'execute_function' => 'command_mk1',
  															'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true,'4' => true);

  $GLOBALS['language_config']['help']['showclear'] = array('commands' => array("/showclear"),
  												'execute_tpl_function' => 'command_showclear',
  												'params' => array(),
		  										'load_template'	=> 'command_showclear.tpl',
  												'Description' => LTChatCOM_showops_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true,'6' => true,'5' => true);

  $GLOBALS['language_config']['help']['trace'] = array('commands' => array("/trace"),
  												'execute_tpl_function' => 'command_trace',
  												'params' => array(),
		  										'load_template'	=> 'command_trace.tpl',
  												'Description' => LTChatCOM_actionstop_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true,'7' => true);

  $GLOBALS['language_config']['help']['ping'] = array('commands' => array("/ping"),
  												'params' => array("{ ".LTChatCOM_ping_param." }"),
  												'execute_function' => 'command_ping',
  												'Description' => LTChatCOM_ping_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true,'8' => true);

  $GLOBALS['language_config']['help']['sus'] = array('commands' => array("/sus"),
  												'execute_function' => 'command_sus',
  												'params' => array("{ ".LTChatCOM_kick_param1." }","[ ".LTChatCOM_kick_param2." ]"),
  												'Description' => LTChatCOM_sus_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true);

  $GLOBALS['language_config']['help']['unsus'] = array('commands' => array("/unsus","/desus"),
                                                     'execute_function' => 'command_unsus',
  												     'params' => array("User Name"),
  												     'Description' => LTChatCOM_unsus_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true,'9' => true);

  $GLOBALS['language_config']['help']['whois'] = array('commands' => array("/whois"),
	  											'execute_function' => 'command_whois',
	  											'Description' => LTChatCOM_whois_info_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true);

  $GLOBALS['language_config']['help']['flash'] = array(		'commands' => array("/flash"),
				  											'execute_function' => 'command_flash',
	  														'Description' => LTChatCOM_flash_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true);

  $GLOBALS['language_config']['help']['mkick'] = array(		'commands' => array("/mkick"),
  												'execute_function' => 'command_multikick',
  												'params' => array("{ ".LTChatCOM_kick_param1." }","[ ".LTChatCOM_kick_param2." ]"),
  												'Description' => LTChatCOM_mkick_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true);

  $GLOBALS['language_config']['help']['trace2'] = array('commands' => array("/trace2"),
  												'execute_tpl_function' => 'command_trace2',
  												'params' => array(),
		  										'load_template'	=> 'command_trace2.tpl',
  												'Description' => LTChatCOM_actionstop_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true,'12' => true,'11' => true,'10' => true);

  $GLOBALS['language_config']['help']['trace4'] = array('commands' => array("/trace4"),
  												'execute_tpl_function' => 'command_trace4',
  												'params' => array(),
		  										'load_template'	=> 'command_trace4.tpl',
  												'Description' => LTChatCOM_actionstop_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true,'16' => true,'15' => true,'14' => true,'13' => true);

  $GLOBALS['language_config']['help']['actionlogs'] = array(		'commands' => array("/actionlogs"),
  												'execute_tpl_function' => 'command_actionlogs',
		  										'load_template'	=> 'command_actionlogs.tpl',
  												'Description' => LTChatCOM_me_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true,'17' => true);

  $GLOBALS['language_config']['help']['usermsg'] = array(	'commands' => array("/usermsg"),
  															'execute_function' => 'command_guestmsg',
  															'Description' => LTChatCOM_usermsg_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true,'19' => true,'18' => true);

  $GLOBALS['language_config']['help']['actionstop'] = array('commands' => array("/actionstop"),
  												'execute_tpl_function' => 'command_actionstop',
  												'params' => array(),
		  										'load_template'	=> 'command_actionstop.tpl',
  												'Description' => LTChatCOM_actionstop_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true);

  $GLOBALS['language_config']['help']['updologs'] = array('commands' => array("/updologs"),
  												'execute_tpl_function' => 'command_updologs',
  												'params' => array(),
		  										'load_template'	=> 'command_updologs.tpl',
  												'Description' => LTChatCOM_actionstop_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true);

  $GLOBALS['language_config']['help']['filter'] = array('commands' => array("/filter"),
  												'execute_function' => 'command_filter',
  												'params' => array(),
  												'Description' => LTChatCOM_clear_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true,'21' => true,'20' => true);

  $GLOBALS['language_config']['help']['showforward'] 	= array('commands' => array("/showforward"),
  												'execute_tpl_function' => 'command_showforward',
  												'params' => array(),
		  										'load_template'	=> 'command_showforward.tpl',
  												'Description' => LTChatCOM_showforward_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true);

  $GLOBALS['language_config']['help']['setip'] = array(	'commands' => array("/setip"),
  														'execute_function' => 'command_setip',
  														'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true,'26' => true,'25' => true,'24' => true,'23' => true,'22' => true);

  $GLOBALS['language_config']['help']['opmsg'] = array(	'commands' => array("/opmsg"),
  															'execute_function' => 'command_opmsg',
  															'Description' => LTChatCOM_opmsg_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true,'28' => true,'27' => true);

  $GLOBALS['language_config']['help']['disable'] = array('commands' => array("/disable"),
  												'execute_function' => 'command_disable',
  												'params' => array("[ Username ]"),
  												'Description' => LTChatCOM_disable_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true,'29' => true);

  $GLOBALS['language_config']['help']['enable'] = array('commands' => array("/enable"),
  												'execute_function' => 'command_enable',
  												'params' => array("[ Username ]"),
  												'Description' => LTChatCOM_enable_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true);

  $GLOBALS['language_config']['help']['team'] = array(	'commands' => array("/team","/addteam","/staff"),
			  												'execute_function' => 'command_team',
			  												'params' => array("[ Username ]"),
			  												'except_params_static' => array("add" => "-add", "del" => "-del", "show" => "-show"),
			  												'Description' => array('add' => LTChatCOM_friend_desc_add,
					  															   'del' => LTChatCOM_friend_desc_del,
					  															   'show' => LTChatCOM_friend_desc_show),
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true);



  $GLOBALS['language_config']['help']['unteam'] = array(	'commands' => array("/unteam", "/deteam", "/removeteam"),
		  										'execute_function' => 'command_unteam',
		  										'params' => array("{ ".LTChatCOM_unwait_param." }"),
		  										'Description' => LTChatCOM_unwait_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true,'34' => true,'33' => true,'32' => true,'31' => true,'30' => true);

//  $GLOBALS['language_config']['help']['xban'] = array(		'commands' => array("/xban","/banpc"),
//  												'execute_function' => 'command_banpc',
//  												'params' => array("{ ".LTChatCOM_kick_param1." }","[ ".LTChatCOM_kick_param2." ]"),
//  												'Description' => LTChatCOM_ban_desc,
//'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true);

  $GLOBALS['language_config']['help']['cls'] = array(	'commands' => array("/cls"),
  														'execute_function' => 'command_clear_all_public',
  														'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true,'36' => true,'35' => true);

  $GLOBALS['language_config']['help']['check'] = array(		'commands' => array("/check"),
  												'execute_tpl_function' => 'command_check',
		  										'load_template'	=> 'command_check.tpl',
  												'Description' => LTChatCOM_check_msg,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true,'37' => true);

  $GLOBALS['language_config']['help']['allmsg'] = array(	'commands' => array("/allmsg"),
  															'execute_function' => 'command_allmsg',
  															'Description' => LTChatCOM_allmsg_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true,'38' => true);

  $GLOBALS['language_config']['help']['create'] = array('commands' => array("/create","/apply"),
  												'execute_tpl_function' => 'command_apply',
  												'params' => array(),
		  										'load_template'	=> 'command_apply.tpl',
  												'Description' => LTChatCOM_apply_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true,'39' => true);

  $GLOBALS['language_config']['help']['upgrade'] = array(	'commands' => array("/upgrade"),
  															'execute_function' => 'command_upgrade',
  															'Description' => LTChatCOM_upgrade_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true);

  $GLOBALS['language_config']['help']['downgrade'] = array(	'commands' => array("/downgrade"),
  															'execute_function' => 'command_downgrade',
  															'Description' => LTChatCOM_downgrade_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true);

  $GLOBALS['language_config']['help']['crlogs'] = array('commands' => array("/crlogs","/applylogs"),
  												'execute_tpl_function' => 'command_applylogs',
  												'params' => array(),
		  										'load_template'	=> 'command_applylogs.tpl',
  												'Description' => LTChatCOM_applylogs_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true);

  $GLOBALS['language_config']['help']['remove'] = array(	'commands' => array("/remove","/delete"),
  														'execute_function' => 'command_remove_user',
  														'Description' => LTChatCOM_sing_desc,
'50' => true,'49' => true,'48' => true);

  $GLOBALS['language_config']['help']['changeop'] = array(	'commands' => array("/changeop"),
  															'execute_function' => 'command_changeop',
  															'Description' => LTChatCOM_changeop_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true);

  $GLOBALS['language_config']['help']['changepass'] = array(	'commands' => array("/changepass"),
  															'execute_function' => 'command_changepass',
  															'Description' => LTChatCOM_changepass_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true,'42' => true,'41' => true,'40' => true);


  $GLOBALS['language_config']['help']['configrooms'] = array(	'commands' => array("/configrooms","/crooms"),
  													'execute_tpl_function' => 'command_tpl_configrooms',
			  										'load_template'	=> 'command_configrooms.tpl',
  													'Description' => LTChatCOM_configrooms_desc,
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true,'45' => true,'44' => true,'43' => true);

  $GLOBALS['language_config']['help']['skin']  = array(	'commands' => array("/skin"),
  												'execute_function' => 'command_skin',
  												'except_params_static' => array("setskin" => "-setskin","setcss" => "-setcss", "showskins" => "-showskins", "showcss" => "-showcss"),
  												'params' => array("[ ".LTChatCOM_skin_param1." | ".LTChatCOM_skin_param2." ]"),
  												'Description' => array(
  												 					   'setskin' => LTChatCOM_skin_desc_setskin,
  												 					   'setcss' => LTChatCOM_skin_desc_setcss,
		  															   'showskins' => LTChatCOM_skin_desc_showskins,
		  															   'showcss' => LTChatCOM_skin_desc_showcss),
'50' => true,'49' => true,'48' => true,'47' => true,'46' => true);


  $GLOBALS['language_config']['help']['config']	= array(	'commands' => array("/config"),
		  													'execute_tpl_function' => 'command_tpl_config',
  															'params' => array(),
		  													'load_template'	=> 'command_config.tpl',
  															'Description' => LTChatCOM_config_desc,
'50' => true,'49' => true,'48' => true,'47' => true);

  $GLOBALS['language_config']['help']['configreg'] = array(	'commands' => array("/configreg"),
		  													'execute_tpl_function' => 'command_tpl_configreg',
  															'params' => array(),
		  													'load_template'	=> 'command_configreg.tpl',
  															'Description' => LTChatCOM_configreg_desc,
'50' => true,'49' => true,'48' => true,'47' => true);
?>