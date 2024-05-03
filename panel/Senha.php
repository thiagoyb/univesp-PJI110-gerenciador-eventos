<?php
if(basename($_SERVER['PHP_SELF'])=='Senha.php'){
	header('Location: index.php?p=Senha');
	exit;
}

$idForm = uniqid('Senha');
?>
<style>
.btn {
    cursor: pointer;
}
.negrito{ font-weight:bold;}
.form div{
	margin:auto;
}
input, .form-control{
	border: 1px solid #d2d2d2 !important;
}
.usuario_logado{
	white-space: nowrap;
    color: #d24145 !important;
}
</style>
<div class="page-inner mb-5">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title font-weight-bold"><i class="fas fa-asterisk mr-2"></i>Alteração de Senha</h4>
		</div>

		<div class="card-body">
			<label class="user info" style="padding: 0.5rem 1.5rem;">
				<i class="fas fa-user mr-2 mr-2"></i>Conta: <b class="usuario_logado ml-2"><?= $user->getEmail()!=null ? $user->getEmail() : ''; ?></b>
			</label>

			<form name="form_<?= $idForm;?>" id="form_senha" class="form text-center" onsubmit="return false;">				
				<div class="form-group text-left col-12">
					<label class="required text-left negrito" for="password">Senha Atual:</label>
					<input type="password" name="password" id="password" required class="form-control form-border text-left" autocomplete="current-password" onchange="liberarAlteracao('<?= $idForm;?>')" placeholder="Digite..">
				</div>

				<div class="form-group text-left col-12">
				<label class="required text-left negrito" for="password1">Nova Senha:</label>
					<input type="password" name="password1" id="password1" required minlength="4" class="form-control form-border text-left" autocomplete="new-password" placeholder="Digite..">
				</div>
				<div class="form-group text-left col-12">
					<label class="required text-left negrito" for="password2">Nova Senha:</label>
					<input type="password" name="password2" id="password2" required minlength="4" class="form-control form-border text-left" autocomplete="new-password" placeholder="Digite..">
				</div>

				<div class="card-footer" style="background-color: white;">
					<div class="form-group col-12">
						<div class="row">
							<div class="col-4 text-left">							
								<a href="index.php" class="btn btn-primary"><span class="fas fa-arrow-left"></span>Voltar</a>
							</div>
							<div class="col-8 text-right">
								<input type="hidden" class="hidden" hidden id="username" name="username" autocomplete="username" value />
								<button class="btn btn-success mr-1" type="button" disabled name="submit" onclick="AjaxController.alteraSenha('<?= $idForm;?>');">Salvar</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="card-footer"></div>
	</div>
</div>