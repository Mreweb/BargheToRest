<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Orders extends CI_Controller{
    private $loginInfo;
    private $enum;
    public function __construct(){  
        parent::__construct();
        $this->loginInfo = getTokenInfo(true);
        $this->enum = $this->config->item('Enum');
        $this->load->model('ModelPerson');
        $this->load->model('Admin/ModelBill');
        $this->load->model('Admin/ModelFinance');
    }
    public function index(){
        switch ($this->input->server('REQUEST_METHOD')) {
            case 'GET':
                $this->get_list();
                break;
            case 'POST':
                //$this->add_bill();
                break;
            case 'PUT':
                $this->edit_order();
                break;
            case 'DELETE':
                //$this->delete_bill();
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
            $result = $this->ModelFinance->get_orders_list($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }


    public function get_order_detail($orderId){
        if (check_request_method('GET')) { 
            $result = $this->ModelFinance->get_order_by_order_id($orderId);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }

    public function edit_order()
    {
         
        if (check_request_method('PUT')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputAdminPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputOrderId', 'شناسه سفارش', 'trim|required');
            $this->form_validation->set_rules('inputBillGUID', 'شناسه یکتای قبض', 'trim|required');
            $this->form_validation->set_rules('inputPersonId', 'شناسه فرد', 'trim|required');
            $this->form_validation->set_rules('inputStatus', 'وضعیت', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelFinance->do_edit_order($inputs);
                response($result, 200);
                die();
            }
        }
    }
    

}