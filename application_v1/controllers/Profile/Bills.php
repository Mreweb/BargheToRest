<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Bills extends CI_Controller
{
    private $loginInfo;
    private $enum;
    public function __construct()
    {
        parent::__construct();
        $this->loginInfo = getTokenInfo(true);
        $this->enum = $this->config->item('Enum');
        $this->load->model('admin/ModelBill');
    }
    public function index(){
        switch ($this->input->server('REQUEST_METHOD')) {
            case 'GET':
                $this->get_list();
                break;
            case 'POST':
                $this->add_bill();
                break;
            case 'PUT':
                $this->edit_bill();
                break;
            case 'DELETE':
                $this->delete_bill();
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
            $result = $this->ModelBill->get_user_bill_list($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function add_bill()
    {
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputBillTitle', 'عنوان قبض', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputBillNumberId', 'شناسه قبض', 'trim|required|numeric|min_length[2]|max_length[50]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelBill->do_add_bill($inputs);
                response($result, 200);
                die();
            }
        }

    }
    public function edit_bill()
    {
        if (check_request_method('PUT')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputBillTitle', 'عنوان قبض', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputBillNumberId', 'شناسه قبض', 'trim|required|numeric|min_length[2]|max_length[50]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelBill->do_edit_bill($inputs);
                response($result, 200);
                die();
            }
        }

    }
    public function delete_bill()
    {
        if (check_request_method('DELETE')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelBill->do_delete_bill($inputs);
            response($result, 200);
            die();
        }
    }



    

}