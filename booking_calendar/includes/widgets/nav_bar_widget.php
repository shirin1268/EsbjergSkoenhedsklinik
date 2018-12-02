<?php
// month_nav_widget.php
// Display arrangement for the navigation bar.
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
	<td align="center" valign="top" colspan="4">
		<table cellspacing="1" cellpadding="1" width="100%" border="0">
		<tr><td align="left" class="SectionHeaderStyle">Booking Calendar Navigation</td></tr>
		</table>
	</td>
  </tr>
  <tr>
	<td align="center" valign="top">
		<?php include('user_nav_widget.php'); ?>
		<?php include('add_event_widget.php'); ?>
	</td>
	<td align="center" valign="top">
		<?php include('day_nav_header_widget.php'); ?>
		<?php include('day_nav_widget.php'); ?>
		<?php include('view_nav_widget.php'); ?>
		<?php include('loc_nav_widget.php'); ?>
	</td>
	<td align="center" valign="top">
		<?php include('month_nav_header_widget.php'); ?>
		<?php include('month_nav_widget.php'); ?>
	</td>
	<td align="center" valign="top">
		<?php include('year_nav_header_widget.php'); ?>
		<?php include('year_nav_widget.php'); ?>
	</td>
  </tr>
</table>
