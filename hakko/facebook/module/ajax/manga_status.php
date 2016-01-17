<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/facebook/include/ajax.require.php';
		
	$online = new PDOConnection();	
	$mangaDetails = new MangaReader(array($site[STORE],$_POST['name']));	
	
	$manga['name'] = rawurlencode($_POST['name']).'/';
	foreach($mangaDetails->getArray() as $mlist)
	{
		if(is_file($mlist['path'])) {
			list($filename, $fileextended) = explode('.',$mlist['name']);			
			if($filename=='thumb') {
				$manga['thumb'] = $mangaDetails->getDomain().$mlist['name'];
			}
		}
	}
	if(!isset($manga['thumb'])) { $manga['thumb'] = 'http://hakko.9friend.net/images/none-thumb.jpg'; }
	$manga['view'] = $online->GetValue('view', 'manga', 'mag_id', $_POST['id']);
	$manga['online'] = $online->CountRow('user_online', 'mag_id', $_POST['id']);
?>

<a href="<?php echo $online->GetValue('link', 'manga', 'mag_id', $_POST['id']); ?>"><h2><?php echo $_POST['name']; ?></h2>
<table width="230" border="0" cellpadding="2" cellspacing="0" class="manga-list">
  <tr>
    <td width="50"><div class="thumb-img" style="width:40px;height:40px;">
    <fb:tag name="img">
       <fb:tag-attribute name="src"><?php echo $manga['thumb'];?></fb:tag-attribute>
       <fb:tag-attribute name="alt">
          <fb:intl><?php echo $_POST['name']; ?></fb:intl>
       </fb:tag-attribute>
       <fb:tag-attribute name="width">
          <fb:intl>40</fb:intl>
       </fb:tag-attribute>
       <fb:tag-attribute name="height">
          <fb:intl>40</fb:intl>
       </fb:tag-attribute>   
    </fb:tag>
    </div>
    </td>
    <td>
      <span class="text-detail"><strong><?php echo _MANGA_STATUS; ?></strong> <?php echo $_POST['status']; ?></span><br />
      <span class="text-detail"><strong><?php echo _MANGA_VIEW; ?></strong> <?php echo $manga['view'].' '._MANGA_READ; ?></span><br />
      <span class="text-detail"><strong><?php echo _MANGA_ONLINE; ?></strong> <?php echo $manga['online'].' '._MANGA_READ; ?></span>
    </td>
  </tr>
</table>
</a>
