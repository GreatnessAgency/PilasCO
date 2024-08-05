<html>
	<head>
		<title>Carga de Archivos</title>
		<?=$extra?>
		<script>
			function formSubmit( id ){
				document.getElementById( 'formulario' ).style.display = 'none';
				document.getElementById( 'loader' ).style.display = 'block';
				document.getElementById( id ).submit();
			}
		</script>
	</head>
	<body>
		<div id="formulario" style="display:block">
			<?=$error;?>
			<?php $dupanassing = ($dup!="")? '/'.$dup.'/'.$assing :""; ?>
			<form id="upload" action="<?=$site_url . 'upload/upload_multiple_imgs/'.$width.'/'.$height.$dupanassing;?>" method="post" enctype="multipart/form-data">				
				<input type="file" name="file[]" multiple="multiple" onChange="formSubmit( 'upload' )" />			
			</form>
		</div>
		<div id="loader" style="display:none">
			<img src="<?=$template?>images/ajax-loader-small.gif" />
			<span style="font-family:verdana; font-size:10px">Subiendo el Archivos, por favor espere.</span>
		</div>
	</body>
</html>