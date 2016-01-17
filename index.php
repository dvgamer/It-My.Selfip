<?php
error_reporting(0);
date_default_timezone_set("Asia/Bangkok");

// Defualt Config Site
$GLOBALS['ICON'] = "favorite.ico";
$GLOBALS['SITE'] = 'http://'.$_SERVER['SERVER_NAME'].'/';
$GLOBALS['ROOT'] = $_SERVER['DOCUMENT_ROOT'].'/';

// Class Loading...
foreach (glob("include/lib/*.php") as $filename) { include_once($filename); }
if(file_exists($GLOBALS['ROOT']."language/th-TH.php")) include_once($GLOBALS['ROOT']."language/th-TH.php"); 

if(!isset($_GET['ajax'])):
ob_start();
session_start(); ?>
<html><head><?php

// Database Access
$loadConfig = parse_ini_file('config\dbConfig.ini', true);
$database = new dbConection(array('password'=>$loadConfig['db']['password'], 'dbname'=>$loadConfig['db']['dbname'])); ?>

<title><?php echo _TITLE_HEADER; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="Description" content="<?php echo _TITLE_DESCRIPTION; ?>" />
<meta name="Keywords" content="<?php echo _TITLE_KEYWORDS; ?>" />
<?php if(file_exists($GLOBALS['ROOT'].'images/'.$GLOBALS['ICON'])): ?>
<link rel="icon" href="<?php echo $GLOBALS['SITE']; ?>images/<?php echo $GLOBALS['ICON']; ?>">
<link rel="shortcut icon" href="<?php echo $GLOBALS['SITE']; ?>images/<?php echo $GLOBALS['ICON']; ?>">
<?php endif; ?>

<?php // Extented Loading...
if(is_readable($GLOBALS['ROOT'])) {
	foreach (glob("include/*.js") as $filename) { echo '<script type="text/javascript" src="'.$GLOBALS['SITE'].$filename.'"></script>'."\n\r"; }
	foreach (glob("include/css/*.css") as $filename) { echo '<link rel="stylesheet" type="text/css" href="'.$GLOBALS['SITE'].$filename.'" />'."\n\r"; }
	foreach (glob("include/*.php") as $filename) { include_once($filename); }
}
?>
</head>
<body>
<?php 
if(file_exists('template.php')) {
	include_once('template.php');
} else {
	echo '<h1>Error: Not Found Site Directory.</h1>';
}
?>

</body></html>

<?php else:
if(is_file('include/ajax/'.$_GET['ajax'].'.php')) {
	include_once('include/ajax/'.$_GET['ajax'].'.php');
} else {
	echo json_encode(array('error'=>'Not Found'));
}
endif; ?>