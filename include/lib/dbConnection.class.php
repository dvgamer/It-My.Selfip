<?php
// Author: Kenanek Thongkam
class dbConection
{
	protected $isConnect;
	protected $isConfig = array(
				  'hostname'	=> 'localhost',
				  'username'	=> 'root',
				  'password'	=> '123456',
				  'dbname'		=> 'sample_db'
			  );
		
	public function __construct($config = NULL)
	{
		foreach($this->isConfig as $name=>$value) {
			if(isset($config[$name])) $this->isConfig[$name] = $config[$name];
		}
			
		try	{
			$dsnString = 'mysql:host='.$this->isConfig['hostname'].';dbname='.$this->isConfig['dbname'].';';
			$this->isConnect = new PDO($dsnString, $this->isConfig['username'], $this->isConfig['password']);
			$this->isConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);			
			$this->isConnect->query("SET NAMES 'UTF8'");
		} catch(PDOException $excep) {
			$this->ErrorException('CONECTION '.$this->isConfig['dbname'], $excep->getMessage(),'');
		}
	}
	
	public function Query($sqlString = NULL)
	{
		if($sqlString) {
			$data = array();
			$tagSplit = explode(' ', $sqlString);
			switch(strtolower($tagSplit[0]))
			{
				case 'select':
					try	{
						$statement = $this->isConnect->prepare($sqlString);
						$statement->execute();						
						while($row = $statement->fetch(PDO::FETCH_ASSOC)) { $data[] = $row;	}
						if($tagSplit[1]=='COUNT(*)') $data = $data[0];
						if(ereg('(limit 1)', strtolower($sqlString))) $data = $data[0];
					} catch(PDOException $e) {
						$this->ErrorException('SELECT '.$tagSplit[3], $e,$sqlString);
					}
				
				break;
				default:
					try	{
						$statement = $this->isConnect->prepare($sqlString);
						$data = $statement->execute();						
					} catch(PDOException $e) {
						$this->ErrorException('SELECT '.$tagSplit[3], $e,$sqlString);
					}
				break;
			}
		} else {
			echo '<div id="exception">No SQL String.</div>';
		}
		return $data;
	}
	
	
	
	
	
	
	
	
	
	public function Count($table, $where = array(), $other)
	{
		try	{
			return count($this->Select($table, $where, $other));
		} catch(PDOException $e) {
			$this->ErrorException('COUNT '.$table, $e,$sqlString);
		}
	}
	
	public function Value($table, $where = array(), $other)
	{
		try	{
			$tmpRow = $this->Select($table, $where, $other);
			return @$tmpRow[0];
		} catch(PDOException $e) {
			$this->ErrorException('GET ROW '.$table, $e,$sqlString);
		}
	}
	
	public function Select($table, $where = array(), $other = array())
	{
		try	{					
			$sqlString = $this->SQLSelect($table, $where, $other);
			$statement = $this->isConnect->prepare($sqlString);
			$statement = $this->BindState($statement, $where);
			$statement->execute();
			$tmpData = array();
			while($row = $statement->fetch(PDO::FETCH_ASSOC)) { $tmpData[] = $row;	}
			return $tmpData;
		} catch(PDOException $e) {
			$this->ErrorException('SELECT '.$table, $e,$sqlString);
		}
	}
	
	public function Insert($table, $values = array())
	{
		try	{		
			$sqlString = "INSERT INTO ".$table.' (';
			foreach($values as $column=>$value) { $sqlString .= $column.', '; }
			$sqlString = substr($sqlString,0,(strlen($sqlString) - 2));	
			$sqlString .= ') VALUES (';
			foreach($values as $column=>$value) { $sqlString .= ':'.$column.', '; }
			$sqlString = substr($sqlString,0,(strlen($sqlString) - 2));	
			$sqlString .= ');';
			$statement = $this->isConnect->prepare($sqlString);
			$statement = $this->BindState($statement, $values);
			$statement->execute();
		} catch(PDOException $e) {
			$this->ErrorException('INSERT '.$table, $e,$sqlString);
		}
	}
	
	public function Update($table, $values = array(), $where = array())
	{
		try	{		
			$sqlString = "UPDATE ".$table.' SET ';
			foreach($values as $column=>$value) { $sqlString .= $column.'=:'.$column.', '; }
			$sqlString = substr($sqlString,0,(strlen($sqlString) - 2));	
			$sqlString .= ' WHERE ';
			foreach($where as $column=>$value) { $sqlString .= $column.'=:'.$column.' AND '; }
			$sqlString = substr($sqlString,0,(strlen($sqlString) - 5));	
			$sqlString .= ';';
			$statement = $this->isConnect->prepare($sqlString);
			$statement = $this->BindState($statement, $values);
			$statement = $this->BindState($statement, $where);
			$statement->execute();
		} catch(PDOException $e) {
			$this->ErrorException('INSERT '.$table, $e,$sqlString);
		}
	}
	
	public function Delete($table, $values = array())
	{
		try	{		
			// WHERE some_column=some_value
			$sqlString = "DELETE FROM ".$table.' WHERE ';
			foreach($values as $column=>$value) { $sqlString .= $column.'=:'.$column.' AND '; }
			$sqlString = substr($sqlString,0,(strlen($sqlString) - 5));	
			$sqlString .= ';';
			$statement = $this->isConnect->prepare($sqlString);
			$statement = $this->BindState($statement, $values);
			$statement->execute();
		} catch(PDOException $e) {
			$this->ErrorException('INSERT '.$table, $e,$sqlString);
		}
	}
	
	protected function SQLSelect($table, $where = array(), $type = array())
	{
		$tmpString = "SELECT * FROM ".$table;
		
		list($comparison, $logical, $limit) = $type;
		
		if(!isset($comparison) || $comparison=='0') { $comparison = '='; }
		if(!isset($logical) || $logical=='0') { $logical = 'AND'; }
		if(!isset($limit)) { $limit = 0; }

		if($where) {
			$tmpString .= " WHERE ";
			foreach($where as $name=>$value)
			{
				$tmpString .= $name.$comparison.":".$name." ".$logical." ";
			}
			$tmpString = substr($tmpString,0,(strlen($tmpString) - (2 + strlen($logical))));			
		}
		if($limit!==0) { $tmpString .= " ".$limit; }
		return $tmpString .= ";";
	}
	
	protected function BindState($state, $index)
	{
		if($index) {
			foreach($index as $name=>$val)
			{
				$column[] = $name;
				$value[] = $val;
			}
			
			for($i=0;$i<count($column);$i++)
			{
				switch(gettype($value[$i]))
				{
					case 'string':
						$state->bindParam(':'.$column[$i], $value[$i], PDO::PARAM_STR);
					break;
					case 'integer':
						$state->bindParam(':'.$column[$i], $value[$i], PDO::PARAM_INT);
					break;
				}
			}
		}
		return $state;
	}
	
	public function __destruct()
	{
		
	}
	
	private function ErrorException($name, $e,$sql)
	{
		echo '<div id="exception">';
		echo '<strong>'.$name.' : </strong><font size="2">'.$sql.'</font><br />';
		echo '<strong>File : </strong><font size="2">'.$e->getFile().'</font><br />';
		echo '<strong>Error :</strong><br /><font size="2">'.$e->getMessage().'</font></div>';
	}
}
?>