<?php
// user_nav_widget.php
// Display the User Navigation/Functions Bar

//if (ALLOW_AUTH_LOGIN_FLAG) {
if (true) {
?>

<table cellspacing="1" cellpadding="1" width="100%" border="0">
  <tr>
	<td nowrap="nowrap" align="center" valign="middle" class="BgcolorDull2">
	<img src="<?php echo DIR_WS_IMAGES?>/spacer.gif" width="15" height="15" />
	User Functions: 
	<img src="<?php echo DIR_WS_IMAGES?>/spacer.gif" width="15" height="15" />
	</td>
  </tr>
</table>

<table cellspacing="1" cellpadding="1" width="100%" border="0">
  <tr>
	<td nowrap="nowrap" align="center" valign="middle" class="BgcolorNormal"><span class="FontSoftSmall">
<a href="<?php echo href_link(FILENAME_LOGIN, '', 'NONSSL')?>">Login</a> / 
<a href="<?php echo href_link(FILENAME_LOGOUT, '', 'NONSSL')?>">Logout</a><br />
<a href="<?php echo href_link(FILENAME_REGISTER, '', 'NONSSL')?>">New User Register</a><br />
<!--
<a href="<?php echo href_link(FILENAME_FORGOT_USERNAME, '', 'NONSSL')?>">Forgot Username?</a><br />
<a href="<?php echo href_link(FILENAME_FORGOT_PASSWD, '', 'NONSSL')?>">Forgot Password?</a><br />
<a href="<?php echo href_link(FILENAME_CHANGE_PASSWD, '', 'NONSSL')?>">Change Password</a><br />
<a href="<?php echo href_link(FILENAME_UPDATE, '', 'NONSSL')?>">Update User Info</a><br />
-->
<a href="<?php echo href_link(FILENAME_HELP, '', 'NONSSL')?>">User Help</a>
	</span></td>
  </tr>
</table>

<?php
} // end allow additions
?>

