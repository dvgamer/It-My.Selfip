<link rel="stylesheet" type="text/css" href="http://hakko.9friend.net/facebook/include/slider_css.css" />
<script type="text/javascript" src="http://hakko.9friend.net/facebook/include/if_js/jquery.min-1.4.3.js"></script>
<script type="text/javascript" src="http://hakko.9friend.net/facebook/include/if_js/s3Slider.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$('#s3slider').s3Slider({ 
		timeOut: 8000 
	});
});
</script>
<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/facebook/include/ajax.require.php';
	
	$gallery = new MangaReader(array('facebook','module','slider'));	
	$listImage = $gallery->getArray();
	shuffle($listImage);
?>

<div id="slide-space"><div id="slide-img"><div id="s3slider"><ul id="s3sliderContent">
<?php foreach($listImage as $image): 
	$tmp = explode('-',iconv('utf-8','tis-620',$image['name']));
	$infoText = explode('.',$tmp[1]);
	$infoName = $tmp[0];
	$infoText = $infoText[0];
?>
<li class="s3sliderImage"><img src="<?php echo $image['source']; ?>" />
<span style="color:#999999;"><h1><?php echo trim($infoText); ?></h1>
&nbsp;&nbsp;&nbsp;<?php echo trim($infoName); ?></span></li>
<?php endforeach; ?>
</ul></div></div></div>







