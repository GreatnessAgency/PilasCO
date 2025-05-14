<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title;?></title>

<!-- bootstrap -->
<link href="//netdna.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $template;?>css/landing-style.css" rel="stylesheet">
<link href="<?php echo $template;?>js/jquery.validationEngine/css/validationEngine.jquery.css" rel="stylesheet">

</head>
<body class="gracias">
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=587762421291387";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

    <div class="container" style="width: 940px;">
        <div style="margin: 0; line-height: 0;"><img src="<?php echo $template;?>images/stripe.jpg" alt="" style="vertical-align: top;" ></div>
        <!-- header -->
        <div class="row-fluid" style="margin-top: 25px;">
            <div class="span7">
                <h1>GRACIAS POR COTACTARNOS</h1>                
            </div>            
            <div class="span3 offset2">
                <img src="<?php echo $template;?>images/logo-sonria.jpg" alt="" style="vertical-align: top;" >
            </div>
        </div>
        <!-- end header -->
        
        <div class="row-fluid contenedor">
            <!-- left -->
            <div class="span7">                
                <h3 class="mensaje">Pronto nos pondremos en contacto contigo</h3>                
                <div class="row-fluid" style="margin-top: 60px;">
                    <div class="span12">
                        <h3>Comparte esta informaci&oacute;n</h3>
                        <div class="compartir">
                            <div class="twitter pull-left">
                                <a href="https://twitter.com/share" class="twitter-share-button" data-lang="es">Twittear</a>
                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                            </div>
                            <div class="facebook pull-left" style="width: 200px;">
                                <div class="fb-like" data-colorscheme="light" data-layout="button" data-action="like" data-show-faces="false" data-send="false"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row-fluid">
                    <div class="span12">
                        <h3>Env&iacute;ale esta informaci&oacute;n a tus amigos</h3>
                        <div class="input-append span10 shareEmail" style="margin: 0;">
                            <form id="shareEmail" method="post" >
                                <input class="span12 validate[required,funcCall[validateEmail]]" id="emails" type="text" name="emails">
                                <button class="btn btnEnviar" type="submit">ENVIAR</button>
                            </form>                            
                        </div>
                    </div>
                </div>
                
                <div class="row-fluid" style="margin-top: 20px;">
                    <div class="span12">
                        <h3>S&iacute;guenos en nuestras redes sociales</h3>
                        <div class="redes">
                            <a href="#" target="_blank" style="margin-right: 10px;"><img alt="" src="<?php echo $template;?>images/facebook.png"></a>
                            <a href="#" target="_blank" style="margin-right: 10px;"><img alt="" src="<?php echo $template;?>images/twitter.png"></a>
                            <a href="#" target="_blank" style="margin-right: 10px;"><img alt="" src="<?php echo $template;?>images/youtube.png"></a>                            
                        </div>
                    </div>
                </div>
                
                <div class="row-fluid" style="margin-top: 20px;">
                    <div class="span12">
                        <h3 style="font-size: 28px; font-family: 'ubuntubold';"><a href="#" style="color:#005AA9;">Conoce otros productos que te pueden interesar <img alt="" src="<?php echo $template;?>images/arrow.jpg"></a></h3>
                        
                    </div>
                </div>
                
                
            </div>
            <!-- end left -->
            <!-- right -->
            <div class="span5">
                <div class="row-fluid">
                    <div class="span12">                                                
                        <img alt="" src="<?php echo $template;?>images/gracias-blanqueamiento.jpg" style="width: 324px; height: 465px; max-width: 324px;">
                    </div>
                </div>
            </div>
            <!-- end right -->
        </div>
        
        <!-- footer -->
        <div class="row-fluid footer">
            <div class="span7">
                <div class="row-fluid">
                    <div class="span11 offset1">
                        <img src="<?php echo $template;?>images/vigilado.png" alt="vigilado Supersalud">
                        <img src="<?php echo $template;?>images/logo-clinicas.png" alt="Cl&iacute;nicas cient&iacute;ficas odontol&oacute;gicas">
                    </div>
                </div>
            </div>        
        </div>
        <!-- end footer -->
        
    </div>    
    
<!-- scripts -->
<script type="text/javascript" src="<?php echo $template;?>js/jquery.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $template;?>js/jquery.validationEngine/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?php echo $template;?>js/jquery.validationEngine/jquery.validationEngine-es.js"></script>
<script type="text/javascript">
function validateEmail(field, rules, i, options) {
    /*
    $.each(field.val().split(","), function(index, item){
        var re = new RegExp(options.allrules.email.regex);
        console.log(re.exec(item));
        if( re.exec(item) == null ){
            response = false
            return options.allrules.email.alertText;
        }
    });
    */
   return true;
}

$(document).ready(function(){
    $('#shareEmail').validationEngine({
        addFailureCssClassToField:"input-error", 
        validationEventTrigger: "submit",
        ajaxFormValidation: true,
        ajaxFormValidationMethod: 'post',
        onBeforeAjaxFormValidation: function(form, options){
            //cambiamos el estado del boton enviar
            $('.btnEnviar').button('loading');
        },
        onAjaxFormComplete: function(form, status, json, options){
            //reseteamos el estado del boton enviar, independientemente del resultado
            $('.btnEnviar').button('reset');
            if( status) {
                if(json.response.code === 200){
                    $('#shareEmail').each(function(){
                        this.reset();
                    });
                    //gracias por participar
                    $(".alert.alert-block").show();
                }                
            }else{
                    
            }
        },
        onFailure: function(){
            $('.btnEnviar').button('reset');
            alert( "Ocurrio un error, sus respuestas no se guardaron, por favor intentelo de nuevo." );
        }
    });
});
</script>
<!-- end scripts -->
</body>
</html>