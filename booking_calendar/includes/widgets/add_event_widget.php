<?php
// add_event_widget.php
// Display the Add Form for the Navigation Bar

//if (ALLOW_ADDITIONS FLAG) {
if (true) {
?>

<!-- add_event_widget.php -->
<table cellspacing="1" cellpadding="1" width="100%" border="0">
  <tr>
	<td nowrap="nowrap" align="center" valign="middle" class="BgcolorDull2">
	<img src="<?php echo DIR_WS_IMAGES?>/spacer.gif" width="15" height="15" />
	Add New Event: 
	<img src="<?php echo DIR_WS_IMAGES?>/spacer.gif" width="15" height="15" />
	</td>
  </tr>
</table>

<form action="<?php echo FILENAME_ADD_EVENT?>" method="post">
<table cellspacing="1" cellpadding="1" width="100%" border="0">
  <tr>
	<td nowrap="nowrap" align="center" valign="middle" class="BgcolorNormal"><div class="FontSoftSmall">
	<select name="start_mon" class="FontSoftSmall">
<?php for ($i=1; $i<=12; $i++) { // Defined 1-12 ?>
	<option value="<?php echo $i?>"<?php echo (SELECTED_DATE_MONTH+0 == $i) ? ' selected="selected"' : ''?>><?php echo month_short_name($i)?></option>
<?php } ?>
	</select>
	<select name="start_day" class="FontSoftSmall">
<?php for ($i=1; $i<=31; $i++) { ?>
	<option value="<?php echo $i?>"<?php echo (SELECTED_DATE_DAY+0 == $i) ? ' selected="selected"' : ''?>><?php echo $i?></option>
<?php } ?>
	</select>,
	<select name="start_year" class="FontSoftSmall">
<?php for ($i=SELECTED_DATE_YEAR-1; $i<=SELECTED_DATE_YEAR+11; $i++) { ?>
	<option value="<?php echo $i?>"<?php echo (SELECTED_DATE_YEAR+0 == $i) ? ' selected="selected"' : ""?>><?php echo $i?></option>
<?php } ?>
	</select><?php echo make_hidden_fields(array('date', 'view', 'loc'))?>
	<input type="submit" name="display_add_form" value="Add" class="ButtonStyleSmall" />
	</div>
	</td>
  </tr>
</table>
</form>

<?php
} // end allow additions
?>

