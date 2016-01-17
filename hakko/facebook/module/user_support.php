<?php
	$typeUser = 2;
	foreach(parent::ViewTableWhere('user', 'class_id', $typeUser, 0, 0) as $index=>$user) {
		$userClass = parent::GetValue('title', 'user_class', 'class_id', $user['class_id'])
?>
<table width="225" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="middle" align="right" style="padding-left:5px;">
      <div>
      <strong><fb:userlink uid="<?php echo $user['uid']; ?>"></fb:userlink></strong> 
       <span style="font-size:7px!important;color:#999">(<fb:pronoun uid="<?php echo $user['uid']; ?>" possessive="true" useyou="false"/>)</span>
      </div>
      <div style="font-size:9px;color:#666;"><?php echo $user['name']; ?></div>
    </td>
    <td valign="top" align="left" width="35">
      <div class="thumb-img" style="width:35px; height:35px;">
      <fb:profile-pic uid="<?php echo $user['uid']; ?>" facebook-logo="false" size="square" width="35" linked="true" />
      </div>
    </td>
  </tr>
</table>
<?php
		if(parent::CountRow('user', 'class_id', $typeUser, 0, 0)!=($index+1)){
			echo '<hr/>';
		}
	}
?>