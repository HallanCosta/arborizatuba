<?php 

	require_once 'db.php';
	/**
	 * 
	 */
	final class Conexao extends AbstractDB
	{
		final function __construct(){return parent::__construct();}
		final function __clone(){return parent::__clone();}
		final function __destruct(){return parent::__destruct();}

		final public function selectDB($sql, $params=null, $type_fetch=null, $class=null){
			return parent::selectDB($sql, $params, $type_fetch, $class);
		}
		final public function insertDB($sql, $params=null){return parent::insertDB($sql, $params);}
		final public function updateDB($sql, $params=null){return parent::updateDB($sql, $params);}
		final public function deleteDB($sql, $params=null){return parent::deleteDB($sql, $params);}
		final public function stablePDO(){return parent::stablePDO();}
	}
