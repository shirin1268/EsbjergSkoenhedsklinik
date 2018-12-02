<?php include_once("./includes/application_top.php"); ?>
<?php
$page_title = "User Registration";

$page_error_message = '';
$reg_result = false; // default

if (!empty($_POST['register'])) { // Register Form Submit

  if ($_POST['username'] == "" || $_POST['passwd'] == "" || $_POST['email'] == "") {  // check forms filled in - required fields
	$page_title = "User Registration Problem";
	$page_error_message = "You have not filled the form out correctly. " . 
		"Please make sure to fill out all required fields (username, password and e-mail).";
  }
  elseif (!validate_email($_POST['email'])) {  // email address not valid
	$page_title = "User Registration Problem";
    $page_error_message = "Your email address is not valid. Please try again.";
  }
  elseif ($_POST['passwd'] != $_POST['passwd2']) {  // passwords not the same
	$page_title = "User Registration Problem";
	$page_error_message = "The passwords you entered do not match. Please try again.";
	$_POST['passwd2'] = '';
  }
  elseif (strlen($_POST['passwd']) < 6 || strlen($_POST['passwd']) > 16) {   // check password length
	$page_title = "User Registration Problem";
	$page_error_message = "Your password must be between 6 and 16 characters. Please try again.";
  }

  if ($page_error_message == '') {  // attempt to register if no error message
	$reg_result = register($_POST['username'], $_POST['passwd'], 
				$_POST['firstname'], $_POST['lastname'], $_POST['groups'], $_POST['email']);
	if ($reg_result) {
		// register session variable 
		//$valid_user = $_POST['username'];
		$_SESSION['valid_user'] = $_POST['username'];
		wrap_session_register("valid_user", "valid_user");
		$page_title = "Registration Successful!";
	} else {
		// register problem: username taken, database error
		$page_title = "User Registration Problem";
		$page_error_message = $reg_result;
	}
  }

} // end of $_POST['register'] != ""
?>
<?php
$page_title = "Booking Calendar - User Registration";
$page_title_bar = "User Registration:";
include_once("header.php");

if ($reg_result) {
	// Registration Successful! Provide link to display wants page.
	echo "Your registration was successful!.<br /><br />";
} else {
    // New Registration or Problem.
?>
<form method="post" action="<?php echo FILENAME_REGISTER; ?>">
<table cellpadding="2" cellspacing="0" border="0" width="100%">
<tr><td align="right">Preferred Username:<br /><span class="FontBlackSmall"><em>(max 16 chars)</em></span></td>
<td><INPUT TYPE="text" name="username" value="<?php echo $_POST['username']; ?>" size="16" maxlength="16"></td></tr>
<tr><td align="right">Password:<br /><span class="FontBlackSmall"><em>(between 6 and 16 chars)</em></span></td>
<td><INPUT TYPE="password" name="passwd" value="<?php echo $_POST['passwd']; ?>" size="16" maxlength="16"></td></tr>
<tr><td align="right">Confirm Password:</td>
<td><INPUT TYPE="password" name="passwd2" value="<?php echo $_POST['passwd2']; ?>" size="16" maxlength="16"></td></tr>
<tr><td align="right">First Name: </td>
<td><INPUT TYPE="text" name="firstname" value="<?php echo $_POST['firstname'] ?>" size="25" maxlength="90"></td></tr>
<tr><td align="right">Last Name: </td>
<td><INPUT TYPE="text" name="lastname" value="<?php echo $_POST['lastname'] ?>" size="25" maxlength="90"></td></tr>
<tr><td align="right">E-mail Address: <br /><span class="FontBlackSmall"><em>(required)</em></span> </td>
<td><INPUT TYPE="text" name="email" value="<?php echo $_POST['email']; ?>" size="30" maxlength="90"></td></tr>
<tr><td align="center" colspan="2"><br />
<input type="hidden" name="groups" value="">
<input type="hidden" name="register" value="yes">
<input type="submit" name="register" value="Submit User Information" class="ButtonStyle">
</td></tr>
</table>
</form>
<?php
} // end of if $reg_result

include_once("footer.php");
?>
<?php include_once("application_bottom.php"); ?>