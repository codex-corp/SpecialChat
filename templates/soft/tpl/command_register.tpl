#header#

	<link rel="stylesheet" href="#LTChatTemplatePath#css/tab-view.css" type="text/css" media="screen">
	<script type="text/javascript" src="#LTChatTemplatePath#tab-view.js"></script>

<script type="text/javascript">
	function ifdisabled () {
     if ( document.getElementsByName("auto").length == 1 ) {	 
         disable ();
	}
}

function disable () { 
	if (document.forms[0].auto.checked == false )	{
		document.forms[0].password1.disabled = false;	
		document.forms[0].password2.disabled = false;	
		document.forms[0].password1.value = "";	
		document.forms[0].password2.value = "";	
	}else{	    
		document.forms[0].password1.disabled = true;	
		document.forms[0].password2.disabled = true;	
		document.forms[0].password1.value = "";	
		document.forms[0].password2.value = "";		
	}
	return;
}
</script>

<body onLoad="return ifdisabled();" bgcolor="#71828A">

  			<TABLE border="0" cellspacing="0" cellpadding="0" style="width:100%; height:100%">
			<tr>
			<td height="6px;">
			  <table width="100%" border="0" style='height:6px;' cellspacing="0"> 
			  <tr>
			    <td background="#LTChatTemplatePath#img/chat_box/lt.bmp" style='width:4px;'></td>
			    <td bgcolor="White" style=""></td>
			    <td background="#LTChatTemplatePath#img/chat_box/rt.bmp" style='width:5px;'></td>
			  </tr>
			  </table>
			</td>
			</tr>
			<tr>
			<td bgcolor="White" style="vertical-align:text-top;padding-left:5px;padding-right:5px;border-right:1px #7A7B7B solid;">
<div id="dhtmlgoodies_tabView1">

	<div class="dhtmlgoodies_aTab">
	<form method="POST">
    #info#
	<table>
		<tr>
			<td>Choose a username</td><td><input name="username"/></td>
		</tr>
		<tr>
			<td>First name</td><td><input name="firstname"/></td>
		</tr>
		<tr>
			<td>Email address</td><td><input name="emailaddress"/></td>
		</tr>
		<tr>
			<td>Choose a password</td><td><input name="password1" type="password"/></td>
		</tr>
		<tr>
			<td>Confirm password</td><td><input name="password2" type="password"/></td>
		</tr>
        <tr><td>Auto Password?</td><td><INPUT TYPE="checkbox" NAME="auto" value="yes" OnClick="return disable();"></td></tr>
		<tr>
			<td></td><td><input type="hidden" name="submitted" value="1"/><input type="submit" value="submit"/></td>
		</tr>
	</table>
	</form>
	</div>
    
	<div class="dhtmlgoodies_aTab">
#admin#
	</div>

</div>
<script type="text/javascript">
initTabs('dhtmlgoodies_tabView1',Array('Register','Admin'),0,500,'100%',Array(true,true,true,true));
</script>
</td>
			  </tr>
				  </table>
				  
			  </td>
			</tr>
			<tr>
			<td height="6px;">
			    <table width="100%" border="0" style='height:7px;' cellspacing="0"> 
			    <tr>
			      <td background="#LTChatTemplatePath#img/chat_box/lb.bmp"	style='width:5px;'></td>
			      <td bgcolor="White" style=""></td>
			      <td background="#LTChatTemplatePath#img/chat_box/rb.bmp" style='width:5px;'></td>
			    </tr>
			    </table>
			  </td>
			</tr>
			</TABLE>
#footer#