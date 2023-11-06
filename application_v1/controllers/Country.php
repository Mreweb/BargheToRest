<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Country extends CI_Controller{
    public function __construct(){
        parent::__construct(); 
        $this->load->model('ModelCountry');
        $this->load->model('admin/ModelCountry');
    }
    public function get_province_list($id =null){
        if (check_request_method('GET')) {
            $result['data']['content'] = $this->ModelCountry->get_province_list($id);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function get_city_list($id =null) {
        if (check_request_method('GET')) {
            $result['data']['content'] = $this->ModelCountry->get_city_list($id);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function get_city_by_province_id($id =null) {
        if (check_request_method('GET')) {
            $result['data']['content'] = $this->ModelCountry->get_city_by_province_id($id);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }

    

}