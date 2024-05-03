<?php
	if(!class_exists('Utils')) require 'Utils.php';
	if(!class_exists('Sql')) require 'Sql.php';

	class User{
		private $id;
		private $nome;
		private $email;
		private $senha;
		private $login;
		private $perfil;

		public function __construct($id=null){
			$Sql = new Sql();

			$data = $id!=null && $id>0 ? $Sql->select1("SELECT * FROM ge_usuarios WHERE ativado=1 AND codUser = {$id} ORDER BY 1 DESC LIMIT 1;") : array();
			foreach(($data!=null ? $data : array()) as $key => $val){
				switch($key){
					case 'codUser':{
						$this->id = $val;
						break;
					}
					case 'nome':{
						$this->nome = $val;
						break;
					}
					case 'email':{
						$this->email = $val;
						break;
					}
					case 'senha':{
						$this->senha = $val;
						break;
					}
					case 'login':{
						$this->login = $val;
						break;
					}
					case 'perfil':{
						$this->perfil = $val;
						break;
					}
				}
			}
		}

		static function getURL($route=''){
			require dirname(__FILE__).DIRECTORY_SEPARATOR.'Config.php';

			$URL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://');
			$HOST = str_replace(Utils::fromCharCode(105,110,116,114,97,110,101,116,46),'',substr($Config['URL'], strpos($Config['URL'], '://')+3));

			return $URL.$HOST.$route;
		}
		static function getPATH(){
			return dirname(dirname(dirname(__FILE__)));
		}

		static function login(){
			//fazendo....
		}

		static function auth($origemFile, $visitante=false){
			$UID = isset($_SESSION['GE_UID']) && !empty($_SESSION['GE_UID']) ? $_SESSION['GE_UID'] : null;
			$user = $UID!=null ? new User($UID) : array();
			$cPanel = User::getURL('panel');

			if(!empty($user)){
				if(isset($_SESSION['GE_Secret']) && $_SESSION['GE_Secret'] === md5($user->getSenha())){
					if(basename(dirname($origemFile)) == 'panel'){
						return $user;
					}
				}else{
					setCookie("erro","Sua senha foi alterada. Faça seu login!");
					if(!$visitante) header("Location: {$cPanel}/Login.php");
				}
			} else{
			   setCookie("erro",'Bem-vindo !');
			   if(!$visitante) header("Location: {$cPanel}/Login.php");
			}
		}

		public function getId(){
				return $this->id;
		}

		public function setId($id){
				$this->id = $id;
		}

		public function getNome(){
				return $this->nome;
		}

		public function setNome($nome){
				$this->nome = $nome;
		}

		public function getEmail(){
				return $this->email;
		}

		public function setEmail($email){
				$this->email = $email;
		}
		
		public function getSenha(){
				return $this->senha;
		}

		public function setSenha($senha){
				$this->senha = $senha;
		}

		public function getLogin(){
				return $this->login;
		}

		public function setLogin($login){
				$this->login = $login;
		}

		public function getPerfil(){
				return $this->perfil;
		}

		public function setPerfil($perfil){
				$this->perfil = $perfil;
		}
	}
?>