<div style="float:right; margin:4px;">
<a href="http://www.facebook.com/board.php?app_id=177780198930005&amp;xid=hakkomew_board&amp;c_url=http%253A%252F%252Fapps.facebook.com%252Fhakkomew%252F&amp;r_url=http%253A%252F%252Fapps.facebook.com%252Fhakkomew%252F&amp;flavor=3&amp;sig=3389f64bfc9356fc1e93ba9d585383ce">
<?php echo _BOARD_TOPICS_VIEW_ALL; ?></a>
</div>
<?php
	$facebook = self::Facebook('/me');
?>
<fb:board xid="hakkomew_board" 
  canpost="<?php if($facebook['session']): echo 'true'; else: echo 'false'; endif; ?>"
  candelete="false" 
  canmark="true" 
  cancreatetopic="<?php if($facebook['session']): echo 'true'; else: echo 'false'; endif; ?>" 
  numtopics="10"
  returnurl="http://apps.facebook.com/hakkomew/">
    <fb:title><?php echo $module['title']; ?></fb:title>
</fb:board>
