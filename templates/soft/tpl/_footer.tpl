<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    
	<form name='myform' method="post" action="./" onsubmit="return disableForm(this);">
	
	<tr>
	<td>

<input type="text" name="message" id="myMSG" size="100%" maxlength="180"  onkeyup="document.getElementById('post').value = this.value == '' ? 'REFRESH' : 'POST/RELOAD';" onselect="isTextArea=1;" />&nbsp;

<input type="submit" id="post" value="REFRESH" name="post" />

<br>
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
 
 </td></tr>
 <td>
 <input type="hidden" name="datatype" value="all_data" />
 <input type="hidden" name="counter" value="#counter#" />
 <input name="get_chat_view" type="hidden" value="1" />
 <input name="uniq" type="hidden" value="#uniq#" />
 <input name="sid" type="hidden" value="#sid#" />
 </form>
</td></tr></table>