<?php
// day_widget.php
// Displays the Day View

  // Changed 'colors' to Style References for Odd and Even Rows
  $colors = array ('BgcolorDull2', 'BgcolorNormal');

  // Time Display Cell Width
  $time_cell_width = 75;

  // Define the $event_data object.
  $event_data = get_day_view_event_data(SELECTED_DATE, $_REQUEST['loc']);

  // Note $event_row_data is passed globally and contains the 
  // 'db_row_id|row_span|start_time|end_time" data.
  // row_span: '' => no data, '1-up' => event, '0' => rowspan of event (no cell)
?>


<!-- day_widget.php -->
<table cellspacing="1" cellpadding="1" width="100%" border="0">
  <tr>
    <td align="left" class="SectionHeaderStyle">
      All <?php echo SELECTED_DATE_LONGSTR?> Events for <?php echo $location_display[$_REQUEST['loc']]?>:
    </td>
  </tr>
</table>



<table cellspacing="1" cellpadding="1" width="100%" border="0">

  <tr>
	<td align="center" valign="middle" width="<?php echo $time_cell_width?>" 
		class="BgcolorDull2" nowrap="nowrap"><b>Time Slot</b></td>
	<td class="BgcolorBright" align="center" valign="middle">
		<a href="<?php echo href_link(FILENAME_DAY_VIEW, 'date='.PREVIOUS_DAY_DATE.'&'.make_hidden_fields_workstring(array('view', 'loc')), 'NONSSL')?>"><img 
		src="<?php echo DIR_WS_IMAGES?>/prev.gif" 
		alt="Previous Day" /></a><b><?php echo SELECTED_DATE_LONGSTR?></b><a 
		href="<?php echo href_link(FILENAME_DAY_VIEW, 'date='.NEXT_DAY_DATE.'&'.make_hidden_fields_workstring(array('view', 'loc')), 'NONSSL')?>"><img 
		src="<?php echo DIR_WS_IMAGES?>/next.gif" alt="Next Day" /></a></td>
  </tr>


<?php
  $count = 0;
  $width_length = 5;
  $data_display_times = array ();
  $data_display_times = get_times_in_range(MIN_BOOKING_HOUR, MAX_BOOKING_HOUR, BOOKING_TIME_INTERVAL);
  array_pop($data_display_times);
  
  foreach ($data_display_times as $display_time) {
	
	//$row_data = $data_sel_day_data[$hour];
	list ($hour, $min, $sec) = explode(":", $display_time);
	$time_str = sprintf("%02d:%02d", $hour, $min);
	$std_time_str = $time_str;
	
	// To Cater for the AM PM Hour display
	if (DEFINE_AM_PM) {
		// Note that the time placed in the HREF will be in 24 hour
		$time_str = format_time_to_ampm($time_str);
	}
	
	$count++;
	$color_ind = count % 2;
?>
	<tr>
	<td align="center" valign="top" width="<?php echo $time_cell_width?>" 
		class="<?php echo $colors[$color_ind]?>" nowrap="nowrap">
<?php
	// NOTE that the $std_time_str will be in 24 hour
	// regardless if it is  set to or not (DEFINE_AM_PM).
	if (ALLOW_ADDITIONS_FLAG) {
?>
		<a href="<?php echo href_link(FILENAME_ADD_EVENT, 'start_time='.$std_time_str.'&'.make_hidden_fields_workstring(array('date', 'view', 'loc')), 'NONSSL')?>"><?php echo $time_str?></a> &nbsp; <br /><br />

<?php
	} else {
?>
		<?php echo $time_str?>
<?php
	}
?>
    </td>
<?php
	// Note $event_row_data is passed globally and contains the 
	// 'db_row_id|row_span|start_time|end_time" data (pipe delimited).
	
	if (strlen($event_row_data[$display_time]) > 1) {
		
		@ list ($db_row_id, $row_span, $start_time, $end_time) = explode("|", $event_row_data[$display_time]);
		// To Cater for the AM PM Hour display
		if (DEFINE_AM_PM) {
			$start_time = format_time_to_ampm($start_time);
			$end_time = format_time_to_ampm($end_time);
		}
		// Use the $db_row_id to data seek to the data for this event.
		$rv = wrap_db_data_seek($event_data, $db_row_id);
		$this_event = wrap_db_fetch_array($event_data);
		
		$event_url = href_link(FILENAME_DETAILS_VIEW, 'event_id='.$this_event['event_id'].'&'.make_hidden_fields_workstring(array('date', 'view', 'loc')), 'NONSSL');
		$over_text = 'Event ID#: ' . $this_event['event_id'] . 
					 '<br />Subject: ' . $this_event['subject']; 
?>
		<td class="BgcolorDull" align="left" rowspan="<?php echo $row_span?>"><span 
		class="FontSoftSmall">&nbsp;<a href="<?php echo $event_url?>" onmouseover="return overlib('' + 
		'<?php echo overlib_escape(htmlentities($over_text, ENT_QUOTES, 'ISO-8859-1'))?>' +
		' ', CAPTION, 'Event Time: <?php echo $start_time?>-<?php echo $end_time?>');" 
		onmouseout="nd();"><?php echo $start_time?>-<?php echo $end_time?></a>&nbsp; - 
		Subject: <?php echo $this_event['subject']?></span></td>
<?php
	} elseif ($event_row_data[$display_time] == '0') {
	
		// This is where the cell is already taken from the prev row.
	
	} else {
?>
		<td align="right" rowspan="1" class="BgcolorNormal"><span 
		class="FontSoftSmall"><a href="<?php echo href_link(FILENAME_ADD_EVENT, 'start_time='.$std_time_str.'&'.make_hidden_fields_workstring(array('date', 'view', 'loc')), 'NONSSL')?>">(+)</a></span></td>
<?php
	} // end of if/elseif/else
?>
  </tr>
<?php
  } // end of foreach
?>
</table>

