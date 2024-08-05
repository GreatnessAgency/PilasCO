<?php 

if($_SESSION["verify"] != "FileManager4TinyMCE") die('forbidden');



$root = rtrim($_SERVER['DOCUMENT_ROOT'],'/'); // don't touch this configuration



//**********************

//Path configuration

//**********************

// In this configuration the folder tree is

// root

//   |- tinymce

//   |    |- source <- upload folder

//   |    |- js

//   |    |   |- tinymce

//   |    |   |    |- plugins

//   |    |   |    |-   |- filemanager

//   |    |   |    |-   |-      |- thumbs <- folder of thumbs [must have the write permission]





//directorio actual desde el root qutandole el document root que es antes del root publico

$direct = substr( __DIR__, strlen($_SERVER['DOCUMENT_ROOT']));

//al residuo se le recorta todo lo que este despues de zav_admin... si esta en local quedara la carpeta del proyecto, si esta arriba puede que quede solo barra (/)

$direct = substr($direct, 0, strpos($direct, 'zav_admin'));



$base_url = '//sfa.com.co'; //url base of site if you want only relative url leave empty

$upload_dir =  $direct.'site/files/'; //'/dividendo/site/files/'; // path from base_url to upload base dir

$current_path = '../../../../../../site/files/'; // relative path from filemanager folder to upload files folder



$MaxSizeUpload=100; //Mb



//**********************

//Image config

//**********************

//set max width pixel or the max height pixel for all images

//If you set dimension limit, automatically the images that exceed this limit are convert to limit, instead

//if the images are lower the dimension is maintained

//if you don't have limit set both to 0

$image_max_width=0;

$image_max_height=0;



//Automatic resizing //

//If you set true $image_resizing the script convert all images uploaded in image_width x image_height resolution

//If you set width or height to 0 the script calcolate automatically the other size

$image_resizing=false;

$image_width=600;

$image_height=0;



//******************

//Permits config

//******************

$delete_file=true;

$create_folder=true;

$delete_folder=true;

$upload_files=true;





//**********************

//Allowed extensions

//**********************

$ext_img = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff'); //Images

$ext_file = array('doc', 'docx', 'pdf', 'xls', 'xlsx', 'txt', 'csv','html','psd','sql','log','fla','xml','ade','adp','ppt','pptx'); //Files

$ext_video = array('mov', 'mpeg', 'mp4', 'avi', 'mpg','wma'); //Videos

$ext_music = array('mp3', 'm4a', 'ac3', 'aiff', 'mid'); //Music

$ext_misc = array('zip', 'rar','gzip'); //Archives





$ext=array_merge($ext_img, $ext_file, $ext_misc, $ext_video,$ext_music); //allowed extensions



?>