<?php
if(basename($_SERVER['PHP_SELF'])=='Menu.php'){
	header('Location: index.php?p=Menu');
	exit;
}

$id = isset($_GET['id']) && $_GET['id']!='' && $_GET['id']>0 ?$_GET['id'] : null;
if($user->getPerfil()!='TI'){
	echo '<meta http-equiv="refresh" content="0; url=index.php" />';
	exit;
}

$acao = $id!=null && $id>0 ? 'EDIT' : 'LIST';

$Menus = Controller::obterSecoes($id);
$idForm = uniqid('secoes');
?>
<style>
button[disabled]{
	background-color: lightgrey !important;
}
div.fakeInput{
	display: block;
	font-size: 14px;
    border: 1px solid #ebedf2 !important;
    padding: 0.6rem 1rem;
}
div.fakeInput[disabled]{
	background: #e8e8e8 !important;
    border-color: #e8e8e8 !important;
}
.btn.btn-sm {
    padding: 0px 3px;
    text-decoration: none !important;
    color: white !important;
}
LI .fakeInput, LI .form-control{
	padding: 5px 3px;
}
UL LI:hover, UL LI:hover .row, UL LI:hover input{
	background-color: #FEFEFE !important;
}
</style>
<div class="page-inner mb-5">
	<div class="card1">
		<div class="card-header bg-white card-title text-left">
			<span class="card-title font-weight-bold">Menu do Site <?= $id!=null ? $id : '';?></span>
		</div>

		<div class="offset-md-1 col-12 col-md-10 col-lg-10">
			<div class="card-subtitle">
				<P class="title"></P>
			</div>
			<form name="form_<?= $idForm;?>" action="" enctype="multipart/form-data" method="post">
			<?php
				if(empty($Menus)){ ?>
					<div class="card-subtitle mt-1">
						<P class="title text-center">Nenhum Menu cadastradodo.</P>
					</div><?php
				} ?>

				<UL class="row" style="list-style-type: none;">
				<?php
				foreach($Menus as $key => $secao){
					foreach(explode(',','codSecao,nome,titulo,url,slug,ordem,fkSecao,submenu,publicar') as $k){
						$secao[$k] = isset($secao[$k])&&$secao[$k]!=NULL ? $secao[$k] : '';
					}
					$idSecao = $secao['codSecao'];
					$isSubmenu = $secao['submenu']==1;
					$subitem = $secao['fkSecao']!=null&&$secao['fkSecao']!=''&&$secao['fkSecao']>0;
					$valorBol =$secao['publicar']==1 ? 'on' : 'off';
					$indice = $key+1; ?>
					<LI class="inteiro form-group border-bottom d-block" data-id="<?= $idSecao; ?>">
						<div class="row">
							<div class="form-cell col-0 col-lg-0">
								<?php if($key<1){ ?><label class="font-weight-bold">ID:</label><?php } ?>
								<div disabled readOnly class="form-control font-weight-bold readOnly fakeInput"><?= $idSecao; ?></div>
								<input type="hidden" class="hidden readOnly" readOnly name="id<?= $indice; ?>" value="<?= $idSecao; ?>" />
							</div>
							<div class="form-cell col-2 col-lg-2">
								<?php if($key<1){ ?><label class="font-weight-bold">Slug:</label><?php } ?>
								<div disabled readOnly class="form-contro font-weight-bold readOnly fakeInput" style="white-space:nowrap;overflow:hidden"><?= $secao['slug']; ?></div>
							</div>
							<div class="form-cell col-1 col-lg-1">
								<?php if($key<1){ ?><label class="font-weight-bold" for="ordem<?= $indice; ?>">Ordem:</label><?php } ?>
								<input class="form-control font-weight-bold text-center typeInt" <?= $acao=='EDIT'?'disabled readOnly':''; ?> <?= $subitem?'disabled readOnly':''; ?> type="number" name="ordem<?= $indice; ?>" id="ordem<?= $indice; ?>"  min="1" max="99" value="<?= $secao['ordem']; ?>" placeholder="">
							</div>
							<div class="form-cell col-5 col-lg-5" for="nome<?= $indice; ?>">
								<?php if($key<1){ ?><label class="font-weight-bold">Nome de Exibição:</label><?php } ?>
								<input class="form-control typeAlphaNum readOnly" type="text" name="nome<?= $indice; ?>" id="nome<?= $indice; ?>" value="<?= $secao['nome']; ?>" placeholder="Digite aqui...">
							</div>
							<div class="form-cell col-3 col-lg-3"><?php
								if($acao=='LIST'){	?>
									<?php if($key<1){ ?><label class="font-weight-bold d-block">&nbsp;</label><?php } ?>
									<a href="index.php?p=Menu&id=<?= $idSecao; ?>" class="btn btn-primary btn-sm font-size-small ml-2" title="Editar..."><span class="material-symbols-outlined">edit</span></a>
						<?php	}	?>

								<div class="switchContainer ml-5">
								<?php
									$checado = $secao['publicar']==1 ? ' checked' : '';
									$valorBol =$secao['publicar']==1 ? 'on' : 'off'; ?>
									<input type="checkbox" id="publicar<?= $indice; ?>" name="publicar<?= $indice; ?>" value="<?= $valorBol;?>" <?= $checado;?> class="switcher" role="switcher" />
									<label class="switch" for="publicar<?= $indice; ?>"> Publicar</label>
								</div>
							</div>
						</div>
					<?php
						if($acao=='EDIT'){ ?>
						<div class="row">
							<div class="form-group col-8 col-lg-8">
								<label class="font-weight-bold optional" for="titulo<?= $indice; ?>">Título:</label>
								<input class="form-control typeAlpha" type="text" name="titulo" id="titulo<?= $indice; ?>"  maxlength="200" value="<?= $secao['titulo']; ?>" placeholder="" />
							</div>
							<div class="form-group col-11 col-lg-11">
								<label class="font-weight-bold optional" for="url<?= $indice; ?>">URL: <span class="ml-1" style="font-weight:100">(Se preenchido será uma URL externa)</span></label>
								<input class="form-control" type="url" name="url" id="url<?= $indice; ?>"  maxlength="300" value="<?= $secao['url']; ?>" placeholder="http://" />
							</div>
						</div>
					<?php
						}
						?>
					</LI>
				<?php				
				} ?>
				</UL>

				<div class="card-footer1">
					<div class="form-group col-12">
						<div class="row">
							<div class="col-4">
								<a href="index.php<?= $id!=null ? '?p=Menu' : ''; ?>" class="btn btn-primary color-white"><span class="fas fa-arrow-left mr-2"></span>Voltar</a>
							</div>
							<div class="col-8 text-right"><?php
								if($acao=='EDIT' && count($Menus)==1){ ?>
									<button class="btn btn-success mr-1" type="button" name="submit" onclick="Controller.updateMenu(this);">Atualizar</button>
								<?php
								} else{ ?>
									<button class="btn btn-success mr-1" type="button" name="submit" onclick="Controller.updateMenu(this);">Atualizar</button>
								<?php								
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>