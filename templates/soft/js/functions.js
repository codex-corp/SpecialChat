/*

  (c) 2006-2007 Hany alsamman. All Rights Reserved

*/

	function _el(t){var i = document.getElementById(t);return i;}
	function $(v) { return(document.getElementById(v)); }
	function $S(v) { return($(v).style); }
	function agent(v) { return(Math.max(navigator.userAgent.toLowerCase().indexOf(v),0)); }
	function isset(v) { return((typeof(v)=='undefined' || v.length==0)?false:true); }
	function XYwin(v) { var z=agent('msie')?Array(document.body.clientHeight,document.body.clientWidth):Array(window.innerHeight,window.innerWidth); return(isset(v)?z[v]:z); }

	function CheckAll()
	{
	var checkboxIndex = 0;
	var inputFields = document.getElementById("private").getElementsByTagName("input");
	 for (var inputIndex=0;inputIndex<inputFields.length;inputIndex++)
	   {
		if (inputFields[inputIndex].className.indexOf("cbStyled")) 
		{
			if (inputFields[inputIndex].getAttribute("type")!=null){
			var styleType=inputFields[inputIndex].getAttribute("type");
			}	
			 var stylename=inputFields[inputIndex].getAttribute("name");
			 if(styleType == "checkbox" && stylename != 'allbox'){
			   if (!inputFields[inputIndex].checked){
				  inputFields[inputIndex].checked = true;
			   }else{
					inputFields[inputIndex].checked = false;
			   }
			 }
			checkboxIndex++;
		}
	   }
	}


   function message(msg)
   {
	 document.getElementById('message').value = ""+msg+"";
   }
   
	function disableForm(theform) {
		if (document.getElementById) {
				var tempobj = document.getElementById('post');
				if (tempobj.type == "submit") tempobj.disabled = true;
		}
	} 
   
   function logout()
   {

	body_self = document.getElementsByTagName('html');
	body_self[0].style.filter = "progid:DXImageTransform.Microsoft.BasicImage(grayscale=1)";
	if (confirm('Are you sure that you want to logout ?'))
	{
		parent.message('/quit');
		document.myform.submit();
	}
	else
	{
		body_self[0].style.filter = '';
		return false;
	}
     
   }
   
   function myfocus(){
   	if(document.forms['myform'].name == 'myform') return document.forms['myform'].message.focus();   	
   }
   
   function do_logout()
   {
 	var cont_put = _el('ajax-div'); 
 	cont_put.innerHTML = '';
		if (confirm('Do you want login again?'))
		{
			window.location.href = "index.php";
		}
		else
		{
			window.close();
		}
   }

   function show_user_list()
   {
	var user_list = document.getElementById('user_list');
	user_list.style.visibility = "visible";
   }
   
   function hide_user_list()
   {
	var user_list = document.getElementById('user_list');
	user_list.style.visibility = "hidden";
   }

   function remove_element(element)
   {
	 var el = document.getElementById(element);
	 el.parentNode.removeChild(el);
   }

	function popupusersetails(URLStr,width, height) {
	var dynamwin=0;
	  if(dynamwin){
		if(!dynamwin.closed) dynamwin.close();
	  }
	var dynamwin = window.open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+width+',height='+height+'');
	}
	
	function sexyTOG() { document.onclick=function(){ 
	$S('sexyBG').display='none'; 
	$S('sexyBOX').display='none'; 
	document.onclick=function(){}; }; }
	function sexyBOX(v,b) { setTimeout("sexyTOG()",100); $S('sexyBG').height=XYwin(0)+'px'; 
	$S('sexyBG').display='block'; 
	$('sexyBOX').innerHTML=v+'<div class="sexyX">click outside box to close)'+"<\/div>"; 
	$S('sexyBOX').left=Math.round((XYwin(1)-b)/2)+'px'; 
	$S('sexyBOX').width=b+'px'; $S('sexyBOX').display='block'; 
	}
	
	function hidebox(){
	var crossobj= document.getElementById("pasion");
	crossobj.style.visibility = "hidden";
	}

	function links(s) {
		return s.replace(/((https|http|ftp):\/\/[\S]+)/gi, '<a  href="$1" target="_blank">$1</a>');
	}

	function click(e) {
	
	var message="Dont use right click, focus on the smiles (only!)";
	
		if (document.all) {
			if (event.button == 2) {
			alert(message);
			return false;
			}
		}
		
		if (document.layers) {
			if (e.which == 3) {
			alert(message);
			return false;
			}
		}
	}