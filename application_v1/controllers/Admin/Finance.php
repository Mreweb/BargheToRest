<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Finance extends CI_Controller{
    private $loginInfo;
    private $enum;
    public function __construct(){
        parent::__construct();
        $this->loginInfo = getTokenInfo(true);
        $this->enum = $this->config->item('Enum');
        $this->load->model('admin/ModelFinance');
        $this->load->model('ModelPerson');
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

    public function get_order_by_order_id($order_id)
    {
        if (check_request_method('GET')) {
            $inputs = $this->input->get();
            $inputs = custom_filter_input($inputs); 
            $result = $this->ModelFinance->get_order_by_order_id($order_id);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }

    public function get_bill_orders($billGUID)
    {
        if (check_request_method('GET')) {
            $inputs = $this->input->get();
            $inputs = custom_filter_input($inputs); 
            $result = $this->ModelFinance->get_bill_orders($billGUID);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    


}