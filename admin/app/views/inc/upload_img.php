<html>
	<head>
		<title>Carga de Archivo</title>
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
			<form id="upload" action="<?=$site_url . 'upload/upload_img/'.$width.'/'.$height.'/'.$id;?>" method="post" enctype="multipart/form-data">
				<input type="file" name="userfile" onChange="formSubmit( 'upload' )" />
			</form>
		</div>
		<div id="loader" style="display:none">
			<img src="<?=$template?>images/ajax-loader-small.gif" />
			<span style="font-family:verdana; font-size:10px">Subiendo el Archivo, por favor espere.</span>
		</div>
	</body>
</html>