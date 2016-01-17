<?php
$iSymbol = json_decode("[\"\u2022\"]");
$iWrongFolder = array(".","..","\$RECYCLE.BIN", "System Volume Information");
$iStore = array("F:\/", "G:\/");
$iData = array();
foreach($iStore as $iPath) {
  if(is_dir($iPath)) {
	  $iResource = opendir($iPath);
	  while(($iFolder = readdir($iResource))!==false)
	  {
		  $iFound = false;
		  foreach($iWrongFolder as $DelFolder) { if($iFolder===$DelFolder) { $iFound = true; } }
		  if(is_dir($iPath.$iFolder) && !$iFound) {
			  $DataAnime = new Anime($iPath.$iFolder.'\\');
  
			  $aTitle = trim($DataAnime->Name['en']);
			  $iKey = trim($DataAnime->Name['en'])." ".$DataAnime->Year." ".$DataAnime->Season;
			  if(isset($DataAnime->Episode['en'])) {
				  $aTitle .= " ".$iSymbol[0]." ".trim($DataAnime->Episode['en']);
			  }
			  $eName = trim($DataAnime->Name['en']);
			  if(strlen($aTitle)>36) $aTitle = trim(substr($aTitle,0,36))."...";
			  
			  $tName = trim($DataAnime->Name['th']);
			  if(!isset($DataAnime->Name['th'])) {
				  $tName = trim($DataAnime->Episode['th']);
			  } elseif(isset($DataAnime->Episode['th'])) {
				  $tName .= " ".$iSymbol[0]." ".trim($DataAnime->Episode['th']);
			  }
						  
			  $aType = $DataAnime->Type;
			  $aEnd = $DataAnime->ChapterEnd;
			  if($DataAnime->Release=="TV") $aType = "TV Series";
			  if($DataAnime->ChapterEnd=="#")$aEnd = "-";
			  if(!isset($DataAnime->Type) && $DataAnime->Release!="TV") $aType = $DataAnime->Release;
			  if(!isset($DataAnime->Type) && $DataAnime->Release=="Blu-ray") $aType = "TV Series";
			  $aSubject = "[".$DataAnime->ChapterNow."] ".$aType." ".$aEnd." ตอน";
			  
			  $aChapter = $DataAnime->ChapterNow." จาก ".$aEnd." ตอน";
			  if($DataAnime->ChapterNow==$DataAnime->ChapterEnd) {
				  $aChapter = "Complated";
				  $aSubject = $aType." (".$DataAnime->Items." ตอน)";
			  }
			  
			  $aVideo = "<strong>Video:</strong> ";
			  if(((int)$DataAnime->Resolution)>=720) {
				  $aVideo .= "Hi-def ".$DataAnime->Resolution;
			  } else {
				  $aVideo .= "Normal ".$DataAnime->Resolution;
			  }
			  
			  $aAudio = "<strong>Audio:</strong> ".Anime::Language($DataAnime->Audio);
			  $aSubtitle = "<strong>Subtitle:</strong> ".Anime::Language($DataAnime->Subtitle);		
			  $aSeason = Anime::Season($DataAnime->Season)." ".$DataAnime->Year;
			  if($DataAnime->Season==0 && $DataAnime->Year!=0) {
				  $aSeason = $DataAnime->Year;
			  } elseif($DataAnime->Year==0) {				
				  $aSeason = Anime::Season($DataAnime->Season);
			  }
			  $aSize = "<strong>Size: </strong>".Anime::Size($DataAnime->Sizes)." (".$DataAnime->Items." Items)";
			  if(!count($DataAnime->Fansub)) $aFansub = "None"; else $aFansub = implode("<br>", $DataAnime->Fansub);
			  
			  $ImageName = $DataAnime->Year."-".$DataAnime->Season."-".trim($DataAnime->Name['en']);
			  if(isset($DataAnime->Episode['en'])) $ImageName .= "-".trim($DataAnime->Episode['en']);
			  $iImage = ereg_replace("[\.\-\![:space:]]","", strtolower($ImageName)).".jpg";
			  if(!file_exists("C:\/AppServ\/www\/al3e.ru\/store\/snapshot\/".$iImage)) $iImage = "!no-image.jpg";
			  $iIcon = 0;
			  if($DataAnime->Drop) {
				  $iIcon = 2;
			  } elseif($DataAnime->Release=="RAW") {
				  $iIcon = 3;
			  } elseif($DataAnime->Release=="Blu-ray") {
				  $iIcon = 1;
			  }
			  
			  $iRepeat = false;
			  $iListSub = array();
			  for($dLoop=0;$dLoop<count($iData);$dLoop++) {
				  if($iData[$dLoop]["eName"]==trim($DataAnime->Name['en'])) {
					  $iRepeat = true;
					  $iData[$dLoop]["List"][] = array(
						  "Key"=>$iKey,
						  "Icon"=>$iIcon,
						  "Title"=>$aTitle,	
						  "Subject"=>$aSubject,	
						  "eName"=>$eName,	
						  "tName"=>$tName,	
						  "Type"=>$aType,	
						  "Chapter"=>$aChapter,
						  "Size"=>$aSize,
						  "Fansub"=>$aFansub,
						  "Video"=>$aVideo,	
						  "Audio"=>$aAudio,	
						  "Subtitle"=>$aSubtitle,	
						  "Season"=>$aSeason,	
						  "Img"=>$iImage
					  );
				  }
			  }
			  if(!$iRepeat) {
				  $iData[] = array(
					  "Key"=>$iKey,
					  "Icon"=>$iIcon,
					  "Title"=>$aTitle,	
					  "Subject"=>$aSubject,	
					  "eName"=>$eName,	
					  "tName"=>$tName,	
					  "Type"=>$aType,	
					  "Chapter"=>$aChapter,
					  "Size"=>$aSize,
					  "Fansub"=>$aFansub,
					  "Video"=>$aVideo,	
					  "Audio"=>$aAudio,	
					  "Subtitle"=>$aSubtitle,	
					  "Season"=>$aSeason,	
					  "Img"=>$iImage,
					  "List"=>array()
				  );
			  }
		  }		
	  }	
  } else {
	  echo json_encode(array("Can't Open Directory."));
  }
}
sort($iData);
for($dLoop=0;$dLoop<count($iData);$dLoop++) sort($iData[$dLoop]["List"]);
?><pre><? print_r($iData); ?></pre><?php
//foreach($iData as $anime) echo $anime["Img"]."<br>";

$jsonName = "C:\AppServ\www\al3e.ru\_sync\ongoing.json";
$Resource = fopen($jsonName, "w");
fputs($Resource, json_encode($iData));

fclose($Resource);
//echo json_encode($iData);

class Anime
{
	protected $iFolderName;
	public $iPathName = "";
	public $Drop = false; 	// !!Drop, !#Raw
	public $Name = array("en"=>NULL);
	public $Episode = array("en"=>NULL);
	public $Fansub = array();
	public $Sizes = 0;
	public $Items = 0;
	public $ChapterNow = 0;
	public $ChapterEnd = 0;
	public $Type = NULL;			 // TV Series, OVA, OAD, ONA, Movie, SP
	public $Release = "TV";		  // SD, PAL, NTSC, Blu-ray  [PAL=4:3, NTSC=16:9 (<720p), SD=VCD]
	public $Resolution = "720p";	 // , 720p, 1080p  
	public $Audio = array("JPN");		// JPN, THA, ENG
	public $Subtitle = array("THA");		// THA, KOR, JPN, ENG, NONE
	public $Year = 0;
	public $Season = 0;	// Spring, Summer, Autumn, Winter

	public function __construct($path)
	{
		$path = str_replace("\\\\", "", str_replace("/", "", $path));		
		$this->iPathName = $path;
		while(substr($path, strlen($path)-1,1)=="\\") { $path = substr($path, 0, strlen($path)-1); }
		$subFolder = explode("\\", $path);
		$this->iFolderName = trim($subFolder[count($subFolder)-1]);
		// Check in Directory for Database
		
		$iAnime = opendir($this->iPathName);
		while(($iList = readdir($iAnime))!==false)
		{
			if(is_file($this->iPathName.$iList)) {
				
				// Get file size Not OVER 4GB
				$file = stat($this->iPathName.$iList);
				$this->Sizes += (float)($file['size']);
				
				$this->Items++;
				$iChar = 0;
				$iFansub = "";
				$iFound = false;
				while($iChar<strlen($iList))
				{
					$chkchr = substr($iList, $iChar, 1);
					if(ord(strtolower($chkchr))==ord('[')) {
						$iFound = true;
						$iChar++;
					} elseif(ord(strtolower($chkchr))==ord(']')) {
						$iFound = false;
						$iDifferent = true;
						foreach($this->Fansub as $name) {
							if(strtolower($name)===strtolower(trim($iFansub))) $iDifferent = false;
						}
						if($iDifferent) $this->Fansub[] = trim($iFansub);
						break;
					}
					if($iFound) {
						$chkchr = substr($iList, $iChar, 1);	
						$iFansub .= $chkchr;				
					}
					$iChar++;
				}
			}
		}
		sort($this->Fansub);
		
		$iChar = 0;
		$iEpisode = false;
		$iDataName = "";
		// Read a Name Folder for Database
		while($iChar<strlen($this->iFolderName))
		{
			$iType = 0;
			$chk = substr($this->iFolderName, $iChar, 1);
			if(ord(strtolower($chk))==ord('(') || ord(strtolower($chk))==ord('[') || ord(strtolower($chk))==ord('{')) {
				$iType = $iChar;
				if(ord(strtolower($chk))==ord('(')) {	
					while($iType<strlen($this->iFolderName)) {	
						$iType++;					
						$chkType = substr($this->iFolderName, $iType, 1);
						if(ord($chkType)==ord(')')) {
							// Database Insert (Type)
							$this->Type = substr($this->iFolderName, ($iChar+1), ($iType-$iChar-1));							
							$iChar = $iType;
							break;
						}						
					}
				} elseif(ord(strtolower($chk))==ord('[')) {					
					while($iType<strlen($this->iFolderName)) {
						$iType++;						
						$chkType = substr($this->iFolderName, $iType, 1);
						if(ord($chkType)==ord(']')) {
							$chkCharFirst = substr($this->iFolderName, ($iChar+1), 1);
							$chkCharLast = substr($this->iFolderName, ($iType-1), 1);
							if(ord($chkCharFirst)>=ord(0) && ord($chkCharFirst)<=ord(9) && (ord($chkCharLast)==ord('#') || (ord($chkCharLast)>=ord(0) && ord($chkCharLast)<=ord(9)))) {
								// Database Insert [Ongoing!End]
								list($this->ChapterNow, $this->ChapterEnd) = explode("!", substr($this->iFolderName, ($iChar+1), ($iType-$iChar-1)));
								$iChar = $iType;
								break;
							} else {
								// Database Insert [$Release $Resolution.$Lang1-$Lang2!$Sub1-$Sub2]
								list($tmpVideo, $tmpLanguage) = explode(".", substr($this->iFolderName, ($iChar+1), ($iType-$iChar-1)));
								list($this->Release, $this->Resolution) = explode(" ", $tmpVideo);
																
								if(!$tmpLanguage) {
									list($tmpAudio, $tmpSubtitle) = explode("!", $tmpVideo);
									if(!$tmpSubtitle)
									{
										if($tmpAudio!="RAW") $tmpSubtitle = "THA"; else $tmpSubtitle = "NONE";
										$tmpAudio = "JPN";
									}
								} else {									
									list($tmpAudio, $tmpSubtitle) = explode("!", $tmpLanguage);
									if($tmpAudio=="RAW") {
										$tmpAudio = "JPN";
										$tmpSubtitle = "NONE";
									} 
									if($tmpSubtitle=="") $tmpSubtitle = "NONE";
								}	
								if(!$this->Resolution)
								{	
									if(!$this->Release || ((int)$this->Release)<1) {										
										$this->Resolution = "720p";
									} else {
										$this->Resolution = $this->Release;
										$this->Release = "TV";
									}
									if($this->Release=="Blu-ray") $this->Resolution = "1080p";
								}
								
								$this->Audio = explode("-", $tmpAudio);
								$this->Subtitle = explode("-", $tmpSubtitle);
								$iChar = $iType;
								break;
							}
						}
					}
				} elseif(ord(strtolower($chk))==ord('{')) {
					while($iType<strlen($this->iFolderName)) {
						$iType++;
						$chkType = substr($this->iFolderName, $iType, 1);
						if(ord($chkType)==ord('}')) {
							$chkChar = substr($this->iFolderName, ($iChar+1), 1);
							if(ord($chkChar)>=ord(0) && ord($chkChar)<=ord(9)) {
								// Database Insert {$Year-$Season}
								list($this->Year, $this->Season) = explode("-", substr($this->iFolderName, ($iChar+1), ($iType-$iChar-1)));
								$this->Season = ((int)$this->Season);
								$this->Year = ((int)$this->Year);
								$iChar = $iType;
								break;
							} else {
								if(!$iEpisode) {
									$this->Name['th'] = iconv("tis-620","utf-8",substr($this->iFolderName, ($iChar+1), ($iType-$iChar-1)));
								} else {
									$this->Episode['th'] = iconv("tis-620","utf-8",substr($this->iFolderName, ($iChar+1), ($iType-$iChar-1)));
								}
								$iChar = $iType;
								break;
							}
						}
					}
				}
				
			} else {
				$iDataName .= $chk;
				if($chk===chr(149)) $iEpisode = true;
			}
			$iChar++;
		}
		if($this->Type && $this->Release!="Blu-ray") $this->Release = "DVD";

		// Name Anime Splin
		$Symbol = substr($iDataName, 0, 1);		
		if(ord($Symbol)==ord("!") || ord($Symbol)==ord("#")) {
			$iDataName = substr($iDataName, 1, strlen($iDataName));
			if(ord($Symbol)==ord("!")) $this->Drop = true;
		}
		list($this->Name['en'], $this->Episode['en']) = explode(chr(149), $iDataName);
		if(isset($this->Name['en'])) $this->Name['en'] = trim($this->Name['en']);
		if(isset($this->Episode['en'])) $this->Episode['en'] = trim($this->Episode['en']);
	}
	
	public static function Season($data)
	{
		$result = "Unknow";
		switch($data)
		{
			case 0: $result = "Unknow"; break;
			case 1: $result = "Spring"; break;
			case 2: $result = "Summer"; break;
			case 3: $result = "Autumn"; break;
			case 4: $result = "Winter"; break;
			case "Unknow": $result = 0; break;
			case "Spring": $result = 1; break;
			case "Summer": $result = 2; break;
			case "Autumn": $result = 3; break;
			case "Winter": $result = 4; break;
		}
		return $result;
	}
	public static function Language($data = array())
	{
		$iString = "";
		foreach($data as $key=>$value) {
			switch($value) {
				case "THA": $iString .= "Thai"; break;
				case "ENG": $iString .= "English"; break;
				case "JPN": $iString .= "Japan"; break;
				case "KOR": $iString .= "Korea"; break;
				case "NONE": $iString .= "None"; break;
			}
			if($key<(count($data)-1)) $iString .= ", ";
		}
		return $iString;
	}
	public static function Size($bytes)
	{
		$iUnit = array(" Bytes"," KB"," MB"," GB"," TB");
		$iSize = $bytes;
		$iIndex = 0;
		if($iSize>=0) {
			while($iSize>1024) {
				$iSize = ($iSize / 1024);		
				$iIndex++;			
			}
		} else {
			$iIndex = 3;
			$iSize = 4;
			$TxtLimit = "Over ";
		}
		
		return $TxtLimit.round($iSize,2).$iUnit[$iIndex];
	}
	
}

?>