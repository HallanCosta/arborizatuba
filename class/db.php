<?php 

	/**
	 * 
	 */
	abstract class AbstractDB {
		//Attribute
		private static $dbtype;
		private static $host;
		private static $port;
		private static $db;
		private static $charset;
		private static $user;
		private static $pass;
		private static $conexao;

		public function __construct(){
			$this->setDBType(NULL);
			$this->setHost(NULL);
			$this->setPort(NULL);
			$this->setDB(NULL);
			$this->setCharset(NULL);
			$this->setUser(NULL);
			$this->setPass(NULL);
			$this->setConexao(NULL);
		}
		public function __clone(){}
		public function __destruct() {
			foreach ($this as $key => $value) {
				print_r($key . '<br><br>');
				unset($key);
			}
		}

		//Method
		protected function Connect() {
			try {
				$this->setDBType('mysql');
				$this->setHost('localhost');
				$this->setPort(3305);
				$this->setDB('arborizatuba');
				$this->setCharset('utf8');
				$this->setUser('root');
				$this->setPass('');
				$conexao = new PDO($this->getDBType() . ":host=" . $this->getHost() . ";port=" . $this->getPort() . ";dbname=" . $this->getDB() . ";charset=" . $this->getCharset(), $this->getUser(), $this->getPass());
				$this->setConexao($conexao);
				$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
				//$conexao->setAttribute(PDO::ATTR_PERSISTENT, FALSE);
			} catch (PDOException $error) {
				print('Error: <code>' . $error->getMessage() . '</code>');
			}
			return $this->getConexao();
		}
		protected function Disconnect() { 
			$this->setConexao(NULL);
			return $this->getConexao();
		}
		protected function stablePDO() {
			return $this->getConexao() instanceof PDO ? print('<br>Successfully') : print('<br>Failed');
		}

		protected function selectDB($sql, $params=null, $type_fetch=null, $class=null) {
			$stmt = $this->Connect()->prepare($sql);
			/*foreach ($params as $key => &$value) {
				$pattern = "/[0-9]+$/";
				if (preg_match($pattern, $value)) {
					print('Key: ' . $key . ' Value: ' . $value . '<br>');
					$stmt->bindParam(':' . $key, $value, PDO::PARAM_INT);
				} elseif(gettype($value) == 'boolean') {
					print('Key: ' . $key . ' Value: ' . $value . '<br>');
					$stmt->bindParam(':' . $key, $value, PDO::PARAM_BOOL);
				}else {
					print('Key: ' . $key . ' Value: ' . $value . '<br>');
					$stmt->bindParam(':' . $key, $value, PDO::PARAM_STR);
				} 
			}*/
			
			$stmt->execute($params);
			if ($class) {
				$rs = $stmt->fetchAll(PDO::FETCH_CLASS, $class);
			} else {
				switch ($type_fetch) {
					case PDO::FETCH_OBJ:
					//print('Return: <strong>OBJ</strong><br>');
						$rs = $stmt->fetchAll(PDO::FETCH_OBJ);
						break;
					case PDO::FETCH_ASSOC:
					//print('Return: <strong>ASSOC</strong><br>');
						$rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
						break;
					default:
					//print('Default Return: <br><strong>OBJ</strong><br>');
						$rs = $stmt->fetchAll(PDO::FETCH_OBJ);
						break;
				
			}
			self::__destruct();
			return $rs;
		}
		protected function insertDB($sql, $params=null) {
			$conexao = $this->Connect();
			$stmt = $conexao->prepare($sql);
			$stmt->execute($params);
			$rs = $conexao->lastInsertId();
			self::__destruct();
			return $rs;
		}

		protected function updateDB($sql, $params=null) {
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute($params);
			$rowCount = $this->selectDB($sql, $params=null, $type_fetch=null, $class=null);
			$rs = count($rowCount);
			self::__destruct();
			return $rs;
		}

		protected function deleteDB($sql, $params=null) {
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute($params);
			$rowCount = $this->selectDB($sql, $params=null, $type_fetch=null, $class=null);
			$rs = count($rowCount);
			self::__destruct();
			return $rs;
		}


		private function getDBType() {return self::$dbtype;		}
		private function getHost()	 {return self::$host;		}
		private function getPort()	 {return self::$port;		}
		private function getDB()	 {return self::$db;			}
		private function getCharset(){return self::$charset;	}
		private function getUser()	 {return self::$user;		}
		private function getPass()	 {return self::$pass;		}
		private function getConexao(){return self::$conexao;	}

		private function setDBType($dbtype)	 {self::$dbtype  = $dbtype;		}
		private function setHost($host)		 {self::$host 	 = $host;		}
		private function setPort($port)		 {self::$port 	 = $port;		}
		private function setDB($db)			 {self::$db 	 = $db; 		}
		private function setCharset($charset){self::$charset = $charset;	}
		private function setUser($user)		 {self::$user 	 = $user; 		}
		private function setPass($pass)		 {self::$pass 	 = $pass; 		}
		private function setConexao($conexao){self::$conexao = $conexao;	}

	}