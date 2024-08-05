<div id="content" class="toAlto">
	<div class="zav-content" style="margin:20px 0; margin-top:6%;">
		<div class="zav-int-content" style="width:260px; font-size: 1.2em;">
			<div class="zav-content" style="margin: 15px 0; text-align: center;">
				<img src="<?php echo $template;?>images/zav_admin.png" border="0" alt="Zav Admin" />
			</div>
			<div class="zav-corner-all-10 zav-shadow">
				<div id="login_content" class="zav-content no-bord-bottom zav-widget-white zav-corner-top-10">
					<?php include(APPPATH.'views/inc/login_form.php');?>
				</div>
				<div class="zav-content zav-widget-gray zav-corner-bottom-10" style="margin:0; padding:5px 0;">
					<div class="zav-int-content" style="width:220px; text-align:right;">
						<a onclick="LoadContent('#login_content','<?=$site_url;?>','home/restore_data/');" href="#!" class="c_black">&iquest;Olvidó su usuario o clave?</a><br/>
						<!--
						<a href="<?php echo str_replace('zav_admin/', '', $site_url);?>" class="c_red-uno">&laquo; Volver a <?php echo $project;?></a>
						-->
					</div>
				</div>
			</div>
			<div class="zav-content" style="margin: 15px 0; text-align: center;">
				<div class="zav-int-content" style="width:260px; text-align:right;">
					
				</div>
			</div>
		</div>	
	</div>
</div><!-- end content -->