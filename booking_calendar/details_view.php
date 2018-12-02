<?php include_once("./includes/application_top.php"); ?>
<?php
  if (REQUIRE_AUTH_FOR_VIEWING_DETAILS_FLAG) {
	if (!@wrap_session_is_registered('valid_user')) {
		header('Location: ' . href_link(FILENAME_LOGIN, 'origin=' . FILENAME_DETAILS_VIEW . '&' . make_hidden_fields_workstring(), 'NONSSL'));
	    wrap_exit();
	}
  }
?>
<?php
$page_error_message = '';
// EVENT DETAILS FOR EVENT_ID

if (!empty($_REQUEST['event_id'])) {
	
	// GET THE EVENT DATA
	$event = get_event_details($_REQUEST['event_id']);
	if (!($event)) {
		$page_error_message = "I'm sorry, but that Event ID does not exist in the event records.";
	}
	
	// VALIDATE DATA
	
	// DEFINE DATES (Do not change from YYYY-MM-DD format!)
	list($starting_date, $starting_time) = explode(" ", $event['starting_date_time']);
	$starting_time = substr($starting_time, 0, strlen($starting_time)-3);
	list($ending_date, $ending_time) = explode(" ", $event['ending_date_time']);
	$ending_time = substr($ending_time, 0, strlen($ending_time)-3);
	$recur_date = $event['recur_until_date'];
	// DEFINE THE RECURRING FREQUENCY AND INTERVAL
	$recur_freq = $event['recur_freq'];
	$recur_interval = strtolower($event['recur_interval']);
	//echo "Start Date: ".$starting_date."<br />";
	//echo "Start Time: ".$starting_time."<br />";
	//echo "End Date: ".$ending_date."<br />";
	//echo "End Time: ".$ending_time."<br />";

	// CHECK REQUIRED FIELDS
	
	// CHECK DATES
	
	if (!(check_valid_date($starting_date))) {
		$page_error_message = "Your starting date does not exist. There are only " .
			number_of_days_in_month($_POST['start_year'], $_POST['start_mon']) . " days in " . month_name($_POST['start_mon']) . 
			" " . $_POST['start_year'] . ". Please check the calendar and try again.";
	}
	elseif (!(check_valid_date($ending_date))) {
		$page_error_message = "Your ending date does not exist. There are only " .
			number_of_days_in_month($_POST['end_year'], $_POST['end_mon']) . " days in " . month_name($_POST['end_mon']) . 
			" " . $_POST['end_year'] . ". Please check the calendar and try again.";
	}
	elseif (!(check_valid_date($recur_date)) && $recur_interval != '') {
		$page_error_message = "Your recurring date does not exist. There are only " .
			number_of_days_in_month($_POST['recur_year'], $_POST['recur_mon']) . " days in " . month_name($_POST['recur_mon']) . 
			" " . $_POST['recur_year'] . ". Please check the calendar and try again.";
	}
	
	// CHECK THAT ENDING DATE/TIME > STARTING DATE/TIME
	
	elseif ( ( implode("", explode("-",$ending_date)) . implode("", explode(":",$ending_time)) )+0 <= 
			 ( implode("", explode("-",$starting_date)) . implode("", explode(":",$starting_time)) )+0 ) {
		$page_error_message = "There is a problem with this event! The ending date and time must occur after the starting " . 
			"date and time. Please notify the calendar adminstrator of this problem.";
	} // end of if/elseif
	
	// CHECK THAT RECUR DATE > ENDING DATE/TIME
	
	elseif ( implode("", explode("-",$recur_date))+0 <= implode("", explode("-",$ending_date))+0 
			   && !($recur_interval == 'none' || $recur_interval == '') ) {
		$page_error_message = "There is a problem with this event! The recurring until date must occur after your ending " . 
			"date. Please notify the calendar adminstrator of this problem.";
	} // end of if/elseif
	
	
	// ACTION HANDLER
	// CHECK AUTHENTICATION/USERNAME/GROUP FOR MODIFY OR DELETE ACTIONS
	$user_id = get_user_id($_SESSION['valid_user']); // Current Session User ID
	$event_user = get_user($event['user_id']); // Define Event User Information
	$valid_session = wrap_session_is_registered('valid_user');
	$display_modify_trigger = true;
	$display_delete_trigger = true;
	
	if (REQUIRE_AUTH_FOR_MODIFYING_FLAG && !$valid_session && 
		($_REQUEST['action'] == 'submit_modify' || $_REQUEST['action'] == 'modify')) {
			$_REQUEST['action'] = "";
			$display_modify_trigger = false;
	}
	if (REQUIRE_AUTH_FOR_DELETING_FLAG && !$valid_session && 
		($_REQUEST['action'] == 'submit_delete' || $_REQUEST['action'] == 'delete' || $_REQUEST['action'] == 'delete_event')) {
			$_REQUEST['action'] = "";
			$display_delete_trigger = false;
	}
	if (REQUIRE_MATCHING_USERNAME_FOR_MODIFICATIONS_FLAG && $event['user_id'] != $user_id) {
		if ($_REQUEST['action'] == 'submit_modify' || $_REQUEST['action'] == 'modify') {
			$_REQUEST['action'] = "";
		}
		$display_modify_trigger = false;
	}
	if (REQUIRE_MATCHING_USERNAME_FOR_DELETIONS_FLAG && $event['user_id'] != $user_id) {
		if ($_REQUEST['action'] == 'submit_delete' || $_REQUEST['action'] == 'delete' || $_REQUEST['action'] == 'delete_event') {
			$_REQUEST['action'] = "";
		}
		$display_delete_trigger = false;
	}
	
	if ($_REQUEST['action'] == 'submit_modify') {
		if ($_POST['subject'] == "") {
			$page_error_message = "You have not filled out the add form completely. Please type in a subject.";
			$event['description'] = $_POST['desc'];
			$event['subject'] = $_POST['subject'];
			$_REQUEST['action'] = 'modify';
		} else {
			if (modify_event($_SESSION['valid_user'], $event['event_id'], $_POST['subject'], $_POST['desc'])) {
				$page_info_message = "Event details modified successfully!";
				$event = get_event_details($_REQUEST['event_id']);
			} else {
				$page_error_message = "Event details could not be modified. Please try again.";
				$event['description'] = $_POST['desc'];
				$event['subject'] = $_POST['subject'];
				$_REQUEST['action'] = 'modify';
			}
		}
	} else if ($_REQUEST['action'] == 'submit_delete') {
		if (delete_event_slot($_SESSION['valid_user'], $event['event_id'], $_REQUEST['date_time'])) {
			$page_info_message = "Time slot deleted successfully!";
		} else {
			$page_error_message = "Event time slot could not be deleted. Please try again.";
		}
		$_REQUEST['action'] = 'delete';
	} else if ($_REQUEST['action'] == 'delete_event') {
		if (delete_event($_SESSION['valid_user'], $event['event_id'])) {
			$page_info_message = "Event deleted successfully!";
			$page_error_message = "No event to display.";
		} else {
			$page_error_message = "Event time slot could not be deleted. Please try again.";
			$_REQUEST['action'] = 'delete';
		}
	}

} // end of if event_id


?>
<?php
if (!empty($_REQUEST['page_info_message'])) $page_info_message = $_REQUEST['page_info_message'];
$page_title = 'Booking Calendar - Event Details';
$page_title_bar = "Event Details:";

include_once("header.php");

  // display details view
?>


<!-- add_event.php -->

<p align="center">


<!-- Table for Right Border Section -->
<table cellspacing="0" cellpadding="0" border="0">
<tr><td align="right" valign="top">


<?php

// DISPLAY DETAILS

?>

<?php if ($_REQUEST['action'] == 'modify') { ?>
<form id="modify_event" action="<?php echo FILENAME_DETAILS_VIEW?>" method="post">
<?php } ?>

<table border="0" cellpadding="4" cellspacing="0">

<tr><td align="left" colspan="2"><strong>Location:</strong>  <?php echo htmlentities($location_display[$event['location']])?></td></tr>

<tr><td align="left" colspan="2"><strong>Subject:</strong> 
<?php
	if ($_REQUEST['action'] == 'modify') {
		echo '<input type="text" name="subject" value="' . htmlentities($event['subject']) . '" size="35" maxlength="150" />';
	} else {
		echo htmlentities($event['subject']);
	}
?></td></tr>

<tr><td colspan="2" align="left" valign="top"><strong>Event Description:</strong></td></tr>

<tr><td colspan="2" align="left">
<?php
	if ($_REQUEST['action'] == 'modify') {
?>
<img src="<?php echo DIR_WS_IMAGES?>spacer.gif" width="500" height="1" alt="" /><br />

<textarea name="desc" rows="5" cols="20" style="width: 100%; height: 120px;"><?php
echo htmlentities($event['description']);
?></textarea>
<br />

</td></tr>
<tr><td colspan="2" align="center" valign="top">
<?php echo make_hidden_fields(array('date', 'view', 'loc'))?>
<input type="hidden" name="action" value="submit_modify" />
<input type="hidden" name="event_id" value="<?php echo $event['event_id']?>" />
<input type="submit" name="submit_button" value="Submit Event Changes" class="ButtonStyle" /> 
<?php
	} else {
		echo nl2br(htmlentities($event['description']));
	}
?>
</td></tr>



<tr><td align="left" colspan="2"><span class="FontSoftSmall">
<br />Posted by: <?php echo htmlentities($event_user['firstname'])?> <?php echo htmlentities($event_user['lastname'])?><br />
Date Posted: <?php list($posted_date, $posted_time) = explode(" ",$event['date_time_added']); ?><?php echo short_date_format($posted_date);?> <?php echo format_time_to_ampm($posted_time)?><br />
<?php
	if (!empty($event['last_mod_date_time']) && $event['last_mod_date_time'] != "0000-00-00 00:00:00") {
?>
Last Modified: <?php echo htmlentities($event['last_mod_date_time'])?><br />
<?php
	}
?>
</span></td>

<?php
	if ($display_modify_trigger || $display_delete_trigger) {
?>
<tr><td align="left" valign="top" nowrap="nowrap" colspan="2">
<br /><span class="FontSoftSmall">User Options:
<a href="<?php echo href_link(FILENAME_DETAILS_VIEW, 'event_id=' . $event['event_id'] . '&action=view&' . make_hidden_fields_workstring(), 'NONSSL')?>"><strong>View</strong></a>
<?php
		if ($display_modify_trigger) {
?>
| <a href="<?php echo href_link(FILENAME_DETAILS_VIEW, 'event_id=' . $event['event_id'] . '&action=modify&' . make_hidden_fields_workstring(), 'NONSSL')?>"><strong>Modify</strong></a>
<?php
		}
		if ($display_modify_trigger) {
?>
| <a href="<?php echo href_link(FILENAME_DETAILS_VIEW, 'event_id=' . $event['event_id'] . '&action=delete_event&' . make_hidden_fields_workstring(), 'NONSSL')?>" onClick="return confirm('Are you sure you want to delete this entire event?');"><strong>Delete Event</strong></a>
| <a href="<?php echo href_link(FILENAME_DETAILS_VIEW, 'event_id=' . $event['event_id'] . '&action=delete&' . make_hidden_fields_workstring(), 'NONSSL')?>"><strong>Delete Time Slots</strong></a>
<?php
		}
?>
</span></td></tr>
<?php
	}
?>
</table>

<?php if ($_REQUEST['action'] == 'modify') { ?>
</form>
<?php } ?>


<?php
// END OF DISPLAY DETAILS
?>





</td>
<td align="right" valign="top"><img 
src="<?php echo DIR_WS_IMAGES?>spacer.gif" width="20" height="1" alt="" /></td>
<td align="right" valign="top">


<?php
if ($_REQUEST['action'] == 'delete') {

// RIGHT BAR SCHEDULE SECTION - DELETE OPTIONS

	if ($_REQUEST['event_id'] > 0) {

		$display_dates_and_time_ranges = get_event_dates_and_time_ranges($event['event_id'], $event['location']);
		do_html_right_nav_bar_top(200);
?>
<strong>Booked Dates<br />and Time Slots:</strong><br />
Slot Duration: <?php echo BOOKING_TIME_INTERVAL?> min.<br /><br />

<?php
		if (count($display_dates_and_time_ranges) > 0) {
?>
<table cellspacing="1" cellpadding="0" border="0">
<?php
			reset ($display_dates_and_time_ranges);
			foreach ($display_dates_and_time_ranges as $display_date_and_time) {
				list ($date, $time_range) = explode(" ", $display_date_and_time);
				list ($from_time, $to_time) = explode("-", $time_range);
				$time_slots = get_times_in_range($from_time, $to_time, DISPLAY_TIME_INTERVAL);
				if (count($time_slots)>1) $trash = array_pop($time_slots);
				foreach ($time_slots as $time_slot) {
?>
<tr><td align="left" valign="top" nowrap="nowrap" class="FontSoftSmall"><?php echo short_date_format($date);?> &nbsp; </td>
<td align="left" valign="top" nowrap="nowrap" class="FontSoftSmall"><?php echo format_time_to_ampm($time_slot)?></td>
<td align="left" valign="top" nowrap="nowrap" class="FontSoftSmall"> &nbsp; 
	<a href="<?php echo FILENAME_DETAILS_VIEW?>?event_id=<?php echo $event['event_id']?>&date_time=<?php echo urlencode($date.' '.$time_slot.':00')?>&action=submit_delete"><strong>Delete</strong></a></td></tr>
<?php
				} // end foreach time_slot
			}
?>
</table><br />
<?php
		}
		do_html_right_nav_bar_bottom(200);
	}

} else {
?>

<?php



// RIGHT BAR SCHEDULE SECTION - REGULAR

	if ($_REQUEST['event_id'] > 0) {

		$display_dates_and_time_ranges = get_event_dates_and_time_ranges($event['event_id'], $event['location']);
		do_html_right_nav_bar_top(200);
?>
<strong>Booked Dates<br />and Time Ranges:</strong><br /><br />
<?php
		if (count($display_dates_and_time_ranges) > 0) {
?>
<table cellspacing="1" cellpadding="0" border="0">
<?php
			reset ($display_dates_and_time_ranges);
			foreach ($display_dates_and_time_ranges as $display_date_and_time) {
				list ($date, $time_range) = explode(" ", $display_date_and_time);
				list ($from_time, $to_time) = explode("-", $time_range);
?>
<tr><td align="left" valign="top" nowrap="nowrap" class="FontSoftSmall"><?php echo short_date_format($date);?> &nbsp; </td>
<td align="left" valign="top" nowrap="nowrap" class="FontSoftSmall"><?php echo format_time_to_ampm($from_time)?>-<?php echo format_time_to_ampm($to_time)?></td></tr>
<?php
			}
?>
</table><br />
<?php
		}
		do_html_right_nav_bar_bottom(200);
	}
?>

<?php
}
?>

</td></tr></table>


<?php

include_once("footer.php");
?>
<?php include_once("application_bottom.php"); ?>