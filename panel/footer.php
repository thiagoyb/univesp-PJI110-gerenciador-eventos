<?php
	///echo URL_HOME;exit;//OK
?>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/jquery-3.3.1.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/popper.min.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/bootstrap.min.js"></script>

	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/Utils.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/Masks.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/Listeners.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/sweetalert.min.js"></script>
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
	editor.on('input', e=>{});
  }
});
	class Swal{
		static alertMsg(title, msg, type){
			return swal(title, msg, {
				icon : type,
				buttons: {
					confirm: {
					  className :  type=='error' ? 'btn btn-danger' : 'btn btn-success'
					}
				},
			});
		}
		static alertError(title, msg){
			return swal(title, msg, {
				icon : 'error',
				buttons: {
					confirm: {
					  className :  'btn btn-danger'
					}
				},
			});
		}
		static alertSuccess(title, msg){
			return swal(title, msg, {
				icon : 'success',
				buttons: {
					confirm: {
					  className :  'btn btn-success'
					}
				},
			});
		}
	}
	class Controller{
		static prepareImage(e){
			let form = e.closest('form') ? e.closest('form') : document, reader = new FileReader();
			if(e.files.length>0){
				let file = e.files[0], id = e.name+'ToUpload', old = form.querySelector('#'+id);
				if(old) old.remove();
				const max = e.dataset.maxfilesize, size = Utils.byteConvert(file.size);
				if(e.accept.split(',').indexOf(file.type) !== -1){
					if(file.size <= max *1024*1024){
						reader.readAsDataURL(file);
						reader.onload = function(){
							if(reader.readyState==2){
								let container = document.createElement('DIV');
								container.setAttribute('id',id);
								container.setAttribute('class','col-12');
								container.innerHTML = "<img src='"+reader.result+"' class='mt-3' />";
								container.innerHTML+= "<input type='hidden' class='hidden' name='banner' id='banner' value='"+reader.result+"' />";
								e.parentElement.append(container);
							}
						};
						return true;
					} else{ e.value='';
					  Swal.alertError('Error','Imagem e maior do que '+max+'MB !');
					}
				} else{ e.value='';
					Swal.alertError('Error', 'Formato de arquivo não permitido.');
				}
			}
		}
		static preparaFiles(f){
		  if(f.files.length>0){
			let file = f.files[0], id = f.name+'FileStatus', old = f.parentElement.querySelector('#'+id);
			if(old) old.remove();
			const max = f.dataset.maxfilesize, size = Utils.byteConvert(file.size);
			if(f.accept.split(',').indexOf(file.type) !== -1){
				if(file.size <= max *1024*1024){
					let spanFile = document.createElement('SPAN');
					spanFile.innerHTML = '<div class="text" id="'+id+'">Arquivo: <b>'+size+'</b>, '+f.value+'</div>';
					f.parentElement.append(spanFile);
					return true;
				} else{ f.value='';
				  Swal.alertError('Error','Arquivo e maior do que '+max+'MB !');
				}
			} else{ f.value='';
				Swal.alertError('Error', 'Formato de arquivo não permitido !');
			}
		  }
		}
		static prepare(form){
			let btn = form.querySelector('[name=submit]');
			if(btn){
				btn.setAttribute('disabled', true);
				btn.innerHTML="<i class='ml-2 circLoader' data-text='"+btn.innerText+"'></i>";
			}
		}
		static reset(){
			let loader = document.querySelector('[name=submit]:disabled i.circLoader');
			if(loader){
				loader.parentElement.removeAttribute('disabled');
				loader.parentElement.innerText = loader.dataset.text;
				loader.remove();
			}
		}
		static getToken(){
			let d = new Date();
			d.setHours(d.getHours()+1);
			return d.getTime();
		}
		static receiveForm(form){
			let o={}, err=false;
			Array.from(form.elements).reverse().forEach(e =>{
				if(!['button','reset','fieldset','submit'].includes(e.type)){
					if(e.hasAttribute('required') && !e.value.length){
						err = true;
						Swal.alertError('Error', e.type!='file' ? ('Preencha o campo '+e.name) : ('Selecione o arquivo para  upload.'))?.then(()=>{
							e.focus();
						});
						return false;
					} else{
						o[e.name] = e.type!='checkbox' ? e.value : (e.checked ? 1: 0);
					}
				}
			});
			return !err ? o : {};
		}

		static alteraSenha(e){
			let form = e.closest('form') ? e.closest('form') : document, o = Controller.receiveForm(form), token = Controller.getToken();
			if(Object.keys(o).length>0 && o.password1 == o.password2){
				Controller.prepare(form);
				return fetch(`./../assets/classes/User.php?a=alteraSenha&token=${token}`,{
					method: 'POST', headers: {
					  'Accept': 'application/json'
					},
					body: Utils.Obj2FD(o)
				})
				.then(response => {
					Controller.reset();
					if(!response.ok){
					   throw new Error('Error '+response.status+': '+response.statusText);
					}
					return response.json();
				})
				.then(rs => {
					if(rs.rs!=-1){
						if(rs.rs!=1){
							Swal.alertError('Error', rs.msg!='' ? rs.msg : 'Error: ');
						} else{
							Swal.alertSuccess('Mensagem', rs.msg ? rs.msg : 'Salvo com sucesso !')?.then(()=>{ form.reset(); });
						}
					}
				});
			} else{ Swal.alertError('Error', 'As senhas devem ser iguais.'); }
		}
		static updateMenu(e){
			let form = e.closest('form') ? e.closest('form') : document, o = Controller.receiveForm(form), orders=[], token = Controller.getToken();
			Array.from(form.querySelectorAll('[name*=ordem]:not([disabled])')).forEach(i=>{ orders.push(i.value); });
			if(Object.keys(o).length>0){
				if(!Utils.hasDuplicates(orders)){
					o['total'] = orders.length;
					Controller.prepare(form);
					return fetch(`./../assets/classes/Controller.php?a=updateMenu&token=${token}`,{
						method: 'POST', headers: {
						  'Accept': 'application/json'
						},
						body: Utils.Obj2FD(o)
					})
					.then(response => {
						Controller.reset();
						if(!response.ok){
						   throw new Error('Error '+response.status+': '+response.statusText);
						}
						return response.json();
					})
					.then(rs => {
						if(rs.rs!=-1){
							if(rs.rs!=1){
								Swal.alertError('Error', rs.msg!='' ? rs.msg : 'Error: ');
							} else{
								Swal.alertSuccess('Mensagem', rs.msg ? rs.msg : 'Salvo com sucesso !')?.then(()=>{
									window.location.reload();
								});
							}
						}
					});
				} else Swal.alertError('Error', 'Os campos de Ordenação não podem ter valores repetidos.');
			}
		}
		static novoBanner(e){
			let form = e.closest('form') ? e.closest('form') : document, o = Controller.receiveForm(form), token = Controller.getToken();
			if(Object.keys(o).length>0){
				Controller.prepare(form);
				return fetch(`./../assets/classes/Controller.php?a=novoBanner&token=${token}`,{
					method: 'POST', headers: {
					  'Accept': 'application/json'
					},
					body: Utils.Obj2FD(o)
				})
				.then(response => {
					Controller.reset();
					if(!response.ok){
					   throw new Error('Error '+response.status+': '+response.statusText);
					}
					return response.json();
				})
				.then(rs => {
					if(rs.rs!=-1){
						if(rs.rs!=1){
							Swal.alertError('Error', rs.msg!='' ? rs.msg : 'Error: ');
						} else{
							Swal.alertSuccess('Mensagem', rs.msg ? rs.msg : 'Salvo com sucesso !')?.then(()=>{ window.location.reload(); });
						}
					}
				});
			} else{ Swal.alertError('Error', 'As senhas devem ser iguais.'); }
		}
	}
</SCRIPT>