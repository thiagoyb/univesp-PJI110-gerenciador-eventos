<?php
	require_once('header.php');
?>
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

				<?php
				  if($user->getPerfil()=='TI'){ ?>
				<li class="nav-item">
				  <a class="nav-link" href="index.php?p=Menu" style="color: #fff;">Menu Principal</a>
				</li><?php
				  }
				?>

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
						<a href="index.php?p=Usuarios&id=<?= $user->getId(); ?>" class="nav-link" style="color: #000;">Meu Usuario</a>
					</li>
					<?php
					  if($user->getPerfil()=='TI'){ ?>
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