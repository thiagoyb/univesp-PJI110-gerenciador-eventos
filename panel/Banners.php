<?php
if(basename($_SERVER['PHP_SELF'])=='Banners.php'){
	header('Location: index.php?p=Banners');
	exit;
}

if(empty($user)){
	echo '<meta http-equiv="refresh" content="0; url=index.php" />';
	exit;
}

$id = isset($_GET['id']) && $_GET['id']!='' && $_GET['id']>0 ?$_GET['id'] : null;

$acao = isset($_GET['acao']) && $_GET['acao']!='' ? $_GET['acao'] : null;
$acao = $acao=='novoBanner' ? 'NEW' : ($id!=null && $id>0 ? 'EDIT' : 'LIST');

$Banners = $acao!='NEW' ? Controller::obterBanners($id, $user->getId()) : array();

$idForm = uniqid('Banners');
?>
<style>
.maiusculo{
	text-transform: uppercase;
}
</style>
<div class="page-inner mb-5">
	<div class="card">
		<div class="card-header bg-white card-title text-left">
			<h4 class="card-title font-weight-bold"><?= $acao=='LIST' ? "Gerenciar Banners" : ($acao=='NEW' ? "Cadastrar Banner" : "Editar Banner");?>:</h4>
		</div>

		<div class="offset-md-0 col-12 col-md-12 col-lg-12">
			<div class="card-body">
				<form name="form_<?= $idForm;?>" action="" enctype="multipart/form-data" method="post">
				<?php
				if($acao=='LIST'){ ?>
					<div class="col-12 text-right">
						<a target="_self" href="index.php?p=Banners&acao=novoBanner" class="btn btn-danger font-size-small mb-2"><i class="fas fa-plus mr-2"></i>Cadastrar</a>
					</div>

					<TABLE border="0" align="center" class="table_banners rs mt-3 col-12 collapse show" cellpadding="5" style="display:table;">
						<TR>
							<TH class="text-center">ID</TH>
							<TH class="text-left">Titulo</TH>
							<TH class="text-left">Banner</TH>
							<TH class="text-left">Dimensões</TH>
							<TH class="text-left">Destino</TH>
							<TH class="text-left">Data de Upload</TH>
							<TH class="text-center">Ações</TH>
						</TR>
						<?php
						foreach($Banners as $Banner){
							$idBanner = $Banner['codBanner'];
							$legenda = array('_self'=>'Abrir na Mesma Janela','_blank'=>'Abrir Nova Janela');
							?>
						<TR>
							<TD class="negrito text-center"><span class="id"><?= $idBanner; ?></span></TD>
							<TD class="text-left"><?= nl2br($Banner['titulo']); ?></TD>
							<TD class="text-left"><?= $Banner['banner']; ?></TD>
							<TD class="text-left"><?= ($Banner['largura']!=''?$Banner['largura']:'auto').' x '.($Banner['altura']!=''?$Banner['altura']:'auto'); ?></TD>
							<TD class="text-left"><?= isset($legenda[$Banner['target']]) ? $legenda[$Banner['target']] : ''; ?></TD>
							<TD class="text-left"><?= date('d/m/Y H:i', strtotime($Banner['data_upload'])); ?></TD>
							<TD class="text-center">
								<!--<A target="_blank" class="btn btn-primary btn-sm" href="./../assets/uploads/banner/<?= $Banner['banner']; ?>" title="Acessar banner" style="padding: 6px;"><i class="fas fa-eye mr-2"></i></A>-->
								<A href="index.php?p=Banners&id=<?= $idBanner; ?>" class="btn btn-primary btn-sm font-size-small ml-1" title="Editar..."><span class="material-symbols-outlined">edit</span></a>
							</TD>
						</TR>
					<?php
						} ?>
					</TABLE>
					<?php
					if(empty($Banners)){ ?>
						<div class="card-subtitle mt-1">
							<P class="title text-center">Nenhum banner encontrado.</P>
						</div><?php
					}
				}
				else{
					$Banner = isset($Banners[0]) ? $Banners[0] : array();
					if($acao=='EDIT' && empty($Banner)){
						echo '<div class="alert col-6 alert-warning text-center" style="margin:auto">Banner '.$id.' não encontrada.</div>';
						echo '<meta http-equiv="refresh" content="1; url=index.php?p=Banners" />';
						exit;
					}
					foreach(explode(',','codBanner,titulo,banner,largura,altura,url,target,ordem,data_upload,data_update,publicar') as $s){
						$Banner[$s] = isset($Banner[$s]) && $Banner[$s]!=NULL ? $Banner[$s]: '';
					}
					$Banner['publicar'] = $acao=='EDIT' ? $Banner['publicar']: 1;
					$idBanner = isset($Banner['codBanner']) ? $Banner['codBanner'] : ''; ?>

					<div class="font-weight-bold font-small text-left">
						<span class="mr-3" style="font-size:14px"><?= $id>0 ? 'Banner '.$id : ''; ?></span>
						<div class="switchContainer"><?php
							$valorBol =$Banner['publicar']==1 ? 'on' : 'off';
							$checado = $valorBol=='on' ? ' checked' : '';
							?>
							<input type="checkbox" id="publicar" name="publicar" value="<?= $valorBol;?>" <?= $checado;?> class="switcher" role="switcher" />
							<label class="switch" for="publicar" style="color:#777"> Publicar</label>
						</div>
					</div>
					<div class="row">
					<?php
						if($Banner['data_upload']!=''){ ?>
							<input type="hidden" name="id" value="<?= $idBanner; ?>" />

							<div class="form-group col-5 col-lg-5">
								<label class="font-weight-bold d-block" id="data_upload">Data de Cadastro:</label>
								<div class="form-control fakeInput" style="font-size: 17px;"><?= date('d/m/Y H:i:s', strtotime($Banner['data_upload'])); ?></div>
							</div>
							<div class="form-group col-6 col-lg-6">
								<label class="font-weight-bold d-block" id="data_update">Data de Update:</label>
								<div class="form-control fakeInput" style="font-size: 17px;"><?= date('d/m/Y H:i:s', strtotime($Banner['data_update'])); ?></div>
							</div>
						<?php
						}  ?>
							<div class="form-group col-11 col-lg-11">
								<label class="font-weight-bold optional" for="titulo">Nome do Banner:</label>
								<input class="form-control typeAlpha" type="text" name="titulo" id="titulo"  maxlength="100" value="<?= $Banner['titulo']; ?>" placeholder="Ex: logotipo do site">
							</div>
							<div class="form-group col-3 col-lg-3">
								<label class="font-weight-bold optional" for="largura">Largura:</label>
								<input class="form-control" type="number" name="largura" id="largura"  value="<?= $Banner['largura']; ?>" placeholder="255 pixels">
							</div>
							<div class="form-group col-3 col-lg-3">
								<label class="font-weight-bold optional" for="altura">Altura:</label>
								<input class="form-control" type="number" name="altura" id="altura"  value="<?= $Banner['altura']; ?>" placeholder="105 pixels">
							</div>
							<div class="form-group col-4 col-lg-4">
								<label class="font-weight-bold required" for="destino">Destino:</label>
								<select class="form-control" required name="destino" id="destino">
								<?php
									$legenda = array('_self'=>'Abrir na Mesma Janela','_blank'=>'Abrir Nova Janela');
									foreach(array('_self','_blank') as $key => $destino){
										$checado = $destino == $Banner['target'] ? 'selected ' : '';
										echo "<option {$checado}value='{$destino}'>{$legenda[$destino]}&nbsp;&nbsp;&nbsp;({$destino})</option>";
									} ?>
								</select>
							</div>

							<div class="form-group col-11 col-lg-11">
								<label class="font-weight-bold" for="url">URL: <span class="ml-1" hidden style="font-weight:100">(Se não desejar um link, coloque um '#')</span></label>
								<input class="form-control" type="url" name="url" id="url"  maxlength="255" value="<?= $Banner['url']; ?>" placeholder="http://">
							</div>
							<div class="form-group col-11 col-lg-11">
								<label class="font-weight-bold d-block required">Banner:</label>
								<?php
								if($idBanner>0){ ?>
								<div class="form-control fakeInput" style="font-size: 17px;">
									<input class="hidden" id="banner" name="banner" value="<?= $Banner['banner']; ?>" type="hidden" />
									<a target="_blank" class="link ml-2" href="<?= $Banner['url']; ?>">
										<img src="./../assets/uploads/banner/<?= $Banner['banner']; ?>" title="<?= $Banner['banner']; ?> (Clique para testar o Link)" alt="<?= $Banner['banner']; ?>" name="bannerFile" id="bannerFile" class="imgToUpload mt-2" />
									</a>
								</div>
							<?php
								} else{ ?>
								<input class="form-control" type="file" data-maxfilesize="3" required name="bannerFile" id="bannerFile" accept="image/png,image/jpg,image/jpeg" onchange="Controller.prepareImage(this);">
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
									<a href="index.php<?= $acao!='LIST' ? "?p=Banners" : '?'; ?>" class="btn btn-primary"><span class="fas fa-arrow-left mr-2"></span>Voltar</a>
								</div>
								<div class="col-8 text-right">
								<?php
								  if($acao=='EDIT'){ ?>
									<button class="btn btn-success mr-1" type="button" name="submit" onclick="Controller.updateBanner(this, <?= $id; ?>);">Atualizar</button>
							<?php  } ?>
							<?php
								  if($acao=='NEW'){ ?>
									<button class="btn btn-danger ml-1" name="submit" onclick="Controller.novoBanner(this)">Cadastrar</button>
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
	function openBanner(id){
		window.location.assign('?p=Banners&id='+id);
	}
</script>