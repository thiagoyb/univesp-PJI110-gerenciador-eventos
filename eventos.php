<?php
	$Eventos = Controller::obterEventos(null, null, true);
?>
<div class="column middle page-inner col-12 mt-2">
	<div class="card1">
		<div class="card-header text-center">
			<h4 class="card-title font-weight-bold"><i class="fas fa-event mr-2"></i>Lista de Eventos</h4>
		</div>

		<div class="card-body">			
			<section class="search-bar d-block text-center">
				<div class="card d-inline-block">
					<div class="form-group text-left">
						<label for="font-weight-bold d-block" style="color:#000">Título:</label>
						<input type="search" value="" placeholder="Pesquisar eventos..." class="form-control form-border form-control-sm form-border" id="titulo" name="titulo" />
					</div>
					<div class="form-group text-left">
						<label for="font-weight-bold d-block" style="color:#000">Data:</label>
						<input type="date" value="" class="form-control form-border form-control-sm form-border" id="data" name="data" />
					</div>
					<div class="form-group mt-3">
						<button class="btn btn-primary form-border" type="submit" id="btn-submit"><i class="fas fa-search mr-1"></i>Buscar</button>
					</div>
				</div>
			</section>
			<section class="events-results d-block text-left">
				<UL class="d-block">
				<?php
					foreach($Eventos as $Evento){
						$idEvento = $Evento['codEvento'];
						$data_inicial = isset($Evento['data_inicial']) && $Evento['data_inicial']!= null && $Evento['data_inicial']!='' ? date('d/m/Y', strtotime($Evento['data_inicial'])) : '';
						$data_final = isset($Evento['data_final']) && $Evento['data_final']!= null && $Evento['data_final']!='' ? date('d/m/Y', strtotime($Evento['data_final'])) : '';
						$printDataFinal = $data_final==$data_inicial ? '' : ' - '.$data_final;
						$valor = $Evento['valor']!=null&&$Evento['valor']!=''&&$Evento['valor']!='0.00' ? $Evento['valor'] : 'Gratuito';
					?>
					<LI class="row event border-bottom mt-2">
						<div class="col-2">
							<img class="event" height="150" src="./assets/uploads/banner/<?= $Evento['banner']; ?>" alt="<?= $Evento['titulo']; ?>">
						</div>
						<div class="col-10">
							<h3 class="d-block font-weight-bold"><?= $Evento['titulo']; ?></h3>
							<p><b class="mr-2">Data:</b> <?= $data_inicial.$printDataFinal; ?> às <?= date('H:i',strtotime($Evento['hora'])); ?></p>
							<p><b class="mr-2">Valor:</b> <?= $valor; ?></p>
							<p><b class="mr-2">Local:</b> <?= $Evento['endereco']; ?></p>							
						</div>
					</LI><?php
					}
				?>
				</UL>
			</section>
		</div>
	</div>
</div>
<?php
	require 'aside.php';
?>