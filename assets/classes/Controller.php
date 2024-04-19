<?php
	if(!class_exists('Utils')) require 'Utils.php';
	if(!class_exists('Sql')) require 'Sql.php';

class Controller{
	static function obterSecoes($id=null, $publicar=false, $slug=null){
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
	static function updateSecoes($idUser, $arrSecoes){
		$Sql = new Sql();
		$arrCampos=array();
		$whereAdd = "";
		$rs = false;

		foreach($arrSecoes as $secao){
			$arrCampos['ordem'] = isset($secao['ordem'])&&$secao['ordem']>0 ? $secao['ordem'] : null;
			$arrCampos['nome'] = isset($secao['nome'])&&$secao['nome']!='' ? $secao['nome'] : null;
			$arrCampos['titulo'] = isset($secao['titulo'])&&$secao['titulo']!='' ? $secao['titulo'] : null;
			$arrCampos['url'] = isset($secao['url'])  ? $secao['url'] : null;
			$arrCampos['publicar'] = isset($secao['ativado']) ? $secao['ativado'] : null;

			$id = isset($secao['id']) ? $secao['id'] : null;
			$rs = $id!=null ? $Sql->updateInstance('ge_secao', array('codSecao'=>$id), $arrCampos, $whereAdd, true) : true;
		}

		return $rs===true ? $rs : 'Erro ao salvar os dados.';
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

	static function obterBanners($id=null, $publicar=false){
		$Sql = new Sql();

		$whereAdd = $publicar ? " AND publicar = 1" : "";
		$whereAdd .= $id!=null && $id>0 ? " AND codBanner = {$id}" : "";
		$querySql = "SELECT * FROM ge_banner L WHERE codBanner>0 {$whereAdd} ORDER BY ordem ASC, data_upload DESC;";

		$Banners = array();
		foreach(Utils::array_get($Sql->select($querySql)) as $data){
			$Banners[] = $data;
		}
		return $Banners;
	}
	static function novoBanner($idUser, $PUT){
		$Sql = new Sql();
		$Banner=array();
		$rs = false;
		$maxSize = isset($PUT['max']) ? $PUT['max'] : 5;

		if($idUser>0){
			///$Banner['fkUser'] = $idUser;
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

				$path = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'banner'.DIRECTORY_SEPARATOR;
				$titleNome = Utils::scape(Utils::clearInvalidChars(str_replace('NULL','',str_replace(' ','-',$Banner['titulo']))));
				$nomeFile = str_replace('--','--','banner-'.$titleNome.'-'.uniqid('iams').'.jpg');

				if(file_put_contents($path.$nomeFile, base64_decode($imagemBase64))){
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
			///$Banner['fkUser'] = $idUser;
			$Banner['ordem'] = isset($PUT['ordem']) ? Utils::soNumeros($PUT['ordem']) : null;
			$Banner['titulo'] = isset($PUT['titulo'])&&$PUT['titulo']!='' ? $PUT['titulo'] : 'NULL';
			$Banner['largura'] = isset($PUT['largura'])&&$PUT['largura']!='' ? Utils::soNumeros($PUT['largura']) : 'NULL';
			$Banner['altura'] = isset($PUT['altura'])&&$PUT['altura']!='' ? Utils::soNumeros($PUT['altura']) : 'NULL';
			$Banner['target'] = isset($PUT['destino'])&&$PUT['destino']!='' ? trim($PUT['destino']) : null;
			$Banner['url'] = isset($PUT['url'])&&$PUT['url']!='' ? $PUT['url'] : '#';
			$Banner['publicar'] = isset($PUT['publicar']) ? Utils::evalVar($PUT['publicar']) : true;
			//$BannerFile = isset($PUT['banner'])&&$PUT['banner']!='' ? $PUT['banner'] : null;

			if($Banner['ordem']!=null && $Banner['target']!=null){
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
			$path = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'banner'.DIRECTORY_SEPARATOR;

			if(file_exists($path.$nomeFile)){
				unlink($path.$nomeFile);
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
?>