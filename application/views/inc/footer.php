<div class="fluid-container fondo_abajo" id="ancla-contacto">
    <div class="container">
        <div class="row">
            <section class="comunicar">
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 boy">
                    <img src="<?php echo $assets; ?>images/boy.png" alt="siguiente">
                </div>
                <?php if (isset($formDefault) && $formDefault) { ?>
                    <!-- Formulario General -->
                    <section id="formDefault" class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        <div class="comunicacion">
                            <p class="titulo">Escríbenos:</p>
                            <form id="contact_form" class="formulario" method="post" action="#">
                                <input class="mitad izquierda" type="text" name="nombre" placeholder=" Nombre Completo"
                                       required>
                                <input class="mitad derecha" type="number" name="celular" placeholder=" Celular"
                                       required>
                                <input class="mitad izquierda" type="email" name="correo"
                                       placeholder=" Correo electrónico" required>
                                <select class="custom-arrow mitad derecha" name="select-asunto" required>
                                    <option value=""> Asunto</option>
                                    <option value="informacion-general">Información general</option>
                                    <option value="solicitar-recoleccion">Solicitar certificado</option>
                                    <option value="solicitar-conetendor">Solicitar contenedor</option>
                                    <option value="solicitar-recoleccion">Solicitar recolección</option>
                                </select>
                                <textarea rows="" cols="" name="mensaje" placeholder="Mensaje" required></textarea>
                                <label><span class="check_terminos"><input type="checkbox" name="politicas" value=""
                                                                           required><span>He leído las<a
                                                    class="enlace-terminos"
                                                    href="<?php echo $assets; ?>images/documentacion/Politicas_PCA.pdf"
                                                    target="_blank"> Políticas de privacidad.</a></span></span></label>
                                <button type="submit" class="btn btn-default" id="submitButton">Contáctanos.</button>
                            </form>
                        </div>
                    </section>
                    <!-- / Formulario General -->
                <?php } elseif (isset($formEmpresas) && $formEmpresas) { ?>
                    <!-- Formulario Empresas -->
                    <section id="formEmpresas" class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        <div class="comunicacion">
                            <p class="titulo">Escríbenos:</p>
                            <form id="contact_form" class="formulario" method="post" action="#">
                                <input class="mitad izquierda" type="text" name="nombre" placeholder=" Nombre Completo"
                                       required>
                                <input class="mitad derecha" type="number" name="celular" placeholder=" Celular"
                                       required>
                                <input class="mitad izquierda" type="text" name="razon_social"
                                       placeholder=" Razón social" required>
                                <select class="custom-arrow mitad derecha" name="select-tipo-empresa" required>
                                    <option value=""> Tipo de empresa:</option>
                                    <option value="empresa-natural">Natural</option>
                                    <option value="empresa-juridica">Jurídica</option>
                                </select>
                                <input class="mitad izquierda" type="email" name="correo"
                                       placeholder=" Correo electrónico" required>
                                <select class="custom-arrow mitad derecha" name="select-asunto" required>
                                    <option value=""> Asunto</option>
                                    <option value="informacion-general">Información general</option>
                                    <option value="solicitar-recoleccion">Solicitar certificado</option>
                                    <option value="solicitar-conetendor">Solicitar contenedor</option>
                                    <option value="solicitar-recoleccion">Solicitar recolección</option>
                                </select>
                                <textarea rows="" cols="" name="mensaje" placeholder="Mensaje" required></textarea>
                                <label><span class="check_terminos"><input type="checkbox" name="politicas" value=""
                                                                           required><span>He leído las<a
                                                    class="enlace-terminos"
                                                    href="<?php echo $assets; ?>images/documentacion/Politicas_PCA.pdf"
                                                    target="_blank"> Políticas de privacidad.</a></span></span></label>
                                <button type="submit" class="btn btn-default" id="submitButton">Contáctanos.</button>
                            </form>
                        </div>
                    </section>
                    <!-- / Formulario Empresas -->
                <?php } elseif (isset($formHogares) && $formHogares) { ?>
                    <!-- Formulario Hogares -->
                    <section id="formHogares" class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        <div class="comunicacion">
                            <p class="titulo">Escríbenos:</p>
                            <form id="contact_form" class="formulario" method="post" action="#">
                                <input class="mitad izquierda" type="text" name="nombre" placeholder=" Nombre Completo"
                                       required>
                                <input class="mitad derecha" type="number" name="celular" placeholder=" Celular"
                                       required>
                                <input class="mitad izquierda" type="email" name="correo"
                                       placeholder=" Correo electrónico" required>
                                <textarea rows="" cols="" name="mensaje" placeholder="Mensaje" required></textarea>
                                <label><span class="check_terminos"><input type="checkbox" name="politicas" value=""
                                                                           required><span>He leído las<a
                                                    class="enlace-terminos"
                                                    href="<?php echo $assets; ?>images/documentacion/Politicas_PCA.pdf"
                                                    target="_blank"> Políticas de privacidad.</a></span></span></label>
                                <button type="submit" class="btn btn-default" id="submitButton">Contáctanos.</button>
                            </form>
                        </div>
                    </section>
                    <!-- / Formulario Hogares -->
                <?php } ?>

            </section>
            <section class="sociales">
                <p class="titulo centrar">Nuestras redes sociales:</p>
                <section class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="comunicado">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  inferior">
                            <span>Síguenos:</span>
                            <div class="redes">
                                <a href="https://www.linkedin.com/company/corporaci%C3%B3n-pilas-con-el-ambiente/"
                                   class="red" target="_blank"><img src="<?php echo $assets; ?>images/redes/lik.svg" alt="Linkedin"></a>
                                <a href="https://www.youtube.com/channel/UCHeANZE9i8pnY5Pf6cbUn5w/feed" class="red"
                                   target="_blank"><img src="<?php echo $assets; ?>images/redes/ytb.svg" alt="Youtube"></a>
                                <a href="https://www.instagram.com/pilascolombia/" class="red" target="_blank"><img
                                            src="<?php echo $assets; ?>images/redes/it.svg" alt="Instagram"></a>
                                <a href="https://twitter.com/PilasColombia" class="red" target="_blank"><img
                                            src="<?php echo $assets; ?>images/redes/tw.svg" alt="Twitter"></a>
                                <a href="https://www.facebook.com/comunidadeco" class="red" target="_blank"><img
                                            src="<?php echo $assets; ?>images/redes/fb.svg" alt="Facebook"></a>
                            </div>
                            <div class="telefono">
                                <div class="icono">
                                    <img class="foto" src="<?php echo $assets; ?>images/telefono_1.svg" alt="Número de Teléfono">
                                </div>
                                <div class="datos">
                                    <p class="numero">(571) 4849170.</p>
                                    <p class="numero">Ext: 2558.</p>
                                    <p class="ciudad">Bogotá - Colombia.</p>
                                </div>
                            </div>
                            <img src="<?php echo $assets; ?>images/girl.png" alt="siguiente" class="girl">
                        </div>
                    </div>
                </section>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 girl">
                </div>
            </section>
        </div>
    </div>

</div>
<section class="footr">
    <div class="container">
        <div class="row">
            <div class="col-lg-4  col-md-4 col-sm-4">
                <div class="footr_dv">
                    <ul>
                        <!--<li><a href="<?php echo $site_url; ?>puntos">Solicita tu recolección de pilas</a></li>-->
                        <li><a href="<?php echo $site_url; ?>preguntas">Preguntas Frecuentes.</a></li>
                        <!--dell-printer-support.php-->
                        <li><a href="<?php echo $site_url; ?>descargas">Descarga recursos y mucho más.</a></li>
                        <li><a href="<?php echo $site_url; ?>puntos">Puntos de recolección.</a></li>
                        <li><a href="<?php echo $site_url; ?>tipos">Tipos de Pilas.</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4  col-md-4 col-sm-4">
                <div class="footr_dv">
                    <ul>
                        <li><a href="<?php echo $site_url; ?>conoce">Conoce el programa</a></li>
                        <li><a href="<?php echo $site_url; ?>hogares">Recolección en Hogares</a><span
                                    style="color:#0CB4B4"> / </span><a
                                    href="<?php echo $site_url; ?>empresas">Empresas.</a></li>
                        <li><a href="<?php echo $site_url; ?>educacion">Pilas con la educación.</a></li>
                        <li><a href="<?php echo $assets; ?>images/documentacion/Politicas_PCA.pdf" target="_blank">
                                Políticas de privacidad..</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4  col-md-4 col-sm-4">
                <div class="footr_dv sep-footer-links">
                    <p>Somos parte del <img src="<?php echo $assets; ?>images/retorna.png" alt="Grupo Retorna"/></p>
                    <strong>Entérate más:</strong>
                    <div class="programas">
                        <a class="programa" href="http://www.cierraelciclo.com/" target="_blank"><img src="<?php echo $assets; ?>images/programas/cierra.png" alt="Cierra el Ciclo"></a>
                        <a class="programa" href="http://ecocomputo.com/" target="_blank"><img src="<?php echo $assets; ?>images/programas/eco.png" alt="Ecocomputo"></a>
                        <a class="programa" href="#"><img src="<?php echo $assets; ?>images/programas/pilas.png" alt="Pilas con el ambiente"></a>
                        <a class="programa" href="http://recoenergy.com.co/" target="_blank"><img src="<?php echo $assets; ?>images/programas/reco.png" alt="Recoenergy"></a>
                        <a class="programa" href="http://www.redverde.co/" target="_blank"><img src="<?php echo $assets; ?>images/programas/red.png" alt="Red verde"></a>
                        <a class="programa" href="https://www.ruedaverde.com.co/" target="_blank"><img src="<?php echo $assets; ?>images/programas/rueda.png" alt="Rueda Verde"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modals -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div id="myModal-content"></div>
                <a href="#" data-dismiss="modal"><img class="btn-cerrar-modal" src="<?php echo $assets; ?>images/cerrar-modal.png" alt="Cerrar"></a>
            </div>
        </div>
    </div>
</div>

<footer class="pie">
    <div class="container">
        <p><img src="<?php echo $assets; ?>images/footlog.png" alt="Zav Agencia Digital"> <script>document.write(new Date().getFullYear())</script></p>
    </div>
</footer>
<script src="<?php echo $assets; ?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo $assets; ?>js/bootstrap.min.js"></script>
<script src="<?php echo $assets; ?>js/slick.min.js"></script>
<script src="<?php echo $assets; ?>js/header.js"></script>
<script src="<?php echo $assets; ?>js/custom.js"></script>
<script src="<?php echo $assets; ?>js/jquery.scrollbar.js"></script>

<script>
    $(document).ready(function () {
        // slick carousel
        $('.galeria-tipos').slick({
            dots: true,
            dotsClass: 'puntos-galeria',
            infinite: true,
            slidesToShow: 1,
            centerMode: true,
            speed: 500,
            fade: true,
            arrows: true,
            prevArrow: '<a class="control anterior"><span class="interior"><img src="<?php echo $assets;?>images/mas.png" alt="Más"/></span></a>',
            nextArrow: '<a class="control siguiente"><span class="interior"><img src="<?php echo $assets;?>images/menos.png" alt="Menos"/></span></a>',
            cssEase: 'ease-in'
        });
    });
</script>
<script src="https://sandi.ver.com.co/accessibility/js/sandi_v0.1.js#pubID=7tgp54s9xzn2d6h1559683772" id="acc_v1"></script>
</body>
</html>
