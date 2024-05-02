<?php
	session_start();
	require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Utils.php';
	require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'User.php';
	require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Controller.php';
	require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Config.php';	
	define('URL_HOME', $Config['URL']);
//User::login();

$user = User::auth(__FILE__);
//echo 'Bem-vindo, '.$user->getNome().'<hr>';var_dump($user);
	define('USERNAME', !empty($user) ? $user->getNome() : 'Anonimo');
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
	require_once('nav.php');
?>
 </HEAD>
 <BODY bgcolor="#DDD" style="background-color: #DDD;">
  <MAIN class="container-fluid">
	<section class="page">
	<?php
	if(isset($_GET['p']) &&$_GET['p']!='' && file_exists($_GET['p'] . '.php')){
		require_once($_GET['p'] . '.php');
	}
	else{ ?>
		<div class="row">
			<div class="col-10">
				<h4 class="text-left">Bem-vindo, <b class="logado"><?= USERNAME; ?></b></h4>
				<p class="text-left">Use os links acima para navegar entre as áreas administrativas do site.</p>
			</div>
		</div>	
	<?php
	} ?>
	</section>
	<?php
		require_once('footer.php');
	?>
  </MAIN>
 </BODY>
</HTML>
