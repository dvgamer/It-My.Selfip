<?php
	// Create our Application instance.
	$facebook = self::Facebook('me');
	$image_fbthumb = $this->site[DOMAIN].'images/hakko-logo.jpg';	
?>


<br /><div id="share">
<fb:share-button class="meta">
  <meta name="medium" content="mult"/>
  <meta name="title" content="HaKKoMEW - Managa Online"/>
  <meta name="description" content="<?php echo _MANGA_SHARED; ?>"/>
  <link rel="image_src" href="<?php echo $image_fbthumb; ?>"/>
  <link rel="target_url" href="http://apps.facebook.com/hakkomew/"/>
</fb:share-button>
</div>
