<script>
$(function(){

	
});
</script>
<?php
function navDisabled($isSelected) {
	list($isDisabled, $level) = explode('/', $_SERVER['REQUEST_URI']);
	if($level=='' || ($level!='store' && $level!='info')) $level = 'home';	
	if($isSelected==$level) $isDisabled = 'selected_'.$level;
	return $isDisabled;
}
?>

<div class="hakko_shadow">
  <table align="center" class="hakko_nav" border="0" cellpadding="0" cellspacing="0" width="970">
    <tr>
      <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left"><img src="<?php echo $GLOBALS['SITE']; ?>images/fansubs_logo.png" width="370" height="79" border="0" /></td>
            <td align="right" valign="bottom">
            <input type="button" class="nav_home <?php echo navDisabled('home'); ?>" level="home" value="" onclick="urlState(this, 1, '/')"  />
            <input type="button" class="nav_store <?php echo navDisabled('store'); ?>" level="store" value="" onclick="urlState(this, 1, '/store')" />          
            <input type="button" class="nav_info <?php echo navDisabled('info'); ?>" level="info" value="" onclick="urlState(this, 1, '/info')" />       
            </td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td align="left"><div class="logo_line"></div></td>
    </tr>
    <tr>
      <td align="left"><?php
		list($isDisabled, $level) = explode('/', $_SERVER['REQUEST_URI']);
		if($level=='' || ($level!='store' && $level!='info')) $level = 'home';
		?>
        <div id="main_body"></div>
      </td>
    </tr>
    <tr>
      <td align="left"><div align="right" style="margin-bottom:30px;"><img src="<?php echo $GLOBALS['SITE']; ?>images/credit.png" width="175" height="25" border="0" /></div></td>
    </tr>
  </table>
</div>

