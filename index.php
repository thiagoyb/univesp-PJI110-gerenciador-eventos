<?php
	session_start();
	require dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Utils.php';
	require dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'User.php';
	require dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Controller.php';
	require dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'Config.php';	
	define('URL_HOME', $Config['URL']);

$user = User::auth(__FILE__, true);//permite Visitante
	define('USERNAME', !empty($user) ? $user->getNome() : 'Anonimo');
?>
<!DOCTYPE html>
<HTML lang="pt-br">
<HEAD>
	<META http-equiv="X-UA-Compatible" content="IE=edge" />
	<META http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="shortcut icon" href="./assets/img/logo.png"/>
	<title>Siga Eventos</title>
	<link rel="stylesheet" href="src/css/estiloIndex.css" />
    <link rel="stylesheet" href="src/css/reset.css" />
<?php
	require_once('header.php'); ?>
</HEAD>
<body>
  <MAIN class="container-fluid">
	<section class="content">
<?php
	$page = isset($_GET['p']) && $_GET['p']!='' && file_exists($_GET['p'].'.php') ? $_GET['p'].'.php' : null;
	if(file_exists($page)){ ?>
	  <div class="row">
  <?php
		require_once $page; ?>
	  </div><?php
	} else{ ?>
		<section class="row container">
			<div class="col-5">
				<div class="logotipo">
					<img class="logo" src="src/imagem/LogotipoSigaEventos2.jpg" alt="Logo Siga Eventos" style="    zoom: 0.7;">
				</div>
			</div>

			<div class="col-7" id="register-section">
				<h1>Cadastre seus eventos, aqui!</h1>
				<h2>"Registre seus eventos de todos os setores: desde iniciativas individuais até ações corporativas, organizações sem fins lucrativos e projetos beneficentes.</h2>
				<h2>Seja parte desta plataforma e promova suas atividades para um público maior!"</h2>
			</div>
		</section>
		<section class="row container">
			<div class="col-12 text-center " id="register-button">
				<a href="cadastro.html" class="button">CADASTRE-SE</a>
			</div>
		</section>
	<?php } ?>
	</section>
	<?php
	require_once 'footer.php'; ?>
  </MAIN>
 </body>
</HTML>
