$(function () {

    $(document).ready(function () {
        // Transición enlaces IDs y Hashes (#)
        $('a[href*="#ancla-contacto"]')
        // Remove links that don't actually link to anything
            .not('[href="#"]')
            .not('[href="#0"]')
            .click(function (event) {
                // On-page links
                if (
                    location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                    &&
                    location.hostname == this.hostname
                ) {
                    // Figure out element to scroll to
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    // Does a scroll target exist?
                    if (target.length) {
                        // Only prevent default if animation is actually gonna happen
                        event.preventDefault();
                        $('html, body').animate({
                            scrollTop: target.offset().top
                        }, 1000, function () {
                            // Callback after animation
                            // Must change focus!
                            var $target = $(target);
                            $target.focus();
                            if ($target.is(":focus")) { // Checking if the target was focused
                                return false;
                            } else {
                                $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                                $target.focus(); // Set focus again
                            }
                            ;
                        });
                    }
                }

            });

        $("#contact_form").submit(function (evn) {
            // Inabilitamos el botón para prevenir múltiples envíos
            $("#submitButton").attr('disabled', true);
            evn.preventDefault();
            var jqxhr = $.post("inicio/contact", $("#contact_form").serialize())
                .done(function (data) {
                    $("#submitButton").attr('disabled', false);
                    var res = JSON.parse(data)
                    $("#myModal-content").html("<p>Debes estar súper atento(a) pronto nos estaremos comunicando contigo<br><strong>¡Gracias por contactarnos!</strong></p>");
                    $("#myModal").modal('show');
                    if (res.answer) {
                        console.log("Success: Hubo un error al procesar el envío. Revisa la consola network para conocer los detalles");
                    }
                })
                .fail(function () {
                    console.log("Error: Hubo un error al procesar el envío. Revisa la consola network para conocer los detalles");
                })
                .always(function () {
                    console.log("Finish: Hubo un error al procesar el envío. Revisa la consola network para conocer los detalles");
                });
        });

        $("#register_form").submit(function (evn) {
            evn.preventDefault();
            var jqxhr = $.post("inicio/register", $("#register_form").serialize())
                .done(function (data) {
                    console.log("second success");
                    var res = JSON.parse(data)
                    if (res.answer) {
                        $("#myModal-content").html("<p>Debes estar súper atento(a) pronto nos estaremos comunicando contigo<br><strong>¡Registro Exitoso!</strong></p>");
                        $("#myModal").modal('show');
                    }
                })
                .fail(function () {
                    console.log("error");
                })
                .always(function () {
                    console.log("finished");
                });
        });

        $("#sticker_form").submit(function (evn) {
            evn.preventDefault();
            var jqxhr = $.post("inicio/sticker", $("#sticker_form").serialize())
                .done(function (data) {
                    console.log("second success");
                    var res = JSON.parse(data)
                    if (res.answer) {
                        var link = document.createElement("a");
                        link.download = "Stickers";
                        link.href = res.path_file;
                        link.click();
                        $("#myModal-content").html("<p>¡Felicidades! Ya haces parte de la comunidad que se preocupa por el cuidado del ambiente</p><br><img src='assets/images/logo.svg' style='width:264px; height:150px;'>");
                        $("#myModal").modal('show');
                    }
                })
                .fail(function () {
                    console.log("error");
                })
                .always(function () {
                    console.log("finished");
                });
        });

        ////hide Menu on click contacto mobile ////

        $("#hide-menu").click(function () {
            $(".nav-menu-mobile, .nav-menu-bg").hide();
        });

        //// Custom Scroll ////

        //jQuery('.scrollbar-chrome').scrollbar();
        jQuery('.scrollbar-dynamic').scrollbar();

    });

});


function imagenModal() {
    var pathImg = $("div#myCarousel-home").find("div.active").children("img").attr("src");
    $("#img-activa-home").attr("src", pathImg);
}