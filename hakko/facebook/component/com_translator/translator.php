<?php
	// Create our Application instance.
	$facebook = self::Facebook('/me');
	$content['engine'] = 'NotAllow';
	list($content['name'], $content['chapter']) = explode('|',self::urlDecode($_GET['manga']));			
	$this->idChapter = $content['chapter'];
	
	$content['mag_id'] = parent::GetValue('mag_id','manga','name',$content['name']);
	$content['valid'] = parent::CountRow('manga','name',$content['name']);
	
	if(!$content['chapter'] && $content['valid']) {
		//------------------------
		foreach(parent::ViewTableWhere('manga', 'mag_id', $content['mag_id'], 0, 1) as $table)
		{						
			$manga['name'] = $table['name'];
			$manga['status'] = $table['status'];
			$manga['summary'] = $table['summary'];
			$manga['created'] = $table['created'];
			$manga['view'] = $table['view'];
			$manga['link'] = $table['link'];
			$manga['xid'] = ereg_replace(' ','_',$table['name']);;
			$manga['author'] = _MANGA_NONE2;
			$manga['genre'] = _MANGA_NONE2;
			$manga['translator'] = _MANGA_NONE;
			$manga['author'] = $this->StringGroup('group_author', $table['mag_id'], 'manga_author', 'aut_id', 'aut_id', 'author_name'); 
			$manga['genre'] = $this->StringGroup('group_genre', $table['mag_id'], 'manga_genre', 'gen_id', 'gen_id', 'genre_name');
			$manga['translator'] = $this->StringGroup('manga_chapter', $table['mag_id'], 'user', 'uid', 'trans_uid', 'name');						
		}
		
		$readManga = new MangaReader(array($this->site[STORE],$manga['name']));
		$manga['cover'] = 'http://hakko.9friend.net/images/none-cover.jpg';
		$manga['thumb'] = 'http://hakko.9friend.net/images/none-thumb.jpg';
		$manga['fbthumb'] = '';
		
		foreach($readManga->getArray() as $chapter)
		{
			$info = pathinfo($chapter['name']);
			if($info['filename']=='cover'){
				$manga['cover'] = $chapter['source'];
			} elseif($info['filename']=='thumb'){
				$manga['thumb'] = $chapter['source'];
			} elseif($info['filename']=='fbthumb'){
				$manga['fbthumb'] = $chapter['source'];
			}
		}
		//------------------------
	} else {

	}
	
	// Manga Reader And View
	if($facebook['session']) {		
		if(isset($_GET['manga'])) {			
			if(!$content['valid']) {				
				$content['engine'] = 'KnowManga';
			} else {
				// User Online AddView
				$this->Update('user_online', 'mag_id', $content['mag_id'], 'uid', $facebook['session']['uid']);	
				(int)$viewManga = $this->GetValue('view', 'manga', 'name', $content['name']);
				$viewManga++;
				$this->Update('manga', 'view', $viewManga, 'name', $content['name']);	
				
				if(!$content['chapter']) {							
					$content['engine'] = 'MangaView';
				} else {
					$content['source'] = $this->site[DOMAIN].$this->site[COM].'com_'.$_GET['component'];
					$content['engine'] = 'ChapterRead';
				}
			}
		} else {
			$content['engine'] = 'Translator';
			$this->Update('user_online', 'mag_id', 0, 'uid', $facebook['session']['uid']);
		}
	} else {
		$content['engine'] = 'NotAllow';
	}
?>
<?php
///// Manga Detail View for Select Chapter \\\\\ name	status	link	summary	created	view
switch($content['engine']): case 'MangaView':
?>
<h1><a href="<?php echo $this->site[APP]; ?>">HaKkoMEw</a> >> <?php echo $manga['name']; ?></h1>
<hr>
<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td valign="top" width="200"><div class="img-manga" style="background:url(<?php echo $manga['cover']; ?>);"></div></td>
    <td valign="top" width="300" class="textbox">
    <div id="share" style="float:right">
    <fb:share-button class="meta">
      <meta name="medium" content="mult"/>
      <meta name="title" content="<?php echo $manga['name']; ?>"/>
      <meta name="description" content="<?php echo $manga['summary']; ?>"/>
      <link rel="image_src" href="<?php echo $manga['fbthumb']; ?>"/>
      <link rel="target_url" href="<?php echo $manga['link']; ?>"/>
    </fb:share-button>
    </div><br />
    <h2><?php echo _MANGA_AUTHOR; ?></h2><span id="details"><?php echo $manga['author']; ?></span>
    <h2><?php echo _MANGA_GENRE; ?></h2><span id="details"><?php echo $manga['genre']; ?></span>    
    <h2><?php echo _MANGA_TRANSLATOR; ?></h2><span id="details"><?php echo $manga['translator']; ?></span>
    <h2><?php echo _MANGA_CREATED; ?></h2><span id="details"><?php echo BB::Date($manga['created'],'m'); ?></span>
    <h2><?php echo _MANGA_VIEW; ?></h2><span id="details"><?php echo $manga['view']._MANGA_READ; ?></span>
    <h2><?php echo _MANGA_STATUS; ?></h2><span id="details"><?php echo $manga['status']; ?></span>
    </td>
  </tr>
  <tr>
    <td valign="top" colspan="2"><h2><?php echo _MANGA_SUMMARY; ?></h2><span id="details"><?php echo BB::Code($manga['summary']); ?></span></td>
  </tr>
</table><br /><hr /><br />
<fb:comments class="meta" xid="<?php echo $manga['xid']; ?>_comments" canpost="true" candelete="false" showform="true" numposts="20" returnurl="<?php echo $manga['link']; ?>">
</fb:comments>
<?php 
///// Read Manga Chapter Select. \\\\\
break; case 'ChapterRead': 
?>
<center>
  <h1><a href="<?php echo $this->site[APP]; ?>?component=translator&manga=<?php echo self::urlEncode($content['name']); ?>"><?php echo $content['name']; ?></a></h1>
  <p><h3>Chapter - <?php echo $content['chapter']; ?></h3>
  (<strong>NextPage:</strong> Left-click on image. OR Press right Arrow-Key. / <strong>BackPage:</strong> Right-click on the image. OR Press left Arrow-Key.)</p>  
</center>
<iframe name="manga-read" id="manga-read" src="<?php echo $content['source']; ?>/iframe/manga.php?manga=<?php echo $content['name']; ?>&chapter=<?php echo $content['chapter']; ?>" 
frameborder="0" width="758" height="1150" scrolling="no"></iframe>   
<?php 
///// Menu Setting For Translator \\\\\
break; case 'Translator': 
?>
        Translator;
<?php 
///// For Not Allow App facebook \\\\\
break; case 'Error': 
?>
       KnowManga
<?php 
///// For Not Allow App facebook \\\\\
break; default: 
?>
<h1><a href="<?php echo $this->site[APP]; ?>">HaKkoMEw</a> >> <?php echo $manga['name']; ?></h1>
<hr>
<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td valign="top" width="200"><div class="img-manga" style="background:url(<?php echo $manga['cover']; ?>);"></div></td>
    <td valign="top" width="300" class="textbox">
    <div id="share" style="float:right">
    <fb:share-button class="meta">
      <meta name="medium" content="mult"/>
      <meta name="title" content="<?php echo $manga['name']; ?>"/>
      <meta name="description" content="<?php echo $manga['summary']; ?>"/>
      <link rel="image_src" href="<?php echo $manga['fbthumb']; ?>"/>
      <link rel="target_url" href="<?php echo $manga['link']; ?>"/>
    </fb:share-button>
    </div><br />
    <h2><?php echo _MANGA_AUTHOR; ?></h2><span id="details"><?php echo $manga['author']; ?></span>
    <h2><?php echo _MANGA_GENRE; ?></h2><span id="details"><?php echo $manga['genre']; ?></span>    
    <h2><?php echo _MANGA_TRANSLATOR; ?></h2><span id="details"><?php echo $manga['translator']; ?></span>
    <h2><?php echo _MANGA_CREATED; ?></h2><span id="details"><?php echo BB::Date($manga['created'],'m'); ?></span>
    <h2><?php echo _MANGA_VIEW; ?></h2><span id="details"><?php echo $manga['view']._MANGA_READ; ?></span>
    <h2><?php echo _MANGA_STATUS; ?></h2><span id="details"><?php echo $manga['status']; ?></span>
    </td>
  </tr>
  <tr>
    <td valign="top" colspan="2"><h2><?php echo _MANGA_SUMMARY; ?></h2><span id="details"><?php echo BB::Code($manga['summary']); ?></span></td>
  </tr>
</table><br /><hr />
<? endswitch; ?>









