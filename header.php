<?php
	$Menus = Controller::obterSecoes(null, true);
?>
  <LINK rel="stylesheet" type="text/css" href="<?= URL_HOME; ?>assets/css/bootstrap.min.css"></LINK>
  <LINK rel="stylesheet" type="text/css" href="<?= URL_HOME; ?>assets/css/bootstrap.css"></LINK>
  <LINK rel="stylesheet" type="text/css" href="<?= URL_HOME; ?>assets/css/atlantis.min.css"></LINK>
  <LINK rel="stylesheet" type="text/css" href="<?= URL_HOME; ?>assets/css/fontawesomepro.css"></LINK>
  <LINK rel="stylesheet" type="text/css" href="<?= URL_HOME; ?>assets/css/style.css"></LINK>
  <LINK rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"></LINK>
  <header class="navbar-expand-lg container-fluid">
	<div class="row">
		<div class="col-lg-12 col-sm-12" align="center">
			<button for="navToggle" class="btn col-sm-12 navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<strong class="collapsed">Menu</strong>
			</button>
		</div>

		<div  class="col-lg-12">			
		  <nav class="navbar-collapse collapse default_gradient border-default rounded pull-right mt-2" id="navbarNavDropdown">
			<ul class="navbar-nav menu">
			<?php
				$first = true;	$antSubItem=false;
				foreach(array_values($Menus) as $menu){
					$isSubmenu = $menu['submenu']==1;
					$attrAdd = $isSubmenu ? ' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : '';
					$url =$menu['url']!='#'&&$menu['url']!='' ? $menu['url'] : null;
					$href = $isSubmenu ? '#' : ($url!=null ? $url : "index.php?p={$menu['slug']}&id={$menu['codSecao']}");
					$subitem = $menu['fkSecao']!=null&&$menu['fkSecao']!=''&&$menu['fkSecao']>0;

					if($antSubItem && !$subitem){
						echo "</div></LI>";
					}

					if(!$subitem){ ?>
					  <li class="nav-item<?= $first ? ' active' : ''; ?> <?= $isSubmenu ? 'dropdown' : '' ?>">
					<?php
					} ?>
						<a target="<?= $url!=null?'_blank':'_self'; ?>" href="<?= $href; ?>" class="nav-link pagescroll <?= $isSubmenu ? 'dropdown-toggle' : '' ?>" <?= $attrAdd; ?> id="<?= $menu['slug']; ?>"><?= $menu['nome']; ?></a>
					<?php
						if($isSubmenu){ ?>
						<div class="dropdown-menu" aria-labelledby="<?= $menu['slug']; ?>">
					<?php
						}

					if(!$subitem && !$isSubmenu){ ?>
					 </li><?php
					}

					$first = false;
					$antSubItem = $subitem;
				} ?>
			</ul>
		  </nav>
		</div>
	</div>
</header>
