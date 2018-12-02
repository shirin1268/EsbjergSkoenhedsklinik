<?php

include_once(DIR_WS_FUNCTIONS . 'password_funcs.php');


function login($username, $passwd)
// check username and passwd with db
// if yes, return true else return false
{
  global $db_link;
  // check if username is unique
  $result = wrap_db_query("SELECT user_id, passwd FROM " . BOOKING_USER_TABLE . " 
						WHERE username = '" . wrap_db_escape_string($username) . "'");
  if (!$result) { return false; }
  $fields = wrap_db_fetch_array($result);
  # check to see if username was found
  # also to prevent username = "" sql default
  if (empty($fields)) { return false; }
  
  # check for admin login, passwd = NULL
  if ($passwd == "" && $result && $fields[1] == NULL)
     $passwd = NULL;
  
  //echo "username: $username<br />";
  //echo "password: $passwd<br />";
  //echo "db field: ".$fields['passwd']."<br />";
  if ($fields['passwd'] == NULL) { echo "NULL db passwd<br />"; }
  
  if (validate_password($passwd, $fields['passwd']))
     return true;
  
  return false;
}


function register($username, $passwd, $firstname, $lastname, $groups, $email)
// register new person with db
// return false or error
{
  global $db_link;
  // crypt user password entry
  $crypted_passwd = crypt_password($passwd);
  
  // check if username is unique 
  $result = wrap_db_query("SELECT username FROM " . BOOKING_USER_TABLE . " WHERE username='" . wrap_db_escape_string($username) . "'"); 
  if (!$result)
     return "Could not register you in the database! Please try again.";
  if (wrap_db_num_rows($result)>0) 
     return "Sorry, that username is taken.  Please choose another one.";
  
  // if ok, put in db
  $result = wrap_db_query("INSERT " . BOOKING_USER_TABLE . " (username, passwd, 
						firstname, lastname, groups, email) 
						VALUES ('" . wrap_db_escape_string($username) . "', '" . wrap_db_escape_string($crypted_passwd) . "', 
						'" . wrap_db_escape_string($firstname) . "', '" . wrap_db_escape_string($lastname) . "', '" . 
						wrap_db_escape_string($groups) . "', '" . wrap_db_escape_string($email) . "')");
  if (!$result)
    return false;
  else
    return true;
}


function change_password($username, $old_passwd, $new_passwd, $email)
// change password for username/old_passwd to new_passwd
// return true or false
{
  global $db_link;
  // if the old password and email are correct!
  // change their password to new_passwd and return true
  // else return false
  if (login($username, $old_passwd))
  {
    // crypt user password entry
    $crypted_new_passwd = crypt_password($new_passwd);
    
    $result = wrap_db_query("UPDATE " . BOOKING_USER_TABLE . " SET passwd = '" . wrap_db_escape_string($crypted_new_passwd) . "' " . 
					"WHERE username = '" . wrap_db_escape_string($username) . "' AND email = '" . wrap_db_escape_string($email) . "'");
    if (!$result)
      return false;  // not changed
    else
      return true;  // changed successfully
  }
  else
    return false; // old password was wrong
}


function reset_password($username, $email)
// set password for username to a random value
// return the new password or false on failure
{ 
  global $db_link;
  $result = wrap_db_query("SELECT email FROM " . BOOKING_USER_TABLE . " WHERE username='" . wrap_db_escape_string($username) . "'");
  if (!$result) {
		return false;  // no result
  } else if (wrap_db_num_rows($result)==0) {
		return false; // username not in db
  } else {
		$fields = wrap_db_fetch_array($result);
		if ($email != $fields['email']) {
			return false; // emails do not match
		}
  }
  $new_passwd = random_password(6);
  // crypt user password entry
  $crypted_new_passwd = crypt_password($new_passwd);
  
  // set user's password to this in database or return false
  $result = wrap_db_query("UPDATE " . BOOKING_USER_TABLE . " SET passwd = '" . wrap_db_escape_string($crypted_new_passwd) . "' " . 
					"WHERE username = '" . wrap_db_escape_string($username) . "' AND email = '" . wrap_db_escape_string($email) . "'");
  if (!$result) {
    return false;  // not changed
  } else {
    return $new_passwd;  // changed successfully
  }
}

function get_username($email)
// Forgot Username Function
// Get username based on email entered
{ 
  $result = wrap_db_query("SELECT username FROM " . BOOKING_USER_TABLE . " WHERE email='" . wrap_db_escape_string($email) . "'");
  if (!$result) {
		return false;
  } else if (wrap_db_num_rows($result)==0) {
		return false; // email not in db
  } else {
		$fields = wrap_db_fetch_array($result);
		$username = $fields['username'];
  }
  return $username; // return valid username
}


function get_user_information($username)
// return the user information array or false on failure
{ 
  $result = wrap_db_query("SELECT * FROM " . BOOKING_USER_TABLE . " WHERE username = '" . wrap_db_escape_string($username) . "'");
  if (!$result) {
		return false;  // not changed
  } else if (wrap_db_num_rows($result)==0) {
		return false; // email not in db
  } else {
		$fields = wrap_db_fetch_array($result);
  }
  return $fields;
}


function update_user_information($username, $firstname, $lastname, $email)
// update user information
// return false, true or error message
{
  // check if username is unique 
  $result = wrap_db_query("SELECT user_id FROM " . BOOKING_USER_TABLE . " WHERE username='" . wrap_db_escape_string($username) . "'"); 
  if (!$result) {
		return false;  // no result
  } else if (wrap_db_num_rows($result)==1) {  // one result row
		$fields = wrap_db_fetch_array($result);
		$user_id = $fields['user_id'];
  } else {
		return false;
  }
  if (empty($user_id)) {
     return false;
  }
  // if ok, put in db and return result
  $result = wrap_db_query("UPDATE " . BOOKING_USER_TABLE . " SET 
						firstname = '" . wrap_db_escape_string($firstname) . "',
						lastname = '" . wrap_db_escape_string($lastname) . "',
						email = '" . wrap_db_escape_string($email) . "' 
						WHERE username = '" . wrap_db_escape_string($username) . "' ".
						" AND user_id = '" . wrap_db_escape_string($user_id) . "'");
  if (!$result)
    return false;
  else
    return true;
}

