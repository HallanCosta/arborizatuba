<?php
	function Connection($parameter){

		$host = "localhost";
		$usuario = "root";
		$port = "3306";
		$senha = "";
		$database = "arborizatuba";
		//$message = NULL;

		if ($parameter == "Open" || $parameter == "open") {
			$conexao = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=utf8", $usuario, $senha);
			$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conexao;
		}else if ($parameter == "Close" || $parameter == "close"){
			$conexao = NULL;
			return $conexao;
		}
	}
?>
