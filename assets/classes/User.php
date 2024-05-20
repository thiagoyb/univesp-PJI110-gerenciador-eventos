<?php
	if(!session_id()){ session_start(); }	
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
			$HOST = substr($Config['URL'], strpos($Config['URL'], '://')+3);

			return $URL.$HOST.$route;
		}
		static function getPATH(){
			return dirname(dirname(dirname(__FILE__)));
		}

		static function login($origemFile, $login, $senha){
			$Sql = new Sql();

			$login = Utils::soNumeros($login);
			$cPanel = User::getURL('panel');

			if($login!='' && $senha!=''){
				if(Utils::isCPF($login)||Utils::isCNPJ($login)){
					$senha = Utils::antiSQL($senha);

					$querySql = "SELECT * FROM ge_usuarios WHERE ativado=1 AND login = '{$login}' AND senha = md5('{$senha}');";
					$rs = $Sql->select1($querySql);
					if(!empty($rs)){
						$_SESSION['GE_UID'] = $rs['codUser'];
						$_SESSION['Login'] = $rs['login'];
						$_SESSION['GE_Secret'] = md5($rs['senha']);

						return true;
					} else{
						$msgError = "Login ou senha incorretos !";
						setCookie("erro",$msgError);
						header("Location: {$cPanel}/Login.php");
					}
				} else{
					$msgError = "Login inválido !";
					setCookie("erro",$msgError);
					header("Location: {$cPanel}/Login.php");
				}
			} else{
				$msgError = "Login ou senha inválidos.";
				setCookie("erro",$msgError);
				header("Location: {$cPanel}/Login.php");
			}
		}

		static function auth($origemFile, $visitante=false){
			$UID = isset($_SESSION['GE_UID']) && !empty($_SESSION['GE_UID']) ? $_SESSION['GE_UID'] : null;
			$user = $UID!=null ? new User($UID) : array();
			$cPanel = User::getURL('panel');

			if(!empty($user)){
				if(isset($_SESSION['GE_Secret']) && $_SESSION['GE_Secret'] === md5($user->getSenha())){
					if(in_array(basename(dirname($origemFile)), array('panel','classes'))){
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

		public function alterarSenha($data, $manterSessao=false){
			$Sql = new Sql();

			$senha1 = isset($data['password1']) ? md5($data['password1']) : null;
			$senha2 = isset($data['password2']) ? md5($data['password2']) : null;
			$senhaAtual = isset($data['password']) ? md5($data['password']) : null;

			if($senha1!=null && $senha1 == $senha2){
				if($this->getSenha() == $senhaAtual){
					$id = $this->getId();

					$querySql ="UPDATE ge_usuarios SET senha = '{$senha1}' WHERE codUser = {$id}";

					$rs = $Sql->update($querySql);

					if($rs && $manterSessao) $_SESSION['GE_Secret'] = md5($senha1);
					return $rs;
				}
				else return 'Senha antiga não confere.';
			}
			else return 'As novas senhas devem ser iguais.';
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

switch($_SERVER['REQUEST_METHOD']){
    case 'PUT':{}
	case 'POST':{
		$arrResponse =  array('rs'=>false, 'msg'=>'');
		$params = Utils::receiveAjaxData('GET');

		if(isset($params['token']) && $params['token'] > time()){
			$u = User::auth(__FILE__, true);
			if(!empty($u)){
				$rs = false;

				switch($params['a']){
					case 'alteraSenha':
						$rs = $u->alterarSenha(Utils::receiveAjaxData('POST'), true);
						break;
					default:
						$rs = 'Error: Ação desconhecida !';
				}

				$arrResponse['rs'] = is_bool($rs) && $rs===true;
				$arrResponse['msg'] = is_string($rs) ? $rs : ($arrResponse['rs'] ? 'Salvo com Sucesso !' : 'Error: ');
			}
			else{ $arrResponse['rs'] = -1; }
		}

		echo json_encode($arrResponse, JSON_NUMERIC_CHECK);
		break;
	}
	default:{}
}
?>