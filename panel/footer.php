<?php
	///echo URL_HOME;exit;//OK
?>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/jquery-3.3.1.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/popper.min.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/bootstrap.min.js"></script>

	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/Utils.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/Masks.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/Listeners.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/tinymce/tinymce.min.js"></script>
<SCRIPT>tinymce.init({
  selector:'textarea#conteudo',
  branding: false,
  language: 'pt_BR',
  plugins: 'print preview paste image link hr pagebreak insertdatetime lists wordcount help emoticons',
  menubar: 'edit insert format help',
  toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | forecolor backcolor removeformat | image link emoticons charmap | preview wordcount print',
  quickbars_selection_toolbar: 'bold italic underline | quicklink',
  file_picker_types: 'image',
  paste_block_drop: false,
  hidden_input: false,
  contextmenu: '',
  setup: function(editor){
	editor.on('input', e=>{
		liberarAlteracao(document.forms[0].name.split('form_').join(''));	
	});
  }
});
class AjaxController{
	static prepare(c){
		let form = c!=null&&c!='' ? document.querySelector('form[name=form_'+c+']') : document, btnSubmit = form.querySelector('[name=submit]');
		if(btnSubmit){
			btnSubmit.setAttribute('disabled', true);
			let span = document.createElement('SPAN');
			span.innerHTML="<u class='ml-2 circLoader'></u>";
			btnSubmit.append(span);
		}
	}
	static preparaFiles(id){//v2.203.202.3
	  let form = document.querySelector('form[name=form_'+id+']'), inputFile = form.querySelector('[type=file]');
	  if(form && inputFile && inputFile.files.length>0){
		let file = inputFile.files[0], oldFile = document.querySelector('#fileToUpload');
		if(oldFile) oldFile.remove();
		const max = inputFile.dataset.maxfilesize;
		if(inputFile.accept.split(',').indexOf(file.type) !== -1){
			if(!max||file.size <= max *1024*1024){
				let spanFile = document.createElement('SPAN');
				spanFile.innerHTML = '<div class="text" id="fileToUpload">Arquivo: <b>'+inputFile.value+'</b></div>';
				inputFile.parentElement.append(spanFile);
				return true;
			} else{ inputFile.value='';
			  toast('Arquivo e maior do que '+max+'MB !','error');
			}
		} else{ inputFile.value='';
			toast('Formato de arquivo não permitido.','error');
		}
	  }
	}
	static previewImage(id){//v3.108.202.3
	  let form = document.querySelector('form[name=form_'+id+']'), inputFile = form.querySelector('[type=file]'), reader = new FileReader();
	  if(form && inputFile && inputFile.files.length>0){
		let file = inputFile.files[0], oldFile = document.querySelector('#imgToUpload');
		if(oldFile) oldFile.remove();
		const max = inputFile.dataset.maxfilesize;
		if(inputFile.accept.split(',').indexOf(file.type) !== -1){
			if(!max||file.size <= max *1024*1024){
				reader.readAsDataURL(file);
				reader.onload = function(){
					if(reader.readyState==2){
						let container = document.createElement('DIV');
						container.setAttribute('id','imgToUpload');
						container.setAttribute('class','col-12');
						container.innerHTML = "<img src='"+reader.result+"' class='imgToUpload mt-3' />";
						container.innerHTML+= "<input type='hidden' class='hidden' name='banner' id='banner' value='"+reader.result+"' />";
						inputFile.parentElement.append(container);
					}
				};
				return true;
			} else{ inputFile.value='';
			  toast('Imagem e maior do que '+max+'MB !','error');
			}
		} else{ inputFile.value='';
			toast('Formato de arquivo não permitido.','error');
		}
	  }
	}
	static reset(c){
		let form = c!=null&&c!='' ? document.querySelector('form[name=form_'+c+']') : document, btnSubmit = form.querySelector('[name=submit]');
		if(btnSubmit){
			btnSubmit.removeAttribute('disabled');
			let span = btnSubmit.querySelector('SPAN');
			if(span) span.remove();
		}
	}
	static updateConfig(c){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o=[],token = '<?= strtotime('+2 hour'); ?>';
		Array.from(form.querySelectorAll('LI.CONFIG')).forEach( e =>{
		  let id = e.dataset.id, campo = e.querySelector('[name=titulo]'), valor = e.querySelector('[name=conteudo]'), atv = e.querySelector('#publicar'+id);
		  if(campo && valor && atv){
			let arr = {};
			arr['id'] = id;
			arr['titulo'] = campo.value;
			arr['valor'] = valor.value;
			arr['ativado'] = atv.checked;
			o.push(arr);
		  }
		});
		if(o.length>0){
			AjaxController.prepare(c);
			  return fetch(`ajax.php?a=updateConfig&categ=${key}&token=${token}`,{
				method: 'POST', headers: {
				  'Content-Type':'application/json; charset=UTF-8',
				  'Accept': 'application/json'
				},
				body: JSON.stringify(o)
				})
				.then(response => {
					if(!response.ok){
					   throw new Error('Error: '+response.statusText);
					}
					return response.json();
				})
				.then(rs => {
					AjaxController.reset(c);
					if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
					if(rs.rs==0){
						SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
					}
					if(rs.rs==1){
						SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
							setTimeout(()=>{window.location.reload();}, 500);
						});
					}
				});
		} else{
			SwalAlert('Error', 'Objeto nao recebido.', 'error');
		}
	}

	static updateSecoes(c){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o=[],token = '<?= strtotime('+2 hour'); ?>';
		let orders=[];
		Array.from(form.querySelectorAll('LI.SECAO')).forEach( e =>{
		  let id = e.dataset.id, ordem = e.querySelector('#ordem'+id+':not([disabled])'), nome = e.querySelector('#nome'+id),
		  atv = e.querySelector('.switcher#publicar'+id);
		  if(nome && atv){
			if(!ordem || ordem.value){
			  if(nome.value){
				let arr = {};
				arr['id'] = id;
				arr['ordem'] = !ordem ? null : ordem.value;
				arr['nome'] = nome.value;
				arr['ativado'] = atv.checked;			
				o.push(arr);
				if(ordem) orders.push(arr.ordem);
			  } else{
				SwalAlert('Error', 'Preecha o campo nome.', 'error')?.then(()=>{nome.focus();});
			  }
			} else{
				SwalAlert('Error', 'Preecha o campo ordem.', 'error')?.then(()=>{ordem.focus();});
			}
		  } else{ console.log('Error getting fields.');}
		});
		if(o.length>0){
		  if(!Utils.hasDuplicates(orders)){
			AjaxController.prepare(c);
			  return fetch(`ajax.php?a=updateSecoes&categ=SECOES&token=${token}`,{
				method: 'POST', headers: {
				  'Content-Type':'application/json; charset=UTF-8',
				  'Accept': 'application/json'
				},
				body: JSON.stringify(o)
				})
				.then(response => {
					if(!response.ok){
					   throw new Error('Error: '+response.statusText);
					}
					return response.json();
				})
				.then(rs => {
					AjaxController.reset(c);
					if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
					if(rs.rs==0){
						SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
					}
					if(rs.rs==1){
						SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
							setTimeout(()=>{window.location.reload();}, 500);
						}); setTimeout(()=>{window.location.reload();}, 500);
					}
				});
		  } else {	SwalAlert('Error', 'Os campos de Ordenação não podem ter valores repetidos.', 'error'); }
		} else{ SwalAlert('Error', 'Objeto nao recebido.', 'error'); }
	}
	static updateSecao(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, arr={},token = '<?= strtotime('+2 hour'); ?>';
		Array.from(form.querySelectorAll('LI.SECAO')).forEach( e =>{
		  let id = e.dataset.id, nome = e.querySelector('#nome'+id), title = e.querySelector('#titulo'+id),
		  url = e.querySelector('#url'+id), atv = e.querySelector('.switcher#publicar'+id);
		  if(nome && title && url && atv){
			if(i == id){
			  if(nome.value!=''){
				arr['id'] = id;
				arr['nome'] = nome.value;
				arr['titulo'] = title.value;
				arr['ativado'] = atv.checked;
				arr['url'] = url.value;
			  } else{
				SwalAlert('Error', 'Preecha o campo nome.', 'error')?.then(()=>{nome.focus();});
			  }
			}
		  }
		});
		if(Object.keys(arr).length>0){
			AjaxController.prepare(c);
			  return fetch(`ajax.php?a=updateSecoes&categ=SECOES&token=${token}`,{
				method: 'POST', headers: {
				  'Content-Type':'application/json; charset=UTF-8',
				  'Accept': 'application/json'
				},
				body: JSON.stringify([arr])
				})
				.then(response => {
					if(!response.ok){
					   throw new Error('Error: '+response.statusText);
					}
					return response.json();
				})
				.then(rs => {
					AjaxController.reset(c);
					if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
					if(rs.rs==0){
						SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
					}
					if(rs.rs==1){
						SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
							setTimeout(()=>{window.location.reload();}, 500);
						}); setTimeout(()=>{window.location.reload();}, 500);
					}
				});
		} else{ SwalAlert('Error', 'Objeto nao recebido.', 'error');}
	}

	static novaPage(c){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>',
		conteudo = form.querySelector('#conteudo');
		if(conteudo) conteudo.value = tinymce.activeEditor.getContent({format:'raw'});
		Array.from(form.elements).forEach(e=>{
			if(!['button','reset','fieldset','submit'].includes(e.type)){
				if(e.hasAttribute('required') && !e.value.length){
					SwalAlert('Error', 'Preenchao campo '+e.name, 'error')?.then(()=>{
						e.focus();
					});
				} else{
					if(e.type!='checkbox'){ o[e.name] = e.value; }
					else{ o[e.name] = e.checked ? 1: 0; }
				}
			}
		});
	  if(Utils.stripTags(conteudo.value).length>3){
		AjaxController.prepare(c);
		return fetch(`ajax.php?a=novaPage&token=${token}`,{
		method: 'POST', headers: {
		  'Content-Type':'application/json; charset=UTF-8',
		  'Accept': 'application/json'
		},
		body: JSON.stringify(o)
		})
		.then(response => {
			if(!response.ok){
				AjaxController.reset(c);
			   throw new Error('Error: '+response.statusText);
			}
			return response.json();
		})
		.then(rs => {
			AjaxController.reset(c);
			if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
			if(rs.rs==0){
				SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
			}
			if(rs.rs==1){
				const toPage = (new URLSearchParams(window.location.search)).get('p');
				SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
					setTimeout(()=>{window.location.assign('?p=page_View&id='+rs.id);}, 500);
				}); setTimeout(()=>{window.location.assign('?p=page_View&id='+rs.id);},1500);
			}
		});
	  } else{SwalAlert('Erro', 'Preencha o conteudo !', 'error');}
	}
	static updatePage(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>',
		conteudo = form.querySelector('#conteudo');
		if(conteudo) conteudo.value = tinymce.activeEditor.getContent({format:'raw'});
		Array.from(form.elements).forEach(e=>{
			if(!['button','reset','fieldset','submit'].includes(e.type)){
				if(e.hasAttribute('required') && !e.value.length){
					SwalAlert('Error', 'Preenchao campo '+e.name, 'error')?.then(()=>{
						e.focus();
					});
				} else{	
					if(e.type!='checkbox'){ o[e.name] = e.value; }
					else{ o[e.name] = e.checked ? 1: 0; }
				}
			}
		});
		AjaxController.prepare(c);
		return i!=o.id ? null : fetch(`ajax.php?a=updatePage&token=${token}`,{
		method: 'POST', headers: {
		  'Content-Type':'application/json; charset=UTF-8',
		  'Accept': 'application/json'
		},
		body: JSON.stringify(o)
		})
		.then(response => {
			if(!response.ok){
				AjaxController.reset(c);
			   throw new Error('Error: '+response.statusText);
			}
			return response.json();
		})
		.then(rs => {
			AjaxController.reset(c);
			if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
			if(rs.rs==0){
				SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
			}
			if(rs.rs==1){
				const toPage = (new URLSearchParams(window.location.search)).get('p');
				SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
					setTimeout(()=>{window.location.reload()}, 500);
				}); setTimeout(()=>{window.location.reload()},1500);
			}
		});
	}

	static deleteNoticia(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, token = '<?= strtotime('+2 hour'); ?>',
		id = form.querySelector('[name=id]').value;
		if(confirm('Confirma apagar ?')){
			AjaxController.prepare(c);
			return i!=id ? null : fetch(`ajax.php?a=deleteNoticia&token=${token}`,{
			method: 'POST', headers: {
			  'Content-Type':'application/json; charset=UTF-8',
			  'Accept': 'application/json'
			},
			body: JSON.stringify({id:id})
			})
			.then(response => {
				if(!response.ok){
					AjaxController.reset(c);
				   throw new Error('Error: '+response.statusText);
				}
				return response.json();
			})
			.then(rs => {
				AjaxController.reset(c);
				if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
				if(rs.rs==0){
					SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
				}
				if(rs.rs==1){
					SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
						setTimeout(()=>{window.location.assign('?p=page_Noticias');}, 500);
					}); setTimeout(()=>{window.location.assign('?p=page_Noticias');},1500);
				}
			});
		}
	}
	static updateNoticia(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>',
		conteudo = form.querySelector('#conteudo');
		if(conteudo) conteudo.value = tinymce.activeEditor.getContent({format:'raw'});
		Array.from(form.elements).forEach(e=>{
			if(!['button','reset','fieldset','submit'].includes(e.type)){
				if(e.hasAttribute('required') && !e.value.length){
					SwalAlert('Error', 'Preenchao campo '+e.name, 'error')?.then(()=>{
						e.focus();
					});
				} else{	
					if(e.type!='checkbox'){ o[e.name] = e.value; }
					else{ o[e.name] = e.checked ? 1: 0; }
				}
			}
		});
		AjaxController.prepare(c);
		return i!=o.id ? null : fetch(`ajax.php?a=updateNoticia&token=${token}`,{
		method: 'POST', headers: {
		  'Content-Type':'application/json; charset=UTF-8',
		  'Accept': 'application/json'
		},
		body: JSON.stringify(o)
		})
		.then(response => {
			if(!response.ok){
				AjaxController.reset(c);
			   throw new Error('Error: '+response.statusText);
			}
			return response.json();
		})
		.then(rs => {
			AjaxController.reset(c);
			if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
			if(rs.rs==0){
				SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
			}
			if(rs.rs==1){
				SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
					setTimeout(()=>{window.location.assign('?p=page_Noticias&id='+rs.id);}, 500);
				}); setTimeout(()=>{window.location.assign('?p=page_Noticias&id='+rs.id);},1500);
			}
		});
	}
	static novaNoticia(c){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>',
		conteudo = form.querySelector('#conteudo');
		if(conteudo) conteudo.value = tinymce.activeEditor.getContent({format:'raw'});
		Array.from(form.elements).forEach(e=>{
			if(!['button','reset','fieldset','submit'].includes(e.type)){
				if(e.hasAttribute('required') && !e.value.length){
					SwalAlert('Error', 'Preencha o campo '+e.name, 'error')?.then(()=>{
						e.focus();
					});
				} else{	o[e.name] = e.value; }
			}
		});
		AjaxController.prepare(c);
		return fetch(`ajax.php?a=novaNoticia&token=${token}`,{
		method: 'POST', headers: {
		  'Content-Type':'application/json; charset=UTF-8',
		  'Accept': 'application/json'
		},
		body: JSON.stringify(o)
		})
		.then(response => {
			if(!response.ok){
				AjaxController.reset(c);
			   throw new Error('Error: '+response.statusText);
			}
			return response.json();
		})
		.then(rs => {
			AjaxController.reset(c);
			if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
			if(rs.rs==0){
				SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
			}
			if(rs.rs==1){
				SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
					setTimeout(()=>{window.location.assign('?p=page_Noticias&id='+rs.id);}, 500);
				}); setTimeout(()=>{window.location.assign('?p=page_Noticias&id='+rs.id);},1500);
			}
		});
	}

	static deleteLei(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, token = '<?= strtotime('+2 hour'); ?>',
		id = form.querySelector('[name=id]').value, nome = form.querySelector('[name=pdf]');
		if(nome && confirm('Confirma apagar ?')){
			AjaxController.prepare(c);
			return i!=id ? null : fetch(`ajax.php?a=deleteLei&token=${token}`,{
			method: 'POST', headers: {
			  'Content-Type':'application/json; charset=UTF-8',
			  'Accept': 'application/json'
			},
			body: JSON.stringify({id:id, nome:nome.value})
			})
			.then(response => {
				if(!response.ok){
					AjaxController.reset(c);
				   throw new Error('Error: '+response.statusText);
				}
				return response.json();
			})
			.then(rs => {
				AjaxController.reset(c);
				if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
				if(rs.rs==0){
					SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
				}
				if(rs.rs==1){
					SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
						setTimeout(()=>{window.location.assign('?p=page_Leis');}, 500);
					}); setTimeout(()=>{window.location.assign('?p=page_Leis');},1500);
				}
			});
		}
	}
	static updateLei(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>';
		Array.from(form.elements).forEach(e=>{
			if(!['button','reset','fieldset','submit'].includes(e.type)){
				if(e.hasAttribute('required') && !e.value.length){
					SwalAlert('Error', 'Preenchao campo '+e.name, 'error')?.then(()=>{
						e.focus();
					});
				} else{	
					if(e.type!='checkbox'){ o[e.name] = e.value; }
					else{ o[e.name] = e.checked ? 1: 0; }
				}
			}
		});
		AjaxController.prepare(c);
		return i!=o.id ? null : fetch(`ajax.php?a=updateLei&token=${token}`,{
		method: 'POST', headers: {
		  'Content-Type':'application/json; charset=UTF-8',
		  'Accept': 'application/json'
		},
		body: JSON.stringify(o)
		})
		.then(response => {
			if(!response.ok){
				AjaxController.reset(c);
			   throw new Error('Error: '+response.statusText);
			}
			return response.json();
		})
		.then(rs => {
			AjaxController.reset(c);
			if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
			if(rs.rs==0){
				SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
			}
			if(rs.rs==1){
				SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
					setTimeout(()=>{window.location.assign('?p=page_Leis&id='+rs.id);}, 500);
				}); setTimeout(()=>{window.location.assign('?p=page_Leis&id='+rs.id);},1500);
			}
		});
	}
	static novaLei(c){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>',
		pdf = form.querySelector('[type=file]'), data = new FormData();
		if(pdf && pdf.files.length>0){
			if(!AjaxController.preparaFiles(c)) return false;
			Array.from(form.elements).forEach(e=>{
				if(!['button','reset','fieldset','submit','file'].includes(e.type)){
					if(e.hasAttribute('required') && !e.value.length){
						SwalAlert('Error', 'Preencha o campo '+e.name, 'error')?.then(()=>{
							e.focus();
							AjaxController.reset(c);
						});
					} else{	
						if(e.type!='checkbox'){ o[e.name] = e.value; }						
						else{ o[e.name] = e.checked ? 1: 0; }
					}
				}
			});
			if(Object.keys(o).length>=6){
				data.append('max', pdf.dataset.maxfilesize);
				for(const [key, val] of Object.entries(o)){
					data.append(key,val);
				} data.append('anexo', pdf.files[0]);
				AjaxController.prepare(c);
				return fetch(`ajax.php?a=novaLei&token=${token}`,{
				method: 'POST',
				body: data
				})
				.then(response => {
					if(!response.ok){
						AjaxController.reset(c);
					   throw new Error('Error: '+response.statusText);
					}
					return response.json();
				})
				.then(rs => {
					AjaxController.reset(c);
					if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
					if(rs.rs==0){
						SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
					}
					if(rs.rs==1){
						SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
							setTimeout(()=>{window.location.assign('?p=page_Leis&id='+rs.id);}, 500);
						}); setTimeout(()=>{window.location.assign('?p=page_Leis&id='+rs.id);},1500);
					}
				});
			}
		} else{	SwalAlert('Error', 'Escolha um arquivo.','error');	}
	}

	static deleteBanner(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, token = '<?= strtotime('+2 hour'); ?>',
		id = form.querySelector('[name=id]').value, banner = form.querySelector('[name=banner]');
		if(banner && confirm('Confirma apagar ?')){
			AjaxController.prepare(c);
			return i!=id ? null : fetch(`ajax.php?a=deleteBanner&token=${token}`,{
			method: 'POST', headers: {
			  'Content-Type':'application/json; charset=UTF-8',
			  'Accept': 'application/json'
			},
			body: JSON.stringify({id:id, banner:banner.value})
			})
			.then(response => {
				if(!response.ok){
					AjaxController.reset(c);
				   throw new Error('Error: '+response.statusText);
				}
				return response.json();
			})
			.then(rs => {
				AjaxController.reset(c);
				if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
				if(rs.rs==0){
					SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
				}
				if(rs.rs==1){
					SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
						setTimeout(()=>{window.location.assign('?p=page_Banners');}, 500);
					}); setTimeout(()=>{window.location.assign('?p=page_Banners');},1500);
				}
			});
		}
	}
	static updateBanner(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>';
		Array.from(form.elements).forEach(e=>{
			if(!['button','reset','fieldset','submit','file'].includes(e.type)){
				if(e.hasAttribute('required') && !e.value.length){
					SwalAlert('Error', 'Preenchao campo '+e.name, 'error')?.then(()=>{
						e.focus();
					});
				} else{	
					if(e.type!='checkbox'){ o[e.name] = e.value; }
					else{ o[e.name] = e.checked ? 1: 0; }
				}
			}
		});
		AjaxController.prepare(c);
		return i!=o.id ? null : fetch(`ajax.php?a=updateBanner&token=${token}`,{
		method: 'POST', headers: {
		  'Content-Type':'application/json; charset=UTF-8',
		  'Accept': 'application/json'
		},
		body: JSON.stringify(o)
		})
		.then(response => {
			if(!response.ok){
				AjaxController.reset(c);
			   throw new Error('Error: '+response.statusText);
			}
			return response.json();
		})
		.then(rs => {
			AjaxController.reset(c);
			if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
			if(rs.rs==0){
				SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
			}
			if(rs.rs==1){
				SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
					setTimeout(()=>{window.location.assign('?p=page_Banners&id='+rs.id);}, 500);
				}); setTimeout(()=>{window.location.assign('?p=page_Banners&id='+rs.id);},1500);
			}
		});
	}
	static novoBanner(c){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>',
		banner = form.querySelector('[name=banner]');
		if(banner&&banner.value.length>0){
			Array.from(form.elements).forEach(e=>{
				if(!['button','reset','fieldset','submit','file'].includes(e.type)){
					if(e.hasAttribute('required') && !e.value.length){
						SwalAlert('Error', 'Preencha o campo '+e.name, 'error')?.then(()=>{
							e.focus();
							AjaxController.reset(c);
						});
					} else{
						if(e.type!='checkbox'){ o[e.name] = e.value; }						
						else{ o[e.name] = e.checked ? 1: 0; }
					}
				}
			});
			if(Object.keys(o).length>=8){
				AjaxController.prepare(c);
				return fetch(`ajax.php?a=novoBanner&token=${token}`,{
					method: 'POST',
					body: JSON.stringify(o)
				})
				.then(response => {
					if(!response.ok){
						AjaxController.reset(c);
					   throw new Error('Error: '+response.statusText);
					}
					return response.json();
				})
				.then(rs => {
					AjaxController.reset(c);
					if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
					if(rs.rs==0){
						SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
					}
					if(rs.rs==1){
						SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
							setTimeout(()=>{window.location.assign('?p=page_Banners&id='+rs.id);}, 500);
						}); setTimeout(()=>{window.location.assign('?p=page_Banners&id='+rs.id);},1500);
					}
				});
			}
		} else{	SwalAlert('Error', 'Escolha uma imagem.','error');	}
	}

	static deleteReceita(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, token = '<?= strtotime('+2 hour'); ?>',
		id = form.querySelector('[name=id]').value, nome = form.querySelector('[name=pdf]');
		if(nome && confirm('Confirma apagar ?')){
			AjaxController.prepare(c);
			return i!=id ? null : fetch(`ajax.php?a=deleteReceita&token=${token}`,{
			method: 'POST', headers: {
			  'Content-Type':'application/json; charset=UTF-8',
			  'Accept': 'application/json'
			},
			body: JSON.stringify({id:id, nome:nome.value})
			})
			.then(response => {
				if(!response.ok){
					AjaxController.reset(c);
				   throw new Error('Error: '+response.statusText);
				}
				return response.json();
			})
			.then(rs => {
				AjaxController.reset(c);
				if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
				if(rs.rs==0){
					SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
				}
				if(rs.rs==1){
					SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
						setTimeout(()=>{window.location.assign('?p=page_Transparencia');}, 500);
					}); setTimeout(()=>{window.location.assign('?p=page_Transparencia');},1500);
				}
			});
		}
	}
	static updateReceita(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>';
		Array.from(form.elements).forEach(e=>{
			if(!['button','reset','fieldset','submit'].includes(e.type)){
				if(e.hasAttribute('required') && !e.value.length){
					SwalAlert('Error', 'Preenchao campo '+e.name, 'error')?.then(()=>{
						e.focus();
					});
				} else{	
					if(e.type!='checkbox'){ o[e.name] = e.value; }
					else{ o[e.name] = e.checked ? 1: 0; }
				}
			}
		});
		AjaxController.prepare(c);
		return i!=o.id ? null : fetch(`ajax.php?a=updateReceita&token=${token}`,{
		method: 'POST', headers: {
		  'Content-Type':'application/json; charset=UTF-8',
		  'Accept': 'application/json'
		},
		body: JSON.stringify(o)
		})
		.then(response => {
			if(!response.ok){
				AjaxController.reset(c);
			   throw new Error('Error: '+response.statusText);
			}
			return response.json();
		})
		.then(rs => {
			AjaxController.reset(c);
			if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
			if(rs.rs==0){
				SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
			}
			if(rs.rs==1){
				SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
					setTimeout(()=>{window.location.assign('?p=page_Transparencia&id='+rs.id);}, 500);
				}); setTimeout(()=>{window.location.assign('?p=page_Transparencia&id='+rs.id);},1500);
			}
		});
	}
	static novaReceita(c){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>',
		pdf = form.querySelector('[type=file]'), data = new FormData();
		if(pdf && pdf.files.length>0){
			if(!AjaxController.preparaFiles(c)) return false;
			Array.from(form.elements).forEach(e=>{
				if(!['button','reset','fieldset','submit','file'].includes(e.type)){
					if(e.hasAttribute('required') && !e.value.length){
						SwalAlert('Error', 'Preenchao campo '+e.name, 'error')?.then(()=>{
							e.focus();
							AjaxController.reset(c);
						});
					} else{	
						if(e.type!='checkbox'){ o[e.name] = e.value; }						
						else{ o[e.name] = e.checked ? 1: 0; }
					}
				}
			});
			if(Object.keys(o).length>=6){
				data.append('max', pdf.dataset.maxfilesize);
				for(const [key, val] of Object.entries(o)){
					data.append(key,val);
				} data.append('anexo', pdf.files[0]);
				AjaxController.prepare(c);
				return fetch(`ajax.php?a=novaReceita&token=${token}`,{
				method: 'POST',
				body: data
				})
				.then(response => {
					if(!response.ok){
						AjaxController.reset(c);
					   throw new Error('Error: '+response.statusText);
					}
					return response.json();
				})
				.then(rs => {
					AjaxController.reset(c);
					if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
					if(rs.rs==0){
						SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
					}
					if(rs.rs==1){
						SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
							setTimeout(()=>{window.location.assign('?p=page_Transparencia&id='+rs.id);}, 500);
						}); setTimeout(()=>{window.location.assign('?p=page_Transparencia&id='+rs.id);},1500);
					}
				});
			}
		} else{	SwalAlert('Error', 'Escolha um arquivo.','error');	}
	}
	static obterReceitas(b, c){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>',
		p = document.querySelector('[name=page]'), table = document.querySelector('#translin_results'), text=b.innerText;
		if(p && b && table){
			o['page'] = parseInt(p.value);
			Array.from(form.elements).forEach(e=>{
				if(!['button','reset','fieldset','submit'].includes(e.type)){
					if(e.hasAttribute('required') && !e.value.length){
						SwalAlert('Error', 'Preencha o campo '+e.name, 'error')?.then(()=>{
							e.focus();
						});
					} else{	
						if(e.type!='checkbox'){ o[e.name] = e.value; }
						else{ o[e.name] = e.checked ? 1: 0; }
					}
				}
			});
			AjaxController.prepare(c);b.innerText='Carregando...';
			return fetch(`ajax.php?a=obterReceitas&token=${token}`,{
			method: 'POST', headers: {
			  'Content-Type':'application/json; charset=UTF-8',
			  'Accept': 'application/json'
			},
			body: JSON.stringify(o)
			})
			.then(response => {
				if(!response.ok){
					AjaxController.reset(c);b.innerText=text;
				   throw new Error('Error: '+response.statusText);
				}
				return response.json();
			})
			.then(rs => {
				AjaxController.reset(c);b.innerText=text;
				if(rs.rs==0){
					SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
				}
				if(rs.rs==1){
					table.innerHTML += rs.html;
					p.value = rs.id;
				}
			});
		}
	}

	static deleteUsuario(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, token = '<?= strtotime('+2 hour'); ?>',
		id = form.querySelector('[name=id]').value;
		if(confirm('Confirma apagar ?')){
			AjaxController.prepare(c);
			return i!=id ? null : fetch(`ajax.php?a=deleteUsuario&token=${token}`,{
			method: 'POST', headers: {
			  'Content-Type':'application/json; charset=UTF-8',
			  'Accept': 'application/json'
			},
			body: JSON.stringify({id:id})
			})
			.then(response => {
				if(!response.ok){
					AjaxController.reset(c);
				   throw new Error('Error: '+response.statusText);
				}
				return response.json();
			})
			.then(rs => {
				AjaxController.reset(c);
				if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
				if(rs.rs==0){
					SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
				}
				if(rs.rs==1){
					SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
						setTimeout(()=>{window.location.assign('?p=page_Usuarios');}, 500);
					}); setTimeout(()=>{window.location.assign('?p=page_Usuarios');},1500);
				}
			});
		}
	}
	static updateUsuario(c, i){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>';
		Array.from(form.elements).forEach(e=>{
			if(!['button','reset','fieldset','submit'].includes(e.type)){
				if(e.hasAttribute('required') && !e.value.length){
					SwalAlert('Error', 'Preenchao campo '+e.name, 'error')?.then(()=>{
						e.focus();
					});
				} else{	
					if(e.type!='checkbox'){ o[e.name] = e.value; }
					else{ o[e.name] = e.checked ? 1: 0; }
				}
			}
		});
		AjaxController.prepare(c);
		return i!=o.id ? null : fetch(`ajax.php?a=updateUsuario&token=${token}`,{
		method: 'POST', headers: {
		  'Content-Type':'application/json; charset=UTF-8',
		  'Accept': 'application/json'
		},
		body: JSON.stringify(o)
		})
		.then(response => {
			if(!response.ok){
				AjaxController.reset(c);
			   throw new Error('Error: '+response.statusText);
			}
			return response.json();
		})
		.then(rs => {
			AjaxController.reset(c);
			if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
			if(rs.rs==0){
				SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
			}
			if(rs.rs==1){
				SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
					setTimeout(()=>{window.location.assign('?p=page_Usuarios&id='+rs.id);}, 500);
				}); setTimeout(()=>{window.location.assign('?p=page_Usuarios&id='+rs.id);},1500);
			}
		});
	}
	static novoUsuario(c){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, o={},token = '<?= strtotime('+2 hour'); ?>';
		Array.from(form.elements).forEach(e=>{
			if(!['button','reset','fieldset','submit','file'].includes(e.type)){
				if(e.hasAttribute('required') && !e.value.length){
					SwalAlert('Error', 'Preencha o campo '+e.name, 'error')?.then(()=>{
						e.focus();
						AjaxController.reset(c);
					});
				} else{	o[e.name] = e.value; }
			}
		});
		AjaxController.prepare(c);
		return Object.keys(o).length<5 ? null : fetch(`ajax.php?a=novoUsuario&token=${token}`,{
		method: 'POST', headers: {
		  'Content-Type':'application/json; charset=UTF-8',
		  'Accept': 'application/json'
		},
		body: JSON.stringify(o)
		})
		.then(response => {
			if(!response.ok){
				AjaxController.reset(c);
			   throw new Error('Error: '+response.statusText);
			}
			return response.json();
		})
		.then(rs => {
			AjaxController.reset(c);
			if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
			if(rs.rs==0){
				SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
			}
			if(rs.rs==1){
				SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
					setTimeout(()=>{window.location.assign('?p=page_Usuarios&id='+rs.id);}, 500);
				}); setTimeout(()=>{window.location.assign('?p=page_Usuarios&id='+rs.id);},1500);
			}
		});
	}
	static alteraSenha(c){
		let form = c!=null && c!='' ? document.querySelector('[name=form_'+c+']') : document, token = '<?= strtotime('+2 hour'); ?>',
		p0 = form.querySelector('[name=password]'), p1 = form.querySelector('[name=password1]'),
		p2 = form.querySelector('[name=password2]');

		if(p0.value.length>0 && p1.value.length>0&& p2.value.length>0){
			if(p1.value === p2.value){
				AjaxController.prepare(c);
				return fetch(`ajax.php?a=alteraSenha&token=${token}`,{
					method: 'POST', headers: {
						'Content-Type':'application/json; charset=UTF-8',
						'Accept': 'application/json'
					},
					body: JSON.stringify({password:p0.value,password1:p1.value,password2:p2.value})
				})
				.then(response => {
					if(!response.ok){
						AjaxController.reset(c);
					   throw new Error('Error: '+response.statusText);
					}
					return response.json();
				})
				.then(rs => {
					AjaxController.reset(c);
					if(rs.rs<0){ Pages.sessionExpired(rs.msg);}
					if(rs.rs==0){
						SwalAlert('Error', rs.msg ? rs.msg : 'Error: ','error');
					}
					if(rs.rs==1){
						SwalAlert('Mensagem', rs.msg ? rs.msg : 'Salvo! ', 'success')?.then(()=>{
							setTimeout(()=>{window.location.assign('?p=page_Senha');}, 500);
						}); setTimeout(()=>{window.location.assign('?p=page_Senha');},1500);
					}
				});
			} else{
				SwalAlert('Error', 'As senha devem ser iguais.', 'error');
			}
		} else{
			SwalAlert('Error', 'Preencha todos os campos.', 'error');
		}
	}
}
class Pages{
	static sessionExpired(msg){}
}
</SCRIPT>