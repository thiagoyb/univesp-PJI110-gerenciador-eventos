<?php
	if(!session_id()){ session_start(); }	
	if(!class_exists('Utils')) require 'Utils.php';
	if(!class_exists('User')) require 'User.php';
	if(!class_exists('Sql')) require 'Sql.php';

class Controller{
	static function obterMenus($id=null, $publicar=false, $slug=null){
		$Sql = new Sql();

		$whereAdd = $publicar ? " AND publicar = 1" : "";
		$whereAdd .= $id!=null && $id>0 ? " AND codSecao = {$id}" : "";
		$whereAdd .= $slug!=null && $slug!='' ? " AND slug = '{$slug}'" : "";

		$querySql = "SELECT * FROM ge_secao WHERE codSecao>0 {$whereAdd} ORDER BY ordem, submenu DESC, nome;";

		$secoes = array();
		foreach(Utils::array_get($Sql->select($querySql)) as $data){
			$secoes[] = $data;
		}
		return $secoes;
	}
	static function updateMenus($data){
		$Sql = new Sql();
		$rs = false;

		$total = isset($data['total']) ? $data['total'] : 0;
		if(!empty($data)){
			foreach(range(1, $total) as $i){
				$arrCampos=array();
				$arrCampos['ordem'] = isset($data['ordem'.$i])&&$data['ordem'.$i]>0 ? $data['ordem'.$i] : null;
				$arrCampos['nome'] = isset($data['nome'.$i])&&$data['nome'.$i]!='' ? $data['nome'.$i] : null;
				$arrCampos['titulo'] = isset($data['titulo'.$i])&&$data['titulo'.$i]!='' ? $data['titulo'.$i] : null;
				$arrCampos['url'] = isset($data['url'.$i])  ? $data['url'.$i] : null;
				$arrCampos['publicar'] = isset($data['publicar'.$i]) ? $data['publicar'.$i] : null;

				$id = isset($data['id'.$i]) ? $data['id'.$i] : null;
				$rs = $id!=null ? $Sql->updateInstance('ge_secao', array('codSecao'=>$id), $arrCampos, '', true) : true;
			}
			
			return $rs===true ? $rs : 'Erro ao salvar os dados.';
		}
	}

	static function obterNoticias($id=null, $publicar=false){
		$Sql = new Sql();

		$whereAdd = $publicar ? " AND publicar = 1" : "";
		$whereAdd .= $id!=null && $id>0 ? " AND codNoticia = {$id}" : "";
		$querySql = "SELECT * FROM ge_noticias WHERE codNoticia>0 {$whereAdd} ORDER BY data_update DESC;";

		$Noticias = array();
		foreach(Utils::array_get($Sql->select($querySql)) as $data){
			$Noticias[] = $data;
		}
		return $Noticias;
	}
	static function novaNoticia($idUser, $PUT){
		$Sql = new Sql();
		$Noticia=array();
		$rs = false;

		if($idUser>0){
			$Noticia['conteudo'] = isset($PUT['conteudo']) ? addslashes($PUT['conteudo']) : null;
			$Noticia['fkUser'] = $idUser;
			$Noticia['titulo'] = isset($PUT['titulo']) ? $PUT['titulo'] : null;
			$Noticia['subtitulo'] = isset($PUT['subtitulo']) ? $PUT['subtitulo'] : null;
			$Noticia['assunto'] = isset($PUT['chapeu']) ? $PUT['chapeu'] : null;
			$Noticia['fonte'] = isset($PUT['fonte']) ? $PUT['fonte'] : null;
			$Noticia['publicar'] = isset($PUT['publicar']) ? Utils::evalVar($PUT['publicar']) : false;

			if($Noticia['titulo']!=null && $Noticia['conteudo']!=null){
				$rs = $Sql->newInstance('ge_noticias', $Noticia);

				return $rs>0 ? intval($rs) : "Erro ao salvar noticia.";
			}
			else{ return "Campos obrigatórios necessários."; }
		}
		else{ return "Usuario não identificado"; }

		return $rs===true ? $rs : 'Erro ao salvar os dados.';
	}
	static function updateNoticia($idUser, $PUT){
		$Sql = new Sql();
		$Noticia=array();
		$idNoticia = isset($PUT['id'])&&$PUT['id']!='' ? $PUT['id'] : 0;
		$rs = false;

		if($idUser>0){
		  if($idNoticia>0){
			$Noticia['conteudo'] = isset($PUT['conteudo']) ? addslashes($PUT['conteudo']) : null;
			$Noticia['fkUser'] = $idUser;
			$Noticia['titulo'] = isset($PUT['titulo']) ? $PUT['titulo'] : null;
			$Noticia['subtitulo'] = isset($PUT['subtitulo'])&&$PUT['subtitulo']!='' ? $PUT['subtitulo'] :'NULL';
			$Noticia['assunto'] = isset($PUT['chapeu'])&&$PUT['chapeu']!='' ? $PUT['chapeu'] : 'NULL';
			$Noticia['fonte'] = isset($PUT['fonte'])&&$PUT['fonte']!='' ? $PUT['fonte'] : 'NULL';
			$Noticia['publicar'] = isset($PUT['publicar']) ? Utils::evalVar($PUT['publicar']) : false;

			if($Noticia['titulo']!=null && $Noticia['conteudo']!=null){
				$rs = $Sql->updateInstance('ge_noticias', array('codNoticia'=>$idNoticia), $Noticia);

				return $rs>0 ? intval($idNoticia) : "Erro ao salvar noticia.";
			}
			else{ return "Campos obrigatórios necessários."; }
		 }
		 else{ return "ID inválido!"; }
		}
		else{ return "Usuario não identificado"; }

		return $rs===true ? $rs : 'Erro ao salvar os dados.';
	}
	static function deleteNoticia($idUser, $PUT){
		$Sql = new Sql();
		$idNoticia = isset($PUT['id'])&&$PUT['id']!='' ? intval($PUT['id']) : 0;
		$rs = false;

		if($idUser>0){
		  if($idNoticia>0){
				$rs = $Sql->deleteInstance('ge_noticias', array('codNoticia'=>$idNoticia));
				return $rs>0 ? intval($idNoticia) : "Erro ao deletar noticia.";
		 }
		 else{ return "ID inválido!"; }
		}
		else{ return "Usuario não identificado"; }

		return $rs===true ? $rs : 'Erro ao salvar os dados.';
	}

	static function obterEventos($id=null, $idUser=null, $publicar=null){
		$Sql = new Sql();

		$whereAdd = $publicar!=null ? ( $publicar===true ? " AND publicar = 1"  : " AND publicar = 0" ) : '';
		$whereAdd .= $idUser!=null && $idUser>0 ? " AND fkUser = {$idUser}" : "";
		$whereAdd .= $id!=null && $id>0 ? " AND codEvento = {$id}" : "";
		$querySql = "SELECT * FROM ge_eventos E WHERE codEvento>0 {$whereAdd} ORDER BY fkUser, data_cadastro DESC;";

		$Eventos = array();
		foreach(Utils::array_get($Sql->select($querySql)) as $data){
			$Eventos[] = $data;
		}

		return $Eventos;
	}
	static function novoEvento($PUT, $idUser){
		$Sql = new Sql();
		$Evento=array();
		$rs = false;

		if($idUser>0){
			$Evento['fkUser'] = $idUser;
			$Evento['fkBanner'] = isset($PUT['banner']) ? Utils::soNumeros($PUT['banner']) : null;
			$Evento['titulo'] = isset($PUT['titulo'])&&$PUT['titulo']!='' ? $PUT['titulo'] : 'NULL';
			$Evento['data_inicial'] = isset($PUT['data_inicial']) ? trim($PUT['data_inicial']) : null;
			$Evento['data_final'] = isset($PUT['data_final']) ? trim($PUT['data_final']) : $Evento['data_inicial'];
			$Evento['endereco'] = isset($PUT['endereco'])&&$PUT['endereco']!='' ? Utils::clearChars($PUT['endereco']) : null;
			$Evento['hora'] = isset($PUT['hora']) ? trim($PUT['hora']) : null;
			$Evento['valor'] = isset($PUT['valor']) ? Utils::toFloat($PUT['valor']) : null;
			$Evento['descricao'] = isset($PUT['descricao'])&&$PUT['descricao']!='' ? addslashes($PUT['descricao']) : null;
			$Evento['publicar'] = isset($PUT['publicar']) ? Utils::evalVar($PUT['publicar']) : true;

			if($Evento['titulo']!=null && $Evento['data_inicial']!=null && $Evento['endereco']!=null && $Evento['hora']!=null){
				$rs = $Sql->newInstance('ge_eventos', $Evento);

				return $rs>0 ? intval($rs) : "Erro ao salvar evento.";
			}
			else{ return "Campos obrigatórios necessários."; }
		}
		else{ return "Usuario não identificado"; }

		return $rs===true ? $rs : 'Erro ao salvar os dados.';
	}

	static function obterBanners($id=null, $idUser=null, $publicar=null){
		$Sql = new Sql();

		$whereAdd = $publicar!=null ? ( $publicar===true ? " AND publicar = 1"  : " AND publicar = 0" ) : '';
		$whereAdd .= $id!=null && $id>0 ? " AND codBanner = {$id}" : "";
		$querySql = "SELECT * FROM ge_banner L WHERE fkUser = {$idUser} {$whereAdd} ORDER BY ordem ASC, data_upload DESC;";

		$Banners = array();
		if($idUser!=null && $idUser>0){
			foreach(Utils::array_get($Sql->select($querySql)) as $data){
				$Banners[] = $data;
			}
		}

		return $Banners;
	}
	static function novoBanner($PUT, $idUser){
		$Sql = new Sql();
		$Banner=array();
		$rs = false;

		if($idUser>0){
			$Banner['fkUser'] = $idUser;
			$Banner['ordem'] = isset($PUT['ordem']) ? Utils::soNumeros($PUT['ordem']) : null;
			$Banner['titulo'] = isset($PUT['titulo'])&&$PUT['titulo']!='' ? $PUT['titulo'] : 'NULL';
			$Banner['largura'] = isset($PUT['largura']) ? Utils::soNumeros($PUT['largura']) : 'NULL';
			$Banner['altura'] = isset($PUT['altura']) ? Utils::soNumeros($PUT['altura']) : 'NULL';
			$Banner['target'] = isset($PUT['destino'])&&$PUT['destino']!='' ? trim($PUT['destino']) : null;
			$Banner['url'] = isset($PUT['url'])&&$PUT['url']!='' ? $PUT['url'] : '#';
			$Banner['publicar'] = isset($PUT['publicar']) ? Utils::evalVar($PUT['publicar']) : true;

			$BannerFile = isset($PUT['banner'])&&$PUT['banner']!='' ? $PUT['banner'] : null;

			if($Banner['target']!=null && $BannerFile!=null){
				$imagemBase64 = str_replace(' ', '+', array_reverse(explode(';base64,',$BannerFile))[0]);

				$PATH = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'banner'.DIRECTORY_SEPARATOR;
				$titleNome = Utils::scape(Utils::clearChars(str_replace('NULL','',str_replace(' ','-',$Banner['titulo']))));
				$nomeFile = str_replace('--','-','banner-'.$titleNome.'-'.uniqid('siga').'.jpg');

				if(file_put_contents($PATH.$nomeFile, base64_decode($imagemBase64))){
					$Banner['banner'] = $nomeFile;

					$rs = $Sql->newInstance('ge_banner', $Banner);
					return $rs>0 ? intval($rs) : "Erro ao salvar banner.";
				}
				else{ return "Erro ao mover a imagem."; }
			}
			else{ return "Campos obrigatórios necessários."; }
		}
		else{ return "Usuario não identificado"; }

		return $rs===true ? $rs : 'Erro ao salvar os dados.';
	}
	static function updateBanner($idUser, $PUT){
		$Sql = new Sql();
		$Banner=array();
		$idBanner = isset($PUT['id'])&&$PUT['id']!='' ? $PUT['id'] : 0;
		$rs = false;

		if($idUser>0){
		  if($idBanner>0){
			$Banner['titulo'] = isset($PUT['titulo'])&&$PUT['titulo']!='' ? $PUT['titulo'] : 'NULL';
			$Banner['largura'] = isset($PUT['largura']) ? Utils::soNumeros($PUT['largura']) : 'NULL';
			$Banner['altura'] = isset($PUT['altura']) ? Utils::soNumeros($PUT['altura']) : 'NULL';
			$Banner['target'] = isset($PUT['destino'])&&$PUT['destino']!='' ? trim($PUT['destino']) : null;
			$Banner['url'] = isset($PUT['url'])&&$PUT['url']!='' ? $PUT['url'] : '#';
			$Banner['publicar'] = isset($PUT['publicar']) ? Utils::evalVar($PUT['publicar']) : true;

			if($Banner['titulo']!=null){
				$rs = $Sql->updateInstance('ge_banner',array('codBanner'=>$idBanner), $Banner);

				return $rs>0 ? intval($idBanner) : "Erro ao salvar banner.";
			}
			else{ return "Campos obrigatórios necessários."; }
		 }
		 else{ return "ID inválido!"; }
		}
		else{ return "Usuario não identificado"; }

		return $rs===true ? $rs : 'Erro ao salvar os dados.';
	}
	static function deleteBanner($idUser, $PUT){
		$Sql = new Sql();
		$idBanner = isset($PUT['id'])&&$PUT['id']!='' ? intval($PUT['id']) : 0;
		$nomeFile = isset($PUT['banner'])&&$PUT['banner']!='' ? $PUT['banner'] : null;
		$rs = false;

		if($idUser>0){
		  if($idBanner>0 && $nomeFile!=null){
			$PATH = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'banner'.DIRECTORY_SEPARATOR;

			if(file_exists($PATH.$nomeFile)){
				unlink($PATH.$nomeFile);
			}

			$rs = $Sql->deleteInstance('ge_banner', array('codBanner'=>$idBanner));
			return $rs>0 ? intval($idBanner) : "Erro ao deletar banner.";
		 }
		 else{ return "ID inválido!"; }
		}
		else{ return "Usuario não identificado"; }

		return $rs===true ? $rs : 'Erro ao salvar os dados.';
	}

	static function obterUsuarios($id=null){
		$Sql = new Sql();

		$whereAdd = $id!=null && $id>0 ? " AND codUser = {$id}" : "";
		$querySql = "SELECT * FROM ge_usuarios WHERE codUser>0 {$whereAdd} ORDER BY data_cadastro DESC;";

		$Usuarios = array();
		foreach(Utils::array_get($Sql->select($querySql)) as $data){
			$Usuarios[] = $data;
		}
		return $Usuarios;
	}
	static function novoUsuario($user, $PUT){
		$Sql = new Sql();
		$Usuario=array();
		$rs = false;

		$idUser = isset($user['codUser']) ? $user['codUser'] : 0;
		$isSuper = isset($user['nivel'])&&$user['nivel']==1;
		if($idUser>0){
		  if($isSuper){
			$Usuario['nome'] = isset($PUT['nome']) ? $PUT['nome'] : null;
			$Usuario['email'] = isset($PUT['email']) ? $PUT['email'] : null;
			$Usuario['nivel'] = isset($PUT['nivel']) ? $PUT['nivel'] : null;
			$Usuario['senha'] = isset($PUT['senha']) ? md5($PUT['senha']) : md5($Usuario['email']);
			$Usuario['ativado'] = isset($PUT['ativado']) ? Utils::evalVar($PUT['ativado']) : true;

			if($Usuario['nome']!=null && $Usuario['email']!=null){
				$rs = $Sql->newInstance('ge_usuarios', $Usuario);

				return $rs>0 ? intval($rs) : "Erro ao salvar usuario.";
			}
			else{ return "Campos obrigatórios necessários."; }
		  }
		}
		else{ return "Usuario não identificado"; }

		return $rs===true ? $rs : 'Erro ao salvar os dados.';
	}
	static function updateUsuario($user, $PUT){
		$Sql = new Sql();
		$Usuario=array();
		$idUsuario = isset($PUT['id'])&&$PUT['id']!='' ? $PUT['id'] : 0;
		$rs = false;

		$idUser = isset($user['codUser']) ? $user['codUser'] : 0;
		$isSuper = isset($user['nivel'])&&$user['nivel']==1;
		if($idUser>0){
		  if($isSuper || ($idUsuario>0 && $idUsuario == $idUser)){
			$Usuario['nome'] = isset($PUT['nome']) ? $PUT['nome'] : null;
			$Usuario['email'] = isset($PUT['email']) ? $PUT['email'] : null;
			$Usuario['nivel'] = isset($PUT['nivel']) ? $PUT['nivel'] : null;
			$Usuario['ativado'] = isset($PUT['ativado']) ? Utils::evalVar($PUT['ativado']) : null;

			if($Usuario['nome']!=null && $Usuario['email']!=null){
				$rs = $Sql->updateInstance('ge_usuarios', array('codUser'=>$idUsuario), $Usuario);

				return $rs>0 ? intval($idUsuario) : "Erro ao salvar usuario.";
			}
			else{ return "Campos obrigatórios necessários."; }
		 }
		 else{ return "Permissões inválidas!"; }
		}
		else{ return "Usuario não identificado"; }

		return $rs===true ? $rs : 'Erro ao salvar os dados.';
	}
	static function deleteUsuario($user, $PUT){
		$Sql = new Sql();
		$idUsuario = isset($PUT['id'])&&$PUT['id']!='' ? intval($PUT['id']) : 0;
		$rs = false;

		$idUser = isset($user['codUser']) ? $user['codUser'] : 0;
		$isSuper = isset($user['nivel'])&&$user['nivel']==1;
		if($idUser>0){
		  if($isSuper && $idUsuario>0){
				$rs = $Sql->deleteInstance('ge_usuarios', array('codUser'=>$idUsuario));
				return $rs>0 ? intval($idUsuario) : "Erro ao deletar usuario.";
		 }
		 else{ return "ID inválido!"; }
		}
		else{ return "Usuario não identificado"; }

		return $rs===true ? $rs : 'Erro ao salvar os dados.';
	}

}

switch($_SERVER['REQUEST_METHOD']){
	case 'POST':{
		$arrResponse =  array('rs'=>false, 'msg'=>'');
		$params = Utils::receiveAjaxData('GET');

		if(isset($params['token']) && $params['token'] > time()){
			$u = User::auth(__FILE__, true);
			if(!empty($u)){
				$rs = false;

				switch($params['a']){
					case 'updateMenu':
						$rs = $u->getPerfil()=='TI' ? Controller::updateMenus(Utils::receiveAjaxData('POST')) : "Sem Permissão para essa função !";
						break;
					case 'novoBanner':
						$rs = Controller::novoBanner(Utils::receiveAjaxData('POST'), $u->getId());
						break;
					case 'novoEvento':
						$rs = Controller::novoEvento(Utils::receiveAjaxData('POST'), $u->getId());
						break;
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