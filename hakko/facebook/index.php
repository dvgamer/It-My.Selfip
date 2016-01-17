<?php
// Awesome Facebook Application
//
// Name: HaKkoMEw
//
require_once 'cgi-bin/facebook-php-sdk/facebook.php';
require_once 'include/engine.php';
?>
<!-- Include SDK Other -->
<link rel="stylesheet" type="text/css" href="<?php echo Engine::$config['include']; ?>style_css.css?v=53" />

<?php
$siteEngine = new Engine();
?>
<table width="760" id="main-hakko" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <?php if($siteEngine->CountRow('module',array('com_id','pos_id'),array($siteEngine->idComponent, $siteEngine->idPosition['left']))>=1 && !$siteEngine->idChapter): ?>
    <td align="left" valign="top" style="padding-right:10px;">
	  <?php $siteEngine->Module('left', 230); ?>
    </td>
    <?php endif; ?>
    <?php if($siteEngine->CountRow('module','pos_id',$siteEngine->idPosition['body'])>=1 || $siteEngine->CountRow('component','com_id',$siteEngine->idComponent)): ?>
    <td align="left" valign="top">
	  <?php $siteEngine->Module('user1',500); ?>
	  <?php $siteEngine->MainBody(); ?>
	  <?php $siteEngine->Module('user2',500); ?>
    </td>
    <?php endif; ?>
    <?php if($siteEngine->CountRow('module',array('com_id','pos_id'),array($siteEngine->idComponent, $siteEngine->idPosition['right']))>=1 && !$siteEngine->idChapter): ?>
    <td align="left" valign="top" style="padding-left:5px;">
	  <?php $siteEngine->Module('right',200); ?>
    </td>
    <?php endif; ?>
  </tr>
</table>





