const getId = id =>{ return document.getElementById(id); }
const get1 = q =>{ return document.querySelector(q); }
const get = q =>{ return document.querySelectorAll(q); }

class Utils{
	static MD5 = s =>{
		function L(k,d){return(k<<d)|(k>>>(32-d))}function K(G,k){var I,d,F,H,x;F=(G&2147483648);H=(k&2147483648);I=(G&1073741824);d=(k&1073741824);x=(G&1073741823)+(k&1073741823);if(I&d){return(x^2147483648^F^H)}if(I|d){if(x&1073741824){return(x^3221225472^F^H)}else{return(x^1073741824^F^H)}}else{return(x^F^H)}}function r(d,F,k){return(d&F)|((~d)&k)}function q(d,F,k){return(d&k)|(F&(~k))}function p(d,F,k){return(d^F^k)}function n(d,F,k){return(F^(d|(~k)))}function u(G,F,aa,Z,k,H,I){G=K(G,K(K(r(F,aa,Z),k),I));return K(L(G,H),F)}function f(G,F,aa,Z,k,H,I){G=K(G,K(K(q(F,aa,Z),k),I));return K(L(G,H),F)}function D(G,F,aa,Z,k,H,I){G=K(G,K(K(p(F,aa,Z),k),I));return K(L(G,H),F)}function t(G,F,aa,Z,k,H,I){G=K(G,K(K(n(F,aa,Z),k),I));return K(L(G,H),F)}function e(G){var Z;var F=G.length;var x=F+8;var k=(x-(x%64))/64;var I=(k+1)*16;var aa=Array(I-1);var d=0;var H=0;while(H<F){Z=(H-(H%4))/4;d=(H%4)*8;aa[Z]=(aa[Z]| (G.charCodeAt(H)<<d));H++}Z=(H-(H%4))/4;d=(H%4)*8;aa[Z]=aa[Z]|(128<<d);aa[I-2]=F<<3;aa[I-1]=F>>>29;return aa}function B(x){var k="",F="",G,d;for(d=0;d<=3;d++){G=(x>>>(d*8))&255;F="0"+G.toString(16);k=k+F.substr(F.length-2,2)}return k}function J(k){k=k.replace(/rn/g,"n");var d="";for(var F=0;F<k.length;F++){var x=k.charCodeAt(F);if(x<128){d+=String.fromCharCode(x)}else{if((x>127)&&(x<2048)){d+=String.fromCharCode((x>>6)|192);d+=String.fromCharCode((x&63)|128)}else{d+=String.fromCharCode((x>>12)|224);d+=String.fromCharCode(((x>>6)&63)|128);d+=String.fromCharCode((x&63)|128)}}}return d}var C=Array();var P,h,E,v,g,Y,X,W,V;var S=7,Q=12,N=17,M=22;var A=5,z=9,y=14,w=20;var o=4,m=11,l=16,j=23;var U=6,T=10,R=15,O=21;s=J(s);C=e(s);Y=1732584193;X=4023233417;W=2562383102;V=271733878;for(P=0;P<C.length;P+=16){h=Y;E=X;v=W;g=V;Y=u(Y,X,W,V,C[P+0],S,3614090360);V=u(V,Y,X,W,C[P+1],Q,3905402710);W=u(W,V,Y,X,C[P+2],N,606105819);X=u(X,W,V,Y,C[P+3],M,3250441966);Y=u(Y,X,W,V,C[P+4],S,4118548399);V=u(V,Y,X,W,C[P+5],Q,1200080426);W=u(W,V,Y,X,C[P+6],N,2821735955);X=u(X,W,V,Y,C[P+7],M,4249261313);Y=u(Y,X,W,V,C[P+8],S,1770035416);V=u(V,Y,X,W,C[P+9],Q,2336552879);W=u(W,V,Y,X,C[P+10],N,4294925233);X=u(X,W,V,Y,C[P+11],M,2304563134);Y=u(Y,X,W,V,C[P+12],S,1804603682);V=u(V,Y,X,W,C[P+13],Q,4254626195);W=u(W,V,Y,X,C[P+14],N,2792965006);X=u(X,W,V,Y,C[P+15],M,1236535329);Y=f(Y,X,W,V,C[P+1],A,4129170786);V=f(V,Y,X,W,C[P+6],z,3225465664);W=f(W,V,Y,X,C[P+11],y,643717713);X=f(X,W,V,Y,C[P+0],w,3921069994);Y=f(Y,X,W,V,C[P+5],A,3593408605);V=f(V,Y,X,W,C[P+10],z,38016083);W=f(W,V,Y,X,C[P+15],y,3634488961);X=f(X,W,V,Y,C[P+4],w,3889429448);Y=f(Y,X,W,V,C[P+9],A,568446438);V=f(V,Y,X,W,C[P+14],z,3275163606);W=f(W,V,Y,X,C[P+3],y,4107603335);X=f(X,W,V,Y,C[P+8],w,1163531501);Y=f(Y,X,W,V,C[P+13],A,2850285829);V=f(V,Y,X,W,C[P+2],z,4243563512);W=f(W,V,Y,X,C[P+7],y,1735328473);X=f(X,W,V,Y,C[P+12],w,2368359562);Y=D(Y,X,W,V,C[P+5],o,4294588738);V=D(V,Y,X,W,C[P+8],m,2272392833);W=D(W,V,Y,X,C[P+11],l,1839030562);X=D(X,W,V,Y,C[P+14],j,4259657740);Y=D(Y,X,W,V,C[P+1],o,2763975236);V=D(V,Y,X,W,C[P+4],m,1272893353);W=D(W,V,Y,X,C[P+7],l,4139469664);X=D(X,W,V,Y,C[P+10],j,3200236656);Y=D(Y,X,W,V,C[P+13],o,681279174);V=D(V,Y,X,W,C[P+0],m,3936430074);W=D(W,V,Y,X,C[P+3],l,3572445317);X=D(X,W,V,Y,C[P+6],j,76029189);Y=D(Y,X,W,V,C[P+9],o,3654602809);V=D(V,Y,X,W,C[P+12],m,3873151461);W=D(W,V,Y,X,C[P+15],l,530742520);X=D(X,W,V,Y,C[P+2],j,3299628645);Y=t(Y,X,W,V,C[P+0],U,4096336452);V=t(V,Y,X,W,C[P+7],T,1126891415);W=t(W,V,Y,X,C[P+14],R,2878612391);X=t(X,W,V,Y,C[P+5],O,4237533241);Y=t(Y,X,W,V,C[P+12],U,1700485571);V=t(V,Y,X,W,C[P+3],T,2399980690);W=t(W,V,Y,X,C[P+10],R,4293915773);X=t(X,W,V,Y,C[P+1],O,2240044497);Y=t(Y,X,W,V,C[P+8],U,1873313359);V=t(V,Y,X,W,C[P+15],T,4264355552);W=t(W,V,Y,X,C[P+6],R,2734768916);X=t(X,W,V,Y,C[P+13],O,1309151649);Y=t(Y,X,W,V,C[P+4],U,4149444226);V=t(V,Y,X,W,C[P+11],T,3174756917);W=t(W,V,Y,X,C[P+2],R,718787259);X=t(X,W,V,Y,C[P+9],O,3951481745);Y=K(Y,h);X=K(X,E);W=K(W,v);V=K(V,g)}var i=B(Y)+B(X)+B(W)+B(V);return i.toLowerCase();
	}
	
	static scape = str =>{
		let a = ['\'' ,'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ'];
		let b = ['' ,'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'];
		for(let i=0;i<a.length;i++){
		  str = str.split(a[i]).join(b[i]);
		}
		return str;
	}

	static isEmail = str =>{
		if(str.indexOf('..')>=0) return false;
		let user = str.substring(0, str.indexOf("@")),
		domain = str.substring(str.indexOf("@")+ 1, str.length);	
		return (
			(user.length >=1) && (domain.length >=3) && 
			(user.search("@")==-1) && 
			(domain.search("@")==-1) &&
			(user.search(" ")==-1) && 
			(domain.search(" ")==-1) &&
			(domain.search(".")!=-1) &&      
			(domain.indexOf(".") >=1)&& 
			(domain.lastIndexOf(".") < domain.length - 1)
		);
	}
	
	static logBase = (val, base) =>{
		return Math.log(val)/Math.log(base);
	}
	static byteConvert = bytes =>{
		if(bytes==0) return '0B';
		let s = ['B','K','M','G','T','P','E','Z','Y'];
		let e = Math.floor(Utils.logBase(bytes, 1024));
		return Math.round(bytes/Math.pow(1024, e)).toFixed(2)+s[e];
	}

	static count = (q, root = document) =>{
		return root.querySelectorAll(q).length;
	}

	static isDatalistVal = (id, val) =>{
		let opt = document.querySelector("datalist#"+id+" option[value='"+val+"']");
		return opt!=null && opt.value.length>0 ? opt : false;
	}

	static maxLength = e =>{
		let max = parseInt(e.getAttribute('maxlength')), id=e.id+'iMax', min = max - e.value.length;
		if(e.value.length > max){
			//SwalToast('Este campo permite o preenchimento de no máximo ' + max + ' caracteres. \nOs caracteres acima deste limite serão retirados do texto.', '', 'warning');
			e.value = e.value.substr(0, max);
			min = 0;
		}
		if(document.querySelector('#'+id)==null){
			let small = document.createElement('small');
			let inside = e.classList.contains('vertical')?'outside':'inside';
			small.className = 'limit_char '+inside+' small';
			small.id = id;
			e.parentNode.appendChild(small);
		}
		let numRest = document.querySelector('#'+id), hasFocus = e === document.activeElement;
		numRest.innerHTML = '<b>' + min + ' / ' + max + '</b>';
		numRest.style.display = !hasFocus ? 'none' : 'block';
	}

	static mask = (str, pattern) =>{
		let i = 0, val = str.toString();
		return pattern.replace(/#/g, ()=> val[i++] || '');
	}

	static soNumeros = str=>{
		return str.replace(/\D/g,"");
	}
	
	static stripTags = str =>{
		let e = document.createElement('DIV');
		e.innerHTML = str;
		return e.textContent || e.innerText || '';
	}

	static inArray(needle, haystack){
		return Array.from(haystack||[]).includes(needle);
	}

	static hasDuplicates(array){
		return (new Set(array)).size!==array.length;
	}

	static Obj2FD(obj){
		let data = new FormData();
		for(const [key, val] of Object.entries(obj)){
			data.append(key,val);
		}
		return data;
	}

	static time = ()=>{
		return new Date().getTime();
	}

	static isCPF = cpf =>{
		let soma, rev, iguais=1;
		cpf = cpf.replace(/\D/g,'');
		if(cpf.length != 11){
			return false;
        }
		for(let i = 0; i < cpf.length - 1; i++){
			if(cpf.charAt(i) != cpf.charAt(i + 1)){
				iguais = 0;
				break;
			}
		}
		if(iguais){
			return false;
		}
		soma = 0;
		for(let i=0;i<9;i++){
			soma += parseInt(cpf.charAt(i)) *(10-i);
		}
  		rev = 11 - (soma % 11);
		rev = rev == 10 || rev == 11 ? 0 : rev;
		if(rev != cpf.charAt(9)){
			return false;
		}
		soma = 0;
		for(let i = 0; i < 10; i ++){
			soma += parseInt(cpf.charAt(i)) * (11 - i);
		}
  	  	rev = 11 - (soma % 11);
		rev = rev == 10 || rev == 11 ? 0 : rev;
		if(rev != cpf.charAt(10)){
			return false;
		}
		return true;
	}

	static isCNPJ = cnpj =>{
		let num, dv, soma, i, rev, pos, tamanho, iguais=1;
		cnpj = cnpj.replace(/\D/g,'');
		if(cnpj.length != 14){
			return false;
		}
		for(i = 0; i < cnpj.length - 1; i++){
			if(cnpj.charAt(i) != cnpj.charAt(i + 1)){
				iguais = 0;
				break;
			}
		}
		if(iguais){
			return false;
		}		
		tamanho = cnpj.length - 2;
		num = cnpj.substring(0,tamanho);
		dv = cnpj.substring(tamanho); 
		soma = 0;	pos = tamanho - 7;
		for(i = tamanho; i >= 1; i--){
			soma += num.charAt(tamanho - i) * pos--; 
			if(pos < 2){
				pos = 9;
			}
		}
		rev = soma % 11 < 2 ? 0 : 11 - soma % 11; 
		if(rev != dv.charAt(0)){
			return false;
		}
		tamanho++;
		num = cnpj.substring(0,tamanho);
		soma = 0;	pos = tamanho - 7;
		for(i = tamanho; i >= 1; i--){ 
			soma += num.charAt(tamanho - i) * pos--;
			if(pos < 2){
				pos = 9;
			}
		} 
		rev = soma % 11 < 2 ? 0 : 11 - soma % 11;
		if(rev != dv.charAt(1)){
			return false;
		}
		return true;
	}
	//static teste = ()=>{ console.log(window); }
}
	class Device{
		constructor(w){
			const $w = window || w;
			this.userAgent = ($w.navigator.userAgent || $w.navigator.vendor || $w.opera).toLowerCase();
			this.platform = $w.navigator.platform.toLowerCase();
			this.appVersion = $w.navigator.appVersion.toLowerCase();

			this.nintendoWii = 'wii';
			this.nintendoDs = 'nitro';
			this.nintendo3ds = 'nintendo 3ds';
			this.nintendo = 'nintendo';

			this.googletv = 'googletv';
			this.windows = 'windows';

			this.mac = 'mac';
			this.macIntel = 'macintel';
			this.macintosh = 'macintosh';

			this.linuxUbuntu = 'ubuntu';
			this.linuxDebian = 'debian';
			this.linuxFedora = 'fedora';

			this.weixin = 'micromessenger';
			this.android = 'android';
			this.iphone = 'iphone';
			this.ipod = 'ipod';
			this.ipad = 'ipad';
		}

		getBrowser(){
			return this.userAgent.match(/(opera|chrome|safari|firefox|msie|trident)\/?\s*(\.?\d+(\.\d+)*)/i);
		}

		isNintendo(){
			return this.userAgent.search(this.nintendoDs) >-1 ||
			this.userAgent.search(this.nintendo3ds) >-1 || 
			this.userAgent.search(this.nintendo) >-1 ||
			this.userAgent.search(this.nintendoWii) >-1;
		}

		isWeixin(){
			return this.userAgent.search(this.weixin) > -1;
		}
		isAndroid(){
			return this.userAgent.search(this.android) > -1;
		}
		isIOS(){
			return this.userAgent.search(this.iphone) >-1 ||
			this.userAgent.search(this.ipad) >-1 ||
			this.userAgent.search(this.ipod) >-1;
		}
		isMobile(){
			return this.isNintendo() || this.isWeixin() || this.isAndroid() || this.isIOS();
		}

		isLinux(){
			return this.userAgent.search(this.linuxUbuntu) >-1 ||
			this.userAgent.search(this.linuxFedora) >-1 ||
			this.userAgent.search(this.linuxDebian) >-1;
		}
		isWindows(){
			return this.userAgent.search(this.windows) > -1;
		}
		isMac(){
			return this.userAgent.search(this.mac) >-1 ||
			this.userAgent.search(this.macIntel) >-1 ||
			this.userAgent.search(this.macintosh) >-1;
		}
		
		isDesktop(){
			return this.isWindows() || this.isMac() || this.isLinux();
		}
	}