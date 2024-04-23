  <LINK rel="stylesheet" type="text/css" href="<?= URL_HOME; ?>assets/css/bootstrap.min.css"></LINK>
  <LINK rel="stylesheet" type="text/css" href="<?= URL_HOME; ?>assets/css/bootstrap.css"></LINK>
  <LINK rel="stylesheet" type="text/css" href="<?= URL_HOME; ?>assets/css/atlantis.min.css"></LINK>
  <LINK rel="stylesheet" type="text/css" href="<?= URL_HOME; ?>assets/css/style.css"></LINK>
  <LINK rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"></LINK>
  <style>
  .img{
    width: 25%;
    height: 25%;
  }
 .logo{
	background-color: transparent;

	-webkit-border-radius: 10%;
	-moz-border-radius: 10%;
	-khtml-border-radius: 10%;
	-ms-border-radius: 10%;
	-o-border-radius: 10%;
	border-radius: 10%;
 }
 header .navbar-brand span{
	font-size: x-small;
    position: absolute;
    top: 72%;
    color: #333333;
    left: 47%;
    font-weight: bold;
    font-family: serif;
 }
  button.navbar-toggler{
	  font-weight: 700;
	  margin-bottom: 1%;
	  background-color: #114065;
	  border:1px solid #EEE;
	  color: #EEE;
  }
  button.navbar-toggler strong, button.navbar-toggler strong:hover{
	color: #FFF !important;
	font-weight: 700;
  }
  #navToggle:checked + .navbar-collapse{
	  display:block;
  }
  .MenuDropdown.navbar-nav .nav-item{
	  margin: 0px !important;
  }
</style>
<header class="navbar-expand-lg container-fluid default_color">
	<div class="col-12">
		<div class="col-lg-12 col-sm-12" align="center">
			<a class="navbar-brand js-scroll-trigger" href="index.php">
				<img class="logo mb-2 mt-3" width="200" height="auto" src="<?= URL_HOME; ?>assets/img/logo.png" />
				<span></span>
			</a>

			<button for="navToggle" class="btn col-sm-12 navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<strong for="navToggle" class="collapsed">Menu</strong>
			</button>
		</div>

		<div  class="col-lg-12">			
		  <div class="navbar-collapse collapse"  id="navbarNavDropdown">
			<ul class="navbar-nav text-center" style="margin:0 auto;">
				<li class="nav-item active">
				  <a class="nav-link" href="index.php" style="color: #fff;">Início</a>
				</li> 

				<li class="nav-item">
				  <a class="nav-link" href="index.php?p=Menu" style="color: #fff;">Menu Principal</a>
				</li>

				<li class="nav-item">
				  <a class="nav-link" href="index.php?p=Banners" style="color: #fff;">Banners</a>
				</li>

				<!--<li class="nav-item">
				  <a class="nav-link" href="index.php?p=Arquivos" style="color: #fff;">Arquivos</a>
				</li>

				<li class="nav-item">
				  <a class="nav-link" href="index.php?p=Paginas" style="color: #fff;">Páginas</a>
				</li>-->

				<li class="nav-item">
				  <a class="nav-link" href="index.php?p=Eventos" style="color: #fff;">Eventos</a>
				</li>

				<li class="nav-item">
				  <a class="nav-link" href="index.php?p=Noticias" style="color: #fff;">Notícias</a>
				</li>

				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff;">
					Conta
				  </a>
				  <UL class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<li class="dropdown-item">
						<a href="index.php?p=Senha" class="nav-link" style="color: #000;">Minha Senha</a>
					</li>
					<li class="dropdown-item">
						<a href="index.php?p=Usuarios&id=<?= isset($user['codUser'])?$user['codUser']:0; ?>" class="nav-link" style="color: #000;">Meu Usuario</a>
					</li>
					<?php
					  if(isset($user['nivel']) && $user['nivel']==1){
					?>
					<li class="dropdown-item">
						<a href="index.php?p=Usuarios" class="nav-link" style="color: #000;">Lista de Usuarios</a>
					</li><?php
					  }
					?>
					<li class="dropdown-item">
						<a href="logout.php" class="nav-link" style="color: #000;">Sair</a>
					</li>
				  </UL>
				</li>
			</ul>
		  </div>
		</div>
	</div>
</header>