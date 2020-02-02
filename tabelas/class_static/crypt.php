<?php
	class Crypt{
		//ATRIBUTOS
		private static $salt;
		private static $codifica;
		private static $Password;

		/*
		CRIOPTOGRAFIA DUPLA
		*/
		public function __construct(){
			$this->setPassword(NULL); 
			$this->setSalt(NULL); 
			$this->setcodified(NULL); 
		}
		public function __clone(){}
		public function __destruct(){
			foreach ($this as $key => $value) {
				unset($key);
			}
		}

		public static function __callStatic($methodName, $arguments){
			if ($methodName === 'Encrypt') {
				foreach ($arguments as $argument) {
					return (new self)->Encrypt($argument[0]);
				}
			}
		}

		private function Encrypt($password){
			// VEJA QUE PRIMEIRO EU VOU GERAR UM SALT JÁ ENCRIPTADO EM MD5
			$this->setPassword($password);
			if ($this->getPassword() !== NULL || $this->getPassword() !== '') {
				$this->setSalt(md5("Hállan da S. Costa, Hállex da S. Costa, Rian P. Panini, Juliana B. Gonçalves Encripta."));
				//PRIMEIRA ENCRIPTAÇÃO ENCRIPTANDO COM crypt	
				$this->setCodified($this->getPassword().$this->getSalt());
				// SEGUNDA ENCRIPTAÇÃO COM sha512 (128 bits)
				$this->setCodified(hash('sha512', $this->getCodified()));
				//AGORA RETORNO O VALOR FINAL ENCRIPTADO
				//print("Encripta: ".$this->getCodifica());
			}
		}

		private function getSalt(){
			return self::$salt;
		}

		private function getPassword(){
			return self::$codified;
		}

		private function getCodified(){
			return self::$codified;
		}


		private function setSalt($salt){
			self::$salt = $salt;
		}
		private function setPassword($password){
			self::$password = $password;
		}
		private function setCodified($codified){
			self::$codified = $codified;
		}
}
?>