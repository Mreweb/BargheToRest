<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$autoload['packages'] = array();
/* دریافت کتابخانه های مورد نیاز در سراسر پروژه */
$autoload['libraries'] = array('session','database','form_validation','JDateTime','encryption' , 'Uuid');
$autoload['drivers'] = array();
/* دریافت توابع مورد نیاز در سراسر پروژه */
$autoload['helper'] = array('url','string','security','html','form','utility/security','utility/pipe','utility/db','cookie');
$autoload['config'] = array('');
$autoload['language'] = array();
$autoload['model'] = array();
