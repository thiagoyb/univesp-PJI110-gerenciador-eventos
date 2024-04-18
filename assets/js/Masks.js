	/*Função Pai de Mascaras*/
    function Maskify(o,f){
	   let v='', isVal = (typeof o)=='string'||(typeof o)=='number';
	   let val = isVal ? o : o.value;	 v=val.toString();
       switch(f){//get data-mask
			case 'Integer':{//Função que permite apenas numeros naturais
				v=v.replace(/\D/g,'');
				break;
			}
			case 'Int':{//Função que permite apenas numeros inteiros
				let isNeg = v.substring(0,1)==='-'?'-':'';
				v=isNeg+v.replace(/\D/g,'');
				break;
			}
			case 'Ramal':{//Função que padroniza ramal 4184-1241
				v=v.replace(/\D/g,"");
				v=v.substring(0,8);
				v=v.replace(/(\d{4})(\d)/,"$1-$2");
				break;
			}
			case 'Tel':{//Função que padroniza telefone (11) 4184-1241
				v=v.replace(/\D/g,"");
				v=v.substring(0,11);
				v=v.replace(/^(\d\d)(\d)/g,"($1) $2");
				v=v.replace(/(\d{4})(\d)/,"$1-$2");
				break;
		   }
			case 'Cel':{//Função que padroniza celular (11) 94184-1241
				v=v.replace(/\D/g,"");
				v=v.substring(0,11);
				v=v.replace(/^(\d\d)(\d)/g,"($1) $2");
				v=v.replace(/(\d{5})(\d)/,"$1-$2");
				break;
		   }
			case 'Cpf':{//Função que padroniza CPF
				v=v.replace(/\D/g,"");
				v=v.substring(0,11);
				v=v.replace(/(\d{3})(\d)/,"$1.$2");
				v=v.replace(/(\d{3})(\d)/,"$1.$2");
				v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2");
				break;
		   }
			case 'Pis':{//Função que padroniza PIS
				v=v.replace(/\D/g,"");
				v=v.substring(0,11);
				v=v.replace(/(\d{3})(\d)/,"$1.$2");
				v=v.replace(/(\d{5})(\d)/,"$1.$2");
				v=v.replace(/(\d{2})(\d{1,2})$/,"$1-$2");
				break;
		   }
			case 'Rg':{//Função que padroniza RG com X
				v=v.replace(/[^0-9xX]/g,"");
				v=v.substring(0,9);
				v=v.replace(/([0-9xX]{2})([0-9xX])/,"$1.$2");
				v=v.replace(/([0-9xX]{3})([0-9xX])/,"$1.$2");
				v=v.replace(/([0-9xX]{3})([0-9xX]{1,2})$/,"$1-$2");
				break;
		   }
			case 'Alpha':{//Função que permite apenas letras
				v.replace(/[^A-Za-zçÇ ]/ig,"");
				break;
		   }
			case 'AlphaNum':{//Função que permite apenas letras com numeros
				v.replace(/[^0-9A-Za-zçÇ ]/ig,"");
				break;
		   }
			case 'AlphaDot':{//Função que permite apenas letras com numeros e .
				v.replace(/[^.0-9A-Za-zçÇ]/ig,"");
				break;
		   }
			case 'AlphaComma':{//Função que permite apenas letras com numeros , e . 
				v.replace(/[^.,0-9A-Za-zçÇ]/ig,"");
				break;
		   }
			case 'AlphaEmail':
			case 'Email':{//Função que permite apenas caracteres de Email
				v.replace(/[^.0-9A-Za-z_@-]/ig,"");
				break;
		   }
			case 'Float':{//Função que permite float
				v=v.replace(/\D/g,"");
				v=v.replace(/(\d+)(\d{2})$/,"$1.$2");
				break;
		   }
			case 'Valor':
			case 'Money':{//Função que padroniza valor monétario com vírgula e separadores de milhares com ponto
				v=v.replace(/\D/g,"");
				if(v.length>=6 && v.length <=8){
					v=v.replace(/(\d+)(\d{5})/g,"$1.$2");
				}
				if(v.length>=9 && v.length <=11){
					v=v.replace(/(\d+)(\d{3})(\d{5})/g,"$1.$2.$3");
				}
				if(v.length>=12 && v.length <=14){
					v=v.replace(/(\d+)(\d{3})(\d{3})(\d{5})/g,"$1.$2.$3.$4");
				}
				if(v.length>=15 && v.length <=17){
					v=v.replace(/(\d+)(\d{3})(\d{3})(\d{3})(\d{5})/g,"$1.$2.$3.$4.$5");
				}
				if(v.length>=18 && v.length <=20){
					v=v.replace(/(\d+)(\d{3})(\d{3})(\d{3})(\d{3})(\d{5})/g,"$1.$2.$3.$4.$5.$6");
				}
				if(v.length>=19 && v.length <=21){
					v=v.replace(/(\d+)(\d{3})(\d{3})(\d{3})(\d{3})(\d{3})(\d{5})/g,"$1.$2.$3.$4.$5.$6.$7");
				}
				if(v.length>=22 && v.length <=24){
					v=v.replace(/(\d+)(\d{3})(\d{3})(\d{3})(\d{3})(\d{3})(\d{3})(\d{5})/g,"$1.$2.$3.$4.$5.$6.$7.$8");
				}
				if(v.length>=25 && v.length <=27){
					v=v.replace(/(\d+)(\d{3})(\d{3})(\d{3})(\d{3})(\d{3})(\d{3})(\d{3})(\d{5})/g,"$1.$2.$3.$4.$5.$6.$7.$8.$9");
				}
				if(v.length>=28 && v.length <=30){
					v=v.replace(/(\d+)(\d{3})(\d{3})(\d{3})(\d{3})(\d{3})(\d{3})(\d{3})(\d{3})(\d{5})/g,"$1.$2.$3.$4.$5.$6.$7.$8.$9.$10");
				}
				v=v.replace(/(\d)(\d{2})$/,"$1,$2");
				break;
		   }
			case 'Agencia':{//Função para Agência Bancária
				v=v.replace(/D/g,"");
				v=v.substring(0,5);
				v=v.replace(/([0-9]{4})([0-9]){1}/,"$1-$2");
				break;
			}
			case 'Conta':{//Função para Conta Bancária
				v=v.replace(/D/g,"");
				v=v.substring(0,8);
				if(v.length<=6){
					v=v.replace(/([0-9]{5})([0-9]){1}/,"$1-$2");
				}
				if(v.length<=8){
					v=v.replace(/([0-9]{7})([0-9]){1}/,"$1-$2");
				}
				break;
			}
			case 'Cep':{//Função que padroniza CEP
				v=v.replace(/\D/g,"");
				v=v.substring(0,8);
				v=v.replace(/^(\d{5})(\d{3})/,"$1-$2");
				break;
			}
			case 'Cnpj':{//Função que padroniza CNPJ
				v=v.replace(/\D/g,"");
				v=v.substring(0,14);
				v=v.replace(/^(\d{2})(\d)/,"$1.$2");
				v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3");
				v=v.replace(/\.(\d{3})(\d)/,".$1/$2");
				v=v.replace(/(\d{4})(\d)/,"$1-$2");
				break;
			}
			case 'Romanos':{//Função que permite apenas numeros Romanos
				v=v.toUpperCase();
				v=v.replace(/[^IVXLCDM]/g,"");
				while(v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/,"")!=""){
					v=v.replace(/.$/,"");
				}
				break;
			}
			case 'Url':
			case 'Site':{//Função que padroniza o Site
				v=v.replace(/^http:\/\/?/,"");
				dominio=v;
				caminho="";
				if(v.indexOf("/")>-1){
					dominio=v.split("/")[0];
					caminho=v.replace(/[^\/]*/,"");
					dominio=dominio.replace(/[^\w\.\+-:@]/g,"");
					caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"");
					caminho=caminho.replace(/([\?&])=/,"$1");
				}
				if(caminho!=""){
					dominio=dominio.replace(/\.+$/,"");
					v="http://"+dominio+caminho;
				}
				break;
		   }
			case 'Data':{//Função que padroniza Data: dd/mm/YYYY
				v=v.replace(/\D/g,"");
				v=v.substring(0,8);
				v=v.replace(/(\d{2})(\d)/,"$1/$2");
				v=v.replace(/(\d{2})(\d)/,"$1/$2");
				break;
		   }
			case 'Hora':{//Função que padroniza Hora: HH:ii
				v=v.replace(/\D/g,"");
				v=v.substring(0,4);
				v=v.replace(/(\d{2})(\d{2})/,"$1:$2");
				break;
		   }
			case 'DataHora':{//Função que padroniza Hora+Hora: dd/mm/YYYY HH:ii
				v=v.replace(/D/g,"");
				v=v.substring(0,12);
				v=v.replace(/(\d{2})(\d{2})(\d{4})(\d{2})(\d{2})/,"$1/$2/$3 $4:$5");
				break;
		   }
			case 'Timestamp':{//Função que padroniza Timestamp dd/mm/YYYY HH:ii:ss
				v=v.replace(/D/g,"");
				v=v.substring(0,14);// pos inicial , qtde+1
				v=v.replace(/(\d{2})(\d{2})(\d{4})(\d{2})(\d{2})(\d{2})/,"$1/$2/$3 $4:$5:$6");
				break;
		   }
			case 'Area':{//Função que padroniza Area
				v=v.replace(/\D/g,"");
				v=v.replace(/(\d)(\d{2})$/,"$1.$2");
				break;
		   }
		   default:{ v = val; break; }
	   }

       return isVal ? v : setTimeout(()=>{ o.value=v; o.classList.add('masked'); },1);
    }