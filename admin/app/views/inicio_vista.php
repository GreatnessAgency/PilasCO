<?php include(APPPATH.'views/inc/head.php');?> 

</head>

<body class="<?=(isset($user))? 'active-user':"";?>">

	<div class="reportes-content"></div>

	<div id="wrapper">

	<?php if(!isset($user)){?>

		<?php include(APPPATH.'views/inc/header.php');?>

		<?php include(APPPATH.'views/login_vista.php');?>

	<?php }else{?>	

    <div id="content">

    <div id="left_wrapper">

		<div>

		<script type="text/javascript">

			var Tree = new Array;var n = 0;

			Tree[n++]  = "1|0|Contenidos del sitio|#|ui-icon-earth";

			<?php  

			/* MODULO CREADO MANUALMENTE 

			existe la carpeta modules/noticias_gestor 

			*/

			if($user->rol_id == 0 || count(@$user->permisos->excel_puntos) > 0){ ?>

			Tree[n++]  = "2|1|Excel Puntos de Recoleccion|LoadContent('#main','<?=$site_url?>','excel_puntos', function(){ Mitab('<?=$site_url?>', 'excel_puntos', 1) })|ui-icon-bullet";

			<?php } ?>

			

			<?php 

			/* MODULOS CREADOS DINAMICAMENTE 

			NO existen en la carpeta modules/ son almacenados en la tabla modules

			se crean con el modulo modules/generador y son cargados con el modulo modules/gestor

			*/

			foreach($mods as $mod){ ?>

			Tree[n++]  = "<?php echo  $mod->shared; ?>|1|<?php echo $mod->title; ?>|LoadContent('#main','<?=$site_url?>','gestor/index/<?php echo  $mod->id; ?>', function(){ Mitab('<?=$site_url?>', 'gestor', 1) })|ui-icon-bullet";

			<?php } ?>

			

			<?php  if( $user->rol_id == 0 || count(@$user->permisos->users) > 0 ){ ?>

				Tree[n++]  = "400|0|Opciones Administrador|#|ui-icon-wrench";

				Tree[n++]  = "401|400|Usuarios|LoadContent('#main','<?=$site_url?>','users')|ui-icon-person";

				Tree[n++]  = "402|400|Roles|LoadContent('#main','<?=$site_url?>','roles')|ui-icon-person";

			<?php } ?> 

			<?php  if( $user->rol_id == 0 ){ ?>

				Tree[n++]  = "403|400|Generador Modulos|LoadContent('#main','<?=$site_url?>','generador')|ui-icon-person";

			<?php } ?> 

			

			createTree(Tree,0, 1);

		</script>

		</div>

    </div><!-- end left_wrapper-->

    <div id="right_wrapper">

		<?php include(APPPATH.'views/inc/header.php');?>

    	<div id="main">

			<div class="zav-int-content" style="font-size: 1.3em; width:95%;">

				<div style="margin-top:6%;"><b>Selecione la sección que va a administrar</b></div>

				<div class="c_red-dos" style="margin-top:10px;">Contenidos del Sitio</div>

				<div>De esta carpeta se deriva su sitio web.  Además es el lugar donde usted puede editar <img src="<?=$template;?>images/edit.png" alt="Editar" border="0" />, crear <img src="<?=$template;?>images/add.png" alt="Crear" border="0" /> o <img src="<?=$template;?>images/delete.png" alt="Eliminar" border="0" /> eliminar contenidos.</div>

				<div class="c_red-dos" style="margin-top:10px;">Opciones Administrador</div>

				<div style="margin-top:10px;">Este elemento permite administrar los diferentes privilegios de usuario de su página web.</div>

			</div>

		</div>

    </div><!-- end right_wrapper -->

    </div><!-- end content -->

    <?php } ?>

	<!--div id="push">&nbsp;</div-->

    </div><!-- end wrapper -->

	<?php //include(APPPATH.'views/inc/footer.php') ?>

	<?php include(APPPATH.'views/inc/popup-map.php'); ?>

	<div id="description_banner" class="description" title="Agregar descripción al banner" style="display: none; min-width: 320px;">

	  <form id="formDescription">

		   <textarea name="description" class="input"></textarea>

	  </form>

	</div>

</body>