<?php
class Utils{
	static function scape($str){
	  $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
	  $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
	  return str_replace($a, $b, $str);
	}
	static function clearChars($str){
		return strtr($str, array('\\'=>'', '/'=>'','\''=>'','"'=>'',':'=>'','*'=>'','?'=>'','<'=>'','>'=>'','|'=>''));
	}
	static function geraToken(){
		return md5(uniqid(rand(), true));
	}
	static function semNumeros($str){
		return preg_replace("/[0-9]/", '', $str);
	}
	static function soNumeros($str){
		return preg_replace("/[^0-9]/", '', $str);
	}
	static function semEspacos($str){
		return preg_replace("/\s+/", '', $str);
	}
	static function toFloat($value){
		return strtr(preg_replace("/\s+/", '', $value), array('.'=>'', ','=>'.'));
	}
	static function LPAD($str, $n, $s){
		$output = str_pad($str,$n, $s,STR_PAD_LEFT);
		return $output;
	}
	static function RPAD($str, $n, $s){
		$output = str_pad($str,$n, $s,STR_PAD_RIGHT);
		return $output;
	}

	//(-1.49999, 2) = [-1.49]	| (.49999, 3) = [0.499]
	static function truncar($val, $f='0'){
		if(($p = strpos($val, '.')) !== false){
			$val = floatval(substr($val, 0, $p + 1 + $f));
		}
		return $val;
	}
	static function antiSQL($s){
		$s = str_ireplace(";",'',$s);
		$s = str_ireplace("--",'',$s);
		$s = str_ireplace("'",'',$s);
		$s = str_ireplace('"','',$s);
		return addslashes(strip_tags($s));
	}
	static function isCPF($cpf){
			$iguais=1;
			$cpf = self::soNumeros($cpf);
			if(strlen($cpf) != 11){
				return false;
			}
			for($i = 0; $i < strlen($cpf) - 1; $i++){
				if($cpf[$i] != $cpf[$i+1]){
					$iguais = 0;
					break;
				}
			}
			if($iguais){
				return false;
			}
			$soma = 0;
			for($i=0;$i<9;$i++){
				$soma += $cpf[$i] *(10-$i);
			}
			$rev = 11 - ($soma % 11);
			$rev = $rev == 10 || $rev == 11 ? 0 : $rev;
			if($rev != $cpf[9]){
				return false;
			}
			$soma = 0;
			for($i = 0; $i < 10; $i++){
				$soma += $cpf[$i] * (11 - $i);
			}
			$rev = 11 - ($soma % 11);
			$rev = $rev == 10 || $rev == 11 ? 0 : $rev;
			if($rev != $cpf[10]){
				return false;
			}
		  return true;
		}
	static function isCNPJ($cnpj){
			$iguais=1;
			$cnpj = self::soNumeros($cnpj);
			if(strlen($cnpj) != 14){
				return false;
			}
			for($i = 0; $i < strlen($cnpj) - 1; $i++){
				if($cnpj[$i] != $cnpj[$i+1]){
					$iguais = 0;
					break;
				}
			}
			if($iguais){
				return false;
			}
			$tamanho = strlen($cnpj) - 2;
			$num = substr($cnpj,0,$tamanho);
			$dv = substr($cnpj,-2,1);
			$soma = 0;	$pos = $tamanho - 7;
			for($i = $tamanho; $i >= 1; $i--){
				$soma += intval($num[$tamanho - $i]) * $pos--;
				if($pos < 2){
					$pos = 9;
				}
			}
			$rev = $soma % 11 < 2 ? 0 : 11 - $soma % 11; 
			if($rev != $dv){
				return false;
			}
			$tamanho++;
			$num = substr($cnpj,0,$tamanho);
			$dv = substr($cnpj,-1,1);
			$soma = 0;	$pos = $tamanho - 7;
			for($i = $tamanho; $i >= 1; $i--){
				$soma += intval($num[$tamanho - $i]) * $pos--;
				if($pos < 2){
					$pos = 9;
				}
			} 
			$rev = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
			if($rev != $dv){
				return false;
			}
			return true;
		}
	static function isEmail($str){
		$usuario = substr($str, 0,strrpos($str, "@"));
		$dominio = substr($str, strrpos($str, "@")+ 1, strlen($str));
		if(	(strlen($usuario) >=1) &&
			(strlen($dominio) >=3) &&
			(!strrpos($usuario, "@")) &&
			(!strrpos($dominio, "@")) &&
			(!strrpos($usuario, " ")) &&
			(!strrpos($dominio, " ")) &&
			(strrpos($dominio, ".")) &&
			(strrpos($dominio, ".") < strlen($dominio) - 1)
		){	return true;	}
		return false;
	}
	static function isURL($dominio){
		if(	(strlen($dominio) >=3) &&
			(!strrpos($dominio, " ")) &&
			(strrpos($dominio, ".")) &&
			(strrpos($dominio, ".") < strlen($dominio) - 1)
		){	return true;	}
		return false;
	}
	static function setMask($val, $mask){
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++){
			if($mask[$i] == '#'){
				if(isset($val[$k])){
					$maskared .= $val[$k++];
				}
			} else{
				if(isset($mask[$i])){
					$maskared .= $mask[$i];
				}
			}
		}
		return $maskared;
	}
	static function getBrowserName($user_agent=''){
		$user_agent = $user_agent!='' ? $user_agent : $_SERVER['HTTP_USER_AGENT'];
		if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
		elseif (strpos($user_agent, 'Edge')) return 'Edge';
		elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
		elseif (strpos($user_agent, 'Safari')) return 'Safari';
		elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
		elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';
		return 'Other';
	}
	static function array_get($data){
		return $data!=null && is_array($data) ? $data : array();
	}
	static function evalVar($var, $type=''){
		switch($type){
			case 'STR':{
				$var = strval($var);
				break;
			}
			case 'INT':{
				$var = intval($var);
				break;
			}
			case 'FLOAT':{
				$var = floatval($var);
				break;
			}
			case 'BOOL':{
				$var = filter_var($var,FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
				break;
			}
			case 'EMAIL':{
				$var = Utils::isEmail($var) ? $var : '';
				break;
			}
			case 'URL':{
				$var = Utils::isURL($var) ? $var : '';
				break;
			}
			default: { $var = $var;	}
		}
		return $var;
	}

	static function teste($a){ return 'Received: = '.$a; }
}
?>