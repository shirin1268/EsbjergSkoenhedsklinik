<?php include_once("./includes/application_top.php");

//wrap_session_start();

  // see if somebody is logged in and notify them if not
  $display_login_form = true; // default
  if (isset($_REQUEST['username']) && isset($_REQUEST['login'])) {
	// they have just tried logging in
	
	if (login($_REQUEST['username'], $_REQUEST['passwd'])) {
		// if they are in the database register the user id
		//$valid_user = $_REQUEST['username'];
		wrap_session_register("valid_user", $_REQUEST['username']);
		$display_login_form = false;
		$page_info_message = "Login Successful!";
	} else {
		// login failed, show error page
		$display_login_form = true;
		$page_error_message = "You could not be logged in. Please try again.";
	}
  } elseif (wrap_session_is_registered("valid_user")) {
	// logged in
	$display_login_form = false;
  } else {
	// they are not logged in, show login page output
	$display_login_form = true;
	if (!empty($_REQUEST['origin']) && $_REQUEST['origin'] != FILENAME_LOGOUT && $_REQUEST['origin'] != FILENAME_LOGIN) {
		$page_error_message = "You are not logged in. You must login to use this page.";
	}
  }

  // redirect back to "origin" page
  if (!$display_login_form && !empty($_REQUEST['origin']) && !empty($_SESSION['valid_user'])) {
	if (@wrap_session_is_registered('valid_user')) {
		header('Location: ' . href_link($_REQUEST['origin'], make_hidden_fields_workstring(), 'NONSSL'));
		wrap_exit();
	}
  }

$page_title = "Booking Calendar - User Login";
$page_title_bar = "User Login:";
include_once("header.php");

if ($display_login_form) {
?>
<p align="center">
<form method="post" action="<?php echo FILENAME_LOGIN?>">
<table cellpadding="2" cellspacing="0" border="0">
<tr><td align="right">Username: </td><td><input type="text" name="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" size="16" maxlength="16"></td></tr>
<tr><td align="right">Password: </td><td><input type="password" name="passwd" size="16" maxlength="16"></td></tr>
<tr><td colspan="2" align="center"><br />
<input type="hidden" name="origin" value="<?php echo $_REQUEST['origin']; ?>">
<?php echo make_hidden_fields(); ?>
<input type="hidden" name="login" value="yes">
<input type="submit" name="login" value="Login" class="ButtonStyle">
<p>
<a href="<?php echo FILENAME_REGISTER?>">Not a user? Register Today!</a>
</p>
</td></tr>
</table>
</form>
</p>
<?php

} else {
?>
<p align="center">
<table cellpadding="2" cellspacing="0" border="0">
<tr><td align="right">
You are curently logged in.
<a href="<?php echo href_link(FILENAME_LOGOUT, '', 'NONSSL'); ?>">User Logout</a>
</td></tr>
</table>
</p>

<?php
}

include_once("footer.php");
?>
<?php include_once("application_bottom.php"); ?>