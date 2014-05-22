#header#

<script>
  function s_default()
  {
    document.forms["ch_data"].type.value = "def";
    document.forms["ch_data"].submit();
  }
  function s_delete()
  {
    document.forms["ch_data"].type.value = "del";
    document.forms["ch_data"].submit();
  }
  
</script>
<head>
<meta http-equiv="content-type" content="text/html; charset=#PageEncoding#">
<title>#title#</title>
</head>
<body bgcolor="#71828A">

  			<TABLE border="0"  cellspacing="0" cellpadding="0" width="100%" height="100%">
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
			  <td bgcolor="White" style="padding-left:5px;padding-right:5px;border-right:1px #7A7B7B solid;">
				  <center><span style="color:red"> #info# </span></center>
				  <table cellpadding="3" align="center" border="0">
				  <tr>
				    <td valign="top">
					  <form method="POST">
					  <input type="hidden" value="add" name="type">
				      <b>#add_room_text#</b><br><br>
				      <b>#category_name_text#:</b><br>
					  <input type="text" name="rooom_cat"><br>
				      <b>#room_name_text#:</b><br>
					  <input type="text" name="rooom_name"><br><br>
				      <center><input type="submit" value="#submit#"></center>
					  </form>
				    </td>
				    <td valign="top">
					  <form method="POST" id="ch_data">
					  <input type="hidden" value="" name="type" id="type">
				      <b>#rooms_list_text#</b><br><br>
					  <select style="width:100%" name="selected_channel" size="15">#rooms_list#</select><br>
					  <center><a href="javascript:s_delete();">#delete_text#</a> | <a href="javascript:s_default();">#set_default_text#</a></center>
					  </form>
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