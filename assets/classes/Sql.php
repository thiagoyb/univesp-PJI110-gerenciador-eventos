<?php

class Sql{

	private $conn;
	private $Settings=array();

	public function __construct(){
		foreach(explode(PHP_EOL, file_get_contents(dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'.env')) as $setting){
			if(strpos($setting,'=')!==false){
				$Settings[substr($setting, 0, strpos($setting,'='))] = substr($setting, strpos($setting,'=')+1);
			}
		}

		$this->conn = new PDO("mysql:dbname={$Settings['DB_NAME']};host={$Settings['DB_HOST']}", $Settings['DB_USER'], $Settings['DB_PASS']);
	}

	private function setParams($statement, $parameters = array()){
		foreach($parameters as $key => $value){
			$statement->bindParam($key, $value);
		}
	}

	public function query($rawQuery, $params = array()){
		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$rsInserted = $stmt->execute();

		return $rsInserted ? $this->conn->lastInsertId() : false;
	}

	public function update($rawQuery, $params = array()){
		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		return $stmt->execute();
	}

	public function select($rawQuery, $params = array()){
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	
	public function select1($rawQuery, $params = array()){
		$lines = $this->select($rawQuery, $params);
		return $lines!=null && !empty($lines) ? $lines[0] : array();
	}

	public function newInstance($tabela, $arrDados){
		$querySql = "INSERT INTO {$tabela} (";
		foreach($arrDados as $key => $val){			
			if($key!='' && $val!='' && $val!=null){
				$querySql .= $key.',';
			}
		}
		$querySql .= ")";
		$querySql = str_replace(',)',')',$querySql);
		$querySql .= " VALUES (";
		foreach($arrDados as $key => $val){
			if($key!='' && $val!='' && $val!=null){
			  if($val=="NULL"){
				$querySql .= "NULL,";
			  } else{
				$querySql .= "'{$val}',";  
			  }
			}
		}
		$querySql .= ")";
		$querySql = str_replace(',)',')',$querySql);

		return $this->query($querySql);
	}

	public function updateInstance($tabela, $id, $arrDados, $whereAdd='', $permiteVazio=false){
		$querySql = "UPDATE {$tabela} SET";
		foreach($arrDados as $key => $val){
			if($key!='' && $val!==null){
				if($val==='NULL'){
					$querySql .= ", {$key} = NULL";
				}
				elseif(is_bool($val)){
					$bit = $val===true ? 1 : 0;
					$querySql .= ", {$key} = $bit";
				}
				elseif($val!=''||$permiteVazio){
					$querySql .= ", {$key} = '{$val}'";
				}
			}
		}
		$querySql = str_replace('SET,','SET',$querySql);

		$campo = is_array($id) ? array_keys($id)[0] : 'id';
		$id = is_array($id) ? array_values($id)[0] : $id;

		$querySql .= " WHERE {$campo}>0 {$whereAdd} AND {$campo} = {$id}";

		return $this->update($querySql);
	}
	
	public function deleteInstance($tabela, $id, $whereAdd=''){
		$querySql = "DELETE FROM {$tabela}";

		$campo = is_array($id) ? array_keys($id)[0] : 'id';
		$id = is_array($id) ? array_values($id)[0] : $id;

		$querySql .= " WHERE {$campo}>0 {$whereAdd} AND {$campo} = {$id}";

		return $this->update($querySql);
	}
}
?>