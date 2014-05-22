<?php

class MAILLER{

	function email_send($name, $password, $email)
	{
	
	# -=-=-=- MIME BOUNDARY
	$mime_boundary = "----SpecialChat.NeT----".md5(time());
	# -=-=-=- MAIL HEADERS
	$to = "$email";
	$subject = "Your account active now in SpecialChat.net";
	
	$headers = "From: SpecialChat <mailer@specialchat.net>\n";
	$headers .= "Reply-To: $name <$email>\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
	
	# -=-=-=- HTML EMAIL PART
	 
	$message .= "--$mime_boundary\n";
	$message .= "Content-Type: text/html; charset=UTF-8\n";
	$message .= "Content-Transfer-Encoding: 8bit\n\n";
	
	$message .= "<html>\n";
	$message .= "<body style=\"font-family:Verdana, Geneva, sans-serif; font-size:14px; color:#666666;\">\n"; 
	$message .= "<br>\n";
	$message .= "This is a notice for new account in SpecialChat.net .<br>\n";
	$message .= "Please Mr/Miss $name save this information in you computer and delete this email.<br>\n\n";
	$message .= "Your nick name : $name  <br>\n\n";
	$message .= "Your Password: $password <br>\n\n";
	$message .= "Your account active now !<br>\n\n";
	$message .= "Best regards from Specialchat.net admin";
	$message .= "</body>\n";
	$message .= "</html>\n";
		
	# -=-=-=- FINAL BOUNDARY
	
	$message .= "--$mime_boundary--\n\n";
	
	# -=-=-=- SEND MAIL
	
	$mail_sent = @mail( $to, $subject, $message, $headers );
	return $mail_sent ? "Mail sent" : "Mail failed";
	}
	
	
	function new_password($name, $new_password, $email)
	{
	# -=-=-=- MIME BOUNDARY
	$mime_boundary = "----SpecialChat.NeT----".md5(time());
	# -=-=-=- MAIL HEADERS
	$to = "$email";
	$subject = "New Issued Password!";
	
	$headers = "From: SpecialChat <mailer@specialchat.net>\n";
	$headers .= "Reply-To: $name <$email>\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
	
	# -=-=-=- HTML EMAIL PART
	 
	$message .= "--$mime_boundary\n";
	$message .= "Content-Type: text/html; charset=UTF-8\n";
	$message .= "Content-Transfer-Encoding: 8bit\n\n";
		
	$message .= "<html>\n";
	$message .= "<body style=\"font-family:Verdana, Geneva, sans-serif; font-size:14px; color:#666666;\">\n"; 
	$message .= "<br>\n";
	$message .= "This is a notice for new password to your account in SpecialChat.net .<br>\n";
	$message .= "Please Mr/Miss $name save this information in you computer and delete this email.<br>\n\n";
	$message .= "Your nick name : $name  <br>\n\n";
	$message .= "Your new Password: $password <br>\n\n";
	$message .= "Best regards from Specialchat.net admin";
	$message .= "</body>\n";
	$message .= "</html>\n";
	
	# -=-=-=- FINAL BOUNDARY
	
	$message .= "--$mime_boundary--\n\n";
	
	# -=-=-=- SEND MAIL
	
	$mail_sent = @mail( $to, $subject, $message, $headers );
	return $mail_sent ? "Mail sent" : "Mail failed";
	}
	
	function new_upgrade_downgrade($name, $new_level, $email, $status)
	{
	# -=-=-=- MIME BOUNDARY
	$mime_boundary = "----SpecialChat.NeT----".md5(time());
	# -=-=-=- MAIL HEADERS
	$to = "$email";
	$subject = "You Have New $status!";
	
	$headers = "From: SpecialChat <mailer@specialchat.net>\n";
	$headers .= "Reply-To: $name <$email>\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
	
	# -=-=-=- HTML EMAIL PART
	 
	$message .= "--$mime_boundary\n";
	$message .= "Content-Type: text/html; charset=UTF-8\n";
	$message .= "Content-Transfer-Encoding: 8bit\n\n";
		
	$message .= "<html>\n";
	$message .= "<body style=\"font-family:Verdana, Geneva, sans-serif; font-size:14px; color:#666666;\">\n"; 
	$message .= "<br>\n";
	$message .= "This is a notice for new <b>$status</b> to your account in SpecialChat.net .<br>\n";
	$message .= "Please Mr/Miss $name save this information in you computer and delete this email.<br>\n\n";
	$message .= "Your nick name : $name  <br>\n\n";
	$message .= "Your new level: $new_level <br>\n\n";
	$message .= "Best regards from Specialchat.net admin";
	$message .= "</body>\n";
	$message .= "</html>\n";
	
	# -=-=-=- FINAL BOUNDARY
	
	$message .= "--$mime_boundary--\n\n";
	
	# -=-=-=- SEND MAIL
	
	$mail_sent = @mail( $to, $subject, $message, $headers );
	return $mail_sent ? "Mail sent" : "Mail failed";
	}

}
?>