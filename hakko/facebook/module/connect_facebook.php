<?php
	$facebook = self::Facebook('/me');
	
	// Session based API call.
	$session = $facebook['session'];
	$user = $facebook['api'];
	$connect = $facebook['fb'];
			
	// login or logout url will be needed depending on current user state.	
	if(!isset($session['uid'])){ 
		$loginUrl = $connect->getLoginUrl(array('req_perms'=>'publish_stream, email', 'next'=>$this->site[APP], 'cancel_url'=>''));
		echo '<div style="margin:10px 0 20px 0;">';
		echo '<center><a href="'.$loginUrl.'"><div class="connect_uid" style="margin:5px;"></div></a></center></div>';
	} else { 
		if(parent::CountRow('user', 'uid', $session['uid'])<1) {
			$username = parse_url($user['link']);
			$username = explode("/",$username['path']);
			$this->Insert('user', array('uid','user','class_id','name'), array($session['uid'],$username[1],1,$username[1]));
		}
		$class_id = parent::GetValue('class_id', 'user', 'uid', $user['id']);
		$userClass = parent::GetValue('title', 'user_class', 'class_id', $class_id);		
		$userName = parent::GetValue('user', 'user', 'uid', $user['id']);		
?>
<script>
	function RefreshAjax() {
		// declare a new FBJS AJAX object
		var ajax = new Ajax(); 
		ajax.responseType = Ajax.FBML; 
		// define a callback to handle the response from the server
		ajax.ondone = function(data) { 
			document.getElementById('online-total').setInnerFBML(data);
			nextTime=1;
		} 
		// collect field values
		ajax.post('<?php echo $this->site[DOMAIN].$this->site[MOD].'ajax/online_total.php'; ?>');
	}
	RefreshAjax();
</script>

<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fapps%2Fapplication.php%3Fid%3D177780198930005&amp;width=292&amp;colorscheme=light&amp;show_faces=false&amp;stream=false&amp;header=false&amp;height=62" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:62px;" allowTransparency="true"></iframe>
<div style="margin-left:10px;" onmouseover="RefreshAjax();">
  <div style="padding-bottom:3px;">Welcome, <strong><fb:userlink uid="<?php echo $user['id']; ?>"></fb:userlink></strong></div>
  <div><?php echo '<strong>'._LOGIN_CLASS.'</strong> '.$userClass; ?></div>
  <div><?php echo '<strong>'._LOGIN_ONLINE.'</strong> '; ?><span id="online-total">
    <fb:tag name="img"><fb:tag-attribute name="src">http://b.static.ak.fbcdn.net/rsrc.php/yb/r/GsNJNwuI-UM.gif</fb:tag-attribute>
    <fb:tag-attribute name="hspace">1</fb:tag-attribute></fb:tag> 
  </span></div>  
</div>

<?php }?>
