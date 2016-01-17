<?php
	$site = array( ROOT => $_SERVER['DOCUMENT_ROOT'].'/' );		
	require_once $site[ROOT].'facebook/cgi-bin/connection.class.php';
	
	class Guest extends PDOConnection
	{
		public function __construct()
		{
			parent::__construct();
			$userid = (ereg_replace('\.','',$_SERVER['REMOTE_ADDR']));
			$expires = time()+1200;
			$table = 'user_online';
			$column = array('expires','uid','mag_id','guest');
			$values = array($expires, $userid,0,1);
			if(parent::CountRow($table, 'uid', $userid)<1) {
				try {
					$sqlString = parent::InsertString($table, $column);
					$statement = $this->isConnect->prepare($sqlString);	
					$statement = parent::bindState($statement, $column, $values);
					$statement->execute();
				} catch(PDOException $e) {
					parent::ErrorException('Insert', $e,$sqlString);
				}
			}
		}
	}	
	$guest = new Guest();	
?>