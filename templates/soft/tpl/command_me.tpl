#header#
<style type="text/css">
/* Used in some of the example templates below. */
.tipClass {
	font: 12px Arial, Helvetica;
	color: black;
	font-weight: bold;
}
.table1 {
	font: 12px Arial;
	color: black;
	font-weight: bold;
}
.table2 {
	font: 12px Arial;
	color: blue;
}
/* Format links inside tips a little, feel free to remove this. */
.tipClass A {
	text-decoration: none;
	color: black;
}
</style>
<script language="Javascript" src="#TemplatePath#js/ColorPicker.js"></script>
<script language="Javascript" src="#TemplatePath#js/tipster.js"></script>
<script type="text/javascript"><!--
// Here's one illustrating a decimal tipStick value so it floats along behind the cursor.
var stickyTip = new TipObj('stickyTip');
with (stickyTip)
{
 template = '<table bgcolor="#FFFFFF" cellpadding="1" cellspacing="0" width="%6%" border="1">' +
  '<tr><td><table bgcolor="#cccccc" cellpadding="4" cellspacing="0" width="100%" border="0">' +
  '<tr><td align="center" class="tipClass">%3%</td></tr></table></td></tr></table>';

  tips.nickcolor = new Array(5, 5, 100, 'Select your nickname color from change link!');
  tips.color = new Array(5, 5, 100, 'Select your typing color from change link!');
  tips.font = new Array(5, 5, 100, 'Select your typing font from scrool change!');
  tips.nickfont = new Array(5, 5, 100, 'Select your typing nickname font from scrool change!');

 tipStick = 0.2;
}
//--></script>
<script language="JavaScript">
var cp = new ColorPicker('window'); // Popup window
var cp2 = new ColorPicker(); // DIV style
</script>
<script type="text/javascript">

function insert_font(font)
{
document.getElementById('font').value = ""+font+"";
overlayclose('fontlayer'); return false;
}

function insert_nick_font(nickfont)
{
document.getElementById('nickfont').value = ""+nickfont+"";
overlayclose('nickfontlayer'); return false;
}

function getposOffset(overlay, offsettype){
var totaloffset=(offsettype=="left")? overlay.offsetLeft : overlay.offsetTop;
var parentEl=overlay.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}

function overlay(curobj, subobjstr, opt_position){
if (document.getElementById){
var subobj=document.getElementById(subobjstr)
subobj.style.display=(subobj.style.display!="block")? "block" : "none"
var xpos=getposOffset(curobj, "left")+((typeof opt_position!="undefined" && opt_position.indexOf("right")!=-1)? -(subobj.offsetWidth-curobj.offsetWidth) : 0) 
var ypos=getposOffset(curobj, "top")+((typeof opt_position!="undefined" && opt_position.indexOf("bottom")!=-1)? curobj.offsetHeight : 0)
subobj.style.left=xpos+"px"
subobj.style.top=ypos+"px"
return false
}
else
return true
}

function overlayclose(subobj){
document.getElementById(subobj).style.display="none"
}

</script>
<div id="stickyTipLayer" style="position: absolute; z-index: 10000; visibility: hidden; left: 0px; top: 0px; width: 10px"></div>

<div id="fontlayer" style="position: absolute; display: none; border: 1px solid black; background-color: white; width: 120px; padding: 8px">
	<table style="width: 120px; height: 171px;">
		<font face="antiqua" color="#000000">
		<a onclick="javascript:insert_font('Book Antiqua')">#login#</a></font></td></tr>
		<tr>
			<td><font color="#000000" face="Georgia">
			<a onclick="javascript:insert_font('Georgia')">#login#</a></font></td>
		</tr>
		<tr>
			<td><font color="#000000" face="Lucida Bright">
			<a onclick="javascript:insert_font('Lucida Bright')">#login#</a></font></td>
		</tr>
		<tr>
			<td><font color="#000000" face="Comic Sans MS">
			<a onclick="javascript:insert_font('Comic Sans MS')">#login#</a></font></td>
		</tr>
		<tr>
			<td><font color="#000000" face="Roman">
			<a onclick="javascript:insert_font('Roman')">#login#</a></font></td>
		</tr>
		<tr>
			<td><font color="#000000" face="Terminal">
			<a onclick="javascript:insert_font('Terminal')">#login#</a></font></td>
		</tr>
		<tr>
			<td><font color="#000000" face="Verdana">
			<a onclick="javascript:insert_font('Verdana')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Palatino Linotype">
			<a onclick="javascript:insert_font('Palatino Linotype')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Arial">
			<a onclick="javascript:insert_font('Arial')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Arial Black">
			<a onclick="javascript:insert_font('Arial Black')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Symbol">
			<a onclick="javascript:insert_font('Symbol')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Tahoma">
			<a onclick="javascript:insert_font('Tahoma')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Century Gothic">
			<a onclick="javascript:insert_font('Century Gothic')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Vrinda">
			<a onclick="javascript:insert_font('Vrinda')">#login#</a></font></td>
		</tr>
	</table>
	<div align="right">
		<font face="arial" size="2">
		<a href="#" onclick="overlayclose('fontlayer'); return false">Close Box</a></font></div>
</div>
<div id="nickfontlayer" style="position: absolute; display: none; border: 1px solid black; background-color: white; width: 120px; padding: 8px">
	
	<table style="width: 120px; height: 171px;">
		<font face="antiqua" color="#000000">
		<a onclick="javascript:insert_nick_font('Book Antiqua')">#login#</a></font></td></tr>
		<tr>
			<td><font color="#000000" face="Georgia">
			<a onclick="javascript:insert_nick_font('Georgia')">#login#</a></font></td>
		</tr>
		<tr>
			<td><font color="#000000" face="Lucida Bright">
			<a onclick="javascript:insert_nick_font('Lucida Bright')">#login#</a></font></td>
		</tr>
		<tr>
			<td><font color="#000000" face="Comic Sans MS">
			<a onclick="javascript:insert_nick_font('Comic Sans MS')">#login#</a></font></td>
		</tr>
		<tr>
			<td><font color="#000000" face="Roman">
			<a onclick="javascript:insert_nick_font('Roman')">#login#</a></font></td>
		</tr>
		<tr>
			<td><font color="#000000" face="Terminal">
			<a onclick="javascript:insert_nick_font('Terminal')">#login#</a></font></td>
		</tr>
		<tr>
			<td><font color="#000000" face="Verdana">
			<a onclick="javascript:insert_nick_font('Verdana')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Palatino Linotype">
			<a onclick="javascript:insert_nick_font('Palatino Linotype')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Arial">
			<a onclick="javascript:insert_nick_font('Arial')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Arial Black">
			<a onclick="javascript:insert_nick_font('Arial Black')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Symbol">
			<a onclick="javascript:insert_nick_font('Symbol')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Tahoma">
			<a onclick="javascript:insert_nick_font('Tahoma')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Century Gothic">
			<a onclick="javascript:insert_nick_font('Century Gothic')">#login#</a></font></td>
		</tr>
		<tr>
			<td width="111"><font color="#000000" face="Vrinda">
			<a onclick="javascript:insert_nick_font('Vrinda')">#login#</a></font></td>
		</tr>
	</table>
	<div align="right">
		<font face="arial" size="2">
		<a href="#" onclick="overlayclose('nickfontlayer'); return false">Close Box</a></font></div>
	</div>
	
<table style="width: 100%">
<tr>
				<td bgcolor="White" style="padding-left: 5px; padding-right: 5px; border-right: 1px #7A7B7B solid;">

				<form method="POST">
					<table width="100%">
						<tr>
							<td align="center" valign="middle">
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="120">
								<tr valign="bottom">
									<td align="center" background="#TemplatePath#/img/av_img/top.gif" height="25" style="color: red;">#login#</td>
								</tr>
								<tr align="center" valign="middle">
									<td background="#TemplatePath#/img/av_img/bottom.gif" height="102">
									<img border="0" src="#TemplatePath#img/nophoto.gif"></td>
								</tr>
							</table>
							</td>
							<td>
							<table class="table1">
								<tr>
									<td valign="top">#registration_text#:</td>
									<td>#registration_date#</td>
								</tr>
								<tr>
									<td valign="top">#posted_msg_text#:</td>
									<td>#posted_msg_value#</td>
								</tr>
								<tr>
									<td valign="top">#last_seen_text#:</td>
									<td>#last_seen_value#</td>
								</tr>
								<tr>
									<td valign="top">#last_host_text#:</td>
									<td>#last_host_value#</td>
								</tr>
								<tr>
									<td valign="top">#last_ip_text#:</td>
									<td>#last_ip_value#</td>
								</tr>
								<tr>
									<td valign="top"><strong>Color Type:</strong></td>
									<td>
									<input name="color" onmouseout="stickyTip.hide()" onmouseover="stickyTip.show('color')" value="#colorvalue#"><font face="arial" size="2"><a id="pick2" href="#" name="pick2" onclick="cp2.select(document.forms[0].color,'pick2');return false;">Change</a></font>
									<script language="JavaScript">cp.writeDiv()</script>
									</td>
								</tr>
								<tr>
									<td valign="top"><strong>Nick Color:</strong></td>
									<td>
									<input name="nickcolor" onmouseout="stickyTip.hide()" onmouseover="stickyTip.show('nickcolor')" value="#nickcolorvalue#"><font face="arial" size="2"><a id="pick" href="#" name="pick" onclick="cp2.select(document.forms[0].nickcolor,'pick2');return false;">Change</a></font>
									<script language="JavaScript">cp.writeDiv()</script>
									</td>
								</tr>
								<tr>
									<td valign="top"><strong>Font Type:</strong></td>
									<td>
									<input id="font" name="font" onmouseout="stickyTip.hide()" onmouseover="stickyTip.show('font')" value="#fontvalue#"><font face="arial" size="2"><a onclick="return overlay(this, 'fontlayer')">Show 
									Content</a></font></td>
								</tr>
								<tr>
									<td valign="top"><strong>Nick Font:</strong></td>
									<td>
									<input id="nickfont" name="nickfont" onmouseout="stickyTip.hide()" onmouseover="stickyTip.show('nickfont')" value="#nickfontvalue#"><font face="arial" size="2"><a onclick="return overlay(this, 'nickfontlayer')">Show 
									Content</a></font></td>
								</tr>
							</table>
							</td>
						</tr>
						#submit#
					</table>
				</form>
				</td>
			</tr>
</table>

#footer#