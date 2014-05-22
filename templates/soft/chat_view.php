<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=windows-1256" http-equiv="Content-Type" />
<meta content="ar-sy" http-equiv="Content-Language" />
<title><?= CHAT_TITLE .' -- '. $_SESSION['SP_USER_NICK'] ?></title>

<link href="templates/soft/css/global.css" rel="stylesheet" type="text/css" />
<link href="templates/soft/css/style.css" rel="stylesheet" type="text/css" />
<link href="templates/soft/css/layout.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" type="text/javascript" src="templates/soft/js/functions.js"></script>

<script type="text/javascript" src="templates/soft/js/ajax_search.js"></script>

</head>

<body onunload="document.getElementById('post').disabled=false;" onload="myfocus()" bgcolor="#FFFFFF">

<div id="sexyBG"></div><div id="sexyBOX" onmousedown="document.onclick=function(){};" onmouseup="setTimeout('sexyTOG()',1);"></div> 

<div id='user_list' style='position: absolute; margin-top:38px; visibility:hidden; width:15%; right:0; border:solid 1px #808080;'>

<table border='0' cellspacing='0' cellpadding='0' style='width:100%; height:100%;'><tr><td bgcolor='#71828A'><img alt='close this internal window' style='margin-left:10px;' src='./templates/standard/img/close.gif' onclick='hide_user_list(); return false' width='24' height='24' /></td></tr></table>

<div style="background-color:#FFFFFF;" id='user_list_data'>#users_online_list#</div>

</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <form name='myform' method="post" action="index.php" onsubmit="return disableForm(this);">

<table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td class="shadow_left"></td>
		<td class="menu">
		
		<table cellpadding="0" cellspacing="0" style="width: 98%" align="center">
			<tr>
				<td style="width: 68%">Welcome: <span class="orange_text"><?=$_SESSION['SP_USER_NICK']?></span>
				<span style="font-family:Calibri; font-size:12px;">
				( 
				Flash | 
				Messenger |
				<a href="javascript:void(0);" onclick="javascript:popupusersetails('./emoticons/default.htm', '650', '500');"> Images </a> |
				<a href="javascript:show_user_list()"> Show user list </a>| Rules | ToolBar | 
				<a href="#" onclick="return logout()">Logout</a> )
					</span>
				</td>
				<td style="width: 50%; text-align: right"><span class="online">Check your cmail:</span> you have 1 new message</td>
			</tr>
		</table>
 </td>
		<td class="shadow_right"></td>
	</tr>
	<tr>
		<td class="c_footer_left" style="height: 6px"></td>
		<td class="footer_bg" style="height: 6px"></td>
		<td class="c_footer_right" style="height: 6px"></td>
	</tr>
	</table>


  <tr>
    <td><?=$my_commands['PUBLIC_MSG']?></td>
  </tr>
  
  <tr>
    <td align="left" id="do_error">
	<?php
	print $my_actions['ERRRO_MSG']; 
	print $my_commands['WHAT']['ERRRO_MSG'];
	?></td>
  </tr>
  
  <tr>
    <td id="private">
	<?=$checkall?>
	<?=$my_private?>
	</td>
  </tr>
  
  <tr><td>

<div id="ajax-div">

<div class="input-div">

<input type="text" autocomplete="off" name="message" id="message" size="100%" maxlength="180"  onkeyup="getScriptPage('box','message'); document.getElementById('post').value = this.value == '' ? 'REFRESH' : 'POST/RELOAD';" onselect="isTextArea=1;" />

<input type="submit" id="post" value="REFRESH" name="post" />

</div>

<div id="box"></div>

	<select name="userlist" onchange="document.myform.message.value=form.userlist.options[form.userlist.selectedIndex].value;">
	<option value="">Room</option>
	<option value="/room Syria">Syria</option>
	</select>
	
	<select name="color" onchange="document.myform.message.value=form.color.options[form.color.selectedIndex].value;">
	<option value="">Mode</option>
	<option value="/away">Away</option>
	</select>
    
	<select id="list" name="list" onchange="document.myform.message.value=form.list.options[form.list.selectedIndex].value;">
	<option value="/list">List</option>
    <?=$my_list?>
	</select>
    
	<img onclick="boldup();" id="boldpic" src="templates/soft/pix/editor_bold_off.gif" />
	<img onclick="underlup();" id="underlinepic" src="templates/soft/pix/underline_off.gif" />
	<img onclick="italicup();" id="italicpic" src="templates/soft/pix/italic_off.gif" />

</div>

 <p align="center" style="font-size:8pt" class="footer">Copyright 2004-2009 <b>Special Version</b> &copy; <b>2.0</b> Stable RC1 , All Rights Reserved<br> Programming and Designing  by <a href="http://codexc.com" target="_blank"><b>Codexc.com</b></a></p>
 
 <input type="hidden" name="room" value="<?=$this->room?>" />
 <input type="hidden" name="datatype" value="all_data" />
 <input type="hidden" name="counter" value="<?php $c = ($_POST['counter'] < 20) ? $_POST['counter']+1: 1; print $c?>" />
 <input name="get_chat_view" type="hidden" value="1" />
 <input id="uniq" name="uniq" type="hidden" value="<?=$_SESSION['SP_USER_NICK']?>" />
 <input id="sid" name="sid" type="hidden" value="<?=$this->sid?>" />
 <input id="after" name="after" type="hidden" value="<?=sha1(base64_encode($_SESSION['SP_USER_NICK']))?>" />

 
 </td></tr>
 
 </form>
 </td>
 </tr>
 <?  print $my_commands['WHAT']['OTHER_METHOD'] ?>
 </table>

</body>
</html>