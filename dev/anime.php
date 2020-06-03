<?php
date_default_timezone_set("Asia/Bangkok");

echo urlencode("&");
$location = "F:\\";
$goingOnValid = "\[OnGoing]";
$dir = opendir($location);
$animeGoingOn = array();

while ($entry = readdir($dir))
{
	if(is_dir($location.$entry))
	{
		if(eregi($goingOnValid,$entry))
		{
			$name = ereg_replace('\[OnGoing]','',$entry);
			$name = explode('[',$name);
			$list = explode(']',$name[1]);
			
			$anime = array();
			
			$anime['episode'] = trim($list[0]);
			$anime['name'] = trim(ereg_replace('\1st|\2nd|\3rd|\4th','',$name[0]));
			$animeGoingOn[] = $anime;
		}
	}
}

$txtNameFile = "C:/Users/HaKko/Documents/Rainmeter/Skins/HaKkoMEw/OnGoing/name.txt";
$txtChapterFile = "C:/Users/HaKko/Documents/Rainmeter/Skins/HaKkoMEw/OnGoing/chapter.txt";
if(file_exists($txtNameFile) && file_exists($txtChapterFile))
{
	$isNmFile = fopen($txtNameFile, 'w');
	$isChFile = fopen($txtChapterFile, 'w');
	foreach($animeGoingOn as $anime)
	{
		if (strlen($anime['episode'])==3) {
			echo '<strong>'.$anime['episode'].'</strong> '.$anime['name'].'<br>';
			fputs($isChFile, $anime['episode']."\r\n");
			fputs($isNmFile, $anime['name']."\r\n");
		}
	}
	foreach($animeGoingOn as $anime)
	{
		if (strlen($anime['episode'])==2) {
			echo '&nbsp;&nbsp;<strong>'.$anime['episode'].'</strong> '.$anime['name'].'<br>';
			fputs($isChFile, " "." ".$anime['episode']."\r\n");
			fputs($isNmFile, $anime['name']."\r\n");
		}
	}
	fclose($isNmFile);
	fclose($isChFile);
} else {
	echo 'Not Found.';
}
?>