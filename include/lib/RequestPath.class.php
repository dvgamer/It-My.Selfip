<?php
class RequestPath
{
	private $isPath = array();
	private $urlCurrentPath = array();
	
	public function __construct()
	{
		$this->urlCurrentPath = explode('/', trim($_SERVER['REQUEST_URI']));
		$tmpCurrrent = array();
		foreach($this->urlCurrentPath as $value)
		{
			if($value!='')
			{
				$tmpCurrrent[] = $value;
			}
		}
		$this->urlCurrentPath = $tmpCurrrent;
	}
		
	public function SetRequest($level,$name)
	{
		$this->isPath = $this->urlCurrentPath;
		$totalReq = 0;
		foreach ($this->isPath as $value)
		{
			if ($value!="") { $totalReq++; }
		}
		if (!$totalReq) { $totalReq = 0; }
		if ($level<=$totalReq)
		{
			for ($listPath=$totalReq;$listPath>=$level;$listPath--)
			{
				$this->isPath[$listPath] = "";
			}
			$this->isPath[($level-1)] = $this->EncondeName($name);
		} else {
			for($listPath=$totalReq;$listPath<$level;$listPath++)
			{
				if($this->Level($listPath))
				{
					$this->isPath[$listPath] = $this->Level($listPath);
				} else {
					$this->isPath[$listPath] = $this->EncondeName($name);
				}
			}
		}
		return 'http://'.$_SERVER['SERVER_NAME'].'/'.$this->NextRequest($this->isPath);
	}	

	public function Level($level)
	{
		if (isset($this->urlCurrentPath[$level])) {
			return $this->DecondeName($this->urlCurrentPath[$level]);
		} else {
			return false;
		}
	}
	
	public function TotalLevel()
	{
		return count($this->urlCurrentPath);
	}
	
	protected function EncondeName($pathName)
	{
		$tmp = ereg_replace(' ', '_', trim($pathName));
		return rawurlencode($tmp);
	}	
		
	protected function DecondeName($pathName)
	{
		$tmp = ereg_replace('_', ' ', $pathName);
		return trim(rawurldecode($tmp));
	}	
	
	private function NextRequest($req)
	{
		$pathUrl = NULL;
		switch(gettype($req))
		{
			case 'string':
				$pathUrl .= $this->EncondeName($req).'/';
				break;
			case 'array':
				foreach ($req as $list=>$value)
				{
					if (!$list || $value!=="")
					{
						$pathUrl .= $this->EncondeName($value).'/';
					}
				}
				break;
		}
		return $pathUrl;
	}	
	private function DebugArr()
	{
		echo '<br><strong>::DedugArr::</strong><br>';
		foreach ($this->urlCurrentPath as $list=>$value)
		{
			echo ' <li>'.$list.'->'.$value.'</li>';
		}	
	}

	public function __destruct()
	{
		//$this->DebugArr();
	}
}
?>