<?php 

	require_once 'conexao.php';
	/*$db = new DB;
	$db->dbtype = 'mysql';
	$db->host = 'mysql';
	$db->port = 'mysql';
	$db->dbname = 'mysql';
	$db->charset = 'mysql';
	$db->user = 'mysql';
	$db->pass = 'mysql';
	$db->dbh = 'mysql';
	echo '<br>';
	$db->setDBType('sdafds') . '<br>';
	$db->setHost('sdafds') . '<br>';
	$db->setPort('sdafds') . '<br>';
	$db->setDBName('sdafds') . '<br>';
	$db->setCharset('sdafds') . '<br>';
	$db->setUser('sdafds') . '<br>';
	$db->setPass('sdafds') . '<br>';
	$db->setDbh('sdafds') . '<br>';
	echo '<br>';
	$db->getDBType() . '<br>';
	$db->getHost() . '<br>';
	$db->getPort() . '<br>';
	$db->getDBName() . '<br>';
	$db->getCharset() . '<br>';
	$db->getUser() . '<br>';
	$db->getPass() . '<br>';
	$db->getDbh() . '<br>';*/

	/*DB::dbtype = 'mysql';
	DB::host = 'mysql';
	DB::port = 'mysql';
	DB::dbname = 'mysql';
	DB::charset = 'mysql';
	DB::user = 'mysql';
	DB::pass = 'mysql';
	DB::dbh = 'mysql';*/
	echo '<br>';
	$db = 'db';
	$db::setDBType('sdafds');
	DB::setHost('sdafds');
	DB::setPort('sdafds');
	DB::setDBName('sdafds');
	DB::setCharset('sdafds');
	DB::setUser('sdafds');
	DB::setPass('sdafds');
	DB::setDbh('sdafds');
	echo '<br>';
	//Aqui não ira mostrar nada pois eu estou Pré Instanciando os metodos Setters
	//Então o método Destruct se encarrega de deletar as Propriedads Estáticas
	//e as Não Estatinas
	echo $db::getDBType();
	echo DB::getHost();
	echo DB::getPort();
	echo DB::getDBName();
	echo DB::getCharset();
	echo DB::getUser();
	echo DB::getPass();
	echo DB::getDbh();
	echo '<br>';
