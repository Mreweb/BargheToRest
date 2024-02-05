<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class CrawlToken extends CI_Controller{
    private $loginInfo;
    private $enum;
    public function __construct(){
        parent::__construct();
        $this->loginInfo = getTokenInfo(true  , 'ADMIN'); 
        $this->enum = $this->config->item('Enum');
        $this->load->model('admin/ModelCrawl');
    }
    public function index(){
        switch ($this->input->server('REQUEST_METHOD')) {
            case 'GET':
                $this->get_list();
                break;
            case 'POST':
                $this->add_token();
                break;
            default:
                check_request_method('NONE');
                break;
        }
    }
    public function get_list(){
        if (check_request_method('GET')) {
            $inputs = $this->input->get();
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelCrawl->get_list($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function add_token(){
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputToken', 'توکن', 'trim|required'); 
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                
                $result = $this->ModelCrawl->add_token($inputs);
                response($result, 200);
                die();
            }
        }

    }

}