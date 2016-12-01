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
$routes['ANY']['Welcome/Homer'] = 'Welcome/Home';
$routes['GET']['Welcome/Home2'] = 'Welcome/Get';
$routes['POST']['post/action'] = 'Welcome/Home';