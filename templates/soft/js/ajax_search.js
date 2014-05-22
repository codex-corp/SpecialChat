/**
 *
 * @package SpecialChat
 * @programmer Hany alsamman ('hany.alsamman@gmail.com')
 * @version $Id$
 * @access private
 */
	subject_id = '';
	function handleHttpResponse() {
		if (http.readyState == 4) {
			if (subject_id != '') {
				document.getElementById(subject_id).innerHTML = http.responseText;
			}
		}
	}
	function getHTTPObject() {
		var xmlhttp;
		/*@cc_on
		@if (@_jscript_version >= 5)
			try {
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (E) {
					xmlhttp = false;
				}
			}
		@else
		xmlhttp = false;
		@end @*/
		if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
			try {
				xmlhttp = new XMLHttpRequest();
			} catch (e) {
				xmlhttp = false;
			}
		}
		return xmlhttp;
	}
	var http = getHTTPObject(); // We create the HTTP Object

	function getScriptPage(div_id,content_id)
	{
		
	 	var slash = /^\//;
		subject_id = div_id;
		content = document.getElementById(content_id).value;
		
		if( content.length > 1 && content.match(slash) ){
		
		uniq = document.getElementById('uniq').value;
		after = document.getElementById('after').value;
		sid = document.getElementById('sid').value;
		
		http.open("GET", "index.php?load_template=Y29tbWFuZF9teWNvbW1hbmQudHBs&uniq="+ escape(uniq) +"&after="+ escape(after) +"&sid=" + escape(sid) + "&command=" + escape(content), true);
		http.onreadystatechange = handleHttpResponse;
		http.send(null);
		
		box('1');
		
		}else{
		
		box('0');
		
		}

	}

	function highlight(action,id)
	{
	  if(action)	
		document.getElementById(id).bgColor = "#878787";
	  else
		document.getElementById(id).bgColor = "#F8F8F8";
	}
	function display(word)
	{
		document.getElementById('message').value = word;
		document.getElementById('box').style.display = 'none';
		document.getElementById('message').focus();
	}
	function box(act)
	{
	  if(act=='0')	
	  {
		document.getElementById('box').style.display = 'none';
	  }
	  else
		document.getElementById('box').style.display = 'block';
	}