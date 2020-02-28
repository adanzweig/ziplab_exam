<?php
/*
| -------------------------------------------------------------------
| ALTERNATIVE ROUTES
| -------------------------------------------------------------------
| This file specifies the alternative routes.
|
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the requests you can get:
|
| 1. GET
| 2. POST
| 3. PUT
| 4. HEAD
| 5. DELETE
| 6. OPTIONS
| 7. ANY - All of the above
|
|
| Prototypes:
| $routes['ANY']['Welcome/Home'] = 'Welcome/Index'
| $router['POST']['Welcome/Index'] = 'Welcome/Post'
| .
| .
| .
*/

$routes = array();
$routes['GET']['contacts/get'] = 'Contacts/index';
$routes['GET']['contacts/search'] = 'Contacts/search';
$routes['GET']['contacts'] = 'Contacts/index';
$routes['GET']['contacts/getOne/[0-9]*'] = 'Contacts/getOne';
$routes['GET']['contacts/photos/[0-9]*'] = 'Contacts/photos';
$routes['POST']['contacts'] = 'Contacts/create';
$routes['PUT']['contacts/[0-9]*'] = 'Contacts/addPE';
$routes['PATCH']['contacts/[0-9]*'] = 'Contacts/update';
$routes['DELETE']['contacts/[0-9]*'] = 'Contacts/delete';

$routes['POST']['register'] = 'Users/register';
$routes['POST']['login'] = 'Users/login';