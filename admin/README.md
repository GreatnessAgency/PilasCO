
# Administrador de Contenido

CMS Basado en CodeIgniter 2.2.6, para la gestion de paginas web
  

## Instalacion

1. Debemos iniciar clonando el repositorio en el sitio donde lo vamos a instalar, o en su defecto en nuetro equipo para luego cargar el codigo al hosting

> git clone https://gitlab.com/zav_group/zav-internos/admin.git
  

2. Una vez que tengamos el codigo base para nuestro proyecto podemos usar el archivo db-inicial.sql para crear la base de datos

> db-inicial.sql
  

3. Luego de crear la base de datos y ejecutar las consultas para crear las tablas basicas para el administrador es hora de configurar.

Creamos una copia del archivo de *config_example.php* con el nombre *config.php*

>>>

* app/config/config_example.php

* app/config/config.php

>>>

4. Abrimos el nuevo archivo, en la linea 18 vamos a configurar la URL absoluta del proyecto que vamos a trabajar, si es local usamos la url local, si lo vamos a publicar debemos colocar la url donde el administrador va a quedar publicado

> 18: `$config['base_url'] = 'http:///admin.zavgroup.com/';`
  

5. En la linea 30 vamos a encontrar el nombre del proyecto que vamos a trabajar

> 30: `$config['project'] = 'ZAV Admin';`
  

5. Al finla del archivo vamos a agregar 2 lineas para la configuracion especifica del poyecto

* Url del sitio que administra, donde vamos a colocar la url sin el http o https, solo la url con doble '/' al inicio

>  `$config["pagina_url"] = "//www.zavgroup.com";`

* Como la instalacion del zav admin se realiza en el mismo hosting aqui vamos a colocar el path completo para la carga de archivos, los cuales deberian quedar en la misma carpeta donde se publica la pagina web.

>  `$config["upload_path"] = "/home/zavgroup/httpdocs/assets/files/";`
  

7. Usando el archivo *database_example.php* creamos una copia con el nombre *database.php*

>>>

* app/config/database_example.php

* app/config/database.php

>>>
  

8. Abrimos el archivo *database.php* para configurar los datos de conexion a la base de datos, en las lineas 51 a la 54 puede ver los datos que deben ser modificados

>>>

* 51 : `$db['default']['hostname'] = 'localhost';`

* 52 : `$db['default']['username'] = 'zav_web';`

* 53 : `$db['default']['password'] = 'clavesupersecreta';`

* 54 : `$db['default']['database'] = 'zav_web';`

>>>
  

9. Ingreso al administrador

Una vez realidadas estas actividades, ya podemos ingresar a nuestro administrador e iniciar a gestionar los contenidos

Ingresamos en la url que configuramos en el paso 4

> http://admin.zavgroup.com

Usamos los datos por defecto

> usuario: admin

> clave: admin

Ya podemos iniciar a usar el administrador ZAV