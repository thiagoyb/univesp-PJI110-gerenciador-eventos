<?php
if(basename($_SERVER['PHP_SELF'])=='Usuarios.php'){
	header('Location: index.php?p=Usuarios');
	exit;
}

if(empty($user)){
	echo '<meta http-equiv="refresh" content="1; url=index.php" />';
	exit;
}

$id = isset($_GET['id']) && $_GET['id']!='' && $_GET['id']>0 ?$_GET['id'] : null;
if($user->getPerfil()!='TI' && $id != $user->getId()){
	echo '<meta http-equiv="refresh" content="1; url=index.php?p=Usuarios&id='.$user->getId().'" />';
	exit;
}

$acao = isset($_GET['acao']) && $_GET['acao']!='' ? $_GET['acao'] : null;
$acao = $acao=='novoUsuario' ? 'NEW' : ($id!=null && $id>0 ? 'EDIT' : 'LIST');

$Usuarios = $acao!='NEW' ? Controller::obterUsuarios($id) : array();
$idForm = uniqid('usuarios');
?>
<style>
.maiusculo{
	text-transform: uppercase;
}
</style>
<div class="page-inner mb-5">
	<div class="card">
		<div class="card-header bg-white card-title text-left" style="border-bottom: 1px solid #cacaca !important;padding: 5px 20px;">
			<h4 class="card-title font-weight-bold"><i class="fas fa-user mr-2"></i><?= $acao=='LIST' ? "Gerenciar Usuarios" : ($acao=='NEW' ? "Cadastrar Usuario" : ($id == $user->getId() ? "Meu Usuario" : "Editar Usuario"));?>:</h4>
		</div>

		<div class="offset-md-0 col-12 col-md-12 col-lg-12 tela_central">
			<div class="card-subtitle">
				<P class="title"></P>
			</div>
			<form name="form_<?= $idForm;?>" action="" enctype="multipart/form-data" method="post">
			<?php
				if($acao=='LIST'){ ?>
					<TABLE border="0" align="center" class="table_usuarios rs col-12 collapse show" cellpadding="5" style="display:table;">
					<TR>
						<TH class="text-center">ID</TH>
						<TH>Data de Cadastro</TH>
						<TH>Nome</TH>
						<TH>Email</TH>
						<TH>Nivel</TH>
						<TH class="text-center">Ações</TH>
					</TR>
			<?php	foreach($Usuarios as $Usuario){
						foreach(explode(',','codUser,nome,login,email,senha,perfil,ativado,data_cadastro') as $s){
							$Usuario[$s] = isset($Usuario[$s]) && $Usuario[$s]!=NULL ?$Usuario[$s]: '';
						}
						$idUsuario = $Usuario['codUser'];
						$souEu = $user->getId() == $idUsuario ? "<b class='id negrito ml-4'>Você</b>" : '';
						?>
						<TR class="col-12 Usuario pb-1" style="height: fit-content;border-bottom:1px solid lightgrey">
							<TD class="negrito text-center"><?= $idUsuario; ?></TD>
							<TD class="ls1 text-left"><?= date('d/m/Y H:i', strtotime($Usuario['data_cadastro'])); ?></TD>
							<TD class="text-left negrito"><?= $Usuario['nome'].$souEu; ?></TD>
							<TD class="text-left"><?= $Usuario['email']; ?></TD>
							<TD class="text-center"><span class="negrito"><?= $Usuario['perfil']; ?></span></TD>
							<TD class="text-center">
								<div class="switchContainer"><?php
									$valorBol =$Usuario['ativado']==1 ? 'on' : 'off';
									$checado = $valorBol=='on' ? ' checked' : '';	?>
									<input type="checkbox" disabled id="ativado<?= $idUsuario; ?>" value="<?= $valorBol;?>" <?= $checado;?> class="switcher" role="switcher" onchange="this.parentElement.nextElementSibling.click();" />
									<label class="switch" for="ativado<?= $idUsuario; ?>" style="color:#777" onclick="this.parentElement.nextElementSibling.click();"> Ativado</label>
								</div>
								<A href="index.php?p=Usuarios&id=<?= $idUsuario; ?>" onclick="openUsuario(<?= $idUsuario; ?>)" class="btn btn-primary btn-sm font-size-small ml-4" title="Editar ou Ver detalhes"><span class="material-symbols-outlined">edit</span></a>
							</TD>
						</TR>
					<?php
					} ?>
					</TABLE>
					<?php
					if(empty($Usuarios)){ ?>
						<div class="card-subtitle mt-1">
							<P class="title text-center">Nenhum usuario encontrada.</P>
						</div><?php
					}
				}
				else{
					$Usuario = isset($Usuarios[0]) ? $Usuarios[0] : array();
					if($acao=='EDIT' && empty($Usuario)){
						echo '<div class="alert col-6 alert-warning text-center" style="margin:auto">Usuario '.$id.' não encontrado.</div>';
						echo '<meta http-equiv="refresh" content="1; url=?p=Usuarios" />';
						exit;
					}
					foreach(explode(',','codUser,nome,login,email,senha,perfil,ativado,data_cadastro') as $s){
						$Usuario[$s] = isset($Usuario[$s]) && $Usuario[$s]!=NULL ? $Usuario[$s]: '';
					}
					$Usuario['ativado'] = $acao=='EDIT' ? $Usuario['ativado']: 1;
					$login = ltrim($Usuario['login'],0);
					$login = Utils::isCPF($login) ? Utils::setMask($login, '###.###.###-##') : (Utils::isCNPJ($login) ? Utils::setMask($login, '##.###.###/####-##') : $login);					

					$idUsuario = $Usuario['codUser'];	?>
					<div class="font-weight-bold font-small text-left">
						<span class="mr-3" style="font-size:14px"><?= $id>0 ? 'Usuario '.$id : ''; ?></span>
						<input type="hidden" name="id" value="<?= $idUsuario; ?>" />
						<div class="switchContainer"><?php
							$valorBol =$Usuario['ativado']==1 ? 'on' : 'off';
							$checado = $valorBol=='on' ? ' checked' : '';
							?>
							<input type="checkbox" id="ativado" name="ativado" value="<?= $valorBol;?>" <?= $checado;?> class="switcher" role="switcher" onchange="liberarAlteracao('<?= $idForm;?>')" />
							<label class="switch" for="ativado" style="color:#777">Ativado</label>
						</div>
					</div>
					<div class="row" style="min-height: 50vh;">
					<?php
					  if($Usuario['data_cadastro']!=''){ ?>
						<div class="form-group col-6 col-lg-6">
							<label class="font-weight-bold d-block">Data de Cadastro:</label>
							<div class="form-control fakeInput" style="font-size: 17px;"><?= date('d/m/Y H:i:s', strtotime($Usuario['data_cadastro'])); ?></div>
						</div>
						<div class="form-group col-6 col-lg-6">
							<label class="font-weight-bold d-block">Login:</label>
							<div class="form-control fakeInput" style="font-size: 17px;"><?= $login ?></div>
						</div>
					<?php
					  }  ?>
						<div class="form-group col-6 col-lg-6">
							<label class="font-weight-bold d-block required" for="nome">Nome:</label>
							<input class="form-control typeAlphaNum" required type="text" maxlength="100" name="nome" id="nome" value="<?= $Usuario['nome']; ?>" oninput="Utils.maxLength(this)" placeholder="Nome" onchange="liberarAlteracao('<?= $idForm;?>')">
						</div>
						<div class="form-group col-6 col-lg-6">
							<label class="font-weight-bold d-block required" for="email">Email:</label>
							<input class="form-control" required type="email" maxlength="100" name="email" id="email" value="<?= $Usuario['email']; ?>" oninput="Utils.maxLength(this)" placeholder="user@mail.com" onchange="liberarAlteracao('<?= $idForm;?>')">
						</div>
					<?php
						if($Usuario['data_cadastro']==''){ ?>
							<div class="form-group col-6 col-lg-6">
								<label class="font-weight-bold d-block required">CPF/CNPJ:</label>
								<input class="form-control" required type="text" minlength="11" maxlength="18" name="login" id="login" onkeypress="this.value=Maskify(this.value,'Integer');" onclick="this.value=Maskify(this.value,'Integer');" onblur="this.value=Maskify(this.value,(this.value.length<12?'Cpf':'Cnpj'))" placeholder="000.000.000" />
							</div>
							<div class="form-group col-6 col-lg-6">
								<label class="required text-left negrito" for="senha">Senha:</label>
								<input type="password" name="senha" id="senha" required class="form-control form-border text-left" autocomplete="current-password" onchange="liberarAlteracao('<?= $idForm;?>')" placeholder="*****">
							</div>
						<?php
						}  ?>

					<?php
						if($user->getPerfil()=='TI'){ ?>

						<div class="form-group col-4 col-lg-4">
							<label class="font-weight-bold d-block required" for="nivel">Perfil:</label>
							<div class="switchContainer"><?php
								$valorBol =$Usuario['perfil']=='TI' ? 'on' : 'off';
								$checado = $valorBol=='on' ? ' checked' : '';
								?>
								<input type="checkbox" id="Administrador" name="Administrador" value="<?= $valorBol;?>" <?= $checado;?> class="switcher" role="switcher" onchange="liberarAlteracao('<?= $idForm;?>')" />
								<label class="switch" for="Administrador" style="color:#777">Administrador</label>
							</div>
						</div>
						<?php
						}
						?>
					</div>
			<?php
				} ?>
				<div class="card-footer">
					<div class="form-group col-12">
						<div class="row">
							<div class="col-4">
								<a href="index.php<?= $acao=='EDIT' && $user->getPerfil()=='TI'? '?p=Usuarios' : '?'; ?>" class="btn btn-primary"><span class="fas fa-arrow-left"></span>Voltar</a>
							</div>
							<div class="col-8 text-right">
							<?php
							  if($acao=='EDIT'){ ?>
								<button class="btn btn-danger mr-1" type="button" onclick="AjaxController.deleteUsuario('<?= $idForm;?>', <?= $id; ?>);">Apagar</button>
								<button class="btn btn-success mr-1" type="button" disabled name="submit" onclick="AjaxController.updateUsuario('<?= $idForm;?>', <?= $id; ?>);">Atualizar</button>
						<?php  } ?>
						<?php
							  if($acao=='NEW'){ ?>
								<button onclick="<?= $acao=='LIST' ? "location.href='?p=Usuarios&acao=novoUsuario'" : "AjaxController.novoUsuario('".$idForm."')"; ?>" name="submit" class="btn btn-danger ml-1" type="button" ><span class="fas fa-trash-alt"></span>Cadastrar</button>
						<?php  } ?>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	function liberarAlteracao(id){
		let form = id!='' ? document.querySelector('form[name=form_'+id+']') : document, btnSubmit = form.querySelector('[name=submit]');
		if(btnSubmit){
		  if(btnSubmit.innerHTML.indexOf('circLoader')<=-1){
			btnSubmit.disabled = false;
		  }	
		}
	}	
	function openUsuario(id){
		window.location.assign('?p=Usuarios&id='+id);
	}
</script>