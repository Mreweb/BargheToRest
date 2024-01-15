<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class ProvinceTariff extends CI_Controller{
    private $loginInfo;
    private $enum;
    public function __construct(){
        parent::__construct();
        $this->loginInfo = getTokenInfo(true);
        $this->enum = $this->config->item('Enum');
        $this->load->model('admin/ModelProvince');
    }
    public function index(){
        switch ($this->input->server('REQUEST_METHOD')) {
            case 'GET':
                break;
            case 'POST':
                break;
            case 'PUT':
                break;
            case 'DELETE':
                break;
            default:
                check_request_method('NONE');
                break;
        }
    }
    
    public function get_electricity_price(){
        if (check_request_method('GET')) { 
            $result = $this->ModelProvince->get_electricity_price();
            response($result, 200);
            die();
        }
    } 

    public function get_electricity_green_price(){
        if (check_request_method('GET')) { 
            $result = $this->ModelProvince->get_electricity_green_price();
            response($result, 200);
            die();
        }
    } 
    
    

}