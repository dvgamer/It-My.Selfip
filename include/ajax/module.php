<?php
$modFolders = new DriveReader($GLOBALS['ROOT'].'module/');
$modFoundFolder = false;
foreach($modFolders->ListsFolder() as $mod){
	list($tmp, $name) = explode('mod_', $mod);
	if(trim($name)==trim($_GET['name'])) {
		$modFoundFolder = true;
		break;
	}
}
if($modFoundFolder) {
	include_once('module/'.$mod.'/'.$_GET['name'].'.php');
} else {
	echo '<div id="exception">'._EXCEPTION_MODULE.'</div>';
}

?>
