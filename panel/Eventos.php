<?php
if(basename($_SERVER['PHP_SELF'])=='Eventos.php'){
	header('Location: index.php?p=Eventos');
	exit;
}

if(empty($user)){
	echo '<meta http-equiv="refresh" content="0; url=index.php" />';
	exit;
}

$id = isset($_GET['id']) && $_GET['id']!='' && $_GET['id']>0 ?$_GET['id'] : null;

$acao = isset($_GET['acao']) && $_GET['acao']!='' ? $_GET['acao'] : null;
$acao = $acao=='novoEvento' ? 'NEW' : ($id!=null && $id>0 ? 'EDIT' : 'LIST');

$Eventos = $acao!='NEW' ? Controller::obterEventos($id, $user->getId()) : array();

$Banners = $acao=='NEW' ? Controller::obterBanners(null, $user->getId()) : array();

$idForm = uniqid('Eventos');
?>
<style>
.maiusculo{
	text-transform: uppercase;
}
</style>
<div class="page-inner mb-5">
	<div class="card">
		<div class="card-header bg-white card-title text-left">
			<h4 class="card-title font-weight-bold"><?= $acao=='LIST' ? "Gerenciar Eventos" : ($acao=='NEW' ? "Cadastrar Evento" : "Editar Evento");?>:</h4>
		</div>

		<div class="offset-md-0 col-12 col-md-12 col-lg-12">
			<div class="card-body">
				<form name="form_eventos" onsubmit="return false" enctype="multipart/form-data" method="post">
				<?php
				if($acao=='LIST'){ ?>
					<div class="col-12 text-right">
						<a target="_self" href="index.php?p=Eventos&acao=novoEvento" class="btn btn-danger font-size-small mb-2"><i class="fas fa-plus mr-2"></i>Cadastrar</a>
					</div>

					<TABLE border="0" align="center" class="table_eventos rs mt-3 col-12 collapse show" cellpadding="5" style="display:table;">
						<TR>
							<TH class="text-center">ID</TH>
							<TH class="text-left">Titulo</TH>
							<TH class="text-left">Data</TH>
							<TH class="text-left">Hora</TH>
							<TH class="text-left">Ingresso</TH>
							<TH class="text-left">Data de Cadastro</TH>
							<TH class="text-center">Ações</TH>
						</TR>
						<?php
						foreach($Eventos as $Evento){
							$idEvento = $Evento['codEvento'];
							$data_inicial = isset($Evento['data_inicial']) && $Evento['data_inicial']!= null && $Evento['data_inicial']!='' ? date('d/m/Y', strtotime($Evento['data_inicial'])) : '';
							$data_final = isset($Evento['data_final']) && $Evento['data_final']!= null && $Evento['data_final']!='' ? date('d/m/Y', strtotime($Evento['data_final'])) : '';
							$printDataFinal = $data_final==$data_inicial ? '' : ' - '.$data_final;
							$valor = $Evento['valor']!=null&&$Evento['valor']!=''&&$Evento['valor']!='0.00' ? $Evento['valor'] : 'Gratuito';
							?>
						<TR>
							<TD class="negrito text-center"><span class="id"><?= $idEvento; ?></span></TD>
							<TD class="text-left"><?= nl2br($Evento['titulo']); ?></TD>
							<TD class="text-left"><?= $data_inicial.$printDataFinal; ?></TD>
							<TD class="text-left"><?= $Evento['hora']; ?></TD>
							<TD class="text-left"><?= $valor; ?></TD>
							<TD class="text-left"><?= date('d/m/Y H:i', strtotime($Evento['data_cadastro'])); ?></TD>
							<TD class="text-center">
								<A href="index.php?p=Eventos&id=<?= $idEvento; ?>" class="btn btn-primary btn-sm font-size-small ml-1" title="Editar..."><span class="material-symbols-outlined">edit</span></a>
							</TD>
						</TR>
					<?php
						} ?>
					</TABLE>
					<?php
					if(empty($Eventos)){ ?>
						<div class="card-subtitle mt-1">
							<P class="title text-center">Nenhum evento encontrado de <?= USERNAME; ?>.</P>
						</div><?php
					}
				}
				else{
					$Evento = isset($Eventos[0]) ? $Eventos[0] : array();
					if($acao=='EDIT' && empty($Evento)){
						echo '<div class="alert col-6 alert-warning text-center" style="margin:auto">Evento '.$id.' não encontrada.</div>';
						echo '<meta http-equiv="refresh" content="1; url=index.php?p=Eventos" />';
						exit;
					}
					foreach(explode(',','codEvento,titulo,descricao,data_inicial,data_final,hora,valor,fkUser,fkBanner,nomeBanner,banner,endereco,data_cadastro,data_update,publicar') as $s){
						$Evento[$s] = isset($Evento[$s]) && $Evento[$s]!=NULL ? $Evento[$s]: '';
					}
					$Evento['publicar'] = $acao=='EDIT' ? $Evento['publicar']: 1;
					$fkBanner = $acao=='EDIT' ? (isset($Evento['codBanner'])?$Evento['codBanner']:' Não') : 0;
					$idEvento = isset($Evento['codEvento'])?$Evento['codEvento']:''; ?>

					<div class="font-weight-bold font-small text-left">
						<span class="mr-3" style="font-size:14px"><?= $id>0 ? 'Evento '.$id : ''; ?></span>
						<div class="switchContainer"><?php
							$valorBol =$Evento['publicar']==1 ? 'on' : 'off';
							$checado = $valorBol=='on' ? ' checked' : '';
							?>
							<input type="checkbox" id="publicar" name="publicar" value="<?= $valorBol;?>" <?= $checado;?> class="switcher" role="switcher" />
							<label class="switch" for="publicar" style="color:#777"> Publicar</label>
						</div>
					</div>
					<div class="row">
					<?php
						if($Evento['data_cadastro']!=''){ ?>
							<input type="hidden" name="id" value="<?= $idEvento; ?>" />

							<div class="form-group col-5 col-lg-5">
								<label class="font-weight-bold d-block" id="data_upload">Data de Cadastro:</label>
								<div class="form-control fakeInput" style="font-size: 17px;"><?= date('d/m/Y H:i:s', strtotime($Evento['data_cadastro'])); ?></div>
							</div>
							<div class="form-group col-6 col-lg-6">
								<label class="font-weight-bold d-block" id="data_update">Data de Update:</label>
								<div class="form-control fakeInput" style="font-size: 17px;"><?= date('d/m/Y H:i:s', strtotime($Evento['data_update'])); ?></div>
							</div>
						<?php
						}  ?>
							<div class="form-group col-11 col-lg-11">
								<label class="font-weight-bold required" for="titulo">Nome do Evento:</label>
								<input class="form-control typeAlpha" required type="text" name="titulo" id="titulo"  maxlength="200" value="<?= $Evento['titulo']; ?>" oninput="Utils.maxLength(this);" placeholder="Ex: Show Musical XYZ">
							</div>
							<div class="form-group col-3 col-lg-3">
								<label class="font-weight-bold required" for="data_inicial">Data Inicial:</label>
								<input class="form-control" required type="date" name="data_inicial" id="data_inicial"  value="<?= $Evento['data_inicial']; ?>" />
							</div>
							<div class="form-group col-3 col-lg-3">
								<label class="font-weight-bold optional" for="data_final">Data Final: <span class="ml-1 small">(Se vários Dias)</span></label>
								<input class="form-control" type="date" name="data_final" id="data_final"  value="<?= $Evento['data_final']; ?>" />
							</div>
							<div class="form-group col-3 col-lg-3">
								<label class="font-weight-bold required" for="hora">Horario:</label>
								<input class="form-control typeHora" required type="text" name="hora" id="hora"  value="<?= $Evento['hora']; ?>" placeholder="Ex: 14h45" />
							</div>
							<div class="form-group col-3 col-lg-3">
								<label class="font-weight-bold required" for="valor">Valor: <span class="ml-1 small">(Se gratuito, colocar R$0,00)</span></label>
								<input class="form-control typeValor" required type="decimal" name="valor" id="valor" minlength="4" maxlength="13" value="<?= $Evento['valor']; ?>" placeholder="R$ 0,00" />
							</div>
							
							<div class="form-group col-11 col-lg-11">
								<label class="font-weight-bold required" for="endereco">Endereço:</label>
								<input class="form-control typeAlpha" required type="text" name="endereco" id="endereco"  maxlength="200" value="<?= $Evento['endereco']; ?>" oninput="Utils.maxLength(this);" placeholder="Ex: Av Brasil, 123 - Centro" />
							</div>

							<div class="form-group col-12 col-lg-12">
								<label class="font-weight-bold d-block required" for="descricao">Descrição:</label>
								<textarea class="form-control" required name="descricao" id="descricao" maxlength="65000" oninput="Utils.maxLength(this);" placeholder=""><?= $Evento['descricao']; ?>&nbsp;</textarea>
							</div>
							<div class="form-group col-11 col-lg-11">
								<label class="font-weight-bold d-block">Banner:</label>
								<?php
								if($fkBanner>0){ ?>
								<div class="form-control fakeInput" style="font-size: 17px;">
									<img src="./../assets/uploads/banner/<?= $Evento['banner']; ?>" id="banner" title="<?= $Evento['nomeBanner']; ?>" alt="<?= $Evento['banner']; ?>" class="imgToUpload mt-2" />
								</div>
								<?php
								} else{ ?>
									<select class="form-control" name="banner" id="banner">
										<option value=""></option>
									<?php
										foreach($Banners as $key => $Banner){
											echo "<option value='{$Banner['codBanner']}'>{$Banner['nome']}&nbsp;&nbsp;&nbsp;(Cod: {$Banner['codBanner']})</option>";
										} ?>
									</select>
								<?php
								} ?>
							</div>
					</div>
				<?php
				} ?>
					<div class="card-footer">
						<div class="form-group col-12">
							<div class="row">
								<div class="col-4">
									<a href="index.php<?= $acao!='LIST' ? "?p=Eventos" : '?'; ?>" class="btn btn-primary"><span class="fas fa-arrow-left mr-2"></span>Voltar</a>
								</div>
								<div class="col-8 text-right">
								<?php
								  if($acao=='EDIT'){ ?>
									<button class="btn btn-success mr-1" type="button" name="submit" onclick="Controller.saveEvento(this);">Atualizar</button>
							<?php  } ?>
							<?php
								  if($acao=='NEW'){ ?>
									<button class="btn btn-danger text-white ml-1" type="button"  name="submit" onclick="Controller.saveEvento(this)">Cadastrar</button>
							<?php  } ?>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="card-footer d-none"></div>
		</div>
	</div>
</div>
<script>
	function openEvento(id){
		window.location.assign('?p=Eventos&id='+id);
	}
</script>