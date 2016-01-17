<?php
require_once('cgi-bin/connection.class.php');
require_once('cgi-bin/manga.class.php');
require_once('cgi-bin/bbcode.class.php');
require_once('cgi-bin/language/thai.language.php');

class Engine extends PDOConnection
{
	public $idPosition;
	public $idComponent;
	public $idChapter;
	private $site;
	
	public function __construct()
	{
		parent::__construct();
		// Config Application instance.
		$this->site = array(
			DOMAIN => 'http://'.$_SERVER['HTTP_HOST'].'/',
			ROOT => $_SERVER['DOCUMENT_ROOT'].'/',
			STORE => 'file_store',
			COM => 'facebook/component/',	
			MOD => 'facebook/module/',	
			APP => 'http://apps.facebook.com/hakkomew/',
			IFRAME => 'http://'.$_SERVER['HTTP_HOST'].'/facebook/module/iframe/',
		);		
		//Set Default Component
		if(!isset($_GET['component'])) { $_GET['component'] = 'frontpage'; }		
		//Query ID Position
		foreach(parent::ViewTable('position', 0) as $pos) {
			$this->idPosition[$pos['name']] = $pos['pos_id'];
		}
		//Query ID Component
		$this->idComponent = parent::GetValue('com_id', 'component', 'name', $_GET['component']);
		//Online User
		$user = self::Facebook('/me');
		if($user['session']) {
			if(!isset($_GET['manga'])) {
				$this->Update('user_online', 'mag_id', 0, 'uid', $user['session']['uid']);
			}
			$delWhere = parent::GetValue('expires', 'user_online', 'uid', $user['session']['uid']).'<'.$_SERVER['REQUEST_TIME'];
			$this->Delete('user_online',$delWhere);
			if(parent::CountRow('user_online', 'uid', $user['session']['uid'])<1) {
				$this->Insert('user_online', array('expires','uid'), array($user['session']['expires'],$user['session']['uid']));
			}
		} else {
			// Guest User.
			echo '<iframe src="'.$this->site[IFRAME].'guest_cookie.php" frameborder="0" style="width:0px; height:0px;"></iframe>';
		}
	}
	
	public static $config = array(
		'appId'		=> '177780198930005',
		'secret' 	=> 'c17ca605baa0b5a0689c952f4f6e1e32',
		'include' 	=> 'http://hakko.9friend.net/facebook/include/',
	);
	
	public static function Facebook($user)
	{
		$fb = new Facebook(array(
			  'appId' => self::$config['appId'],
			  'secret' => self::$config['secret'],
			  'cookie' => true,
		));
		$api = NULL; 
		$user = NULL;
		$session = $fb->getSession();		
		if ($session) {
			try {
				$user = $fb->getUser();
				$api = $fb->api($user);
			} catch (FacebookApiException $e) {
				parent::ErrorException('Facebook',$e,$user);
			}
		}
		
		return array('fb'=>$fb,'api'=>$api,'session'=>$session);
	}
	 
	public static function dirReader($folder)
	{
		return $dir = new MangaReader($folder);
	}
	 
	public static function BuildQuery($arraylist = array())
	{
		$urlString = '?';
		$total = count($arraylist);
		$current = 0;
		foreach($arraylist as $index=>$value)
		{
			$current++;
			$urlString .= $index.'='.self::urlEncode($value);
			if($current<$total) { $urlString .= '&'; }
		}
		return 'http://apps.facebook.com/hakkomew/'.$urlString;
	}
	
	public static function urlDecode($string)
	{
		return ereg_replace('_',' ',$string);
	}
	
	public static function urlEncode($string)
	{
		return ereg_replace(' ','_',$string);
	}
	
	public function MainBody()
	{
		$pathComponent = $this->site[ROOT].$this->site[COM].'com_'.$_GET['component'].'/';
		if(file_exists($pathComponent) && $this->idComponent!=0) {
			if($module['public']==1) {
				echo '<div id="'.$target.'-head">'.$module['title'].'</div>';
			}
			require_once($pathComponent.$_GET['component'].'.php');	
		} else {
			echo 'Not Found.';
		}
	}
	
	public function Module($target,$width)
	{
		$pathModule = $this->site[ROOT].$this->site[MOD];
		if($this->idPosition[$target]!='') {
			foreach(parent::ViewTableWhere('module', array('com_id','pos_id'), array($this->idComponent,$this->idPosition[$target]), 'order_list', 0) as $module) {
				echo '<div id="module-'.$target.'" style="width:'.$width.'px;">';
				if($module['public']==1) {
					echo '<div id="'.$target.'-head">'.$module['title'].'</div>';
				}
				echo '<div id="'.$target.'-body">';
				if(file_exists($pathModule.$module['name'])) {
					include $pathModule.$module['name'];
				} else {
					echo '<center>Error: '.$module['name'].'</center>';
				}			
				echo '</div></div>';
			}
		}
	}
	
	public function StringGroup($table, $mag_id, $tableget, $colomnget, $column, $value)
	{
		$item = array(); 
		foreach(parent::ViewTableWhere($table, 'mag_id', $mag_id, 0, 0) as $group)
		{
			$tmpName = parent::GetValue($value, $tableget, $colomnget, $group[$column]);
			$found = true;
			foreach($item as $tmp): if($tmp==$tmpName):
				$found = false;
			endif; endforeach;			
			if($found): $item[] = $tmpName; endif; 
		}
		sort($item);
		$stringGroup = '';	
		$itemCount = count($item);		
		foreach($item as $index => $tostring){			
			$stringGroup .= '<a href="'.self::BuildQuery(array('component'=>'translator',$tableget=>$tostring)).'">'.$tostring.'</a>';	
			if($itemCount>($index+1)) { $stringGroup .= ', ';  }			
		}
		return $stringGroup;					
	}	
	
	public function Insert($table, $column, $values)
	{
		try {
			$sqlString = parent::InsertString($table, $column);
			$statement = $this->isConnect->prepare($sqlString);	
			$statement = parent::bindState($statement, $column, $values);
			$statement->execute();
		} catch(PDOException $e) {
			parent::ErrorException('Insert', $e,$sqlString);
		}
	}
		
	public function Update($table, $column, $value1, $where, $value2)
	{
		try {
			$sqlString = parent::UpdateString($table, $column, $where);
			$statement = $this->isConnect->prepare($sqlString);	
			$statement = parent::bindState($statement, $column, $value1);
			$statement = parent::bindState($statement, $where, $value2);
			$statement->execute();
		} catch(PDOException $e) {
			parent::ErrorException('Update', $e,$sqlString);
		}
	}
	
	public function Delete($table, $where)
	{
		try {
			$sqlString = parent::DeleteString($table, $where);
			$statement = $this->isConnect->prepare($sqlString);	
			$statement->execute();
		} catch(PDOException $e) {
			parent::ErrorException('Delete', $e,$sqlString);
		}
	}

}

?>