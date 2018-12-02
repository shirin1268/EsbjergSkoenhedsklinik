<?php include_once("./includes/application_top.php"); ?>
<?php
  if (REQUIRE_AUTH_FOR_ADDING_FLAG) {
	if (!@wrap_session_is_registered('valid_user')) {
		header('Location: ' . href_link(FILENAME_LOGIN, 'origin=' . FILENAME_ADD_EVENT . '&' . make_hidden_fields_workstring(), 'NONSSL'));
	    wrap_exit();
	}
  }
?>
<?php
$page_error_message = '';

// ADD EVENT OR CHECK EVENT FORM SUBMIT BUTTONS
if (!empty($_POST['add_event']) || !empty($_POST['check_event'])) {
	
	// VALIDATE DATA
	
	// DEFINE DATES (Do not change from YYYY-MM-DD format!)
	$starting_date = sprintf("%04d-%02d-%02d", $_POST['start_year'], $_POST['start_mon'], $_POST['start_day']);
	$ending_date = sprintf("%04d-%02d-%02d", $_POST['end_year'], $_POST['end_mon'], $_POST['end_day']);
	$recur_date = sprintf("%04d-%02d-%02d", $_POST['recur_year'], $_POST['recur_mon'], $_POST['recur_day']);
	
	// DEFINE THE RECURRING DATES, FREQUENCY AND INTERVAL
	
	$recur_freq = $_REQUEST['recur_freq'];
	$recur_interval = $_REQUEST['recur_interval'];
	$recurring_dates = array ();
	$recurring_dates = get_recurrence_dates($starting_date, $ending_date, $recur_date, $recur_freq, $recur_interval);
	
	//NUMBER OF SPANNING DAYS (NOT including the recurrence dates)
	$days_span = days_span($starting_date, $ending_date);
	//echo "<br />Days Span: $days_span<br />";
	
	
	// CHECK REQUIRED FIELDS
	
	if ($_POST['subject'] == "") {
		$page_error_message = "You have not filled out the add form completely. Please type in a subject.";
	}
	
	// CHECK DATES
	
	elseif (!(check_valid_date($starting_date))) {
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
	
	elseif ( ( implode("", explode("-",$ending_date)) . implode("", explode(":",$_POST['end_time'])) )+0 <= 
			 ( implode("", explode("-",$starting_date)) . implode("", explode(":",$_POST['start_time'])) )+0 ) {
		$page_error_message = "Your ending date and time must occur after your starting " . 
			"date and time. Please check your dates and times and try again.";
	} // end of if/elseif
	
	// CHECK THAT RECUR DATE > ENDING DATE/TIME
	
	elseif ( implode("", explode("-",$recur_date))+0 <= implode("", explode("-",$ending_date))+0 
			   && !($recur_interval == 'none' || $recur_interval == '') ) {
		$page_error_message = "Your recurring until date must occur after your ending " . 
			"date. Please check your dates and try again.";
	} // end of if/elseif
	
	// CHECK FOR OVERLAPPING RECURRENCE PROBLEM
	
	//echo "Recurrence Dates:<br />";
	reset($recurring_dates);
	while (list($date,$freq) = each($recurring_dates)) {
		//echo "Date: $date, Freq: $freq<br />";
		if ($date != '' && $freq > 1) {
			$page_error_message = 'Recurrency Problem: Your &quot;Recurrency Interval&quot; is '.
				'too small for the spanning days between your starting and ending dates.  This causes '.
				'overlapping of dates to occur.  Try increasing your &quot;Recurrency Interval&quot; '.
				'or change your starting and ending dates.';
		}
	}
	
	// DATA HAS PASSED VALIDATION - PROCESS DATE AND TIME DATA
	
	if ($page_error_message == '') {
		
		//echo "Start Date: ".$starting_date."<br />";
		//echo "Start Time: ".$_POST['start_time']."<br />";
		//echo "End Date: ".$ending_date."<br />";
		//echo "End Time: ".$_POST['end_time']."<br />";
		
		// ENSURE THE CREATION OF THE SCHEDULE TABLE DATA FOR THE SPANNING
		
		// DETERMINE THE TIME RANGES FOR THE SPANNING DAYS
		
		$time_ranges_for_spanning_days = array (); // "hh:mm-hh:mm" format (min_time-max_time)
		$time_ranges_for_spanning_days = get_time_ranges_for_spanning_days(
				sprintf("%02d", MIN_BOOKING_HOUR).':00', sprintf("%02d", MAX_BOOKING_HOUR).':00',
				$_POST['start_time'], $_POST['end_time'], $days_span);
		//echo "<br />Time Ranges for Spanning Dates:<br />";
		
		//foreach ($time_ranges_for_spanning_days as $tr) { echo "---$tr<br />"; }
		//reset ($time_ranges_for_spanning_days);
		//echo "<br /><br />";
		
		// REPEATATIVELY BUILD-OUT THE TIME RANGES FOR SPANNING DAYS
		// OVER THE RECURRING DATES ARRAY. (This array includes the spanning days.)
		
		$display_dates_and_time_ranges = array (); // FOR HTML DISPLAY
		$scheduled_date_time_data = array (); // FOR SQL DATABASE
		
		$day = 1; // start on the first span day time range.
		reset($recurring_dates);
		while (list($date,$freq) = each($recurring_dates)) {
			if ($day > $days_span) { $day = 1; }
			$time_range = $time_ranges_for_spanning_days[$day-1];
			//echo "Time Range: $time_range <br />";
			list($range_start_time, $range_end_time) = explode("-", $time_range); // "hh:mm-hh:mm"
			// Define the date/time blocks in SQL format.
			$time_blocks = get_times_in_range ($range_start_time, $range_end_time,
							BOOKING_TIME_INTERVAL, false);
			foreach ($time_blocks as $time_block) {
				//echo "---$time_block<br />";
				$scheduled_date_time_data[] = $date.' '.$time_block.':00'; // SQL
			}
			$display_dates_and_time_ranges[] = $date.' '.$time_range; // Display
			$day++;
		}
		
		// CHECK AVAILABILITY OF DATE TIME DATA
		
		$scheduled_slots = count($scheduled_date_time_data);
		//echo "Scheduled Slots: ".$scheduled_slots."<br />";
		$available_date_time_data = array ();
		$unavailable_date_time_data = array ();
		$availability_count = check_schedule_availability(
					$scheduled_date_time_data, $location_db_name[$_REQUEST['location']] );
		//echo "Availability Count: ".$availability_count."<br />";
		// All slots not available condition check.
		if ($scheduled_slots > $availability_count) {
			$page_error_message = 'Availability Problem: Not all of the selected date and time slots ' . 
					'are available for booking.  Please check the conflicting date and time slots, ' . 
					'make the necessary changes to your booking form and try again.';
			$unavailable_date_time_data = find_schedule_unavailability(
					$scheduled_date_time_data, $location_db_name[$_REQUEST['location']] );
			if (count($unavailable_date_time_data) > 0) {
				$available_date_time_data = array_minus_array($scheduled_date_time_data, $unavailable_date_time_data);
			}
		} else {
			$available_date_time_data = $scheduled_date_time_data;
		}
	}
	
	// IF ALL IS WELL WITH THE SCHEDULE DATA AVAILABILITY - ADD EVENT DATA
	
	echo "valid user: ".$_SESSION['valid_user']."<br />user_id: ".get_user_id($_SESSION['valid_user'])."<br />";
	
	if ($page_error_message == '' && !empty($_POST['add_event'])) {
		
		// Attempt to Add the Event to the Database
		$add_event_id = add_event($_SESSION['valid_user'], $scheduled_date_time_data, $_REQUEST['subject'], $_REQUEST['location'], 
					$starting_date.' '.$_REQUEST['start_time'], $ending_date.' '.$_REQUEST['end_time'], 
					$_REQUEST['recur_interval'], $_REQUEST['recur_freq'], 
					$recur_date, $_REQUEST['desc']);
                echo "<pre>";
                var_dump($_SESSION['valid_user'], $scheduled_date_time_data, $_REQUEST['subject'], $_REQUEST['location'], 
					$starting_date.' '.$_REQUEST['start_time'], $ending_date.' '.$_REQUEST['end_time'], 
					$_REQUEST['recur_interval'], $_REQUEST['recur_freq'], 
					$recur_date, $_REQUEST['desc']);
                echo "</pre>";
		if (!empty($add_event_id)) {
			// Redirect to display page for user options (edit/delete).
			header('Location: ' . href_link(FILENAME_DETAILS_VIEW, 'event_id=' . $add_event_id . '&origin=' . FILENAME_ADD_EVENT . '&' . make_hidden_fields_workstring() . '&page_info_message=' . urlencode("Event added successfully!"), 'NONSSL'));
		    wrap_exit();
		} else {
			$page_error_message = "We could not add your event. Please check your information and try again.";
		}
	
	} // end of if ($page_error_message == '')
	
} // end of if ($_POST['add_want'] != "" || $_POST['check_event'] != "")


$page_title = "Booking Calendar - Add Booking Event";
$page_title_bar = "Add Booking Event:";
include_once("header.php");


// Define some arrays for the Input Form below.
// Valid booking times in 24 hour format; includes max and min hours.
$valid_booking_times = get_times_in_range(MIN_BOOKING_HOUR, MAX_BOOKING_HOUR, BOOKING_TIME_INTERVAL, true);

  // display the form, new want or problem
?>

<!-- add_event.php -->


<br />
<div align="center">


<!-- Table for Right Border Section -->
<table cellspacing="0" cellpadding="0" border="0">
<tr><td align="right" valign="top">



<form id="add_event_table" action="<?php echo FILENAME_ADD_EVENT?>" method="post">
<table border="0" cellpadding="2" cellspacing="0">

<tr>
<td align="right">Subject: <br /><em class="FontSoftSmall">(Brief Description)</em></td>
<td align="left"><input type="text" name="subject" value="<?php echo htmlentities($_REQUEST['subject']); ?>" size="35" maxlength="150" /></td>
</tr>


<tr>
<td align="right">Location: </td>
<td align="left">
<select name="location">
<?php if ($_REQUEST['location'] == '' && $_REQUEST['loc'] != '') { $_REQUEST['location'] = $_REQUEST['loc']; }
   reset($location_display);
   while (list ($location_id, $location_display_name)= each($location_display)) { ?>
<option value="<?php echo $location_id?>"<?php echo ($_REQUEST['location'] == $location_id) ? ' selected="selected"' : ''?>><?php echo $location_display_name?></option>
<?php } ?>
</select>
</td></tr>


<tr>
<td align="right">Starting Date/Time: </td>
<td align="left">
<select name="start_mon">
<?php if ($_REQUEST['start_mon'] == '') { $_REQUEST['start_mon'] = SELECTED_DATE_MONTH; }
   for ($i=1; $i<=12; $i++) { // Defined 1-12 ?>
<option value="<?php echo $i?>"<?php echo ($_REQUEST['start_mon']+0 == $i) ? ' selected="selected"' : ''?>><?php echo month_name($i)?></option>
<?php } ?>
</select> 
<select name="start_day">
<?php if ($_REQUEST['start_day'] == '') { $_REQUEST['start_day'] = SELECTED_DATE_DAY; }
   for ($i=1; $i<=31; $i++) { ?>
<option value="<?php echo $i?>"<?php echo ($_REQUEST['start_day']+0 == $i) ? ' selected="selected"' : ''?>><?php echo $i?></option>
<?php } ?>
</select>, 
<select name="start_year">
<?php if ($_REQUEST['start_year'] == '') { $_REQUEST['start_year'] = SELECTED_DATE_YEAR; }
   for ($i=TODAYS_DATE_YEAR-1; $i <= TODAYS_DATE_YEAR+11; $i++) { ?>
<option value="<?php echo $i?>"<?php echo ($_REQUEST['start_year']+0 == $i) ? ' selected="selected"' : ''?>><?php echo $i?></option>
<?php } ?>
</select>
 at 
<select name="start_time">
<?php $index_cnt = 0;
   $start_time_index = 0;
   reset ($valid_booking_times);
   foreach ($valid_booking_times as $time) {
      if ($time != $valid_booking_times[count($valid_booking_times)-1]) {
?>
<option value="<?php echo $time?>" <?php echo ($_REQUEST['start_time'] == $time) ? ' selected="selected"' : ''?>><?php echo (DEFINE_AM_PM == true) ? format_time_to_ampm($time) : $time?></option>
<?php    }
      if ($_REQUEST['start_time'] == $time) { $start_time_index = $index_cnt; }
      $index_cnt++;
   } ?>
</select>
</td>
</tr>


<tr>
<td align="right">Ending Date/Time: </td>
<td align="left">
<select name="end_mon">
<?php if ($_REQUEST['start_mon'] != '' && $_REQUEST['end_mon'] == '') { $_REQUEST['end_mon'] = $_REQUEST['start_mon']; } 
   elseif ($_REQUEST['end_mon'] == '') { $_REQUEST['end_mon'] = SELECTED_DATE_MONTH; }
   for ($i=1; $i<=12; $i++) { // Defined 1-12 ?>
<option value="<?php echo $i?>"<?php echo ($_REQUEST['end_mon']+0 == $i) ? ' selected="selected"' : ''?>><?php echo month_name($i)?></option>
<?php } ?>
</select> 
<select name="end_day">
<?php if ($_REQUEST['start_day'] != '' && $_REQUEST['end_day'] == '') { $_REQUEST['end_day'] = $_REQUEST['start_day']; } 
   elseif ($_REQUEST['end_day'] == '') { $_REQUEST['end_day'] = SELECTED_DATE_DAY; }
   for ($i=1; $i<=31; $i++) { ?>
<option value="<?php echo $i?>"<?php echo ($_REQUEST['end_day']+0 == $i) ? ' selected="selected"' : ''?>><?php echo $i?></option>
<?php } ?>
</select>, 
<select name="end_year">
<?php if ($_REQUEST['start_year'] != '' && $_REQUEST['end_year'] == '') { $_REQUEST['end_year'] = $_REQUEST['start_year']; } 
   elseif ($_REQUEST['end_year'] == '') { $_REQUEST['end_year'] = SELECTED_DATE_YEAR; }
   for ($i=TODAYS_DATE_YEAR-1; $i <= TODAYS_DATE_YEAR+11; $i++) { ?>
<option value="<?php echo $i?>"<?php echo ($_REQUEST['end_year']+0 == $i) ? ' selected="selected"' : ''?>><?php echo $i?></option>
<?php } ?>
</select>
 at 
<select name="end_time">
<?php reset ($valid_booking_times);
   if ($_REQUEST['end_time'] == '') {
      $_REQUEST['end_time'] = $valid_booking_times[$start_time_index+1];
   }
   foreach ($valid_booking_times as $time) {
      if ($time != $valid_booking_times[0]) {
?>
<option value="<?php echo $time?>" <?php echo ($_REQUEST['end_time'] == $time) ? ' selected="selected"' : ''?>><?php echo (DEFINE_AM_PM == true) ? format_time_to_ampm($time) : $time?></option>
<?php    }
   } ?>
</select>
</td>
</tr>


<tr>
<td align="right" valign="top" nowrap="nowrap"><br />Recurrence Interval: 
<br /><em class="FontSoftSmall">(Optional)</em> </td>
<td align="left">
<input type="radio" name="recur_interval" value="none"<?php echo ($_REQUEST['recur_interval'] == 'none' || $_REQUEST['recur_interval'] == '') ? ' checked="checked"' : ''?> />None
<br /><em class="FontSoftSmall">No recurrency.</em><br />
<input type="radio" name="recur_interval" value="day"<?php echo ($_REQUEST['recur_interval'] == 'day') ? ' checked="checked"' : ''?> />Daily
<br /><em class="FontSoftSmall">Recur daily can be used to span even more days.</em><br />
<input type="radio" name="recur_interval" value="week"<?php echo ($_REQUEST['recur_interval'] == 'week') ? ' checked="checked"' : ''?> />Weekly
<br /><em class="FontSoftSmall">Recur every week.</em><br />
<input type="radio" name="recur_interval" value="day-month"<?php echo ($_REQUEST['recur_interval'] == 'day-month') ? ' checked="checked"' : ''?> />Monthly (by day of the month)
<br /><em class="FontSoftSmall">Recur based on day of the month; 3rd, 14th or 20th. </em><br />
<input type="radio" name="recur_interval" value="weekday-month"<?php echo ($_REQUEST['recur_interval'] == 'weekday-month') ? ' checked="checked"' : ''?> />Monthly (by occuring weekday of the month)
<br /><em class="FontSoftSmall">Recur based on the occuring weekday; 1st Thursday or 3rd Monday.</em><br />
<input type="radio" name="recur_interval" value="year"<?php echo ($_REQUEST['recur_interval'] == 'year') ? ' checked="checked"' : ''?> />Yearly
</td>
</tr>


<tr>
<td align="right" valign="top" nowrap="nowrap">Recurrence Frequency: 
<br /><em class="FontSoftSmall">(Optional)</em> </td>
<td nowrap="nowrap" align="left">
<select name="recur_freq">
<option value="1"<?php echo ($_REQUEST['recur_freq'] == "1") ? ' selected="selected"' : ''?>>1 (Normal)</option>
<?php for ($i=2; $i<10; $i++) { ?>
<option value="<?php echo $i?>"<?php echo ($_REQUEST['recur_freq'] == $i) ? ' selected="selected"' : ''?>><?php echo $i?></option>
<?php } ?>
</select>
<br /><em class="FontSoftSmall">
For example, if the recurrence interval is set to &quot;weekly&quot;, this<br />
setting can be used to recur on every 2 weeks, 3 weeks,<br />
5 weeks, etc. until the recur until date.</em><br />
</td></tr>


<tr>
<td align="right" valign="top" nowrap="nowrap">Recur Until Date: 
<br /><em class="FontSoftSmall">(Optional)</em> </td>
<td align="left">
<select name="recur_mon">
<?php if ($_REQUEST['start_mon'] != '' && $_REQUEST['recur_mon'] == '') { $_REQUEST['recur_mon'] = $_REQUEST['start_mon']; } 
   elseif ($_REQUEST['recur_mon'] == '') { $_REQUEST['recur_mon'] = SELECTED_DATE_MONTH; }
   for ($i=1; $i<=12; $i++) { // Defined 1-12 ?>
<option value="<?php echo $i?>"<?php echo ($_REQUEST['recur_mon']+0 == $i) ? ' selected="selected"' : ''?>><?php echo month_name($i)?></option>
<?php } ?>
</select> 
<select name="recur_day">
<?php if ($_REQUEST['start_day'] != '' && $_REQUEST['recur_day'] == '') { $_REQUEST['recur_day'] = $_REQUEST['start_day']; } 
   elseif ($_REQUEST['recur_day'] == '') { $_REQUEST['recur_day'] = SELECTED_DATE_DAY; }
   for ($i=1; $i<=31; $i++) { ?>
<option value="<?php echo $i?>"<?php echo ($_REQUEST['recur_day']+0 == $i) ? ' selected="selected"' : ''?>><?php echo $i?></option>
<?php } ?>
</select>, 
<select name="recur_year">
<?php if ($_REQUEST['start_year'] != '' && $_REQUEST['recur_year'] == '') { $_REQUEST['recur_year'] = $_REQUEST['start_year']; } 
   elseif ($_REQUEST['recur_year'] == '') { $_REQUEST['recur_year'] = SELECTED_DATE_YEAR; }
   for ($i=TODAYS_DATE_YEAR-1; $i <= TODAYS_DATE_YEAR+11; $i++) { ?>
<option value="<?php echo $i?>"<?php echo ($_REQUEST['recur_year']+0 == $i) ? ' selected="selected"' : ''?>><?php echo $i?></option>
<?php } ?>
</select>
</td>
</tr>


<tr>
<td align="center" colspan="2">
<br />It is highly recommended to check availability before writing your description!<br />
<input type="submit" name="check_event" value="Check Schedule Availability" class="ButtonStyle" />
<br /><img src="<?php echo DIR_WS_IMAGES?>spacer.gif" width="500" height="1" alt="" /></td>
</tr>


<tr>
<td align="right" valign="top"><br />Detailed Description: </td><td align="left">&nbsp;</td>
</tr>

<tr>
<td align="center" colspan="2">

<textarea name="desc" rows="5" cols="20" style="width: 100%; height: 120px;"><?php
echo htmlentities($_REQUEST['desc']);
?></textarea>
<br />

<?php echo make_hidden_fields(array('date', 'view', 'loc'))?>
<input type="hidden" name="check_event" value="yes" /> 
<input type="submit" name="add_event" value="Add Booking Event" class="ButtonStyle" /> 

</td></tr>
</table>

</form>


</td>

<td align="right" valign="top"><img 
src="<?php echo DIR_WS_IMAGES?>spacer.gif" width="20" height="1" alt="" /></td>
<td align="right" valign="top">



<?php

// RIGHT BAR/BORDER SCHEDULE SECTION

if ((!empty($_POST['add_event']) || !empty($_POST['check_event'])) && $scheduled_slots > 0) {
	
	do_html_right_nav_bar_top(200);
	if (!empty($_POST['add_event'])) {
		echo "<strong>Event Booking:</strong><br />";
	} else {
		echo "<strong>Schedule Check:</strong><br />";
	}
?>
<?php echo $location_display[$_POST['location']]?><br />
Total Booking Slots: <?php echo $scheduled_slots?><br />
Slot Duration: <?php echo BOOKING_TIME_INTERVAL?> min.<br /><br />
<strong>Requested Dates<br />and Time Ranges:</strong><br />
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
	} else {
		echo "<strong>None</strong><br />";
	}
	
	if (count($unavailable_date_time_data) > 0) {
?>
<strong>Unavailable Time Slots:</strong><br />
<table cellspacing="1" cellpadding="0" border="0" width="1%">

<?php
		reset ($unavailable_date_time_data);
		foreach ($unavailable_date_time_data as $unavailable_slot) {
			list ($date, $time) = explode(" ", $unavailable_slot);
?>
<tr><td align="left" valign="top" nowrap="nowrap" class="FontSoftSmall"><?php echo short_date_format($date);?> &nbsp; </td>
<td align="left" valign="top" nowrap="nowrap" class="FontSoftSmall"><?php echo format_time_to_ampm($time)?></td></tr>
<?php
		}
?>
</table><br />
<?php
	}
	
	$show_available = true;
	if (count($available_date_time_data) > 0 && count($available_date_time_data) < 50 && $show_available) {
?>
<strong>Available Time Slots:</strong><br />
<table cellspacing="1" cellpadding="0" border="0" width="1%">

<?php
		reset ($available_date_time_data);
		foreach ($available_date_time_data as $available_slot) {
			list ($date, $time) = explode(" ", $available_slot);
?>
<tr><td align="left" valign="top" nowrap="nowrap" class="FontSoftSmall"><?php echo short_date_format($date);?> &nbsp; </td>
<td align="left" valign="top" nowrap="nowrap" class="FontSoftSmall"><?php echo format_time_to_ampm($time)?></td></tr>
<?php
		}
?>
</table><br />
<?php
	} elseif (count($available_date_time_data) > 0 && $show_available)  {
?>
<strong>Available Time Slots:</strong>
<table cellspacing="1" cellpadding="0" border="0" width="1%">
<tr><td align="left" valign="top" nowrap="nowrap" class="FontSoftSmall">
<?php echo count($available_date_time_data)?><br />
</td></tr></table>
<?php
	}
	
	do_html_right_nav_bar_bottom(200);
}
?>

</td></tr></table>

</div>

<?php

include_once("footer.php");
?>
<?php include_once("application_bottom.php"); ?>