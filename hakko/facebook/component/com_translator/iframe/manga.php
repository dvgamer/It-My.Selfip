<link rel="stylesheet" type="text/css" href="http://hakko.9friend.net/facebook/include/manga_css.css" />

<script type="text/javascript" src="http://hakko.9friend.net/facebook/include/if_js/jquery.min-1.4.3.js"></script>
<script type="text/javascript" src="http://hakko.9friend.net/facebook/include/if_js/jquery.rightClick.js"></script>
<script type="text/javascript" src="http://hakko.9friend.net/facebook/include/if_js/jquery.disable.text.select.js"></script>
<script language="javascript">
	$(document).ready(function() {	
		var imageManga = '<?php echo ereg_replace('_',' ',$_GET['manga']); ?>';
		var imageChapter = '<?php echo $_GET['chapter']; ?>';
		var imageCurrent = 1;
		var imageTotal = 0;
		// Disable context menu on an element
		$("body").noContext();
		$('body').disableTextSelect();
		PriviewImage(imageCurrent);
		function PriviewImage(value)
		{ 
			$.ajax({ url: 'http://hakko.9friend.net/facebook/component/com_translator/iframe/engine.image.php',
				type: 'POST',
				data: ({ manga : imageManga, chapter: imageChapter, id: value }),
				dataType: 'json',
				error: function (data){
					$('body').html('Not Found.');
				},
				beforeSend: function() {
					$('#preload').show();
				},
				success: function (image){
					imageTotal = image.total;					
					$('#preload').hide();
					$('#image-view').css({
						'background': 'url('+image.source+') 1px 1px no-repeat',
						'width': '750px',
						'height': image.height,
						'padding': '1px',
						'border': '#999 solid 1px',
					});	
				},
			});
		}
		
		// Left Click Image
		$('#image-view').click(function() {
			NextPage();
		});										
		// Right Click Image
		$('#image-view').rightClick(function(){
			BackPage();
		});
		
		$(document).keydown(function(e){
			if(e.keyCode == 37) { 
				BackPage();
				return false;
			} 
			if(e.keyCode == 39) {
				NextPage();
				return false;
			}					
		});			
		
		function NextPage()
		{			
			if((imageCurrent+1)<=imageTotal)
			{
				imageCurrent++;
				PriviewImage(imageCurrent);
			}
		}
		
		function BackPage()
		{
			if((imageCurrent-1)>0)
			{
				imageCurrent--;
				PriviewImage(imageCurrent);
			}
		}		
	});
</script>
<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/facebook/include/ajax.require.php';	
	$raw['manga'] = ereg_replace('_',' ',$_GET['manga']);		
	$raw['chapter'] = $_GET['chapter'];		
?>
<span id="preload" style="float:right; margin:10px; padding:5px; display:none; background-color:#FFF; border:#000 solid 1px;">
<strong>Loading...</strong>
</span><div id="image-view"></div>