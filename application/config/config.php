<?php
/*
| -------------------------------------------------------------------
| HEADER 
| -------------------------------------------------------------------
| This file specifies config information like Header scripts, stylesheets
| metas, title.
|
| 
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the header things you can configure:
|
| 1. Script
| 2. Css
| 3. Meta
| 4. Title
|
|
| Prototypes:
| $headers['script'] = array('/js/jquery.js','/js/bootstrap.js')
| $headers['css'] = array('/css/bootstrapp.css','/css/main.css')
| $headers['meta'] = array('<meta charset="utf-8">')
| $headers['title'] = 'Site title'
*/

$headers['script'] = array('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
$headers['css'] = array('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css','https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
$headers['title'] = 'Test title';
$headers['meta'] = array('<meta charset="utf-8">');



/*
| -------------------------------------------------------------------
| DATABASE 
| -------------------------------------------------------------------
| This file specifies config information for the database
|
| 
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['HOSTNAME'] The hostname of your database server.
|	['DBUSERNAME'] The username used to connect to the database
|	['DBPASSWORD'] The password used to connect to the database
|	['DBNAME'] The name of the database you want to connect to
|	['DBTYPE'] The database driver. e.g.: mysql.
|			Currently supported:
|				 mssql, mysql, oci8,
|			
*/
define('DBTYPE','mysql');
define('HOSTNAME','localhost');
define('DBNAME','transitionmvc');
define('DBUSERNAME','root');
define('DBPASSWORD','123456');