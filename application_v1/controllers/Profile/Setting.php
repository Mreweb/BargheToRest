<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'helpers/cors.php';
class Setting extends CI_Controller
{
    private $loginInfo;
    private $enum;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ModelAccount');
        $this->load->model('ModelCountry');
        $this->loginInfo = getTokenInfo(true);
        $this->enum = $this->config->item('Enum');
    }
    public function change_user_info()
    {
        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputFirstName', 'نام', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputLastName', 'نام خانوادگی', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputNationalCode', 'کد ملی', 'trim|required|min_length[10]|max_length[10]');
            $this->form_validation->set_rules('inputAddress', 'آدرس ', 'trim|required|min_length[5]|max_length[150]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelProfile->do_change_info($inputs);
                response($result, 200);
                die();
            }
        }

    }
    public function change_user_legal_info()
    {


        if (check_request_method('POST')) {
            $inputs = json_decode($this->input->raw_input_stream, true);
            $inputs = custom_filter_input($inputs);
            $inputs['inputPersonId'] = $this->loginInfo['Info']['PersonId'];
            $this->form_validation->set_data($inputs);
            $this->form_validation->set_rules('inputLegalOrganizationName', 'نام سازمان', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputLegalFinanceCode', 'کد اقتصادی', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('inputLegalCompanyId', 'شناسه ملی', 'trim|required|min_length[1]|max_length[50]');
            $this->form_validation->set_rules('inputLegalRegisterNumber', 'شناسه ثبت', 'trim|required|min_length[1]|max_length[50]');
            $this->form_validation->set_rules('inputLegalPhone', 'تلفن ثابت دفتر مرکزی', 'trim|required|min_length[4]|max_length[50]');
            $this->form_validation->set_rules('inputLegalProvinceId', 'استان', 'trim|required|numeric');
            $this->form_validation->set_rules('inputLegalCityId', 'شهر', 'trim|required|numeric');
            $this->form_validation->set_rules('inputLegalAddress', 'آدرس', 'trim|required|min_length[5]|max_length[150]');
            if ($this->form_validation->run() == FALSE) {
                response(get_req_message('ErrorAction', validation_errors()), 400);
                die();
            } else {
                $result = $this->ModelProfile->do_change_user_legal_info($inputs);
                response($result, 200);
                die();
            }
        }

    }
    
    public function doSubmitNewPhone()
    {
        $inputs = $this->input->post(NULL, TRUE);
        $inputs = array_map(function ($v) {
            return strip_tags($v);
        }, $inputs);
        $inputs = array_map(function ($v) {
            return remove_invisible_characters($v);
        }, $inputs);
        $inputs = mapArray('makeSafeInput', $inputs);

        if ($this->loginInfo['PersonPhone'] == $inputs['inputPhone']) {
            $arr = array(
                'success' => false,
                'type' => "red",
                'content' => "شماره جدید تکراری ست"
            );
            echo json_encode($arr);
            die();
        }

        /*if ($this->session->userdata('CSRF') !== $inputs['inputCSRF']) {
            $arr = array(
                'type' => "red",
                'content' => "درخواست نامعتبر است"
            );
            echo json_encode($arr);
            die();
        }*/

        $this->session->set_userdata('PersonPhone', $inputs['inputPhone']);

        $inputs['inputPersonId'] = $this->loginInfo['PersonId'];
        $inputs['inputPhone'] = $this->session->userdata('PersonPhone');
        $result = $this->ModelAccount->doSubmitNewPhone($inputs);
        /* Log Action */
        $logArray = getVisitorInfo();
        $logArray['Action'] = $this->router->fetch_class() . "_" . $this->router->fetch_method();
        $logArray['Description'] = json_encode($inputs);
        $logArray['LogPersonId'] = $this->loginInfo['PersonId'];
        $this->ModelLog->doAdd($logArray);
        /* End Log Action */
        echo json_encode($result);

    }
    public function doVerifyNewPhone()
    {
        $inputs = $this->input->post(NULL, TRUE);
        $inputs = array_map(function ($v) {
            return strip_tags($v);
        }, $inputs);
        $inputs = array_map(function ($v) {
            return remove_invisible_characters($v);
        }, $inputs);
        $inputs = mapArray('makeSafeInput', $inputs);
        /* if ($this->session->userdata('CSRF') !== $inputs['inputCSRF']) {
             $arr = array(
                 'type' => "red",
                 'content' => "درخواست نامعتبر است"
             );
             echo json_encode($arr);
             die();
         }*/

        if ($this->session->userdata('ActivationCode') !== $inputs['inputVerifyCode']) {
            $arr = array(
                'type' => "red",
                'content' => "کد تاییدیه نامعتبر است"
            );
            echo json_encode($arr);
            die();
        }

        $inputs['inputPhone'] = $this->session->userdata('PersonPhone');
        $inputs['inputPersonId'] = $this->loginInfo['PersonId'];
        $result = $this->ModelAccount->doVerifyNewPhone($inputs);
        /* Log Action */
        if ($result['success']) {
            $logArray = getVisitorInfo();
            $logArray['Action'] = $this->router->fetch_class() . "_" . $this->router->fetch_method();
            $logArray['Description'] = json_encode($inputs);
            $logArray['LogPersonId'] = $this->loginInfo['PersonId'];
            $this->ModelLog->doAdd($logArray);
        }
        /* End Log Action */

        echo json_encode($result);
    }
    public function doAddAddress()
    {
        $inputs = $this->input->post(NULL, TRUE);
        /*if ($this->session->userdata('CSRF') !== $inputs['inputCSRF']) {
            $arr = array(
                'type' => "red",
                'content' => "درخواست نامعتبر است"
            );
            echo json_encode($arr);
            die();
        }*/
        $inputs['inputPersonId'] = $this->loginInfo['PersonId'];
        $inputs = array_map(function ($v) {
            return strip_tags($v);
        }, $inputs);
        $inputs = array_map(function ($v) {
            return remove_invisible_characters($v);
        }, $inputs);
        $inputs = array_map(function ($v) {
            return makeSafeInput($v);
        }, $inputs);
        $result = $this->ModelProfile->doAddAddress($inputs);
        /* Log Action */
        if ($result['success']) {
            $logArray = getVisitorInfo();
            $logArray['Action'] = $this->router->fetch_class() . "_" . $this->router->fetch_method();
            $logArray['Description'] = json_encode($inputs);
            $logArray['LogPersonId'] = $this->loginInfo['PersonId'];
            $this->ModelLog->doAdd($logArray);
        }
        /* End Log Action */

        echo json_encode($result);

    }
    public function doEditAddress()
    {
        $inputs = $this->input->post(NULL, TRUE);
        /*if ($this->session->userdata('CSRF') !== $inputs['inputCSRF']) {
            $arr = array(
                'type' => "red",
                'content' => "درخواست نامعتبر است"
            );
            echo json_encode($arr);
            die();
        }*/
        $inputs['inputPersonId'] = $this->loginInfo['PersonId'];
        $inputs = array_map(function ($v) {
            return strip_tags($v);
        }, $inputs);
        $inputs = array_map(function ($v) {
            return remove_invisible_characters($v);
        }, $inputs);
        $inputs = array_map(function ($v) {
            return makeSafeInput($v);
        }, $inputs);
        $result = $this->ModelProfile->doEditAddress($inputs);
        /* Log Action */
        if ($result['success']) {
            $logArray = getVisitorInfo();
            $logArray['Action'] = $this->router->fetch_class() . "_" . $this->router->fetch_method();
            $logArray['Description'] = json_encode($inputs);
            $logArray['LogPersonId'] = $this->loginInfo['PersonId'];
            $this->ModelLog->doAdd($logArray);
        }
        /* End Log Action */

        echo json_encode($result);

    }
    public function doDeleteAddress()
    {
        $inputs = $this->input->post(NULL, TRUE);
        /*if ($this->session->userdata('CSRF') !== $inputs['inputCSRF']) {
            $arr = array(
                'type' => "red",
                'content' => "درخواست نامعتبر است"
            );
            echo json_encode($arr);
            die();
        }*/
        $inputs['inputPersonId'] = $this->loginInfo['PersonId'];
        $inputs = array_map(function ($v) {
            return strip_tags($v);
        }, $inputs);
        $inputs = array_map(function ($v) {
            return remove_invisible_characters($v);
        }, $inputs);
        $inputs = array_map(function ($v) {
            return makeSafeInput($v);
        }, $inputs);
        $result = $this->ModelProfile->doDeleteAddress($inputs);
        /* Log Action */
        if ($result['success']) {
            $logArray = getVisitorInfo();
            $logArray['Action'] = $this->router->fetch_class() . "_" . $this->router->fetch_method();
            $logArray['Description'] = json_encode($inputs);
            $logArray['LogPersonId'] = $this->loginInfo['PersonId'];
            $this->ModelLog->doAdd($logArray);
        }
        /* End Log Action */

        echo json_encode($result);

    }
}