<script>
	function RefreshManga(idManga,nameManga,statusManga) {
		var DOMManga = document.getElementById('updateManga-'+idManga);
		var ajax = new Ajax(); 
		ajax.responseType = Ajax.FBML;
		ajax.ondone = function(data) { 		
			Animation(DOMManga).to('height', '75px').duration(100).go();		
			DOMManga.setInnerFBML(data);
		}		
		var queryParams = { 'id' : idManga, 'name' : nameManga, 'status' : statusManga };        
		ajax.post('<?php echo $this->site[DOMAIN].$this->site[MOD].'ajax/manga_status.php'; ?>', queryParams);
	}
</script>

<?php foreach(parent::ViewTableWhere('manga', 0, 0, 'created DESC', '0,10') as $index=>$manga):?>
<script>
	RefreshManga(<?php echo $manga['mag_id']; ?>,'<?php echo $manga['name']; ?>','<?php echo $manga['status']; ?>');
</script>
<div class="manga-list"><div id="updateManga-<?php echo $manga['mag_id']; ?>" style="height:35px; overflow:hidden;" 
onmouseover="RefreshManga(<?php echo $manga['mag_id']; ?>,'<?php echo $manga['name']; ?>','<?php echo $manga['status']; ?>');" >
<h2><?php echo $manga['name']; ?></h2>
<span class="text-detail" style="margin-left:10px;"><strong><?php echo _MANGA_STATUS; ?>:</strong> <?php echo $manga['status']; ?></span>
</div></div>
<?php endforeach; ?>