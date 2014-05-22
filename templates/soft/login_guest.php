<HTML>
<HEAD>
<title>#title#</title>
<meta http-equiv="content-type" content="text/html; charset=#PageEncoding#">


</HEAD>

<body style="background-color: #DFDFDF;">

<table align="center">
<form method="post" class="niceform">
<tr><td align="center">
<select size="1" name="room">
	<option value="1">Arabia</option>
</select>
</td></tr><br>
<tr><td align="center">
<input type="submit" value="Continue">
<input name="get_chat_view" type="hidden" value="1">
<input name="get_login" type="hidden" value="1"> 
<input name="uniq" type="hidden" value="<?=$_SESSION['SP_USER_NICK']?>" />
<input name="sid" type="hidden" value="<?=$this->sid?>" />
</td></tr>
</form>
</table>

</body>
</html>