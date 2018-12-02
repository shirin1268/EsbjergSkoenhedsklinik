<?php
// Member Header Include Variables

// MAIN INPUT VARIABLES
// $page_title
// $page_meta_description
// $page_meta_keywords

// $page_error_message
// $page_info_message

// Set Defaults
if (@$page_meta_description == "") { $page_meta_description = $page_title; }
if (@$page_meta_keywords == "") { $page_meta_keywords = $page_title; }
if (@$page_author == "") { $page_author = "JJW Web Design; http://www.jjwdesign.com"; }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo htmlentities($page_title); ?></title>
<meta name="Description" content="<?php echo htmlentities($page_meta_description); ?>" />
<meta name="Keywords" content="<?php echo htmlentities($page_meta_keywords); ?>" />
<meta name="Author" content="<?php echo htmlentities($page_author); ?>" />
<meta name="Design" content="JJW Web Design" />
<?php if (@$page_meta_refresh == true) {?>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="refresh" content="<?php echo PAGE_REFRESH; ?>" />
<?php } ?>
<meta name="robots" content="index,nofollow" />
<link rel="stylesheet" type="text/css" href="./main.css" />
<script type="text/javascript" src="<?php echo DIR_WS_SCRIPTS?>/overlib.js"></script>
<?php if (SCRIPT_NAME."" == FILENAME_ADD_EVENT || SCRIPT_NAME."" == FILENAME_DETAILS_VIEW) { ?>
<?php } ?>
</head>

<body>

<div id="overDiv" style="position:absolute; visibility:hide;"></div>


<table cellspacing="5" cellpadding="5" width="100%" border="0">
<tr><td valign="top"><?php include('nav_bar_widget.php'); ?></td></tr>
<tr><td>

<?php
  if (!empty($page_title_bar)) {
?>
<table cellspacing="1" cellpadding="1" width="100%" border="0">
  <tr>
    <td align="left" class="SectionHeaderStyle">
	<?php echo htmlentities($page_title_bar); ?>
    </td>
  </tr>
</table>
<?php
}
?>


<?php
  if (!empty($page_error_message)) {
?>

<p align="center" class="Warning"><?php echo htmlentities($page_error_message); ?></p>

<?php
  }
?>
<?php
  if (!empty($page_info_message)) {
?>
<p align="center" class="FontBlack"><?php echo htmlentities($page_info_message); ?></p>
<?php
  }
?>