<?php
	class Crypt{

		private static $salt;
		private static $password;
		private static $codified;

		public function __clone(){}
		public function __construct(){
			$this->setSalt(NULL);
			$this->setPassword(NULL);
			$this->setCodified(NULL);
		}

		public static function Encrypt($senha){
			self::setPassword($senha);
			self::setSalt(md5("Hállan da S. Costa Hállex da S. Costa Rian P. Panini Juliana B. Gonçalves Encripta: Hackers não são Crackers '-'."));
			self::setCodified(crypt(self::getPassword(), self::getSalt()));
			self::setCodified(hash('sha512', self::getCodified()));
			return self::getCodified();
		}

		private static function getSalt(){
			return self::$salt;
		}

		private static function getPassword(){
			return self::$password;
		}

		private static function getCodified(){
			return self::$codified;
		}

		private static function setSalt($s){
			self::$salt = $s;
		}

		private static function setPassword($p){
			self::$password = $p;
		}

		private static function setCodified($c){
			self::$codified = $c;
		}
	}


?>