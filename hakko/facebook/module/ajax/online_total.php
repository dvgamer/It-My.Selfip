<?php
	$site = array(
		DOMAIN => 'http://'.$_SERVER['HTTP_HOST'].'/',
		ROOT => $_SERVER['DOCUMENT_ROOT'].'/',
		MOD => 'facebook/module/',	
	);		
	require_once $site[ROOT].'facebook/cgi-bin/connection.class.php';
	require_once $site[ROOT].'facebook/cgi-bin/language/thai.language.php';
	
	$online = new PDOConnection();
	$total_online = $online->CountRow('user_online', 0, 0);
	$guest_online = $online->CountRow('user_online', 'guest', 1);
?>
<?php echo ($total_online-$guest_online)._MANGA_READ; ?> 
<?php if($guest_online!=0): ?>
<span class="text-detail">(<?php echo _MANGA_GUEST.$guest_online._MANGA_READ; ?>)</span>
<?php endif; ?>