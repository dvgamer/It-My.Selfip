<?php
include_once('../include/lib/DriveReader.class.php');

$data_avs_scripts = "#VideoSource\r\n";
$data_avs_scripts .= 'video=DirectShowSource("G:\Detective Conan\Detective Conan ~ Season 11 (TureVision) [TH]\"+file, audio=false).ConvertToYV12()'."\r\n\r\n";
$data_avs_scripts .= "#Crop\r\nvideo=Crop(video,10,4,-12,-2)\r\n\r\n#Resize\r\nvideo=Spline36Resize(video,852,480).Sharpen(0.2)\r\n\r\n";
$data_avs_scripts .= "#AudioSource\r\n".'audio=DirectShowSource("G:\Detective Conan\Detective Conan ~ Season 11 (TureVision) [TH]\"+file,video=false)'."\r\n\r\n";
$data_avs_scripts .= "#AudioDub\r\naudio=ConvertAudioTo16bit(audio)\r\nAudioDub(video,audio)";

$conan_list = new DriveReader("G:/Detective Conan/Detective Conan ~ Season 11 (TureVision) [TH]/");
foreach($conan_list->ListsFile() as $file) {
	$tmpinfo = pathinfo($file);
	$write_file = $conan_list->Path($tmpinfo['filename'].".avs");
	if($tmpinfo['extension']!=='avs') {	
		//$is_file = fopen($write_file, 'w+');
		//fputs($is_file, "#FileSource\r\nfile = ".'"'.$file.'"'."\r\n\r\n".$data_avs_scripts);		
		//fclose($is_file);		
		
		echo $conan_list->TIS($file).'<br/>';		
	}	
	if($tmpinfo['extension']=='avs') unlink($write_file);
}


?>
