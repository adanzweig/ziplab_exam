<?php
/*
| -------------------------------------------------------------------
| AUTO-LOADER
| -------------------------------------------------------------------
| This file specifies which systems should be loaded by default.
|
| In order to keep the framework as light-weight as possible only the
| absolute minimal resources are loaded by default.
|
| -------------------------------------------------------------------
| Instructions
| -------------------------------------------------------------------
|
| These are the things you can load automatically:
|
| 1. Libraries
| 2. Models
|
|
| Prototypes:
| $loader['core'] = array('session') 
| $loader['libraries'] = array('newLib')
| $loader['models'] = array('newModel')
*/

$loader['core'] = array('session');
$loader['models'] = array('contactsModel','emailsModel','phonesModel','usersModel');