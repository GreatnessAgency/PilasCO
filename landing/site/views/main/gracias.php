<!DOCTYPE html itemscope itemtype="http://schema.org/Blog">
<!--[if lt IE 7 ]><html lang="es" class="ie6 ielt9"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="ie7 ielt9"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="ie8 ielt9"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Pilas Colombia</title>
        
        <meta property="fb:app_id" content="219290648248249" />
        <meta property="og:title" content="Pilas Colombia" />
        <meta property="og:type" content="Article" />
        <meta property="og:url" content="http://pilascolombia.com/landing/" />
        <meta property="og:image" content="http://pilascolombia.com/landing/site/images/avatar.jpg" />
        <meta property="og:description" content="En el cuidado del medio ambiente todos tenemos una gran responsabilidad, productores, importadores y consumidores #PilasconelAmbiente" />
	<!-- meta tags -->

	<!-- css styles and fonts -->
	<script type="text/javascript" src="<?php echo $template;?>js/modernizr.js"></script>
	<script type="text/javascript" src="<?php echo $template;?>js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $template;?>css/swis711BT/stylesheet.css" >
	<link rel="stylesheet" type="text/css" href="<?php echo $template;?>css/swis711LT/stylesheet.css" >
	<link rel="stylesheet" type="text/css" href="<?php echo $template;?>css/forms.css" >
	<link rel="stylesheet" type="text/css" href="<?php echo $template;?>css/style.css" >	
<script type="text/javascript">
$(document).ready(function(){
	$('a[href^="#"]').click(function (e) {
	    e.preventDefault();

	    var target = this.hash,
	    $target = $(target);

	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 900, 'swing', function () {
	        window.location.hash = target;
	    });
	});
});

function validate(btn, form, ajax, func){
	btn = $(btn);
	form = $(form);
	inputs = form.find('input,textarea,select');

	for(var i = 0; i < inputs.length; i++){
		ipt = $(inputs[i]);
		label = form.find('label[for='+ipt.attr('name')+']');
		if(ipt.hasClass('required') && ipt.val() == ""){
			ipt.addClass('error');
			alert(label.text()+' Este campo es obligatorio');
			return false;
		}else{
			ipt.removeClass('error');
		}
		if(ipt.hasClass('email') && ipt.val() != ""){
			if(ipt.val().indexOf('@') == '-1' || ipt.val().indexOf('.') == '-1'){
				ipt.addClass('error');
				alert('Verifique el correo electrónico.');
				return false;
			}else{
				ipt.removeClass('error');
			}
		}
		if(ipt.hasClass('onlynum') && ipt.val() != ""){
			var filter=/^([0-9\s]+)*$/;
			if(!filter.test(ipt.val())){
				ipt.addClass('error');
				alert(label.text()+' Este campo solo permite números.');
				return false;
			}else{
				ipt.removeClass('error');
			}
		}
		if(ipt.attr('data-compair')){
			com = form.find(ipt.attr('data-compair'));
			if(ipt.val() != com.val() && ipt.val() != ""){
				ipt.addClass('error');
				com.addClass('error');
				alert(label.text()+' Estos campos no pueden ser diferentes.');
				return false;
			}else{
				ipt.removeClass('error');
				com.removeClass('error');
			}
		}
		
	}
	
	if(btn.hasClass('deactive') === false){
		if(ajax != undefined){
			org = btn.html();
			btn.addClass('deactive');
			btn.html('<span class="loader"></span> Espere ');
			$.ajax({
				type : 'POST',
				data : form.serialize(),
				url : ajax,
				success: function(data){
					btn.removeClass('deactive');
					btn.html(org);
					if(func != undefined){
						func(data);
					}
				}
			});
		}else{
			form.submit();
		}
	}
}

</script>	
<script type="text/javascript">
var fb_param = {};
fb_param.pixel_id = '6010436755963';
fb_param.value = '0.00';
fb_param.currency = 'USD';
(function(){
  var fpw = document.createElement('script');
  fpw.async = true;
  fpw.src = '//connect.facebook.net/en_US/fp.js';
  var ref = document.getElementsByTagName('script')[0];
  ref.parentNode.insertBefore(fpw, ref);
})();
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6010436755963&amp;value=0&amp;currency=USD" /></noscript>
</head>
<body id="gracias">
<!-- Google Code for Registro Institucional Landing 2 Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 942934271;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "mcNcCJaigF0Q_5HQwQM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/942934271/?label=mcNcCJaigF0Q_5HQwQM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<?php if($file == 1): ?>
	<!--
	Start of DoubleClick Floodlight Tag: Please do not remove
	Activity name of this tag: CO_Pilas_Colombia_TP1
	URL of the webpage where the tag is expected to be placed: http://www.pilascolombia.com/landing/main/gracias/1
	This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.
	Creation Date: 03/05/2014
	-->
	<script type="text/javascript">
	var axel = Math.random() + "";
	var a = axel * 10000000000000;
	document.write('<iframe src="http://4379943.fls.doubleclick.net/activityi;src=4379943;type=lp1dw588;cat=co_pi731;ord=' + a + '?" width="1" height="1" frameborder="0" style="display:none"></iframe>');
	</script>
	<noscript>
	<iframe src="http://4379943.fls.doubleclick.net/activityi;src=4379943;type=lp1dw588;cat=co_pi731;ord=1?" width="1" height="1" frameborder="0" style="display:none"></iframe>
	</noscript>

	<!-- End of DoubleClick Floodlight Tag: Please do not remove -->
<?php else:?>

	<!--
	Start of DoubleClick Floodlight Tag: Please do not remove
	Activity name of this tag: CO_Pilas_Colombia_TP2
	URL of the webpage where the tag is expected to be placed: http://www.pilascolombia.com/landing/main/gracias/2
	This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.
	Creation Date: 03/05/2014
	-->
	<script type="text/javascript">
	var axel = Math.random() + "";
	var a = axel * 10000000000000;
	document.write('<iframe src="http://4379943.fls.doubleclick.net/activityi;src=4379943;type=lp2fj367;cat=co_pi867;ord=' + a + '?" width="1" height="1" frameborder="0" style="display:none"></iframe>');
	</script>
	<noscript>
	<iframe src="http://4379943.fls.doubleclick.net/activityi;src=4379943;type=lp2fj367;cat=co_pi867;ord=1?" width="1" height="1" frameborder="0" style="display:none"></iframe>
	</noscript>

	<!-- End of DoubleClick Floodlight Tag: Please do not remove -->


<?php endif; ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=219290648248249";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
	<header>
		<div class="barra_sup">&nbsp;</div>
	</header>
	<section class="wrapper">	
			<div class="wrapper logos" style=" display:table; ">
				<a class="fixie7" href="http://pilascolombia.com"><img style="margin-left:0;" src="<?php echo $template;?>images/pilas_con_el_ambiente.png" title="Pilas con el Ambiente"></a>
				<img src="<?php echo $template;?>images/andi_logo.png" title="Andi">
				<img src="<?php echo $template;?>images/logo_ministerio.png" title="MinAmbiente">
				<div class="redes">
                                    <div>Vis&iacute;tenos en:</div>
					<div>
						<a href="https://twitter.com/pilascolombia" target="_blank"><img src="<?php echo $template;?>images/icon-tw.png" width="31"></a>
						<a href="https://www.facebook.com/comunidadeco" target="_blank"><img src="<?php echo $template;?>images/icon-fb.png" width="25"></a>
						<a href="http://www.linkedin.com/groups/Pilas-Ambiente-6631712/about" target="_blank"><img src="<?php echo $template;?>images/icon-in2.png" width="25"></a> 
					</div>
				</div>
			</div>
			<div>&nbsp;</div>
			<div>&nbsp;</div>
		<article class="logos left_content">
			<div>
                            <div class="tag_cont">
                                <h1 class="cOrange">&iexcl;Gracias&excl;</h1>
                                <p>Su participaci&oacute;n tendr&aacute; un gran impacto positivo en el medio ambiente.</p>
                                    <p>Usted y su empresa estan dando un paso importante hacia el cuidado de la Tierra y de sus recursos, cumpliendo con la normatividad vigente.</p>
                                    <p>&iquest;Desea seguir ayudando?</p>
                            </div>

                            <div class="block_cont">
                                    <div class="cont_doMore fLeft">
                                            <div class="share_btn">
                                                    <a href="http://pilascolombia.com/index.php/institucional" target="_blank">
                                                        <div><span style="font-size: 26px;">Obtenga m&aacute;s</span><br/> informaci&oacute;n del programa</div>
                                                    </a>
                                            </div>
                                    </div>
                                    <div class="cont_doMore fRight">
                                        Compartir en redes sociales:<br/>
                                        <div style="float: left; width: 100px; padding-top: 15px;">
                                            <a href="https://twitter.com/share" class="twitter-share-button" data-text="En el cuidado del medio ambiente todos tenemos una gran responsabilidad, productores, importadores y consumidores" data-lang="es" data-size="large" data-count="none" data-hashtags="PilasconelAmbiente">Twittear</a>
                                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                                        </div>
                                        <div style="float: left; width: 100px; padding-top: 11px;">
                                            <div class="fb-share-button" data-href="<?php echo trim($ruta).$file;?>" data-width="100" data-type="button"></div>
                                        </div>
                                        <div style="float: left; width: 100px; padding-top: 16px; display: none;" >
                                            <div class="g-plus" data-action="share" data-annotation="none" data-height="24"></div>
                                            <script type="text/javascript">
                                                window.___gcfg = {lang: 'es'};

                                                (function() {
                                                  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                                  po.src = 'https://apis.google.com/js/plusone.js';
                                                  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                                })();
                                              </script>
                                        </div>
                                        <?php /*<a target="_blank" href="http://www.twitter.com/share"><img src="<?php echo $template;?>images/icon-tw.png" width="40"></a>
                                        <a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=<?=$this->config->item("base_url");?>"><img src="<?php echo $template;?>images/icon-fb.png" width="35"></a>
                                        <a target="_blank" href=""><img src="<?php echo $template;?>images/icon-google.png" width="35"></a>*/?>
                                    </div>
                                    <div></div>
                            </div>
                            <div id="push" class="wrapper">&nbsp;</div>	
                            <div class="end_tag">
                                <p class="fsize26"><span class="cGreen">Pilas con el Ambiente</span> dar&aacute; un manejo adecuado a las pilas y acumuladores entregados, acorde con la normatividad para el manejo de estos residuos.</p>
                            </div>
			</div>
		</article>
		<article class="right_content">
			<div class="pilascol2"><img src="<?php echo $template;?>images/pilascol.png" width="110" height="255" alt="Pilas Colombia"></div>
		</article>
		<div id="push" class="wrapper">&nbsp;</div>	
		<div id="push" class="wrapper">&nbsp;</div>	
	</section>	
	<div class="footer">
		<div class="footer-wrapper">
			<div class="footer_content">
				<div>
                                    <p>Todos los derechos reservados &copy; 2013</p>
				</div>
				<div class="separator">&nbsp;</div>
				<div class="zav"><p><a href="http://www.zavgroup.com" target="_blank">Desarrollado por Zav Group</a></p></div>
			</div>
		</div>
	</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7526679-31']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>