<?php
// Common Display Functions

function do_html_bar_heading($heading, $width = '100%')
{
  // print heading bar
?>

<table cellspacing="1" cellpadding="1" width="<?php echo $width?>" border="0">
  <tr><td align="left" class="SectionHeaderStyle"><?php echo $heading?>:</td></tr>
</table>

<?php
}


function do_html_right_nav_bar_top($width = 140)
{
  // start right navigation bar
?>
<table border="0" cellpadding="0" cellspacing="0" width="<?php echo $width?>">
<tr><td align="left" valign="top" class="BgcolorHard"><img 
   src="<?php echo DIR_WS_IMAGES?>spacer.gif" width="<?php echo $width?>" height="1" alt="" /></td></tr>
<tr><td align="left" valign="top" class="BgcolorNormal">
<table border="0" cellpadding="0" cellspacing="10" width="100%" class="BgcolorNormal"><tr><td 
align="left" valign="top">

<?php
}


function do_html_right_nav_bar_bottom($width = 140)
{
  // end right navigation bar
?>
</td></tr></table>
</td></tr>
<tr><td align="left" valign="top" class="BgcolorHard"><img 
   src="<?php echo DIR_WS_IMAGES?>spacer.gif" width="<?php echo $width?>" height="1" alt="" /></td></tr>
</table>

<?php
}


function overlib_escape ($content) {
	// Escape
	$patterns = array ("/'/", "/#/");
	$replacements = array ("\'", "\#");
	$content = preg_replace($patterns, $replacements, $content);
	return $content;
}


function send_mail($myname = MAIL_MYNAME, $myemail = MAIL_MYEMAIL, 
					$contactname, $contactemail, $subject = "None", $message = "None", 
					$wrap = '1', $add_footer = "1") {
  
  // MAIL_MYNAME and MAIL_MYEMAIL should be defined constants!
  
  $headers .= "MIME-Version: 1.0\r\n";
  // Next Line Removed for Wrapping Effect, HTML Not Needed
  //$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
  $headers .= "Content-type: text/plain; charset=us-ascii\r\n";
  $headers .= "From: ".MAIL_MYNAME." <".MAIL_MYEMAIL.">\r\n";
  $headers .= "To: ".$contactname." <".$contactemail.">\r\n";
  $headers .= "Reply-To: ".MAIL_MYNAME." <".MAIL_MYEMAIL.">\r\n";
  $headers .= "X-Priority: 1\r\n";  //1 UrgentMessage, 3 Normal
  $headers .= "X-MSMail-Priority: High\r\n";  // High, Normal
  $headers .= "X-Mailer: PHP";  //mailer
  
  if ($wrap == '1') { $message = wordwrap($message, 70); }
  
  if ($add_footer == "1") {
$message .= "\n" . do_email_divider_line() . "
This message was sent by the Web Calendar script.
" . do_email_divider_line();
  } // end of if $add_footer
  
  if (mail($contactemail, $subject, $message, $headers)) {
		return true;
  } else {
		return false;
  }
  
} // end of send_mail


function do_email_divider_line() {
return ('~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~'."\n");
}


