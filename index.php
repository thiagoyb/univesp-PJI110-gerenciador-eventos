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
	$page = isset($_GET['p']) && $_GET['p']!='' && file_exists($_GET['p'].'.php') ? $_GET['p'].'.php' : 'inicio.php';
	if(file_exists($page)){ ?>
	  <div class="row">
  <?php
		require_once $page; ?>
	  </div><?php
	} ?>
	</section>
	<?php
	require_once 'footer.php'; ?>
  </MAIN>
 </body>
</HTML>
