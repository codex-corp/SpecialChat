<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Special Chat</title>
<meta content="text/html; charset=windows-1256" http-equiv="Content-Type" />
<meta content="NO-CACHE" http-equiv="CACHE-CONTROL" />
<meta content="NO-CACHE" http-equiv="PRAGMA" />
<link href="templates/soft/css/layout.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="templates/soft/js/niceforms.js" type="text/javascript"></script>
<link href="templates/soft/css/niceforms.css" media="all" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#FFFFFF" style="margin: 0; font-family:Calibri; font-size:12px; background-image: url('templates/soft/images/index.jpg');">

<?php
if($my_actions['COMMANDS_CODE'] == true){
print $my_actions['COMMANDS_CODE'];
}
if( !empty($errors[0]['error']) && !empty($errors[0]['reason']) ) {
print $errors[0]['error'].$errors[0]['reason'];
}
?>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="832">
	<tr>
		<td class="shadow_left"></td>
		<td class="menu">
		<table cellpadding="0" cellspacing="0" style="width: 100%">
			<tr>
				<td class="center"><a href="index.html">Home</a> |
				<a href="cpanel.php">Control Panel</a> | <a href="signup.php">Sign Up</a> | <a href="signup.php"></a><a href="forums.dandanh.com">Forums</a>
				</td>
				<td class="center">
				<div class="div" style="left: 400px; top: 0; width: 467px; height: 14px">
					<span class="online">On Line Now!</span> <span>GMR | MR_One_Love | Sweet | Moon | Raul | Spider | Tony | 3li | SoSO</span>
				</div>
				</td>
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
<table align="center" border="0" cellpadding="0" cellspacing="0" width="832">
	<tr>
		<td class="c_top_left"></td>
		<td class="top_bg"></td>
		<td class="c_top_right"></td>
	</tr>
	<tr>
		<td class="shadow_left"></td>
		<td class="login">
		<table cellpadding="0" cellspacing="0" style="width: 100%">
			<tr>
				<td style="width: 25%" valign="top">
				<table align="center" cellpadding="0" cellspacing="0" style="width: 90%; height: 201px; float: right; margin-top: 15px">
					<tr>
						<td class="blue_hr" colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td class="blog_right" style="width: 1%; height: 201px">&nbsp;</td>
						<td style="width: 98%">
						<form action="./" class="niceform" method="post">
							<table align="center" cellpadding="0" cellspacing="0" style="width: 95%">
								<tr>
									<td class="h_blue" colspan="3">Users Login</td>
								</tr>
								<tr>
									<td class="blog_info" colspan="3">Welcome and 
									we hope to enjoy, have fun and pls read our
									<a href="rules.php">rules</a> ! please feel 
									welcome in our small and great community, if 
									you like us you can ask for a membership by
									<a href="Signup.php">Signup</a> ! </td>
								</tr>
								<tr>
									<td colspan="3" style="height: 35px">
									<label for="username">User name:</label><br />
									<input maxlength="15" name="user_name" size="19" type="text" /></td>
								</tr>
								<tr>
									<td style="width: 68px">
									<select name="room" size="1">
									<option value="1">Arabia</option>
									</select></td>
									<td style="width: 8px">
									<img alt="" height="6" src="templates/soft/images/bl_ar.png" width="4" /></td>
									<td class="blog_info_small" style="width: 110px">
									Please Chose your favorite room</td>
								</tr>
								<tr>
									<td style="width: 68px">
									<input id="submit" name="submit" type="submit" value="Login" /></td>
									<td style="width: 8px">
									<img alt="" height="6" src="templates/soft/images/bl_ar.png" width="4" /></td>
									<td class="blog_info_small" style="width: 110px">
									and here we Go !Enjoy :)</td>
								</tr>
								<input name="guest" type="hidden" value="1" />
								<input name="get_login" type="hidden" value="1" />
								<input name="interface" type="hidden" value="1" />
								<input name="sid" type="hidden" value="1" />
								<input name="user_password" type="hidden" value="1" />
							</table>
						</form>
						</td>
						<td class="blog_right" style="width: 1%; height: 201px">&nbsp;</td>
					</tr>
				</table>
				<table align="center" cellpadding="0" cellspacing="0" style="width: 90%; height: 201px; float: right; margin-top: 40px">
					<tr>
						<td class="blue_hr" colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td class="blog_right" style="width: 1%; height: 201px">&nbsp;</td>
						<td style="width: 98%" valign="top">
						<table align="center" cellpadding="0" cellspacing="0" style="width: 95%">
							<tr>
								<td class="h_blue" colspan="2">Last members</td>
							</tr>
							<tr>
								<td class="blog_info" colspan="2">&nbsp;So ! you&#39;re 
								member here ! we all Glad to see you again ..</td>
							</tr>
							<tr>
								<td class="center" style="width: 12px">
								<img alt="" height="6" src="templates/soft/images/bl_ar.png" width="4" /></td>
								<td class="orange_text" style="font-size: 14px; width: 110px">Please 
								Chose your </td>
							</tr>
							<tr>
								<td class="center" style="width: 12px">
								<img alt="" height="6" src="templates/soft/images/bl_ar.png" width="4" /></td>
								<td class="orange_text" style="font-size: 14px; width: 110px">Please 
								Chose your </td>
							</tr>
							<tr>
								<td class="center" style="width: 12px">
								<img alt="" height="6" src="templates/soft/images/bl_ar.png" width="4" /></td>
								<td class="orange_text" style="font-size: 14px; width: 110px">Please 
								Chose your </td>
							</tr>
							<tr>
								<td class="center" style="width: 12px">
								<img alt="" height="6" src="templates/soft/images/bl_ar.png" width="4" /></td>
								<td class="orange_text" style="font-size: 14px; width: 110px">Please 
								Chose your </td>
							</tr>
							<tr>
								<td class="center" style="width: 12px">
								<img alt="" height="6" src="templates/soft/images/bl_ar.png" width="4" /></td>
								<td class="orange_text" style="font-size: 14px; width: 110px">Please 
								Chose your </td>
							</tr>
						</table>
						</td>
						<td class="blog_right" style="width: 1%; height: 201px">&nbsp;</td>
					</tr>
				</table>
				</td>
				<td class="dancers" style="width: 50%; height: 200px;">
				<object id="flash1" data="templates/soft/images/special.swf" style="height: 150px" type="application/x-shockwave-flash" width="200">
					<param name="movie" value="templates/soft/images/special.swf" />
					<param name="quality" value="High" />
					<param name="menu" value="false" />
					<param name="wmode" value="transparent" />
				</object>
				</td>
				<td style="width: 25%" valign="top">
				<table align="center" cellpadding="0" cellspacing="0" style="width: 90%; height: 201px; float: left; margin-top: 15px">
					<tr>
						<td class="blue_hr" colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td class="blog_right" style="width: 1%; height: 201px">&nbsp;</td>
						<td style="width: 98%">
						<form action="./" class="niceform" method="post">
							<table align="center" cellpadding="0" cellspacing="0" style="width: 95%">
								<tr>
									<td class="h_orange" colspan="3">Members Login</td>
								</tr>
								<tr>
									<td class="blog_info" colspan="3">Welcome and 
									we hope to enjoy, have fun and pls read our
									<a href="rules.php">rules</a> ! please feel 
									welcome in our small and great community, if 
									you like us you can ask for a membership by
									<a href="Signup.php">Signup</a> ! </td>
								</tr>
								<tr>
									<td colspan="3" style="height: 35px">
									<label for="username">User name:</label><br />
									<input maxlength="15" name="user_name" size="19" type="text" /></td>
								</tr>
								<tr>
									<td colspan="3" style="height: 35px">
									<label for="password">Password:</label><br />
									<input maxlength="15" name="user_password" size="19" type="password" /></td>
								</tr>
								<tr>
									<td style="width: 68px">
									<select name="room" size="1">
									<option value="1">Arabia</option>
									</select></td>
									<td style="width: 8px">
									<img alt="" height="6" src="templates/soft/images/or_ar.png" width="4" /></td>
									<td class="blog_info_small" style="width: 110px">
									Please Chose your favorite room</td>
								</tr>
								<tr>
									<td style="width: 68px">
									<input name="member_send" type="submit" value="Login" /></td>
									<td style="width: 8px">
									<img alt="" height="6" src="templates/soft/images/or_ar.png" width="4" /></td>
									<td class="blog_info_small" style="width: 110px">
									and here we Go !Enjoy :)</td>
								</tr>
								<input name="get_login" type="hidden" value="1" />
								<input name="interface" type="hidden" value="1" />
								<input name="sid" type="hidden" value="1" />
							</table>
						</form>
						</td>
						<td class="blog_right" style="width: 1%; height: 201px">&nbsp;</td>
					</tr>
				</table>
				<table align="center" cellpadding="0" cellspacing="0" style="width: 90%; height: 201px; float: left; margin-top: 6px">
					<tr>
						<td class="blue_hr" colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td class="blog_right" style="width: 1%; height: 201px">&nbsp;</td>
						<td style="width: 98%" valign="top">
						<table align="center" cellpadding="0" cellspacing="0" style="width: 95%">
							<tr>
								<td class="h_orange" colspan="2">Active members</td>
							</tr>
							<tr>
								<td class="blog_info" colspan="2">&nbsp;So ! you&#39;re 
								member here ! we all Glad to see you again ..</td>
							</tr>
							<tr>
								<td class="center" style="width: 12px">
								<img alt="" height="6" src="templates/soft/images/or_ar.png" width="4" /></td>
								<td class="blue_text" style="font-size: 14px; width: 110px">
								Please Chose your </td>
							</tr>
							<tr>
								<td class="center" style="width: 12px">
								<img alt="" height="6" src="templates/soft/images/or_ar.png" width="4" /></td>
								<td class="blue_text" style="font-size: 14px; width: 110px">
								Please Chose your </td>
							</tr>
							<tr>
								<td class="center" style="width: 12px">
								<img alt="" height="6" src="templates/soft/images/or_ar.png" width="4" /></td>
								<td class="blue_text" style="font-size: 14px; width: 110px">
								Please Chose your </td>
							</tr>
							<tr>
								<td class="center" style="width: 12px">
								<img alt="" height="6" src="templates/soft/images/or_ar.png" width="4" /></td>
								<td class="blue_text" style="font-size: 14px; width: 110px">
								Please Chose your </td>
							</tr>
							<tr>
								<td class="center" style="width: 12px">
								<img alt="" height="6" src="templates/soft/images/or_ar.png" width="4" /></td>
								<td class="blue_text" style="font-size: 14px; width: 110px">
								Please Chose your </td>
							</tr>
						</table>
						</td>
						<td class="blog_right" style="width: 1%; height: 201px">&nbsp;</td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="height: 20px;" valign="top">&nbsp;</td>
			</tr>
		</table>
		</td>
		<td class="shadow_right"></td>
	</tr>
	<tr>
		<td class="c_footer_left"></td>
		<td class="footer_bg"></td>
		<td class="c_footer_right"></td>
	</tr>
</table>
<table align="center" cellpadding="0" cellspacing="0" style="width: 832px">
	<tr>
		<td class="footer">Copyright � 2004-2009 | SpecialChat.net | All Rights 
		Reserved. Intellectual Property Rights Policy</td>
	</tr>
</table>

</body>

</html>
