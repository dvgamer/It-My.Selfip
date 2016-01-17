<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/facebook/include/ajax.require.php';
	$HaKko = new MangaReader(array('file_store',$_POST['manga']));
	
	$aNext = false;
	$aBack = false;	
	foreach($HaKko->getArray() as $manga) {
		list($id,$name) = explode('-',$manga['name']);
		$folder['id'] = trim($id);
		$folder['name'] = trim($name);
		if($folder['id']==$_POST['chapter']) {
			$image = new MangaReader(array('file_store',$_POST['manga'],iconv('utf-8','tis-620',$manga['name'])));
			$imageSort = $image->getArray();
			sort($imageSort);
			foreach($imageSort as $index=>$list) {
				if(($index+1)==$_POST['id']) {					
					$getImage = $list['source'];
					$height = getimagesize($list['path']);
				}
			}
		}
	}	
	echo json_encode(array('source'=>$getImage,'total'=>count($imageSort),'height'=>$height[1]));
?>