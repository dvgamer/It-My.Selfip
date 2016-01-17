<?php
$site = array(
	STORE => 'file_store',
	COM => 'facebook/component/',	
	MOD => 'facebook/module/',	
	APP => 'http://apps.facebook.com/hakkomew/',
);
require_once $_SERVER['DOCUMENT_ROOT'].'/facebook/cgi-bin/connection.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/facebook/cgi-bin/manga.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/facebook/cgi-bin/language/thai.language.php';	
?>