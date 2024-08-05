<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="cache-control" content="no-cache" />	
	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="<?=$template;?>css/grid.css" />    
	<link rel="stylesheet" type="text/css" href="<?=$template;?>css/template.css" />
    <link rel="stylesheet" type="text/css" href="<?=$template;?>css/style.css" />
	<script type="text/javascript" src="<?=$template;?>js/jquery.js"></script>
	<script type="text/javascript" src="<?=$template;?>js/tree.js"></script>
	<script type="text/javascript" src="<?=$template;?>js/standard.js"></script>
    <!-- Scripts de jQuery ui-->
    <script type="text/javascript" src="<?=$template;?>js/ui/js/jquery-ui.js"></script>
    <link id="style_ui" rel="stylesheet" type="text/css" href="<?=$template;?>js/ui/css/smoothness/jquery-ui.css" />
	<!--tiny_mce-->	
	<script type="text/javascript" src="<?=$template;?>js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript" src="<?=$template;?>js/MD5.js"></script>
	<?php if(isset($user)){ ?>	
    <!-- ak custom select-->	<link href="<?=$template;?>js/jquery.ak.select/jquery.ak.select.css" rel="stylesheet" type="text/css" />
	<script src="<?=$template;?>js/jquery.ak.select/jquery.ak.select.js" type="text/javascript"></script>
	    <!-- maps google api-->
	<script type="text/javascript" src="http://maps.google.com/maps/api/js"></script>

    <!-- jquerydataTables -->
    <link rel="stylesheet" type="text/css" href="<?=$template;?>js/jqueryDataTables/css/demo_table.css" />
    <script type="text/javascript" src="<?=$template;?>js/jqueryDataTables/jquery.dataTables.js"></script>

	<!-- jquery autoNumeric -->
	<script type="text/javascript" src="<?=$template;?>js/autoNumeric-min.js"></script>
	<!-- fancybox -->
	<script type="text/javascript" src="<?=$template;?>js/source/jquery.fancybox.js"></script>
	<script type="text/javascript" src="<?=$template;?>js/source/jquery.fancybox.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=$template;?>js/source/jquery.fancybox.css" />
    <script src="<?=$template;?>js/jquery.miniColors/jquery.miniColors.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="<?=$template;?>js/jquery.miniColors/jquery.miniColors.css" />	
	<script type="text/javascript" src="<?=$template;?>js/script.js"></script>
	<?php } ?>
	<title><?=$project?> :: Zav Admin</title>