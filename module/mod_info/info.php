<script>
var preloading = '<img src="../../images/loading_wh.gif" vspace="160" hspace="200" />';
var modSelected = null;
var preloadWait = false;
function devSelected(modoule, name) {
	if(!preloadWait) {
		preloadWait = true;
		if(modSelected) { $(modSelected).removeClass('selected'); }
		$(modoule).addClass('selected');
		$('#box_contents').html(preloading);
		$.ajax({ url:'http://it-my.selfip.info/dev/'+name,
			dataType: 'html',
			error: function(){ },
			success: function(data){		
				$('#box_contents').html(data);
				modSelected = modoule;
				preloadWait = false;
			},
		});
	}
}
</script>
<?php
$devfiles = new DriveReader("dev/");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70%" valign="top" style="padding-right:15px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td class="conner-lt"></td><td class="border-t"></td><td class="conner-rt"></td></tr>
        <tr><td class="border-l"></td>
          <td class="box_main"><div id="box_contents">&nbsp;</div></td>
        <td class="border-r"></td></tr>
        <tr><td class="conner-lb"></td><td class="border-b"></td><td class="conner-rb"></td></tr>
      </table>
    </td>
    <td width="30%" valign="top">
	   <?php foreach($devfiles->ListsFile() as $dev): ?>
      <div id="list_dev" onclick="devSelected(this,'<?php echo $dev; ?>')"><?php
	    $contents = file_get_contents('dev/'.$dev);
		$get_name = explode('<title>', $contents);
		if(count($get_name)!=1) {
			list($get_name) = explode('</title>', $get_name[1]);
		} else {
			$get_name = $dev;
		}
		
		$get_details = explode('<!--', $contents);
		if(count($get_details)!=1) {
			list($get_details) = explode('-->', $get_details[1]);
		} else {
			$get_details = $dev;
		}
	    ?><name><?php echo $get_name; ?></name>
        <details id="<?php echo $dev; ?>"><?php echo $get_details; ?></details>
      </div>
      <?php endforeach; ?>
    </td>
  </tr>
</table>