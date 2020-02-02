<?php 

	/**
	 * 
	 */
	abstract class AbstractDB {
		//Attribute
		private static $dbtype;
		private static $host;
		private static $port;
		private static $dbname;
		private static $charset;
		private static $user;
		private static $pass;
		private static $dbh;

		public function __construct(){
			$this->setDBType(NULL);
			$this->setHost(NULL);
			$this->setPort(NULL);
			$this->setDBName(NULL);
			$this->setCharset(NULL);
			$this->setUser(NULL);
			$this->setPass(NULL);
			$this->setDbh(NULL);
		}
		public function __clone(){}
		public function __destruct() {
			foreach ($this as $key => $value) {
				//print_r('<br>Property: ' . $key . ' Value: ' . $value);
				unset($key);
			}
			//return print('Destruct called successfully!<br>');
		}
		public function __call(String $mehtodName, Array $arguments){
			//Method SELECT, INSERT, UPDATE AND DELTE
			//Method GET
			if ($mehtodName === 'getDBType') {
				//print('Entrei no __CALL<br>');
				return $this->__get('dbtype');
			} elseif($mehtodName === 'getHost') {
				//print('Entrei no __CALL<br>');
				return $this->__get('host');
			} elseif($mehtodName === 'getPort') {
				//print('Entrei no __CALL<br>');
				return $this->__get('port');
			} elseif($mehtodName === 'getDBName') {
				//print('Entrei no __CALL<br>');
				return $this->__get('dbname');
			} elseif($mehtodName === 'getCharset') {
				//print('Entrei no __CALL<br>');
				return $this->__get('charset');
			} elseif($mehtodName === 'getUser') {
				//print('Entrei no __CALL<br>');
				return $this->__get('user');
			} elseif($mehtodName === 'getPass') {
				//print('Entrei no __CALL<br>');
				return $this->__get('pass');
			} elseif($mehtodName === 'getDbh') {
				//print('Entrei no __CALL<br>');
				return $this->__get('dbh');
			}

			//Method SET
			if ($mehtodName === 'setDBType') {
				///print('Entrei no __CALL<br>');
				foreach ($arguments as $key => $value) {
					return $this->__set('dbtype', $value);
				}
			} elseif($mehtodName === 'setHost') {
				///print('Entrei no __CALL<br>');
				foreach ($arguments as $key => $value) {
					return $this->__set('host', $value);
				}
			} elseif($mehtodName === 'setPort') {
				///print('Entrei no __CALL<br>');
				foreach ($arguments as $key => $value) {
					return $this->__set('port', $value);
				}
			} elseif($mehtodName === 'setDBName') {
				///print('Entrei no __CALL<br>');
				foreach ($arguments as $key => $value) {
					return $this->__set('dbname', $value);
				}
			} elseif($mehtodName === 'setCharset') {
				///print('Entrei no __CALL<br>');
				foreach ($arguments as $key => $value) {
					return $this->__set('charset', $value);
				}
			} elseif($mehtodName === 'setUser') {
				///print('Entrei no __CALL<br>');
				foreach ($arguments as $key => $value) {
					return $this->__set('user', $value);
				}
			} elseif($mehtodName === 'setPass') {
				///print('Entrei no __CALL<br>');
				foreach ($arguments as $key => $value) {
					return $this->__set('pass', $value);
				}
			} elseif($mehtodName === 'setDbh') {
				///print('Entrei no __CALL<br>');
				foreach ($arguments as $key => $value) {
					return $this->__set('dbh', $key);
				}
			}
		}
		public static function __callStatic(String $mehtodName, Array $arguments){
			//Method SELECT, INSERT, UPDATE, DELETE, EXECUTESQL
			if ($mehtodName === 'selectDB') {
				//print('Num é que entrei mesmo');
				//print_r($arguments);
				return (new static)->selectDB($arguments[0], $arguments[1], $arguments[2]);
			} elseif ($mehtodName === 'insertDB') {
				//print('Num é que entrei mesmo');
				//print_r($arguments);
				return (new static)->insertDB($arguments[0], $arguments[1]);
			} elseif ($mehtodName === 'updateDB') {
				//print('Num é que entrei mesmo');
				//print_r($arguments);
				return (new static)->updateDB($arguments[0], $arguments[1]);
			} elseif ($mehtodName === 'deleteDB') {
				//print_r($arguments);
				return (new static)->deleteDB($arguments[0], $arguments[1]);
			} elseif ($mehtodName === 'ExecuteSQL') {
				//print_r($arguments);
				return (new static)->ExecuteSQL($arguments[0], $arguments[1]);
			}  elseif ($mehtodName === 'stablePDO') {
				return (new static)->stablePDO();

			//Method GET
			} elseif ($mehtodName === 'getDBType') {
				//print('Entrei no __CALL<br>');
				return (new static)->__get('dbtype');
			} elseif($mehtodName === 'getHost') {
				//print('Entrei no __CALL<br>');
				return (new static)->__get('host');
			} elseif($mehtodName === 'getPort') {
				//print('Entrei no __CALL<br>');
				return (new static)->__get('port');
			} elseif($mehtodName === 'getDBName') {
				//print('Entrei no __CALL<br>');
				return (new static)->__get('dbname');
			} elseif($mehtodName === 'getCharset') {
				//print('Entrei no __CALL<br>');
				return (new static)->__get('charset');
			} elseif($mehtodName === 'getUser') {
				//print('Entrei no __CALL<br>');
				return (new static)->__get('user');
			} elseif($mehtodName === 'getPass') {
				//print('Entrei no __CALL<br>');
				return (new static)->__get('pass');
			} elseif($mehtodName === 'getDbh') {
				//print('Entrei no __CALL<br>');
				return (new static)->__get('dbh');
			}

			//Method SET
			if ($mehtodName === 'setDBType') {
				//print('Entrei no __CALL<br>');
				foreach ($arguments as $key => &$value) {
					return (new static)->__set('dbtype', $value);
				}
			} elseif($mehtodName === 'setHost') {
				//print('Entrei no __CALL<br>');
				foreach ($arguments as $key => &$value) {
					return (new static)->__set('host', $value);
				}
			} elseif($mehtodName === 'setPort') {
				//print('Entrei no __CALL<br>');
				foreach ($arguments as $key => &$value) {
					return (new static)->__set('port', $value);
				}
			} elseif($mehtodName === 'setDBName') {
				//print('Entrei no __CALL<br>');
				foreach ($arguments as $key => &$value) {
					return (new static)->__set('dbname', $value);
				}
			} elseif($mehtodName === 'setCharset') {
				//print('Entrei no __CALL<br>');
				foreach ($arguments as $key => &$value) {
					return (new static)->__set('charset', $value);
				}
			} elseif($mehtodName === 'setUser') {
				//print('Entrei no __CALL<br>');
				foreach ($arguments as $key => &$value) {
					return (new static)->__set('user', $value);
				}
			} elseif($mehtodName === 'setPass') {
				//print('Entrei no __CALL<br>');
				foreach ($arguments as $key => &$value) {
					return (new static)->__set('pass', $value);
				}
			} elseif($mehtodName === 'setDbh') {
				//print('Entrei no __CALL<br>');
				foreach ($arguments as $key => &$value) {
					return (new static)->__set('dbh', $key);
				}
			}
		}

		public function __set(String $propertyName, $value){
			if ($propertyName == 'dbtype') {
				////print('Entrei no __SET<br>');
				return $this->setDBType($value);
			} elseif ($propertyName == 'host') {
				////print('Entrei no __SET<br>');
				return $this->setHost($value);
			} elseif ($propertyName == 'port') {
				////print('Entrei no __SET<br>');
				return $this->setPort($value);
			} elseif ($propertyName == 'dbname') {
				////print('Entrei no __SET<br>');
				return $this->setDBName($value);
			} elseif ($propertyName == 'charset') {
				////print('Entrei no __SET<br>');
				return $this->setCharset($value);
			} elseif ($propertyName == 'user') {
				////print('Entrei no __SET<br>');
				return $this->setUser($value);
			} elseif ($propertyName == 'pass') {
				////print('Entrei no __SET<br>');
				return $this->setPass($value);
			} elseif ($propertyName == 'dbh') {
				////print('Entrei no __SET<br>');
				return $this->setDbh($value);
			}
		}
		public function __get(String $propertyName){
			if ($propertyName === 'dbtype') {
				//print('Entrei no __GET<br>');
				return $this->getDBType();
			} elseif ($propertyName == 'host') {
				//print('Entrei no __GET<br>');
				return $this->getHost();
			} elseif ($propertyName == 'port') {
				//print('Entrei no __GET<br>');
				return $this->getPort();
			} elseif ($propertyName == 'dbname') {
				//print('Entrei no __GET<br>');
				return $this->getDBName();
			} elseif ($propertyName == 'charset') {
				//print('Entrei no __GET<br>');
				return $this->getCharset();
			} elseif ($propertyName == 'user') {
				//print('Entrei no __GET<br>');
				return $this->getUser();
			} elseif ($propertyName == 'pass') {
				//print('Entrei no __GET<br>');
				return $this->getPass();
			} elseif ($propertyName == 'dbh') {
				//print('Entrei no __GET<br>');
				return $this->getDbh();
			}
		}

		//Method
		protected function Connect() {
			try {
				$this->setDBType('mysql');
				$this->setHost('localhost');
				$this->setPort(3305);
				$this->setDBName('arborizatuba');
				$this->setCharset('utf8');
				$this->setUser('root');
				$this->setPass('');
				$dbh = new PDO($this->getDBType() . ":host=" . $this->getHost() . ";port=" . $this->getPort() . ";dbname=" . $this->getDBName() . ";charset=" . $this->getCharset(), $this->getUser(), $this->getPass());
				$this->setDbh($dbh);
				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
				$dbh->setAttribute(PDO::ATTR_PERSISTENT, TRUE);
			} catch (PDOException $error) {
				print('Database Error: <code>' . $error->getMessage() . '</code>');
			} catch (Exception $error) {
				print('Generic Error: <code>' . $error->getMessage() . '</code>');
			}
			return $this->getDbh();
		}
		protected function Disconnect() { 
			$this->setDbh(NULL);
			return $this->getDbh();
		}
		protected function stablePDO() {
			return $this->getDbh() instanceof PDO ? print('<br>Successfully') : print('<br>Failed');
		}

		protected function ExecuteSQL(String $sql, Array $params=null) {
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute($params);
			$rs = $stmt->rowCount();
			return $rs;
		}
		protected function selectDB(String $sql, Array $params=null, $type_fetch=null, $class=null) {
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
			}
			//$this->__destruct();
			return $rs;
		}
		protected function insertDB(String $sql, Array $params=null) {
			$dbh = $this->Connect();
			$stmt = $dbh->prepare($sql);
			$stmt->execute($params);
			$rs = $dbh->lastInsertId();
			$this->__destruct();
			return $rs;
		}

		protected function updateDB(String $sql, Array $params=null) {
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute($params);
			$rs = $stmt->rowCount();
			$this->__destruct();
			return $rs;
		}

		protected function deleteDB(String $sql, Array $params=null) {
			$stmt = $this->Connect()->prepare($sql);
			$stmt->execute($params);
			$rs = $stmt->rowCount();
			$this->__destruct();
			return $rs;
		}

		private static function setDBType($dbtype)	{self::$dbtype   = $dbtype;	}
		private static function setHost($host)		{self::$host 	 = $host;	}
		private static function setPort($port)		{self::$port 	 = $port;   }
		private static function setDBName($dbname)	{self::$dbname   = $dbname; }
		private static function setCharset($charset){self::$charset  = $charset;}
		private static function setUser($user)		{self::$user 	 = $user;   }
		private static function setPass($pass)		{self::$pass 	 = $pass;   }
		private static function setDbh($dbh)		{self::$dbh 	 = $dbh;    }

		private static function getDBType() {return self::$dbtype;	}
		private static function getHost()	{return self::$host;	}
		private static function getPort()	{return self::$port;	}
		private static function getDBName() {return self::$dbname;	}
		private static function getCharset(){return self::$charset; }
		private static function getUser()	{return self::$user;	}
		private static function getPass()	{return self::$pass;	}
		private static function getDbh()	{return self::$dbh;		}


	}