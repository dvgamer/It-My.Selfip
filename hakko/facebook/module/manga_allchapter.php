<?php
	list($content['name'], $content['chapter']) = explode('|',self::urlDecode($_GET['manga']));			
	$content['name'] = rawurldecode($content['name']);	
	$facebook = self::Facebook('/me');
	$content['mag_id'] = parent::GetValue('mag_id','manga','name',$content['name']);
	
?>
<div style="width:100%; height:3px;">&nbsp;</div>
<div style="margin-top:5px; border-top:#CCC solid 1px;">&nbsp;
<?php foreach(parent::ViewTableWhere('manga_chapter','mag_id',$content['mag_id'],'list_id DESC',0) as $chapter): ?>
<?php if($facebook['session']): ?>
<a href="<?php echo self::BuildQuery(array('component'=>'translator','manga'=>$content['name'].'|'.$chapter['list_id'])); ?>"><div id="manga-chapter">
<?php else: ?>
<div id="manga-chapter-none">
<?php endif; ?>
<div id="list-chapter">Chapter <?php echo $chapter['list_id']; ?></div>
<div id="name-chapter"><?php echo $chapter['chapter_name']; ?></div>
<?php if($facebook['session']): ?>
</div></a>
<?php else: ?>
</div>
<?php endif; ?>
<?php endforeach; ?>
</div>