#header#
<script type='text/javascript'>
function formValidator(){
	// Make quick references to our fields
	var username = document.getElementById('create');
	var email = document.getElementById('email');
	var password = document.getElementById('password');
	
	// Check each input in the order that it appears in the form!
					if(lengthRestriction(username, 1, 20)){
					if(lengthRestriction(password, 1, 20)){
						if(emailValidator(email, "Please enter a valid email address")){
							return true;
						}
					  }	
					}
	
	return false;	
}

function lengthRestriction(elem, min, max){
	var uInput = elem.value;
	if(uInput.length >= min && uInput.length <= max){
		return true;
	}else{
		alert("Please enter between " +min+ " and " +max+ " characters");
		elem.focus();
		return false;
	}
}

function emailValidator(elem, helperMsg){
	var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){
		return true;
	}else{
		alert(helperMsg);
		//elem.focus();
		return false;
	}
}

function isEmpty(elem, helperMsg){
	if(elem.value.length == 0){
		alert(helperMsg);
		elem.focus();
		return true;
	}
	return false;
}
</script>
  
	<TABLE  cellspacing="0" cellpadding="0">

	<tr>
	  <td bgcolor="White" style="padding-left:5px;padding-right:5px">
		    <h1 align="center">#title#</h1>
			<FORM method="POST">
			<span style="color:red;">#info#</span>
			<TABLE align="center">
			  <tr>
			    <td><b>#required# #login#</b></td>
			    <td><INPUT type="text" value="#post_login#" name="create"></td>
			  </tr>
			  <tr>
			    <td>#required# #pass#</td>
			    <td><INPUT type="password" value="" name="password"></td>
			  </tr>
			  <tr>
			    <td>#required# Level Select</td>
			    <td>
				#level_select#
				</td>
			  </tr>
			  <tr>
			    <td>#required# Email</td>
			    <td>
                <INPUT name="email" value="" type="text">
				</td>
			  </tr>
			  <tr>
              <input name="apply" type="hidden" value="1">
			   <td colspan="2" align="center"><INPUT type="submit" value="#submit#" ><br><br>#required_desc#</td>
			  </tr>
			</TABLE>
			</FORM>
	  </td>
	</tr>

	</TABLE>
<br>	
  </td>
</tr>
</table>

#footer#
