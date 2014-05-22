<?php

  define("ChFun_actionlogs_Title","Action logs");
  define("ChFun_checksaved_Title","Check Saved Logs");
  
  define("ChFun_private_logs_syntex","<span style=\"color: AAAAAA; font-family: arial; font-size: 10pt;\"><b>Logs:</b> #text#");
  define("ChFun_team_members_online","<a style=\"text-decoration: none\" href=\"javascript:parent.message('/msg #nick#')\"><font color='#levelcolor#' font='#nickfont#'>#nick#,</font></a></span>");

  define("ChFun_create_team_nickname","<span style=\"color: blue; font-family: arial; font-size: 10pt;\"><b>Team of the members online</b> #all_nickname#");

  define("LTTpl_required_reg_mark","*");
  define("LTTpl_login_selroom","<span class='label'>Select room</span><br>");
  define("LTTpl_static_html","Document doesn't exists");
  define("LTTpl_required_reg_desc","* Field can not be empty.");
  define("LTChatCore_user_doesnt_exists", "User \"#user#\" doesn't exists.");
  define("LTChatCore_change_ip", "Your IP has been changed to #change#");  
  
  define("ChFunBadCommand", "<font face=Arial size=2 color=red>*** Sorry , Unknown command </font> <font face=Arial size=2 color=000000><b>\"#command#\"</b></font><font face=Arial size=2 color=red> ! Its maybe used by higher rank !</font><br><font face=Arial size=2 color=green>* Please check <a style=\"text-decoration: none; color: red; font-family: Arial\" href=\"javascript:parent.message('/fullhelp')\"><b>help</b></a> or please use </font><font size=2 style=\"text-decoration: none; color: red; font-family: Arial\">/?</font>");
  
  define("LTChatRoomChangeMsg", "<b><font face='Trebuchet MS'><font color='#D20A04'>Special</font><font color='#147DB8'>Chat</font></font></b><font face='Trebuchet MS' size='2'> | </font><b><font face='Tahoma' color='#147DB8' size='2'>#room_name#</font></b>");
  
  define("ChFunBadFunction","Function is not implemented");
 
  define("ChFunNoRights","You can not use this command. You are not the administrator.");
  define("ChFunQuitb4twomin","** Sorry, you can not QUIT before than 2 minutes!");
 
  define("abuse","<TABLE cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\"><tr><td><span style='font-family: Arial; font-size: 9pt; color:black'><b>#mynick# :</b><span style=visibility:hidden; font-size:xx-small>i</span><span style='font-family:Tahoma; color:black'>#text#</span></span></td></tr></TABLE>");
  
  define("waitmsg","<FONT face='Palatino Linotype' size='3' color=red>Nickname wait :<font color=ffffff>i</font><a style=\'text-decoration: none; color: cc0000\' <a onclick='parent.message(\"/msg #waitname# \")' href=\"#\"><font color='#nickcolor#'><b>#waitname#</b></font></a><font color=ffffff>i</font><b>(#waitright#)</b> is currently on the chat in room <a style=\'text-decoration: none; color: cc0000\' onclick='parent.message(\"/room #joinedroom# \")' href=\"#\"><font color='#FF0000'>#joinedroom#</font></a> !</FONT>");
  
  define("ChFun_msg_forward","<span style=\"color: black; font-family: arial; font-size: 9pt;\">The message's forward from #f_sender# <span style=\"color: #nickcolor#; font-family: #nickfont#; font-size: 10pt;\"><b>#user_name# (#rights#):</b></span><span style=visibility:hidden; font-size:xx-small>i</span><span style=\"color: #color#; font-family: #font#\">#text# </span>");

  define("ChFun_msg_forward_logs_start","<br /><span style=\"color: black; font-family: arial; font-size: 9pt;\">*** Forward From : <font color=green><b>#f_sender#</font></b> : to : <b><font color=orange>#f_send_to#</font></span><br />");
 
  define("ChFun_msg_forward_logs","<span style=\"color: #nickcolor#; font-family: #nickfont#; font-size: 10pt;\"><b>#user_name# (#rights#):</b></span><span style=visibility:hidden; font-size:xx-small>i</span><span style=\"color: #color#; font-family: #font#\">#text#</span><br />");
  
  define("ChFun_msg_forward_ok","<span style=\"color: black; font-family: arial; font-size: 9pt;\">The selected message's has been forward to <b>#f_send_to#</b> </span>");
  
  define("ChFun_msg_clear_logs_start","<span style=\"color: black; font-family: arial; font-size: 9pt;\">*** clear <strong>#user#</strong> messages by <strong>#sender#</strong>:</span><br />");
 
  define("ChFun_msg_clear_logs","<span style=\"color: #nickcolor#; font-family: #nickfont#; font-size: 10pt;\"><b>#user_name# (#rights#):</b></span><span style=visibility:hidden; font-size:xx-small>i</span><span style=\"color: #color#; font-family: #font#\">#text#</span><br />");
  
  define("ChFun_msg_filter_logs_start","<span style=\"color: black; font-family: arial; font-size: 9pt;\">*** Filter <strong>#word#</strong> messages by <strong>#sender#</strong> :</span><br />");
  
  define("ChFun_msg_filter_logs","<span style=\"color: #nickcolor#; font-family: #nickfont#; font-size: 10pt;\"><b>#user_name# (#rights#):</b></span><span style=visibility:hidden; font-size:xx-small>i</span><span style=\"color: #color#; font-family: #font#\">#text#</span><br />");
  
  define("offline","The user #user# not online now and message not sent!");
  define("ChFun_offline","The user #user# not online now");
  
  define("ChCore_nick_exists_in_database","You can not login to this user, allready exists in database as member.");
  define("ChCore_login_err_bad_pass","Bad password.");
  define("ChCore_login_err_bad_login","Bad login. User doesn't exist.");
  define("ChCore_guest_user_exists","You can not login to this user. allready in use under an allready - online changed nickname");
  define("ChCore_member_user_exists","You can not login to this user. Nick has been allready taken.");
  
//------------------------ fullhelp -------------------------
  define("LTTpl_fullhelp_title","Command list");
  define("LTTpl_fullhelp_desc","Command list whitch can be used in the chat");
########################## fullhelp #########################
 
//------------------------ me -------------------------------
  define("LTTpl_me_title", "User \"#user#\" profile.");
  define("LTTpl_me_send", "Update your profile");
  define("LTTpl_me_error_fill_required","Fill all required fields");
  define("LTTpl_me_error_bad_type", "You entered wrang type of data");
########################## me ###############################
 
//------------------------ bug ------------------------------
  define("LTTpl_bug_title", "Bug report");
  define("LTTpl_bug_send", "Send report");
########################## bug ##############################
 
  
//------------------------ config ---------------------------
  define("LTTpl_config_title","Chat config");
  define("LTTpl_config_submit","Save");
########################## config ###########################
 
////////////////////////////////////////////////////////////
// COMMANDS
////////////////////////////////////////////////////////////
 
//------------------------ help ----------------------------
// jezeli komenda nie jest rozpoznawana przez system
  define("ChFun_help_UnknownCommand",ChFunBadCommand);
########################## help #############################
 
//------------------------ whoami ---------------------------
  define("ChFun_whoami", "You are logged in as \"#user#\".");
//######################## whoami ###########################
 
//------------------------ ping -----------------------------
  define("ChFun_ping_BadHost", "Bad host name");
  define("ChFun_ping_Disabled", "Low level socket support is disabled on this server.");
  define("ChFun_ping_ResolveErr", "Can't resolve hostname (#host#)");
  define("ChFun_ping_Info", "Pinging  #host# [#ip#] with 32 bytes of data:");
  define("ChFun_ping_Info_resp", "Reply from #ip#: bytes=#b# time=#time#ms");
  define("ChFun_ping_Info_Timeout", "Request time limit is up.");
//######################## ping #############################
 
//------------------------ kick -----------------------------
  define("ChFun_kick_BadNick", "User \"#user#\" doesn't exists.");
  define("ChFun_kick_OkReason", "<font face='Arial' size='2' color='AAAAAA' size='3px'>** <b>#user#</b> (#rights#) has been kicked by <font color=#senderrightcolor#>#sender#</font> for <font color=#sendercolor#>(#reason#).</font></font>");
  define("ChFun_kick_Ok", "User \"#user#\" was deleted.");
  define("ChFun_write_kick_reason", "Kick failed: No kick reason provided!");
  define("ChFun_kick_your_self", "Kick failed: cannot alowwed kick your self!");
  define("ChFun_kick_same_level", "Sorry, you cant kick an op higher than you or in the same level!");
  define("ChFun_kick_offline", "Sorry, user \"#user#\" cannot online for kicked him right now!");
########################## kick #############################

//------------------------ jail -----------------------------
  define("ChFun_jail_BadNick", "User \"#user#\" doesn't exists.");
  define("ChFun_jail_OkReason", "<font face='Arial' size='2' color='AAAAAA' size='3px'>** <b>#user#</b> (#rights#) has been jailed by <font color=#senderrightcolor#>#sender#</font> for <font color=#sendercolor#>(#reason#).</font></font>");
  define("ChFun_jail_Ok", "User \"#user#\" was deleted.");
  define("ChFun_write_jail_reason", "Jail failed: No jail reason provided!");
  define("ChFun_jail_your_self", "Jail failed: cannot alowwed jail your self!");
  define("ChFun_jail_same_level", "Sorry, you cant jail an op higher than you or in the same level!");
  define("ChFun_jail_offline", "Sorry, user \"#user#\" cannot online for jail him right now!");
########################## jail #############################

//------------------------ multi kick -----------------------------
  define("ChFun_multikick_op", "*** Multi-kick failed: You can not multi-kick an Op nick!");
  define("ChFun_multikick_OkReason", "<font face='Arial' size='2' color='AAAAAA' size='3px'>*** A multi-kick against user <b>#user#</b> (#rights#) kicking <b>#number#</b> a total of user #name# has been performed by <font color=#senderrightcolor#>#sender#</font> for <font color=#sendercolor#>(#reason#).</font></font>");
    define("ChFun_multikick_4_person", "<font face='Arial' size='2' color='AAAAAA' size='3px'>*** A multi-kick has been performed by <font color=#senderrightcolor#>#sender#</font> for <font color=#sendercolor#>(#reason#).</font></font>");
  define("ChFun_write_multikick_nick", "*** Multi-kick failed: No nickname provided to multi-kick!");
  define("ChFun_write_multikick_reason", "*** Multi-kick failed: No reason provided to multi-kick!");
########################## multi kick #############################

//------------------------ disable -----------------------------
  define("ChFun_disable_your_self", "*** Stop try to disable your self!");
  define("ChFun_disable_offline", "*** Sorry, user \"#user#\" cannot online for disable him right now! ");
  define("ChFun_disable_same_level", "*** Sorry, you cant disable an op higher than you or in the same level!");
  define("ChFun_disable_user", "*** Sorry, you cant disable user (GUEST)");
  define("ERROR_already_disable", "*** Sorry, but Op <b>#user#</b> is already DISABLE.");
  define("ChFun_write_disable_reason", "*** Disable failed: No ban reason provided!");
  define("ChFun_disable_Ok", "<font face='Arial' size='2' color='AAAAAA' size='3px'>** <b>#user#</b> (#rights#) has been disable by <font color=#senderrightcolor#>#sender#</font> for <font color=#sendercolor#>(#reason#).</font></font>");
  
########################## disable #############################

//------------------------ enable -----------------------------
  define("ChFun_enable_your_self", "*** Stop try to enable your self!");
  define("ChFun_enable_same_level", "*** Sorry, you cant enable an op higher than you or in the same level!");
  define("ChFun_enable_user", "*** Sorry, you cant enable (GUEST)!");
  define("ChFun_already_enable", "*** Sorry, but Op <b>#user#</b> is already have power.");
  define("ChFun_enable_Ok", "<font face='Arial' size='2' color='AAAAAA' size='3px'>** <b>#user#</b> (#rights#) has been enable by <font color=#senderrightcolor#>#sender#</font></font>");
  define("ChFun_enable_msg", "*** The power of user <strong>#user#</strong> has been enabled!");
  define("ChFun_stop_disable_msg", "The user <strong>#user#</strong> has been enable the action id number <strong>#reason_id#</strong> and write in logs");
  
########################## enable #############################

//------------------------ ban -----------------------------
  define("ChFun_banip_OkReason", "<font face='Arial' size='2' color='AAAAAA' size='3px'>*** The Ip <b>(#ip#)</b> has been banned by <font color=\"#senderrightcolor#\">#sender#</font> for the reason <font color=#sendercolor#>(#reason#).</font></font>");
  
  define("ChFun_banuser_OkReason", "<font face='Arial' size='2' color='AAAAAA' size='3px'>*** The user <b>(#user#)</b> has been banned by <font color=\"#senderrightcolor#\">#sender#</font> for the reason <font color=#sendercolor#>(#reason#).</font></font>");
  
  define("ChFun_banuser_not", "<font face='Arial' size='2' color='AAAAAA' size='3px'>*** Sorry, cannot alowwed ban <b>#user#</b> coz this memeber account!</font>");
  
  define("ChFun_write_banip_reason", "*** Ban failed: No ban reason provided!");
  define("ChFun_not_valid_ip", "*** Ban failed: Non-valid Ip address provided.");
  
  define("ChFun_un_banned_ip", "<font face='Arial' size='2' color='AAAAAA'>The IP <strong>(#ip#)</strong> Unbanned from chat by <strong>#sender#</strong>, a ban originally done by <strong>#sender_original#</strong> !.</font>");
  
  define("ChFun_un_banned_nick", "<font face='Arial' size='2' color='AAAAAA'>The IP of <strong>(#user#)</strong> Unbanned from chat by <strong>#sender#</strong>, a ban originally done by <strong>#sender_original#</strong> !.</font>");
  
  define("ChFun_un_banned_msg", "The user <strong>#user#</strong> has been stop the ban id number <strong>#reason_id#</strong> and write in logs");
########################## ban #############################

//------------------------ sus -----------------------------
  define("ChFun_sus_BadNick", "User \"#user#\" doesn't exists.");
  define("ChFun_sus_OkReason", "<font face='Arial' size='2' color='AAAAAA'>** <b>#user#</b> (#rights#) has been suspended by <font color=\"#senderrightcolor#\">#sender#</font> for <font color=#sendercolor#>(#reason#).</font></font>");
  define("ChFun_write_sus_reason", "** Suspension failed: No suspension reason provided!");
  define("ChFun_sus_your_self", "Kick failed: cannot alowwed sus your self!");
  define("ChFun_sus_same_level", "Sorry, you cant suspend an op higher than you or in the same level!");
  define("ChFun_sus_offline", "Sorry, user \"#user#\" cannot online for suspension him right now!");
########################## sus #############################

//------------------------ unsus -----------------------------
  define("ChFun_unsus_your_self", "*** Suspension failed: try to suspension your self!");
  define("ChFun_unsus_same_level", "*** Sorry, you cant un-suspension an op higher than you or in the same level!");
  define("ChFun_unsus_user", "*** Sorry, you cant un-suspension (GUEST)");
  define("ChFun_already_unsus", "*** Sorry, the user \"#user#\" not have suspension to be un-suspension!");
  define("ChFun_un_sused", "<font face='Arial' size='2' color='AAAAAA'>The Operator <strong>#user#(# #rights# #)</strong> un-suspension from chat by <strong>#sender#</strong>, a suspension originally done by <font color='#senderrightcolor#'><strong>#sender_original#</strong></font> !.</font>");
  define("ChFun_un_sused_msg", "The user <strong>#user#</strong> has been stop the suspanded id number <strong>#reason_id#</strong> and write in logs !");
########################## unsus #############################
 
//------------------------ warn -----------------------------
  define("ChFun_warn_BadNick", "User \"#user#\" doesn't exists.");
  define("ChFun_warn_Ok", "<font face='Arial' size='2' color='AAAAAA' size='3px'>** <b>#user#</b> (#rights#) has been warned by <font color=#senderrightcolor#>#sender#</font> for <font color=#sendercolor#>(#reason#).</font></font>");
  define("ChFun_write_warn_reason", "You should write <font color='#FF0000'>a REASON</font> with your action !");
  define("ChFun_warn_your_self", "Warn failed: cannot alowwed warn your self!");
  define("ChFun_warn_same_level", "Sorry, you cant warn an op higher than you or in the same level!");
  define("ChFun_warn_offline", "Sorry, user \"#user#\" cannot online for warn him right now!");
########################## warn #############################

//------------------------ apply ------------------------------

  define("LTChatCreateOpMsg", "<font face='arial' size='2'>** The user <strong>#created#</strong> was added successfully in level #created_level# at #created_time# by #created_by# with level #creating_level#</font>");
  
  define("LTChatCOM_apply_desc","Display list of the created Opreators");
  
  define("LTChatCOM_applylogs_desc","Display logs for all opreators created");
########################## apply ##############################

//------------------------ upgrade ----------------------------

  //action upgrade
  define("LTChatCOM_upgrade_desc", "This command used for upgrade the operator (only) to new level");
  //action upgrade failed not operator
  define("LTChatCOM_stop_upgrade_level_zero", "Sorry, user #user# not operator and upgraded failed!");
  //action upgrade failed Maximum 50
  define("LTChatCOM_stop_upgrade_maximum_level", "Sorry, upgrade failed: Maximum level is 50!");
  //action upgrade failed level under allowed level
  define("LTChatCOM_stop_upgrade_error_level", "Sorry, upgrade failed: Can't upgrade from level #from_level# to level #to_level#");
  //action upgrade approved , this upgrade message
  define("LTChatCOM_upgrade_msg", "<font face=arial size=2>User <b>#up_user#</b> in level #up_level# successfully <strong>upgraded</strong> to level <strong>#up_to_level#</strong> done by <font color=#up_sender_color#>#up_sender#!</font></font>");
  //action upgrade not have the new level
  define("LTChatCOM_downgrade_without_new_level", "Sorry, Can't find the new level to upgrade!");
  
########################## upgrade ############################

//------------------------ downgrade ----------------------------

  //action downgrade
  define("LTChatCOM_downgrade_desc", "This command used for downgrade the operator (only) to new level");
  //action downgrade failed not operator
  define("LTChatCOM_stop_downgrade_level_zero", "Sorry, user #user# not operator and downgraded failed!");
  //action downgrade failed Maximum 50
  define("LTChatCOM_stop_downgrade_maximum_level", "Sorry, downgrade failed: Maximum level is 1!");
  //action downgrade failed level under allowed level
  define("LTChatCOM_stop_downgrade_error_level", "Sorry, downgrade failed: Can't downgrade from level #from_level# to level #to_level#");
  //action downgrade failed level under allowed level
  define("LTChatCOM_stop_downgrade_only_admin", "Sorry, only admins can downgrade Ops higher than level 49!");
  //action downgrade approved , this downgrade message
  define("LTChatCOM_downgrade_msg", "<font face=arial size=2>User <b>#do_user#</b> in level #do_level# successfully <strong>downgraded</strong> to level <strong>#do_to_level#</strong> done by <font color=#do_sender_color#>#do_sender#!</font></font>");
  //action downgrade not have the new level
  define("LTChatCOM_downgrade_without_new_level", "Sorry, Can't find the new level to downgrade!");
  
########################## downgrade ############################

//------------------------ change password operator ----------------------------
  //action change password
  define("LTChatCOM_changepass_desc", "This command used for change any operator password to new password!");
  //action change nick failed not operator
  define("LTChatCOM_changepass_level_zero", "Sorry, user #user# not operator and change password failed!");
  //action change nick failed not operator
  define("LTChatCOM_changepass_error_confirm", "Sorry, user #user# confirm password not correct and changing password failed!");
  //action change password approved , this changed message
  define("LTChatCOM_changepass_msg", "Operator nick <b>#user#</b> successfully changed password to <b>#new_pass#</b>!");
  //action change password not have the new password
  define("LTChatCOM_changepass_without_new_level", "Sorry, Can't find the new password to changing!");
########################## change password operator ############################

//------------------------ change operator nick name ----------------------------
  //action change operator nick name
  define("LTChatCOM_changeop_desc", "This command used for change any operator nick name to new nick name !");
  //action change nick failed not operator
  define("LTChatCOM_changeop_level_zero", "Sorry, user #user# not operator and change nick failed!");
  //action change nick approved , this changed message
  define("LTChatCOM_changeop_msg", "Operator nick <b>#user#</b> successfully changed to <b>#new_nick#</b>!");
  //action change nick not have the new nick name
  define("LTChatCOM_changeop_without_new_nick", "Sorry, Can't find the new nick name to changing!");
########################## change operator nick name ############################

//------------------------ away mode ----------------------------
  //action away mode
  define("LTChatCOM_away_desc", "This command used enter the away mode (in away mode the message in private will be delete)");
  //action away disable
  define("LTChatCOM_away_disable", "away mode is disable");
  //action away enable
  define("LTChatCOM_away_enable", "away mode is enable");
########################## away mode ############################

//------------------------ del -----------------------
  define("ChFun_fl_nomsg","** Sorry, no message number provided to be deleted!");
  define("ChFun_fl_delmsg_ok","** Selected private message number has been deleted!");
  define("ChFun_fl_delmsg_no","** Sorry, the message id provided not correct!");
  define("LTChatCOM_del_desc", "Delete the private message by selection!");
########################## del #######################

//------------------------ forward -----------------------
  define("ChFun_forward_notonline","** The user <b>#user#</b> not online now to forward message!");
  define("LTChatCOM_forward_desc","This command used to forward any message from your private by selection to another operator");
########################## forward #######################

//------------------------ collection's of desc ------------------------------
  //action actionstop
  define("LTChatCOM_actionstop_desc", "Display list of the action's posted (jail, sus, unsus, kill)");
  //action showsus
  define("LTChatCOM_showsus_desc", "Display list of suspanded operators");
  //action showban
  define("LTChatCOM_showban_desc", "Display list of banned operators OR banned ip!");
  //action showops
  define("LTChatCOM_showops_desc", "Display list of all opreator's in chat with level and some information's!");
  //action showforward
  define("LTChatCOM_showforward_desc", "Display list of all forwardes messages bettwen the opreator's, this command only for high level and administrators");
  //action fl (flash)
  define("LTChatCOM_fl_desc", "Delete and flash all message in your private");
  //action whois
  define("LTChatCOM_whois_info_desc", "Display info about an operator(IP, Room, Online Time, public idle , private idle, Status)");
  //command abuse
  define("LTChatCOM_abuse_desc", "Thanx, a copy of the public room #room# has been sent to the administrators and staff.");
  //command check
  define("LTChatCOM_check_msg", "Display list of all action's posted in chat but with history for public to this action's!");
  //action actionlogs
  define("LTChatCOM_actionlogs_desc", "Display list of the action's posted (kick, banned (ip|user), unbanned (ip|user), multikick)");

########################## collection's of desc ##############################

//------------------------ collection's of command ------------------------------

//command sing
  define("ChFun_sing_msg","<span style='visibility:hidden; font-size:xx-small'>i</span><font face='#my_nick_font#' color='#my_nick_color#' size='2'><b>#user#</b> </font><strong><font face='Tahoma' size='4' color='#008000'>sings,</font></strong><img src='templates/soft/img/song_ne.gif'>&nbsp;<font face=#my_font# color=#my_color#><b><i>#text#</i></b></font>&nbsp;<img src='templates/soft/img/song_ne.gif'><span style='visibility:hidden; font-size:xx-small'>i</span>");
//command sing error
  define("ChFun_sing_msg_error","Sorry, not found the sing message");
//command comment
  define("ChFun_comment_msg","<span style='font-family:#myfont#; color:#mycolor#'>#comment#</span>");
//command comment error
  define("ChFun_comment_msg_error","Sorry, not found the comment message to change");
//command mk1
  define("ChFun_mk1_msg","<span style='visibility:hidden; font-size:xx-small'>i</span><span style='font-family:#nickfont#; color:#nickcolor#'>#user#</span><span style='visibility:hidden; font-size:xx-small'>i</span><marquee width='800'><span style='font-family:#myfont#; color:#mycolor#'>#text#</span></marquee>");
//command mk1 error
  define("ChFun_mk1_msg_error","Sorry, not found the mk1 message to send");

//command mk2
  define("ChFun_mk2_msg","<span style='visibility:hidden; font-size:xx-small'>i</span><span style='font-family:#nickfont#; color:#nickcolor#'>#user#</span><span style='visibility:hidden; font-size:xx-small'>i</span><marquee width='800' behavior='slide'><span style='font-family:#myfont#; color:#mycolor#'>#text#</span></marquee>");
//command mk2 error
  define("ChFun_mk2_msg_error","Sorry, not found the mk2 message to send");

//command mk3
  define("ChFun_mk3_msg","<span style='visibility:hidden; font-size:xx-small'>i</span><span style='font-family:#nickfont#; color:#nickcolor#'>#user#</span><span style='visibility:hidden; font-size:xx-small'>i</span><marquee width='800' behavior='alternate'><span style='font-family:#myfont#; color:#mycolor#'>#text#</span></marquee>");
//command mk3 error
  define("ChFun_mk3_msg_error","Sorry, not found the mk3 message to send");
//command clear
  define("ChFun_clear","<font color='AAAAAA'>Your cleared <strong>#cleared#</strong> text from the main screen !");
//command msg clear
  define("ChFun_msg_clear","<font face='arial' size='2' color='AAAAAA'><strong>#user#</strong> cleared message's from the main screen by <font color=#levelcolor#><strong>#sender#</strong></font>!");
//command msg filter
  define("ChFun_msg_filter","<font face='arial' size='2' color='AAAAAA'><strong>#word#</strong> filterd message's from the main screen by <font color=#levelcolor#><strong>#sender#</strong></font>!");
//command filter
  define("ChFun_filter","<font color='AAAAAA'>Your filterd <strong>#word#</strong> word from the main screen !");
//command showid
  define("ChFun_msg_id","<font face='arial' size='2' color='red'>Nickname is <strong>#user#</strong> #maskip# ~Level <strong>#level#</strong>~ ~Status <strong>#rights#</strong> ~ Level color <strong>#levelcolor#</strong></font>");
  
########################## collection's of command ##############################
 
//------------------------ prv ------------------------------
// tytul prywatnego chata
  define("ChFun_prv_Title","Private chat");
  define("ChFun_prv_msgtome", "You can not send private message to your self!");
########################## prv ##############################
 
//------------------------ configreg ------------------------
// tytul prywatnego chata
  define("ChFun_configreg_Title","User registration config");
  define("ChFun_configreg_name","Name");
  define("ChFun_configreg_type","Type");
  define("ChFun_configreg_length","Length");
  define("ChFun_configreg_required","Required");
  define("ChFun_configreg_delete","Delete");
 
  define("ChFun_configreg_add_text","Add field to registration");
  define("ChFun_configreg_add_submit", "Save");
  define("ChFun_configreg_add_field_name", "Field name");
  define("ChFun_configreg_add_items_text", "Field type");
  define("ChFun_configreg_add_required_text", "Required");
  define("ChFun_configreg_add_length_text", "Field Length");
  define("ChFun_configreg_add_options_text", "Separate options with | sign");
 
########################## configreg ########################
 
//------------------------ friend ---------------------------
  define("ChFun_friend_from_text","Your friend list");
  define("ChFun_friend_to_text","List of users witch added you to the their friend list");
  define("ChFun_friend_Eempty","Your friend list is empty");
  define("ChFun_friend_Add", "User \"#user#\" was added to your friend list.");
  define("ChFun_friend_Del", "User \"#user#\" was deleted from your friend list.");
########################## friend ###########################

//------------------------ Team ---------------------------
  define("ChFun_team_list_empty","Team list is empty");
  define("ChFun_Team_Add", "User <b>#user#</b> was added to group <font color='green'>#group_name#</font> list.");
  define("ChFun_Team_Del", "User <b>#user#</b> was deleted from group <font color='red'>#group_name#</font> list.");
  define("ChFun_team_user_exists", "User <font color='red'><b>#user#</b></font> was exists in an group list"); 
########################## Team ###########################
  
//------------------------ ignore ---------------------------
  define("ChFun_ignore_Add", "User \"#user#\" was added to your ignore list.");
  define("ChFun_ignore_Del", "User \"#user#\" was deleted from your ignore list.");
  define("ChFun_ignore_All", "Your ignore all users from your private!");
  
  define("ERROR_IGNORE_FROM_MSG", "This user ignors your private messages.");
  define("ERROR_IGNORE_FROM_ALL_MSG", "This user ignors all private messages.");
  define("ERROR_IGNORE_TO_MSG", "You ignore this user.");
########################## ignore ###########################

//------------------------ wait ---------------------------
  define("ChFun_wait_Add", "User #user# was added to your waiting list");
  define("ChFun_wait_Del", "User #user# was deleted from your waiting list");
  define("ChFun_wait_exists", "User #user# was exists in your waiting list"); 
  define("ChFun_wait_not_exists", "User #user# was not exists in your waiting list to delete!");
########################## wait ###########################

//------------------------ jail -----------------------------
  define("ERROR_msg_jail", "Not allowed: Your nick is in the Jail List for 10 min(s)!");
  define("ERROR_msg_already_jail", "** Sorry, but Op <b>#user#</b> is already jailed.");
########################## jail #############################

//------------------------ all msg -----------------------------
  define("ChFun_allmsg", "<font color=\"blue\" face=\"Palatino Linotype\">Message to all chatter's :</font> <a style=\"text-decoration: none; color: #nickcolor#; font-family: #nickfont#\" onclick='parent.message(\"/msg #sender_name# \")'><b>#sender_name#</b><span style=\"visibility:hidden; font-size:xx-small\">i</span>(#rights#)<span style=\"visibility:hidden; font-size:xx-small\">i</span>:</a></b> <span style=\"color: #color#; font-family: #font#\">#text#</font>");
  define("ChFun_allmsg_ok", "*** all message has been sent to #count_sent#");
  define("ERROR_allmsg", "All message failed: No message detected to be sent!");
########################## all msg #############################

//------------------------ guest msg ----------------------------- 
  define("ChFun_guestmsg", "<font color=\"blue\" face=\"Palatino Linotype\">Message to all guest's :</font> <a style=\"text-decoration: none; color: #nickcolor#; font-family: #nickfont#\" onclick='parent.message(\"/msg #sender_name# \")'><b>#sender_name#</b><span style=\"visibility:hidden; font-size:xx-small\">i</span>(#rights#)<span style=\"visibility:hidden; font-size:xx-small\">i</span>:</a></b> <span style=\"color: #color#; font-family: #font#\">#text#</font>");
  define("ChFun_guestmsg_ok", "*** User message has been sent to #count_sent#");
  define("ERROR_guestmsg", "guest's message failed: No message detected to be sent!");
########################## guest msg #############################

//------------------------ operators msg ----------------------------- 
  define("ChFun_opmsg", "<font color=\"blue\" face=\"Palatino Linotype\">Message to all operator's :</font> <a style=\"text-decoration: none; color: #nickcolor#; font-family: #nickfont#\" onclick='parent.message(\"/msg #sender_name# \")'><b>#sender_name#</b><span style=\"visibility:hidden; font-size:xx-small\">i</span>(#rights#)<span style=\"visibility:hidden; font-size:xx-small\">i</span>:</a></b> <span style=\"color: #color#; font-family: #font#\">#text#</font>");
  define("ChFun_opmsg_ok", "*** operator's message has been sent to #count_sent#");
  define("ERROR_opmsg", "Operator's message failed: No message detected to be sent!");
########################## operators msg #############################

//------------------------ configroom -----------------------
  /* napis w select-ie ktory mowi ktory pokoj jest wybrany jako ten do ktorego uzytkownik zostanie zalogowany po starcei  */
  define("ChFun_croom_Default"," (Default)"); // mozna zmieniac
  /* Tekst pojawiajacy sie przy zmianie defaultowego pokoju */
  define("ChFun_croom_TxtNoRoomSelDef", "Select room witch should be set as default.");
  define("ChFun_croom_DefaultChanged", "Default room was changed.");
 
  /* informacja ze pokoj zostal usuniety */
  define("ChFun_croom_RoomDeleted", "Room deleted");
  define("ChFun_croom_TxtRc", "You didn't write category name.");
  define("ChFun_croom_TxtRn", "You didn't write room name.");
  define("ChFun_croom_TxtLRc", "Category name is too long. Max(#max_room_cat_name#)");  
  define("ChFun_croom_TxtLRn", "Room name is too long. Max(#max_room_name#)");  
  define("ChFun_croom_TxtExists", "Room with the name you typed allready exists. Please write different name.");
  define("ChFun_croom_RoomAdded", "Room changed.");
  define("ChFun_croom_TxtNoRoomSel", "Select room you want to delete.");
########################## configroom #######################
 
//------------------------ info -----------------------------
  define("ChFun_info_BadUserName", "User \"#user#\" doesn't exists.");
########################## info #############################
 
//------------------------ skin -----------------------------
  define("ChFun_skin_List", "#name# ");
  define("ChFun_skin_ListSep", ", ");
  define("ChFun_skin_UnParam" , "Unknown param \"#param#\"");
  define("ChFun_skin_CssChanged" , "Css changed to \"#css_name#\"");
  define("ChFun_skin_SkinChanged" , "Skin changed to \"#skin_name#\"");
  define("ChFun_skin_BadCss" , "Bad Css name");
  define("ChFun_skin_BadSkin" , "Bad Skin name");
########################## skin ############################
 
//------------------------ avatar --------------------------
  define("LTTpl_avatar_title", "Select avatara");
########################## avatar ##########################

//------------------------ configrooms ---------------------
  define("ChFun_configrooms_add", "Add room");
  define("ChFun_configrooms_cat_name", "Category name");
  define("ChFun_configrooms_room_name", "Room name");
  define("ChFun_configrooms_defined", "List of available rooms");
  define("ChFun_configrooms_submit", "Create room");
  define("ChFun_configrooms_delete", "Delete");
  define("ChFun_configrooms_default","Set as default");
########################## configrooms #####################

//------------------------ room ----------------------------
  define("ChFun_room_Changed", "Room changed to \"#room#\".");
  define("ChFun_room_BadName", "Bad Room Name");
########################## room ############################
 
############################################################
## COMMANDS
############################################################
 
////////////////////////////////////////////////////////////
// SHOUTBOX
////////////////////////////////////////////////////////////
  define("LTTpl_shoutbox_msg", "Message");
  define("LTTpl_shoutbox_nick", "Nick");
  define("LTTpl_shoutbox_submit", "Send");
############################################################
## SHOUTBOX
############################################################
 
// menu.tpl //////////////////////////////////////////////////
  define("ChMenuHelp","Help");
  define("ChMenuRules","Rules");
  define("ChMenuStatistics","Statistic data");
  define("ChMenuRegister","Register yourself");
  define("ChMenuLogin","Login");
##############################################################

// statistics.tpl
	 define("LTChat_statistics_rooms_txt","Rooms");
	 define("LTChat_statistics_online_txt","Users online");
	 define("LTChat_statistics_last_reg_txt","Last registered chatter");
	 define("LTChat_statistics_registered_txt","Registered users");
	 define("LTChat_statistics_prv_count_txt","Private messages count");
	 define("LTChat_statistics_msg_count_txt","Messages count");
	 define("LTChat_statistics_msg_sum","All messages count");
	 define("LTChat_statistics_nick_guest","Guest");


// registration_form.tpl
  define("LTTpl_user_added","User added."); 
  define("ChTPL_RegLogin", "User");
  define("ChTPL_RegPass", "Password");
  define("ChTPL_RegSub", "Send");
 
  define("ChTPL_RegErrLogTooShort", "The minimal number of signs required for login is #chars# .");
  define("ChTPL_RegErrPasTooShort", "The minimal number od signs required for password is #chars#.");
  define("ChTPL_RegErrUserBadNick", "Bad user name. You can use only signs: 0-9 a-Z and _.");
  define("ChTPL_RegErrUserExists", "This user allready exists.");
  define("ChTPL_RegErrFillAllFields", "Fill all required fields.");
  define("ChTPL_RegErrBadEmail", "Please enter a valid email address.");
  
//  command.tpl
  define("ChTPL_ENABLED", "Enabled");
  define("ChTPL_Disabled", "Disabled");

#####################
//  login_form.tpl
  define("ChTPL_LogLogin", "User");
  define("ChTPL_LogPass", "Password");
  define("ChTPL_LogSub", "Enter");
  define("ChTPL_LogGuest", "Guest login");
 
  define("ChFun_January", "January");
  define("ChFun_February", "February");
  define("ChFun_March", "March");
  define("ChFun_April", "April");
  define("ChFun_May", "May");
  define("ChFun_June", "June");
  define("ChFun_July", "July");
  define("ChFun_August", "August");
  define("ChFun_September", "September");
  define("ChFun_October", "October");
  define("ChFun_November", "November");
  define("ChFun_December", "December");
 
//flash command
  define("LTChatCOM_flash_desc","This command for show nice flash pice");

// komendy
  define("LTChatCOM_help_desc", "Displays help document.");
  define("LTChatCOM_help_param", "Command");
  define("LTChatCOM_fullhelp_desc", "Displays list of all available commands with informations about them.");
  define("LTChatCOM_bug_desc", "Send a bug report.");
  define("LTChatCOM_room_desc", "Changes the room.");
  define("LTChatCOM_room_param", "Room name");
  define("LTChatCOM_clear_desc", "Clears the current chat window.");
  define("LTChatCOM_ignore_desc_add", "Add a user to your ignore list. That user cannot send you private messages and you can not see messages they send.");
  define("LTChatCOM_ignore_desc_del", "Remove a user from your ignore list. That user can now send you private messages and you can see messages they send.");
  define("LTChatCOM_ignore_param", "Username");
  define("LTChatCOM_prv_desc", "Allows you to send private messages.");
  define("LTChatCOM_prv_param", "Username");
  define("LTChatCOM_removefriend_desc", "Removes a friend from your friend list.");
  define("LTChatCOM_removefriend_param", "Username");
  define("LTChatCOM_friend_desc_add", "Adds a friend from your friend list.");
  define("LTChatCOM_friend_desc_del", "Removes a friend from your friend list.");
  define("LTChatCOM_friend_desc_show", "Displays all users on your friend list.");
  define("LTChatCOM_url_desc", "Allows you to insert a URL into the chat.");
  define("LTChatCOM_url_param", "URL address");
  define("LTChatCOM_unignore_desc", "Remove a user from your ignore list. That user can now send you private messages and you can see messages they send.");
  define("LTChatCOM_unignore_param", "Username");
  define("LTChatCOM_kick_desc", "Kick a user from the system. You may specify an optional reason. This command can only be used by administrators or operators.");
  define("LTChatCOM_kick_param1", "Username");
  define("LTChatCOM_kick_param2", "Reason");
  define("LTChatCOM_mkick_desc", "Kick a all user's from the system with same pcip. You may specify an optional reason. This command can only be used by administrators or operators.");
  define("LTChatCOM_disable_desc", "This command used for disable an operator of using his power");
  define("LTChatCOM_ban_desc", "This command used for ban a specific user's IP OR IP directed only from entering the chat");
  define("LTChatCOM_sus_desc", "This command used for suspand a user from entering the chat");
  define("LTChatCOM_warn_desc", "This command used for send a warning message to a user in the public");
  define("LTChatCOM_jail_desc", "This command used for put that nick in the jail list");
  define("LTChatCOM_filter_desc", "This command used for filter that text or nick from the public");
  define("LTChatCOM_allmsg_desc", "This command used for send a private message to all chatters in the chat");
  define("LTChatCOM_usermsg_desc", "This command used for send a private message to all user(guest) in the chat");
  define("LTChatCOM_opmsg_desc", "This command used for send a private message to all opreator's only in the chat");
  define("LTChatCOM_me_desc", "Informations about user.");
  define("LTChatCOM_whoami_desc", "Displays user nick.");
  define("LTChatCOM_ping_param", "Host");
  define("LTChatCOM_ping_desc", "sending icmp_echo_request packages to network hosts.");
  define("LTChatCOM_logout_desc", "Chat exit with exit message");
  define("LTChatCOM_configrooms_desc", "Rooms configuration.");
  define("LTChatCOM_skin_desc_setskin", "Sets skin for the chat");
  define("LTChatCOM_skin_desc_showskins", "Shows a list of available skins");
  define("LTChatCOM_skin_desc_setcss", "Sets  css for the chat");
  define("LTChatCOM_skin_desc_showcss", "Shows a list of available css");
  define("LTChatCOM_skin_param1", "skin_name");
  define("LTChatCOM_skin_param2", "css_name");
  define("LTChatCOM_whois_desc", "Displays information about the specified user.");
  define("LTChatCOM_whois_param", "Username");
  define("LTChatCOM_emoticons_desc", "List of available  emoticons.");
  define("LTChatCOM_config_desc", "Chat variables configuration");
  define("LTChatCOM_avatar_desc", "Selection of avatar for user.");
  define("LTChatCOM_configreg_desc", "Registration fields configuration.");

// komendy  

  define(LTTpl_me_reg_text, "Registered since");
  define(LTTpl_me_last_seen_text, "Last seen");
  define(LTTpl_me_posted_msg_text, "Posted messages");
  define(LTTpl_me_last_host_text, "Last Host");
  define(LTTpl_me_last_ip_text, "Last IP");

  

/////////////// MODYFIKOWALNE ZMIENNE ///////////////////
  define("LTChart_CONF_PERFORMANCE","Performance");
  define("LTChart_CONF_OTHER","Other chat configuration");

  define("_DESC_LTChart_offline_user_after", "Information about the time limit for a user to be offline if he/she doesn't respond (seconds).");
  define("_DESC_LTChart_delete_offline_data", "Time after which information that a user is offline gets removed from the chart (seconds).");
  define("_DESC_ChRefreshAfter", "Time after which the page is refeshed (miliseconds).");
  define("_DESC_ChDK_max_msg_get", "Maximum amount of chat messages a user can receive");
  define("_DESC_ChDK_max_SB_msg_get", "Maximum amount of shoutboxa messages a user can receive");
  define("_DESC_ChDK_max_msg_time_back", "When entering a room the user will not receive messages older than (amount) seconds");
  define("_DESC_ChDK_max_msg_on_enter", "The amount of old messages for a user when entering a room");
  define("_DESC_ChDK_max_SB_msg_on_enter", "The amount of old messages for a user when entering a shoutboxa");
  define("_DESC_LTChatCore_user_min_login_chars", "Minimum number of signs allowed with login");
  define("_DESC_LTChatCore_user_min_password_chars", "Minimum number of signs allowed with password");
  define("_DESC_ChDK_delete_free_avatar_after", "User's avatar is deleted if the user doesn't log in longer than (seconds).");
  define("_DESC_ChDK_delete_guest_after", "Guest's account is deleted after (seconds).");
  define("_DESC_ChDK_delete_user_after", "User is deleted if he/she doesn't log in longer than (seconds).");
  define("_DESC_LTChatCore_guest_account", "Is log in to guest account allowed?");
  define("_DESC_LTChat_md5_passwords", "Encode password with the function md5");
?>