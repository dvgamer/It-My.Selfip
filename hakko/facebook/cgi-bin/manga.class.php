<?php
class MangaReader
{
	private $domainDirectory;
	private $pathDirectory;
	private $domainFolder;
	private $pathFolder;
	private $arrayDirectory = array();
	
	public function __construct($folder = array())
	{
		$this->domainDirectory = 'http://'.$_SERVER['HTTP_HOST'].'/';
		$this->pathDirectory = $_SERVER['DOCUMENT_ROOT'].'/';
		foreach($folder as $name) {
			$this->domainFolder .= rawurlencode($name).'/';
			$this->pathFolder .= $name.'/';
		}
		
		$targetDirectory = $this->pathDirectory.$this->pathFolder;
		$directory = opendir($targetDirectory);
		while (($entry = readdir($directory)) !== false)
		{			
			if($entry!=='.' && $entry!=='..')
			{
				$data = array();
				$data['name'] = iconv('tis-620','utf-8',$entry);
				$splitName = explode('[',$entry);
				if(count($splitName)>1) {
					$status = explode(']',$splitName[1]);
					$data['status'] = $status[0];
				} else {
					$data['status'] = 'OnGoing';
				}	
						
				if(is_file($targetDirectory.$entry)) {
					$data['path'] = $targetDirectory.$entry;
					$data['source'] = $this->domainDirectory.$this->domainFolder.rawurlencode($entry);
				} elseif(is_dir($targetDirectory.$entry)) {
					$data['path'] = $targetDirectory.$entry.'/';
				}				
				
				$data['created'] = filectime($data['path']);
				$this->arrayDirectory[] = $data;
			}
		}
		closedir($directory);
	}
	
	public function getPath()
	{
		return $this->pathDirectory.$this->pathFolder.'/';
	}
	public function getDomain()
	{
		return $this->domainDirectory.$this->domainFolder;
	}
	
	public function getArray()
	{
		return $this->arrayDirectory;
	}
	
	public function __toString()
	{
		$list = NULL;
		foreach($this->arrayDirectory as $entry) {
			$date = date('M d, Y',$entry['created']);
			if(is_file($entry['path'])) {
				$list .= $date.' - <strong>[F]</strong> '.$entry['name']."<br />\n";
			}
			if(is_dir($entry['path'])) {
				$list .= $date.' - <strong>[D]</strong> '.$entry['name']."<br />\n";
			}
		}
		return $list;
	}
	
	public function __destruct()
	{

	}
	
}
?>