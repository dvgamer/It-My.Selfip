<?php
class DriveReader
{
	private $directoryName;
	private $location;
	private $listDirectory = array();
	
	public function __construct($loc)
	{
		$this->location = $loc;				
		$this->directoryName = opendir($this->location);
		while (($entry = readdir($this->directoryName))!==false)
		{
			$this->listDirectory[] = $entry;
		}
	}
	
	public function Path($string)
	{
		$target = $this->location.$string;
		if(is_dir($this->location.$string)) $target .= '/';
		return $target;
	}
	
	public function UTF($string)
	{
		return iconv('utf-8','tis-620',$string);
	}
	
	public function TIS($string)
	{
		return iconv('tis-620','utf-8',$string);
	}
	
	public function Lists()
	{
		$tmpDir = array();
		foreach($this->listDirectory as $file)
		{
			if(!is_dir($file)) $tmpDir[] = $file;
		}
		return $tmpDir;
	}
	
	public function ListsFolder()
	{
		$tmpDir = array();
		foreach($this->listDirectory as $file)
		{
			if(!is_dir($file) && is_dir($this->Path($file))) $tmpDir[] = $file;
		}
		return $tmpDir;
	}

	public function ListsFile()
	{
		$tmpDir = array();
		foreach($this->listDirectory as $file)
		{
			if(!is_dir($file) && !is_dir($this->Path($file))) $tmpDir[] = $file;
		}
		return $tmpDir;
	}

	public function isSize()
	{
		$fileSize = 0;
		foreach($this->listDirectory as $file)
		{
			if(!is_dir($file) && !is_dir($this->Path($file))) 
			{
				$fileSize += filesize($this->location.$this->toUTF($file));
			}
		}
		return $fileSize;
	}
	public function isFile()
	{
		$fileTotal = 0;
		foreach($this->listDirectory as $file)
		{
			$tmpInfo = pathinfo($file);
			if(isset($tmpInfo['extension'])) {
				$fileTotal++;
			}
		}
		return ($fileTotal-2);
	}
	public function isFolder()
	{
		$fileTotal = 0;
		foreach($this->listDirectory as $file)
		{
			if(!is_dir($file) && is_dir($this->Path($file))) {
				$fileTotal++;
			}
		}
		return $fileTotal;
	}
	
	public function __toString()
	{
		$list = NULL;
		foreach($this->listDirectory as $entry) {
			$list .= $entry."<br />\n";
		}
		return $list;
	}
	
	public function __destruct()
	{
		closedir($this->directoryName);
	}
	
	
}
?>