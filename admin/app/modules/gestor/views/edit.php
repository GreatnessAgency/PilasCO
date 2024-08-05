<?php $cont = 1; ?>
<?php if (isset($alert)): ?>
    <div id="message"><?= $alert ?></div><?php endif ?>
<script type="text/javascript">
    var cont = 0;
    var tot = 1;

    function enviarZavForm(form) {
        ak_validate(form, {
            ajax: '<?=$site_url?><?=$controller;?>/edit/<?=$module->id . '/' . $shared . '/' . $lang;?>'
            , func: function (obj) {
                //
                LoadContent('#main', '<?=$site_url;?>', obj.params, function () {
                    Mitab('<?=$site_url?>', '<?=$controller;?>', 1)
                });
            }
        });
        return false;
    };

</script>
<form name="ZavForm" onsubmit="return enviarZavForm(this); return false;" method="post">
    <div id="general">
        <div>&nbsp;</div>
        <div class="title"><?= $titulo; ?></div>
        <div>&nbsp;</div>
        <div class="tasks">
            <div class="filter" style="padding-top:5px">
                <label><b><?php echo $acto . ' ' . $contenido; ?></b></label>
            </div>
            <div class="back">
                <?php $borrar = ($modo == 'Crear') ? $items[0]->shared : "";
                if ($module->content == 'multiple') { ?>
                    <a href="#"
                       onclick="LoadContent( '#main', '<?= $site_url; ?>', '<?= $controller; ?>/index/<?= $module->id . '/0/' . $lang . '/' . $borrar; ?>' )">
                        <img src="<?= $template; ?>images/back.png" alt="Regresar" title="Regresar"/> Regresar al
                        listado
                    </a>
                <?php } ?>
            </div>
            <div class="pages">
                <img src="<?= $template; ?>images/info.png" alt="Modo Agregar" title="Modo Agregar"/>
                <label>Esta en modo <?php echo $modo; ?></label>
            </div>
        </div>
        <div class="content2" style="background:#<?php echo $color; ?>">
            <?php if (@$all_langs > 1){ ?>
            <div class="lang">
                <div class="row">
                    <div class="form-content">
                        <div class="txt-content">Agregar Idioma:</div>
                        <select class="lev1 input"
                                onchange="if(this.value != '') addTab(this,'#tabs')" <?= (count($langs) == 0) ? 'disabled="disabled"' : '' ?>>
                            <option>Seleccione...</option>
                            <?php foreach ($langs as $l): ?>
                                <option value="<?= $l->value; ?>"><?= $l->name; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="row" style="display:none">
                    <div style="float:left">
                        <select class="lev2">
                            <?php foreach ($items as $ls): ?>
                                <option value="<?= $ls->lang_id; ?>"><?= $ls->lang_name; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
        <!-- Cierro lang -->
            <div>&nbsp;</div>
            <div id="tabs">
                <ul>
                    <?php foreach ($items as $key => $i): ?>
                        <li>
                            <a href="#tabs-<?= $i->lang_id; ?>">
                                <?= $i->lang_name; ?>
                            </a>
                            <?php if ($key != 0): ?><span class="ui-icon ui-icon-close">Remove Tab</span><?php endif ?>
                        </li>
                    <?php endforeach ?>
                </ul>
                <?php } ?>
                <?php foreach ($items as $key => $i) { ?>
                    <div id="tabs-<?= $i->lang_id; ?>">
                        <input type="hidden" name="_Idioma[]" value="<?= $i->lang_id; ?>"/>
                        <input type="hidden" name="_idItem[]" class="eid" value="<?= $i->id; ?>"/>
                        <?php if ($key == 0) {
                            $id = $i->id;
                            $status = $i->status_id;
                            /*estado del item key 0 usado para replicarlo en los idiomas nuevos*/
                        } ?>
                        <div class="row">
                            <?php echo $i->template; ?>
                        </div>
                    </div>
                    <!-- end tab <?= @$i->lang; ?> -->
                <?php }//end foreach?>
                <?php if (@$all_langs > 1){ ?>
            </div>
            <!-- end tabs -->
        <?php } ?>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div class="row">
                <?php
                if ($user->rol_id == 0 || @$this->permisos->pub == 't') {
                    if ($module->content == 'unico') { ?>
                        <div class="col-sm-2">
                            <input type="hidden" name="status_id" value="publico"/>
                        </div>
                        <div class="col-sm-2">&nbsp;</div>
                    <?php } else {
                        if ($modo == 'Crear') { ?>
                            <div class="col-sm-2">
                                <input type="hidden" name="status_id" value="oculto"/>
                            </div>
                            <div class="col-sm-2">&nbsp;</div>
                        <?php } else { ?>
                            <div class="col-sm-2">Estado del contenido:</div>
                            <div class="col-sm-2">
                                <select name="status_id" class="input">
                                    <option value="publico" <?php echo ($status == 'publico') ? 'selected="selected"' : ""; ?>>
                                        Publico
                                    </option>
                                    <option value="oculto" <?php echo ($status == 'oculto') ? 'selected="selected"' : ""; ?>>
                                        Oculto
                                    </option>
                                </select>
                            </div>
                        <?php }
                    }
                } ?>
                <div class="col-sm-2">&nbsp;</div>
                <div class="col-sm-6">
                    <div class="actions">
                        <a href="#!" class="btn"
                           onclick="LoadContent( '#main', '<?= $site_url ?>', '<?= $controller ?>/index/<?= $module->id . '/0/' . $lang . '/' . $borrar; ?>', function(){ Mitab('<?= $site_url ?>', 'gestor', 1); });">
                            <img src="<?= $template ?>images/cancel.png" alt="Cancelar" title="Cancelar"/> Cancelar
                        </a>
                        <button class="btn">
                            <img src="<?= $template ?>images/ok.png"
                                 title="<?php echo $boton . ' ' . $contenido ?>"/> <?php echo $boton; ?>
                        </button>
                    </div>
                </div>
            </div>
            <div class="spacer">&nbsp;</div>
        </div>
        <!-- end content2 -->
    </div>
    <!-- end general -->
</form>
<!-- Inicio tabs CLON -->

<!-- Fin tabs CLON -->
<?php include(APPPATH . 'modules/' . $controller . '/views/divs-dup.php'); ?>
