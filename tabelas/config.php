<?php
require 'class_static/conexao.class.php';

/**
 * @param object $obj
 * @param static or non-static calling
 * @return resource connection
 */

$obj = new DB();
$obj -> setDBType('mysql');
$obj -> setHost('localhost');
$obj -> setPort(3306);
$obj -> setDBName('arborizatuba');
$obj -> setCharset("UTF8");
$obj -> setUser('root');
$obj -> setPass('');
$obj -> Connect();

if ($obj->getDbh()) {
	print('Connection successfully');
}
