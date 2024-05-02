<?php
	///echo URL_HOME;exit;//OK
?>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/jquery-3.3.1.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/popper.min.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/bootstrap.min.js"></script>

	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/Utils.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/Masks.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/Listeners.js"></script>
	<script type="application/javascript" src="<?= URL_HOME; ?>assets/js/tinymce/tinymce.min.js"></script>
<SCRIPT>tinymce.init({
  selector:'textarea#conteudo',
  branding: false,
  language: 'pt_BR',
  plugins: 'print preview paste image link hr pagebreak insertdatetime lists wordcount help emoticons',
  menubar: 'edit insert format help',
  toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | forecolor backcolor removeformat | image link emoticons charmap | preview wordcount print',
  quickbars_selection_toolbar: 'bold italic underline | quicklink',
  file_picker_types: 'image',
  paste_block_drop: false,
  hidden_input: false,
  contextmenu: '',
  setup: function(editor){
	editor.on('input', e=>{
		liberarAlteracao(document.forms[0].name.split('form_').join(''));	
	});
  }
});
</SCRIPT>