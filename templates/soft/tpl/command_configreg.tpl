#header#
<table width="100%" height="100%">
<tr>
  <td align="center" valign="middle">
	<TABLE  cellspacing="0" cellpadding="0">
	<tr>
	<td>
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
	  <h2 align="center">#title#</h2><br>

	  <table border=1 align=center>#fields_desc##fields#</table>
			
<br><br>

<br>

<script>
  function ch_text(info)
  {
    element = document.getElementById("len");
	element.style.display = "block";

    element = document.getElementById("opt");
	element.style.display = "block";

	element = document.getElementById("len2");
	element.style.display = "block";

    element = document.getElementById("opt2");
	element.style.display = "block";

    if(info == 'radio' || info == 'select')
    {
      element = document.getElementById("len");
	  element.style.display = "none";

      element = document.getElementById("len2");
	  element.style.display = "none";
    }
    else
    {
      var element = document.getElementById("opt");	
	  element.style.display = "none";    
	  
      var element = document.getElementById("opt2");	
	  element.style.display = "none";    
    } 
  }

</script>
	  <h2 align="center">#add_text#</h2>
		  <form method='post'>
		  <table border=0 align=center>
		  	<tr>
		  	  <th>#field_name_text#</td>
		  	  <th>#items_text#</td>
		  	  <th>#required_text#</td>
		  	  <th><div id="len2">#length_text#</div><div id="opt2" style="display: none;">#options_text#</div></td>
		  	</tr>
		  	<tr>
		  	  <td><input type='text' name='#field_name#'></td>
		  	  <td><select name='#item_name#' onChange='ch_text(this.value);'>#items#</select></td>
		  	  <td align=center><input type='checkbox' name='#required_name#'></td>
		  	  <td><div id="len"><input type='text' name='#length_name#' style='width:100px'></div><div id="opt" style="display: none;"><input type='text' name='#options_name#' style='width:200px'></div></td>
		  	  <td><input type='submit' value='#submit#'></td>
		  	</tr>
		  </table>
		  </form>			
			
	  </td>
	</tr>
	<tr>
	  <td>
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