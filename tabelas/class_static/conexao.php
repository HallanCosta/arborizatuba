<?php 

	require_once 'db.php';
	/**
	 * 
	 */
	final class DB extends AbstractDB
	{
		final function __construct(){return parent::__construct();}
		final function __clone(){return parent::__clone();}
		final function __destruct(){return parent::__destruct();}
		final function __get(String $propertyName){return parent::__get($propertyName);}
		final function __set(String $propertyName, $value){return parent::__set($propertyName, $value);}
		final function __call(String $methodName, Array $arguments){
			return parent::__call($methodName, $arguments);
		}
		final static function __callStatic(String $methodName, Array $arguments){
			return parent::__callStatic($methodName, $arguments);
		}

		/*final public function ExecuteSQL(String $sql, Array $params=null) {
			return parent::ExecuteSQL($sql, $params);
		}
		final public function selectDB(String $sql, Array $params=null, $type_fetch=null, $class=null){
			return parent::selectDB($sql, $params, $type_fetch, $class);
		}
		final public function insertDB($sql, $params=null){return parent::insertDB($sql, $params);}
		final public function updateDB($sql, $params=null){return parent::updateDB($sql, $params);}
		final public function deleteDB($sql, $params=null){return parent::deleteDB($sql, $params);}
		final public function stablePDO(){return parent::stablePDO();}*/
	}
