#header#

<STYLE>
	* { text-decoration: none;font-family: Verdana, Helvetica;  color:black; font-size:11px }
    a { text-decoration: underline; font-size:11px; font-family:Verdana;  }
	    a:hover {color: black; text-decoration: none; font-size:11px;   }
	like_hov {font-family:Verdana; text-decoration: none; color:#21536A; color:#21536A;}

	H2 {
		FONT-SIZE: 16px; BACKGROUND: none transparent scroll repeat 0% 0%; COLOR: #666666; FONT-FAMILY: Arial, Verdana, Helvetica, sans-serif; TEXT-DECORATION: none
		}
	.stars
	{
	  cursor:pointer;
	  cursor:hand;
	}
</STYLE>
	<script type="text/javascript" src="#LTChatTemplatePath#jscripts/contact/functionAddEvent.js"></script>
	<script type="text/javascript" src="#LTChatTemplatePath#jscripts/contact/contact.js"></script>
	<script type="text/javascript" src="#LTChatTemplatePath#jscripts/contact/xmlHttp.js"></script>


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
      
    <p id="loadBar" style="display:none;">
		<strong style="color:black;">Sending Email via AJAX. Hold on just a sec&#8230;</strong>
		<img src="#LTChatTemplatePath#img/loading.gif" alt="Loading..." title="Sending Email" />
	</p>
    
	<p id="emailSuccess" style="display:none;">
		<strong style="color:black;">Success! Your Email has been sent.</strong>
	</p>
      
	<div id="contactFormArea">
		<form action="scripts/contact.php" method="post" id="cForm">
			<fieldset>
				<label for="posName">Name:</label>
				<input class="text" type="text" size="25" name="posName" id="posName" />
				<label for="posEmail">Email:</label>
				<input class="text" type="text" size="25" name="posEmail" id="posEmail" />
				<label for="posRegard">Regarding:</label>
				<input class="text" type="text" size="25" name="posRegard" id="posRegard" />
				<label for="posText">Message:</label>
				<textarea cols="50" rows="5" name="posText" id="posText"></textarea>
				<label for="selfCC">
					<input type="checkbox" name="selfCC" id="selfCC" value="send" /> Send CC to self
				</label>
				<label>
					<input class="submit" type="submit" name="sendContactEmail" id="sendContactEmail" value=" Send Email " />
				</label>
			</fieldset>
		</form>
	</div>
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