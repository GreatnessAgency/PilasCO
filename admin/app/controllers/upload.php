<?php

class Upload extends Ext_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn();
        $this->setCurrentUser();
        ini_set('memory_limit', '256M');
        $this->tmp = "tmp/";
        $this->tmp_dir = APPPATH . "assets/tmp/";
    }

    public function upload_img($width, $height, $id)
    {
        $this->tp['extra'] = '';
        $this->tp['error'] = '';
        $this->tp['width'] = $width;
        $this->tp['height'] = $height;
        $this->tp['id'] = $id;
        //si post files
        if ($_FILES) {
            $config['upload_path'] = $this->tmp_dir;
            $config['allowed_types'] = 'jpg|png|gif';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload()) {
				//Cuando el archivo no sube
                $this->tp['extra'] = '<script src="' . $this->tp['template'] . 'js/jquery.js"></script><script>setTimeout(function(){$("#message").slideDown(400)}, 100); setTimeout(function(){$("#message").slideUp(400)}, 4000);</script><style>#message{text-align:center; border:1px solid #CD0000; background:#FFEEEE; width:250px; color:#CD0000; display:none; margin:3px 0;}</style>';
                $this->tp['error'] = "<div id=\"message\">" . $this->upload->display_errors() . "</div>";
            } else {
                //busco la informacion de la imagen subida
                $img_info = getimagesize($this->tmp_dir . $this->upload->file_name);
                $ancho = $img_info[0];
                $alto = $img_info[1];
                //
                $anchura = $ancho;
                $altura = $alto;
                //
                if ($width == 'scale' && $height != 'scale') {
                    //calculos porcentajes ancho
                    $porcent = $height / $alto;
                    $ancho *= $porcent;
                    $width = $ancho;
                }
                if ($width != 'scale' && $height == 'scale') {
                    //calculos porcentajes alto
                    $percentage = $width / $ancho;
                    $alto *= $percentage;
                    $height = $alto;
                }
                if ($width == 'scale' && $height == 'scale') {
                    $width = $ancho;
                    $height = $alto;
                }

                if ($anchura < $width) {
                    $width = $anchura;
                    $height = $altura;
                }

                //Image Resizing
                $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                $config['maintain_ratio'] = false;
                $config['width'] = $width;
                $config['height'] = $height;
                $this->load->library('image_lib', $config);
                if (!$this->image_lib->resize()) {
                    $this->tp['extra'] = '<script src="' . $this->tp['template'] . 'js/jquery.js"></script><script> alert("El sistema ha devuelto un error al intentar cargar el archivo, la respuesta es: \r\n ' . strip_tags($this->upload->display_errors()) . '"); </script>';
                } else {
                    //-----------------------//
                    $ind = explode('_', $id);
                    $guion = strrpos($ind[0], "-");
                    $thumb = "";
                    $func = "";
                    if ($guion === false) {
                        //no tiene guion
                        $thumb = '#' . $ind[0] . '_div .thumbnail';
                    } else {
                        //si el ind2[1] no es un valor numerico entoces thumb buscara un _div si o es entonces buscara un clon _ind2[1]
                        $ind2 = explode('-', $ind[0]);
                        if (is_numeric($ind2[1]) != true) {
                            //no es numerico
                            $thumb = '#' . $ind[0] . '_div .thumbnail';
                        } else {
                            //es numerico
                            $thumb = '#clone_' . $ind2[1] . ' .thumbnail';
                            $func = 'window.parent.addImage( ' . $ind2[1] . ' );';
                        }
                    }
                    $imagen = $this->upload->file_name;
                    $imagen_url = $this->tp['template'] . $this->tmp . $imagen;

                    $this->tp['extra'] = '
				<script src="' . $this->tp['template'] . 'js/jquery.js"></script>
				<script>
					$("#' . $id . '", top.document ).val( "' . $imagen . '" );
					$("' . $thumb . '", top.document ).attr( "src", "' . $imagen_url . '?t=' . time() . '" );
					' . $func . '
				</script>';
                }
            }
        }
        $this->load->view('inc/upload_img', $this->tp);
    }

    public function upload_multiple_imgs($width, $height = "scale", $dup = "", $assing = "")
    {
        $this->load->library('image_lib');

        $this->tp['extra'] = '';

        $this->tp['error'] = '';

        $this->tp['width'] = $width;

        $this->tp['height'] = $height;

        $this->tp['dup'] = $dup;

        $this->tp['assing'] = $assing;
        $files = array();
        $tipos = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/bmp');
        if ($_FILES) {
            $names = $_FILES["file"]["name"];
            $types = $_FILES["file"]["type"];
            $tmp_names = $_FILES["file"]["tmp_name"];
            $errors = $_FILES["file"]["error"];
            $sizes = $_FILES["file"]["size"];
            //loop filenames
            foreach ($names as $key => $file) {
                //variables
                $files[$key] = (object) array();
                $size = ($sizes[$key] / 1024) / 1024;
                $max_size = intval(substr(ini_get('upload_max_filesize'), 0, -1));
                $type_files = in_array($types[$key], $tipos);
                $files[$key]->archivo = $file;
                //validaciones
                if ($type_files && $size < $max_size) {
                    if ($errors[$key] <= 0) {
                        $file_name = $file;
                        //    if (file_exists($this->tmp_dir . $file)){
                        //si el archivo ya existe genera un nombre con un numero aleatorio
                        $name = explode(".", $file);
                        $ext = end($name);
                        unset($name[count($name) - 1]);
                        $file_name = implode($name) . '-' . rand(1, 99) . '.' . $ext;
                        $files[$key]->archivo = $file_name;
                        //      }
                        //mover el archivo subido
                        move_uploaded_file($tmp_names[$key], $this->tmp_dir . $file_name);
                        //si el archivo exite en la carpeta tmp entoces empieza la reescala
                        if (file_exists($this->tmp_dir . $file_name)) {
                            //busco la informacion de la imagen subida
                            $img_info = getimagesize($this->tmp_dir . $file_name);
                            $ancho = $img_info[0];
                            $alto = $img_info[1];

                            $anchura = $ancho;
                            $altura = $alto;

                            if ($width == 'scale' && $height != 'scale') {
                                //calculos porcentajes ancho
                                $porcent = $height / $alto;
                                $ancho *= $porcent;
                                $width = $ancho;
                            }
                            if ($width != 'scale' && $height == 'scale') {
                                //calculos porcentajes alto
                                $percentage = $width / $ancho;
                                $alto *= $percentage;
                                $height = $alto;
                            }
                            if ($width == 'scale' && $height == 'scale') {
                                $width = $ancho;
                                $height = $alto;
                            }

                            if ($anchura < $width) {
                                $width = $anchura;
                                $height = $altura;
                            }

                            //Image Resizing
                            $config['source_image'] = $this->tmp_dir . $file_name;
                            $config['maintain_ratio'] = false;
                            $config['width'] = $width;
                            $config['height'] = $height;

                            $this->image_lib->initialize($config);
                            if ($this->image_lib->resize()) {
                                //exito
                                $this->image_lib->clear();
                                $files[$key]->status = '1';
                                $files[$key]->reporte = 'Archivo subido con &exito;xito';
                            } else {
                                $this->image_lib->clear();
                                $files[$key]->status = '0';
                                $files[$key]->reporte = 'Error al reescalar la imagen.';
                            }
                        } else {
                            $files[$key]->status = '0';
                            $files[$key]->reporte = 'Error al copiar el archivo.';
                        }
                    } else {
                        $files[$key]->status = '0';
                        $files[$key]->reporte = 'Error al subir el archivo.';
                    }
                } else {
                    $files[$key]->status = '0';
                    $files[$key]->reporte = 'No es un archivo valido o supera los ' . $max_size . 'Mb.';
                }
            }

        } //fin if post

        if (count($files) > 0) {
            $cloneto = ($dup != "") ? ', "' . $dup . '", "' . $assing . '"' : "";

            $this->tp['extra'] = '
			<script type="text/javascript">
				window.parent.listarImgs( ' . json_encode($files) . ', "' . $this->tp['template'] . $this->tmp . '"' . $cloneto . ');
			</script>';

        }

        $this->load->view('inc/upload_multiple_imgs', $this->tp);

    }

    public function upload_file($tipo, $id)
    {

        $this->tp['extra'] = '';

        $this->tp['error'] = '';

        $this->tp['tipo'] = $tipo;

        $this->tp['id'] = $id;

        if ($_FILES) {
            $tipes = str_replace('-', '|', $tipo);
            $config['upload_path'] = $this->tmp_dir;
            $config['allowed_types'] = $tipes;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $this->tp['extra'] = '<script src="' . $this->tp['template'] . 'js/jquery.js"></script>
        	<script> alert("El sistema ha devuelto un error al intentar cargar el archivo, la respuesta es: \r\n ' . strip_tags($this->upload->display_errors()) . '"); </script>';
            } else {
                //-----------------------//
                $ind = explode('_', $id);
                $guion = strrpos($ind[0], "-");
                $thumb = "";
                if ($guion === false) {
                    //no tiene guion
                    $thumb = '#' . $ind[0] . '_div .thumbnail';
                } else {
                    //si el ind2[1] no es un valor numerico entoces thumb buscara un _div si o es entonces buscara un clon _ind2[1]
                    $ind2 = explode('-', $ind[0]);
                    if (is_numeric($ind2[1]) != true) {
                        //no es numerico
                        $thumb = '#' . $ind[0] . '_div .thumbnail';
                    } else {
                        //es numerico
                        $thumb = '#clone_' . $ind2[1] . ' .thumbnail';
                    }
                }

                $file = $this->upload->file_name;
                $exte = $this->upload->file_ext;
                $file_url = $this->tp['template'] . 'images/filetypes/file' . $exte . '.png';

                $this->tp['extra'] = '
			<script src="' . $this->tp['template'] . 'js/jquery.js"></script>
			<script>
				parent.document.getElementById("' . $id . '").value = "' . $file . '";
				$("' . $thumb . '", top.document ).attr( "src", "' . $file_url . '" );
			</script>';
            }

        } //fin if post

        $this->load->view('inc/upload_file', $this->tp);

    }

    public function upload_files_dup($tipo, $id)
    {
        //usar este metodo cuando los items son duplicados con dupAndAsing
        $this->upload_file($tipo, $id, $clone = false);
    }

}
