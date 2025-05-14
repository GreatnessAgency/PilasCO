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
<body class="landing">
    <div class="container" style="width: 940px;">
        <div style="margin: 0; line-height: none;"><img src="<?php echo $template;?>images/stripe.jpg" alt="" style="vertical-align: top;" ></div>
        <!-- banner -->
        <div class="banner">
            <img src="<?php echo $template;?>images/<?php echo $imagen;?>" alt='Tu sonrisa atrae, brilla y resplandece&iexcl; En Sonr&iacute;a contamos con un amplio portafolio de productos de acuerdo a tu tiempo y presupuesto, con resultados espectaculares para que luzcas una sonrisa resplandeciente. Conf&iacute;a tu salud oral en manos de los mejores Solo en Sonr&iacute;a cuentas con la experiencia de Profesionales graduados y especializados de las mejores universidades del pa&iacute;s.'>
        </div>
        <!-- end banner -->
        <!-- cuerpo -->
        <div class="row-fluid">
            <!-- contenido-principal -->
            <div class="span7 contenido-principal">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="oferta">
                            <ul>
                                <li>
                                    <h2>Blanqueamiento BLACK SPOT</h2>
                                    <div>
                                        <h4>Recupera el color natural de tu sonrisa</h4>
                                        <p>
                                            Una sonrisa espectacular depende del color de los dientes. 
                                            El blanqueamiento en dientes no vitales es el aclaramiento 
                                            que se realiza en las piezas dentales que est&aacute;n oscuros por 
                                            traumatismos como golpes y accidentes o por tratamientos con da&ntilde;os en el nervio del diente.
                                        </p>
                                        <p>Es as&iacute; como el procedimiento del Blanqueamiento Black Spot es una excelente opci&oacute;n para recuperar el aspecto natural y est&eacute;tico de una linda sonrisa.</p>
                                    </div>
                                </li>
                                
                                <li>
                                    <h2>Blanqueamiento EXPRESS HD</h2>
                                    <div>
                                        <h4>Dientes blancos en tan solo 30 minutos</h4>
                                        <p>
                                            Indicado para pacientes que quieren lucir sus dientes m&aacute;s blancos en tan solo 30 minutos.
                                        </p>
                                        <p>Este procedimiento es realizado en cl&iacute;nica por nuestros profesionales, utilizando la m&aacute;s alta tecnolog&iacute;a de c&aacute;mara luz LED, que en combinaci&oacute;n con los agentes blanqueadores elimina el efecto de las manchas en una sola sesi&oacute;n sin da&ntilde;ar el esmalte dental.</p>
                                    </div>
                                </li>
                                
                                <li>
                                    <h2>Blanqueamiento WHITE EXTREME</h2>
                                    <div>
                                        <h4>Dos t&eacute;cnicas para mejores resultados</h4>
                                        <p>
                                            Este tipo de blanqueamiento debe realizarse &uacute;nicamente en cl&iacute;nicas dentales certificada y bajo la supervisi&oacute;n de un especialista para evitar posibles da&ntilde;os en las enc&iacute;as de no realizarse este tratamiento de la forma correcta.
                                        </p>
                                        <p>Este procedimiento combina las dos t&eacute;cnicas de blanqueamiento: En consultorio y casero.</p>
                                        <p><a href="#">Leer m&aacute;s</a></p>
                                    </div>
                                </li>
                                
                                <li>
                                    <h2>Blanqueamiento ULTRA WHITE</h2>
                                    <div>
                                        <h4>Dientes resplandecientes hechos en casa</h4>
                                        <p>
                                            Es un tratamiento que inicia con las recomendaciones de nuestros profesionales en cl&iacute;nica y el paciente lo finaliza en casa. Este blanqueamiento se realiza a trav&eacute;s de cubetas pl&aacute;sticas en las cuales se coloca un gel blanqueador a baja concentraci&oacute;n y en tan solo unos d&iacute;as se pueden ver resultados sorprendentes.
                                        </p>
                                        <p>El tiempo y n&uacute;mero de sesiones ser&aacute;n indicados por nuestros profesionales de acuerdo a la tonalidad que se desea lograr.</p>
                                    </div>
                                </li>
                                
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end contenido-principal -->
            <!-- form -->
            <div class="span4 offset1" style="position: relative;">
                <div class="form squared">
                    <div class="titulo">
                        &iquest;Quieres hacerte <br>un blanqueamiento&quest;
                    </div>
                    <form id="form-blanqueamiento" method="post" class="form-horizontal" action="<?php echo $site_url;?>main/enviar/<?php echo $url;?>">
                        <small>Ingresa tus datos y pronto te contactaremos!</small>
                        <label for="nombre"><span class="required">*</span> Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="span12 validate[required]">
                        
                        <label for="email"><span class="required">*</span> Correo Electr&oacute;nico</label>
                        <input type="text" id="email" name="email" class="span12 validate[required]">
                        
                        <label for="telefono"><span class="required">*</span> Tel&eacute;fono</label>
                        <input type="text" id="telefono" name="telefono" class="span12 validate[required]">
                        
                        <label for="comentarios">Comentarios</label>
                        <textarea id="comentarios" name="comentarios" class="span12"></textarea>
                        
                        <label><span class="required">*</span>&nbsp;<input name="aceptaterminos" type="checkbox" value="1" class="validate[required]">&nbsp;<a href="#" target="_blank">Acepto t&eacute;rminos  y condiciones</a></label>
                        
                        <div class="botonera text-center">
                            <button class="btn btnEnviar" type="submit">ENVIAR</button>
                            <input type="hidden" name="producto" value="blanqueamiento">
                        </div>
                    </form>                    
                </div>
            </div>
            <!-- end form -->
        </div>
        <!-- end cuerpo -->
        
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
$(document).ready(function(){
    $('#form-blanqueamiento').validationEngine({
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
                    $('#formEncuesta').each(function(){
                        this.reset();
                    });
                    //gracias
                    window.location.href = json.url;
                }
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