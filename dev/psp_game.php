<?php
ob_start();
session_start();
date_default_timezone_set("Asia/Bangkok");
switch($_GET['root'])
{
	case 'cookie':
		include_once('../include/lib/Session.class.php');
		$session = new Session();
		$tmp = explode('\\', $_GET['store']);
		$store = '';
		foreach($tmp as $char) { if(trim($char)!='') $store .= $char.'/'; }
		$session->setCookie('DIR_STORE', $store, 0);
		break;
	case 'scripts':		
		include_once('../include/lib/DriveReader.class.php');
		$tmp = explode('\\', $_GET['store']);		$store = '';
		
		foreach($tmp as $char) { if(trim($char)!='') $store .= $char.'/'; }
		if(is_dir($store)) {
		$pspStore = new DriveReader($store);		
			foreach($pspStore->ListsFile() as $new) {
				echo $new.'<br>';
			}
		} else {
			echo 'Directory Not Found.';
		}
		break;
	default:
		include_once('../include/lib/Session.class.php');
		$session = new Session(); ?>
        <title>Created Folder PSP Games</title>
		<script>
        $(function(){  
		      
            $('.btn_psp').click(function(){
				$('#loader').html(preloading);
				$.ajax({ url:'<?php echo $_SERVER['PHP_SELF']; ?>',
					data: { root: 'scripts',store: $('#store').val() },
					dataType: 'html',
					success: function(data){		
						$('#loader').html(data);
					},
				});
			});
			
            $('.btn_save').click(function(){
				$.ajax({ url:'<?php echo $_SERVER['PHP_SELF']; ?>',
					data: { root: 'cookie',store: $('#store').val() },
					dataType: 'html',
					success: function(data){ alert('Save Complated.') },
				});
			});
        });
        </script>
		<style type="text/css">
        .store_dir { width:250px; }
        .btn_save { width:80px; font-size:11px; }
        .btn_psp { width:160px; font-weight:bold; font-size:11px; }
        </style>
        <table width="580" border="0" cellspacing="0" cellpadding="0" style="color:#333; position:fixed; background-color:#FFF;">
          <tr>
            <td width="75"><strong>PSP Store: </strong></td>
            <td width="260"><input type="text" id="store" class="store_dir" value="<?php echo $session->Value('DIR_STORE'); ?>" /></td>
            <td valign="top">
             <input type="button" class="btn_psp" value="Run Scripts" />
             <input type="button" class="btn_save" value="Save" />
            </td>
          </tr>
        </table>
		<div style="height:25px;"></div>
        <div id="loader">&nbsp;</div>
		<?php
		break;		
}
?>
<!--
สร้างโฟล์เดอร์ให้เกมส์รอมของเครื่อง PSP 
-->