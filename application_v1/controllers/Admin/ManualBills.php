<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class ManualBills extends CI_Controller
{
    private $loginInfo;
    private $enum;
    public function __construct(){
        parent::__construct();
        $this->loginInfo = getTokenInfo(true  , 'ADMIN'); 
        $this->enum = $this->config->item('Enum');
        $this->load->model('admin/ModelManualBill');
    }
    public function index()
    {
        switch ($this->input->server('REQUEST_METHOD')) {
            case 'POST':
                $this->add_manual_bill();
                break;
            case 'PUT':
                $this->edit_manual_bill();
                break;
            case 'DELETE':
                $this->delete_manual_bill();
                break;
            default:
                check_request_method('NONE');
                break;
        }
    }
    public function add_manual_bill()
    {
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputAdminPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputBillName', 'عنوان قبض', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputBillNumberCompany', 'شرکت', 'trim|required|numeric|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputBillNumberId', 'شناسه قبض', 'trim|required|numeric|min_length[2]|max_length[50]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelManualBill->do_add_manual_bill($inputs);
                response($result, 200);
            }
        }
    }

    public function edit_manual_bill()
    {
        if (check_request_method('PUT')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputAdminPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputBillName', 'عنوان قبض', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputBillNumberCompany', 'شرکت', 'trim|required|numeric|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputBillNumberId', 'شناسه قبض', 'trim|required|numeric|min_length[2]|max_length[50]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelManualBill->do_edit_manual_bill($inputs);
                response($result, 200);
            }
        }
    }
    public function delete_manual_bill()
    {
        if (check_request_method('DELETE')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputAdminPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelManualBill->do_delete_manual_bill($inputs);
            response($result, 200);
            die();
        }
    }

    public function recalculate_power_data()
    {
        if (check_request_method('PUT')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputAdminPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputBillNumberId', 'شناسه قبض', 'trim|required|numeric|min_length[2]|max_length[50]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelManualBill->do_recalculate_power_data($inputs);
                response($result, 200);
            }
        }
    }

    public function recalculate_sale_data()
    {
        if (check_request_method('PUT')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputAdminPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputBillNumberId', 'شناسه قبض', 'trim|required|numeric|min_length[2]|max_length[50]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelManualBill->do_recalculate_sale_data($inputs);
                response($result, 200);
            }
        }
    }

     
    

}