<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$autoload['packages'] = array();
$autoload['libraries'] = array('session','database','form_validation','JDateTime','encryption' , 'Uuid','user_agent');
$autoload['drivers'] = array();
$autoload['helper'] = array('url','string','html','form','utility/security','utility/pipe','auth','utility/db','cookie');
$autoload['config'] = array('');
$autoload['language'] = array();
$autoload['model'] = array('ModelPerson','ModelProfile','ModelLog');
