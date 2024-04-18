/*function tableHeaderFixed(cls){
	if(document.getElementsByClassName(cls).length>0){
		window.onscroll = function(){
			let tab = document.getElementsByClassName(cls)[0];
			let tab_top = tab.getBoundingClientRect().top + window.scrollY;
			let thCels = tab.getElementsByTagName('th');
			for(let i=0; i<thCels.length;i++){
			  thCels[i].style.zIndex = 9;      
			  thCels[i].style.top =  tab_top - window.scrollY <=0 ? window.scrollY - tab_top+'px' : 0;
		   }
	   }
	}
}*/

const addEventsListener = (element, events, fn)=>{
	events.split(' ').forEach(event =>{
		element.addEventListener(event, fn, false);
	});
}

const ApplyMasks = ()=>{
	document.querySelectorAll("[class*='type'").forEach(e =>{
		let maskKey = e.classList.toString().split('type')[1].split(' ')[0];
		addEventsListener(e,'input mouseover', ev =>{ Maskify(e, maskKey); });
	});
}

const getInternetIp = ()=>{
	//fetch('https://api.ipify.org/?format=json',{method: 'GET'}).then(r=>{ return r.json()}).then(i=>{ console.log(i.ip)});
}

document.addEventListener("DOMContentLoaded", event=>{
	ApplyMasks(); getInternetIp();
	//tableHeaderFixed('tbFixedHeader');
});