<div id="header" class="zav-header">
	<div class="zav-int-content" style="width:99%;">
		<?php if(isset($user)){ ?>
		<div class="btn-menu">
			<a href="#!" onclick="$('html').toggleClass('slide-anim');">
				<span class="btn-menu-line"></span>
				<span class="btn-menu-line"></span>
				<span class="btn-menu-line"></span>
			</a>
		</div>
		<?php } ?>
		<div class="header-title">
			<?php if(isset($user)){ echo '<div style="float:left; margin:3px 5px 0 0;"><img src="'.$template.'images/zav_icon.png" border="0" alt="" /></div>';}?>
			<div class="c_red-uno" style="float:left; font-size: 1.1em; margin-top:6px; vertical-align:middle;">Bienvenido(a) al Sistema de Administración de Contenidos <span class="c_red-dos"><?php echo $project;?></span></div>
		</div>
		<div class="header-opts">
		<?php if(isset($user)){?>
		<div style="float:right; font-size: 1.2em; margin-top:4px;"><a href="<?=$site_url;?>home/logout">Cerrar Sesión</a></div>
		<?php }?>
		</div>
	</div>
</div>