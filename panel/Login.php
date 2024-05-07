<?php
	session_start();
	require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Utils.php';
	require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'User.php';
	require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Controller.php';
	require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Config.php';	
	define('URL_HOME', $Config['URL']);

	if(isset($_POST) && !empty($_POST)){
		$login = isset($_POST['login']) ? $_POST['login'] : null;
		$senha = isset($_POST['senha']) ? $_POST['senha'] : null;

		if($login!=null && $senha!=null){
			if(User::login(__FILE__, $login, $senha)){
				echo '<meta http-equiv="refresh" content="0; url=panel.php" />';
				exit;
			}
		}
	}

if(isset($_SESSION['GE_Secret'])){
	echo '<meta http-equiv="refresh" content="0; url=index.php" />';
}else{
?>
<!DOCTYPE html>
<HTML lang="pt-br">
 <HEAD>
	<META http-equiv="X-UA-Compatible" content="IE=edge" />
    <META http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="./../assets/img/orquidea.png"/>
	<title>Administração</title>
<?php
	require_once('header.php');
?>
 </HEAD>
 <BODY bgcolor="#DDD" class="login">
	<MAIN id="main" class="wrapper wrapper-login">
		<section id="area-login" class="container container-login animated fadeIn" style="width: 555px;">
			<div class="login-form">
				<form class="row" method="post" action="?" id="form_login" name="form_login">
					<div class="col-5">
						<a target="_self" href="./Login.php"><img class="logo" width="175" height="auto" src="<?= URL_HOME; ?>assets/img/logo.png" /></a>
					</div>
					<div class="col-7">
						<div class="form-group form-floating-label">
							<input type="text" class="form-control input-border-bottom login-input" id="login" name="login" maxlength="14" autocomplete="username" autofocus required onkeypress="this.value=Maskify(this.value,'Integer');" onclick="this.value=Maskify(this.value,'Integer');" onblur="this.value=Maskify(this.value,(this.value.length<12?'Cpf':'Cnpj'))">
							<label for="login" class="placeholder">CPF / CNPJ</label>
						</div>
						<div class="form-group form-floating-label">
							<input id="senha" name="senha" type="password" class="form-control input-border-bottom login-input" autocomplete="current-password" required>
							<label for="senha" class="placeholder">Senha</label>
							<div class="show-password">
								<i class="icon-eye"></i>
							</div>
						</div>

						<div class="col-12 form-action">
							<input type="submit" class="btn btn-danger btn-inline" value="Entrar" />
							<input type="button" id="show-signup" class="btn btn-inline btn-secondary" value="Cadastrar" />
						</div>
					</div>

					<div class="col-12 d-block text-center form-sub form-message border-bottom border-top mt-3">
						<?= isset($_COOKIE['erro'])&&$_COOKIE['erro']!='' ? $_COOKIE['erro'] : ''; ?>
					</div>
				</form>
			</div>
		</section>

		<section id="area-register" class="container container-signup animated fadeIn" style="display: none;padding-top: 20px;">
			<div class="text-center" style="margin-bottom: 1.5rem;">
				<img class="logo" width="200" height="auto" src="<?= URL_HOME; ?>assets/img/logo.png" />
				<h3 class="text-center">Cadastro - Siga !</h3>
			</div>

			<div class="login-form">
				<form method="post" action="?" id="form_cadastro" name="form_cadastro">
				<div class="form-group form-floating-label">
					<input id="docId" name="docId" type="text" class="form-control input-border-bottom" required onkeypress="this.value=Maskify(this.value,'Integer');" onclick="this.value=Maskify(this.value,'Integer');" onblur="this.value=Maskify(this.value,(this.value.length<12?'Cpf':'Cnpj'))" />
					<label id="labelDocID" for="docId" class="placeholder">CPF / CNPJ</label>
				</div>
				<div class="form-group form-floating-label">
					<input id="nomeRazao" name="nomeRazao" type="text" maxlength="180" oninput="Utils.maxLength(this)" onfocus="Utils.maxLength(this)" onblur="Utils.maxLength(this)" class="form-control input-border-bottom" required />
					<label id="labelNomeRazao" for="nomeRazao" class="placeholder">Nome Completo</label>
				</div>
				<div class="form-group form-floating-label">
					<input id="email" name="email" type="email" class="form-control input-border-bottom typeEmail" required />
					<label for="email" class="placeholder">Email</label>
				</div>
				<div class="form-group form-floating-label">
					<input id="celular" name="celular" type="text" class="form-control input-border-bottom typeCel" required />
					<label for="celular" class="placeholder">Celular</label>
				</div>
				<div class="form-group form-floating-label">
					<input id="password" name="password" type="password" autocomplete="off" class="form-control input-border-bottom" required />
					<label for="password" class="placeholder">Senha</label>
					<div class="show-password">
						<i class="icon-eye"></i>
					</div>
				</div>
				<div class="form-group form-floating-label">
					<input id="password-confirm" name="password-confirm" type="password" autocomplete="off" class="form-control input-border-bottom" required />
					<label for="password-confirm" class="placeholder">Confirma Senha</label>
					<div class="show-password">
						<i class="icon-eye"></i>
					</div>
				</div>

				<div class="row form-sub m-0">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" name="agree" id="agree">
						<label class="custom-control-label" for="agree">Eu concordo com os <a href="#">termos</a>.</label>
					</div>
				</div>

				<div class="form-action">
					<a href="#" id="show-signin" class="btn btn-danger btn-link btn-login mr-3">Cancelar</a>
					<input type="submit" href="#" name="Enviar" class="btn btn-primary btn-logister" value="Cadastrar" />
					<input type="hidden" name="registerToken" value="<?= strtotime('+2 hour'); ?>" />
				</div>
				</form>
			</div>
		</section>
	<?php
		require_once('footer.php');
	?>
	</MAIN>
  </BODY>
</HTML>
<?php
}
?>