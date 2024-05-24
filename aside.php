<?php
	$Eventos = array(
		array('banner'=>'show-semna1.jpg', 'titulo'=>'Show das Meninas'),
		array('banner'=>'show-semna2.jpg', 'titulo'=>'Show das Poderosas'),
	);//Controller::obterEventos(null, null, true);
?>
<aside class="column side text-center">
	<div class="card-header text-center">
		<h4 class="card-title font-weight-bold"><i class="fas fa-event mr-2"></i>Eventos da Semana</h4>
	</div>

  <div>
	<UL>
	<?php
	foreach($Eventos as $Evento){
		$codEvento = isset($Evento['codEvento']) ?$Evento['codEvento'] : 0;
	?>
	<LI class="banner mt-2">
		<a target="_self" href="index.php?Evento?id=<?= $codEvento; ?>" title="<?= $Evento['titulo']; ?>" alt="<?= $Evento['titulo']; ?>">
			<img class="art-menu-image" align="center" width="255" height="220" src="./assets/uploads/banner/<?= $Evento['banner']; ?>" />
			<label class="d-block font-weight-bold mt-1 text-sm"><?= $Evento['titulo']; ?></label>
		</a>
	</LI>
<?php
	}	
	?>
	</UL>
  </div>
</aside>