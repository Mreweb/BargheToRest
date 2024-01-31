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
        $this->load->model('admin/ModelFinance');
        $this->load->model('ModelPerson');
        $this->load->model('admin/ModelProvince');
    }

    public function index()
    {
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
                //$this->delete_bill();
                break;
            default:
                check_request_method('NONE');
                break;
        }
    }
    public function get_list()
    {
        if (check_request_method('GET')) {
            $inputs = $this->input->get();
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelBill->get_user_bill_list($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function get_by_id($id)
    {
        if (check_request_method('GET')) {
            $inputs = $this->input->get();
            $inputs = custom_filter_input($inputs);
            $result = $this->ModelBill->get_bill_by_id($id);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function get_by_guid($guid)
    {
        if (check_request_method('GET')) {
            $inputs = $this->input->get();
            $inputs = custom_filter_input($inputs);
            $result = $this->ModelBill->get_bill_by_guid($guid);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function get_all()
    {
        if (check_request_method('GET')) {
            $inputs = $this->input->get();
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelBill->get_user_all_bill_list($inputs);
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
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelBill->do_delete_bill($inputs);
            response($result, 200);
            die();
        }
    }
    public function active_bill()
    {
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelBill->do_active_bill($inputs);
            response($result, 200);
            die();
        }
    }
    public function add_legal_info()
    {
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputPersonId', 'شناسه کاربر', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelBill->do_add_legal_info($inputs);
                response($result, 200);
                die();
            }
        }
    }
    public function edit_legal_info()
    {
        if (check_request_method('PUT')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputPersonId', 'شناسه کاربر', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelBill->do_edit_legal_info($inputs);
                response($result, 200);
                die();
            }
        }
    }

    public function set_factor_type()
    {
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputPersonId', 'شناسه کاربر', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelBill->set_factor_type($inputs);
                response($result, 200);
                die();
            }
        }
    }
    
    public function power_data($guid)
    {
        if (check_request_method('GET')) {
            $inputs['guid'] = $guid;
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelBill->get_bill_power_data($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function sale_data($guid)
    {
        if (check_request_method('GET')) {
            $inputs['guid'] = $guid;
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelBill->get_bill_sale_data($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function avg_cons($numberId)
    {
        if (check_request_method('GET')) {
            $inputs['inputBillNumberId'] = $numberId;
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $result = $this->ModelBill->get_bill_avg_cons($inputs);
            response(get_req_message('SuccessAction', null, $result), 200);
        }
    }
    public function get_plans()
    {
        if (check_request_method('POST')) {

            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputBillGUID', 'شناسه قبض', 'trim|required');
            $this->form_validation->set_rules('inputShiftWorkId', 'شناسه شیفت کاری', 'trim|required');
            $this->form_validation->set_rules('inputTotalRequestKW', 'مجموع کیلووات درخواستی', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
            } else {
                $inputs['guid'] = $inputs['inputBillGUID'];
                $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
                $legalInfo = $this->ModelPerson->get_person_legal_info($inputs['inputPersonId'])[0];
                $inputs['tariff'] = $this->ModelProvince->get_province_tariff_list_by_province_id($legalInfo['LegalProvinceId']);
                $inputs['electricity_price'] = $this->ModelProvince->get_electricity_price();
                if (isset($inputs['electricity_price'][0])) {
                    $inputs['electricity_price'] = $inputs['electricity_price'][0];
                } else {
                    response(get_req_message('ErrorAction', null, array('message' => 'تعرفه برق در سیستم تعریف نشده است')), 200);
                    die();
                }
                $inputs['LegalInfo'] = $this->ModelPerson->get_person_legal_info($inputs['inputPersonId']);

                $inputs['todayDate'] = convertDate(time());
                $inputs['currentMonth'] = convertDate(time(), false, 'm');

                $result = $this->ModelBill->get_bill_plans($inputs);
                response(get_req_message('SuccessAction', null, $result), 200);
            }

        }
    }

    public function start_payment()
    {
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputOrderId', 'شناسه سفارش', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {

                $personInfo = $this->loginInfo;
                $order = $this->ModelFinance->get_order_by_order_id($inputs['inputOrderId']);
                if (empty($order['data']['content'])) {
                    response(get_req_message('ErrorAction', 'سفارش مورد نظر یافت نشد'), 400);
                    die();
                }
                if ($order['data']['content'][0]['Status'] != 'Pend' && $order['data']['content'][0]['Status'] != 'Failed') {
                    response(get_req_message('ErrorAction', 'سفارش قبلا پردازش شده است'), 400);
                    die();
                }
                $order = $order['data']['content'][0];
                $this->load->helper('payment/behpardakht/bpm');
                $p = new bpPayRequest();
                $p->terminalId = $this->config->item('TerminalId');
                $p->userName = $this->config->item('TerminaUserName');
                $p->userPassword = $this->config->item('TerminalPassword');
                $p->orderId = $order['OrderId'];
                $p->amount = $order['FinalPrice'];
                $p->localDate = date('Ymd');
                $p->localTime = date('His');
                $p->additionalData = "";
                $p->callBackUrl = 'https://pay.bargheto.com/Pay/pay_result';
                $p->payerId = 0;
                $c = new BPM();
                $bpPayRequestResponse = $c->bpPayRequest($p);
                if (isset($bpPayRequestResponse->return)) {
                    $res = explode(',', $bpPayRequestResponse->return);
                    $ResCode = $res[0];
                    if ($ResCode == "0") {
                        if ($order['data']['content'][0]['Status'] != 'Pend' && $order['data']['content'][0]['Status'] != 'Failed') {
                            response(get_req_message('SuccessAction', null, array(
                                'ResCode' => $res[1],
                                'OrderId' => $order['OrderId']
                            )), 200);
                            die();
                        }
                    } else {
                        response(get_req_message('ErrorAction', 'خطای اتصال به درگاه'), 400);
                        die();
                    }
                } else {
                    response(get_req_message('ErrorAction', 'خطای اتصال به درگاه'), 400);
                    die();
                }

            }
        }
    }

    public function choose_plan()
    {
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];

            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputPlanOrder', 'شماره پلن', 'trim|required');
            $this->form_validation->set_rules('inputBillGUID', 'شناسه قبض', 'trim|required');
            $this->form_validation->set_rules('inputShiftWorkId', 'شناسه شیفت کاری', 'trim|required');
            $this->form_validation->set_rules('inputTotalRequestKW', 'مجموع کیلووات درخواستی', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $inputs['guid'] = $inputs['inputBillGUID'];
                $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
                $legalInfo = $this->ModelPerson->get_person_legal_info($inputs['inputPersonId'])[0];
                $inputs['tariff'] = $this->ModelProvince->get_province_tariff_list_by_province_id($legalInfo['LegalProvinceId']);
                $inputs['electricity_price'] = $this->ModelProvince->get_electricity_price()[0];
                $inputs['LegalInfo'] = $this->ModelPerson->get_person_legal_info($inputs['inputPersonId']);

                $inputs['todayDate'] = convertDate(time());
                $inputs['currentMonth'] = convertDate(time(), false, 'm');
                $inputs['todayDate'] = convertDate(time(), false);
                $result = $this->ModelBill->choose_plan($inputs);
                response(get_req_message('SuccessAction', null, $result), 200);
            }
        }

    }
    public function choose_plan_green()
    {
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputPlanOrder', 'شماره پلن', 'trim|required');
            $this->form_validation->set_rules('inputBillGUID', 'شناسه قبض', 'trim|required');
            $this->form_validation->set_rules('inputShiftWorkId', 'شناسه شیفت کاری', 'trim|required');
            $this->form_validation->set_rules('inputTotalRequestKW', 'مجموع کیلووات درخواستی', 'trim|required');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $inputs['guid'] = $inputs['inputBillGUID'];
                $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
                $legalInfo = $this->ModelPerson->get_person_legal_info($inputs['inputPersonId'])[0];
                $inputs['tariff'] = $this->ModelProvince->get_province_tariff_list_by_province_id($legalInfo['LegalProvinceId']);
                $inputs['electricity_green_price'] = $this->ModelProvince->get_electricity_green_price();
                $inputs['LegalInfo'] = $this->ModelPerson->get_person_legal_info($inputs['inputPersonId']);

                $inputs['todayDate'] = convertDate(time());
                $inputs['currentMonth'] = convertDate(time(), false, 'm');
                $inputs['todayDate'] = convertDate(time(), false);
                $result = $this->ModelBill->choose_plan_green($inputs);
                if ($result == 0) {
                    response(get_req_message('ErrorAction', null, array(
                        'message' => 'کیلووات درخواستی بیشتر از موجودی برقتو می باشد'
                    )
                    ), 200);
                } else {
                    response(get_req_message('SuccessAction', null, $result), 200);
                }
            }
        }

    }


}