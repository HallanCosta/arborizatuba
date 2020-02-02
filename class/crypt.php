<?php
	class Crypt{
		//ATRIBUTOS
		//Static Ele é um atributo da classe que não pode ser modificado
		private static $salt = "Hállan da S. Costa, Hállex da S. Costa, Rian P. Panini, Juliana B. Gonçalves agora Encripta.";
		private $codifica;
		private $Password;

		/*
		CRIOPTOGRAFIA DUPLA
		*/
		public function __construct(){
			$this->setPassword(NULL); 
			$this->setSalt(NULL); 
			$this->setcodified(NULL); 
		}
		//Serve para não clonarem meu metodo
		public function __clone(){}
		//Destroi todos meus atributos
		public function __destruct(){
			foreach ($this as $key => $value) {
				unset($key);
			}
		}

		private function Encrypt($senha){
			// VEJA QUE PRIMEIRO EU VOU GERAR UM SALT JÁ ENCRIPTADO EM MD5
			
			$this->setSalt(md5($this->getSalt()));
		 
			//PRIMEIRA ENCRIPTAÇÃO ENCRIPTANDO COM crypt	
			$this->setCodified(crypt($this->getPassword(), $this->getSalt()));
		 
			// SEGUNDA ENCRIPTAÇÃO COM sha512 (128 bits)
			$this->setCodified(hash('sha512', $this->getCodified()));
			//AGORA RETORNO O VALOR FINAL ENCRIPTADO
			//print("Encripta: ".$this->getCodifica());
		}
		public function getNewPassword($senha){
			$this->Encrypt($senha);
			return $this->getCodified();
		}

		private function getSalt(){
			//Self serve para cessar um atributo estatico(static)
			return self::$salt;
		}

		private function getPassword(){
			return $this->codified;
		}

		private function getCodified(){
			return $this->codified;
		}


		private function setSalt($salt){
			self::$salt = $salt;
		}
		private function setPassword($password){
			$this->password = $password;
		}
		private function setCodified($codified){
			$this->codified = $codified;
		}
}
?>