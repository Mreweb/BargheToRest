<?php

use MiladRahimi\Jwt\Generator;
use MiladRahimi\Jwt\Parser;
use MiladRahimi\Jwt\Cryptography\Algorithms\Hmac\HS256;
use MiladRahimi\Jwt\Exceptions\ValidationException;
use MiladRahimi\Jwt\Validator\DefaultValidator;
use MiladRahimi\Jwt\Validator\Rules\EqualsTo;
use MiladRahimi\Jwt\Validator\Rules\NewerThan;
class ModelAccount extends CI_Model{
    public function do_submit_phone($inputs){
        $code = randomString('nozero',4);
        $url = 'https://api.kavenegar.com/v1/'.getSMSAPI().'/verify/lookup.json?receptor='.$inputs['inputPhone'].'&token='.$code.'&template=MobileVerification&type=sms';      
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_exec($curl);
        curl_close($curl);
        $this->session->set_userdata('PersonPhone',$inputs['inputPhone']);
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(array('PersonPhone' => $inputs['inputPhone']));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $result = $query->result_array()[0];
            $userArray = array('ActivationCode' => $code);
            $this->db->where('PersonId', $result['PersonId']);
            $this->db->update('person', $userArray);
            return get_req_message('SuccessAction' , "کد تایید ارسال شد" , ['personId' => $result['PersonId']] );
        }
        else{
            $userArray = array(
                'PersonPhone' => $inputs['inputPhone'],
                'Password' => md5($inputs['inputPhone']),
                'ActivationCode' => $code,
                'CreateDateTime' => time(),
                'ModifyDatetime' => time()
            );
            $this->db->insert('person', $userArray);
            $personId = $this->db->insert_id();
            $userArray = array(
                'PersonId' => $personId,
                'AccountBalance' => 0,
                'CreateDateTime' => time(),
                'CreatePersonId' => $personId
            );
            $this->db->insert('person_account_balance', $userArray);

            $userArray = array(
                'PersonId' => $personId,
                'CreateDateTime' => time(),
                'CreatePersonId' => $personId
            );
            $this->db->insert('person_legal_info', $userArray);

            return get_req_message('SuccessAction' , "کد تایید ارسال شد" , ['personId' => $personId] );

        }
    }

    public function do_verify_phone($inputs){
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(array(
            'ActivationCode' => $inputs['inputVerifyCode'],
            'PersonId' => $inputs['inputPersonId']
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $userArray = array('IsActive' => 1);
            $this->db->where('PersonId', $inputs['inputPersonId']);
            $this->db->update('person', $userArray);

            $this->db->select('*');
            $this->db->from('person');
            $this->db->where(array('PersonId' => $inputs['inputPersonId']));
            $query = $this->db->get();
            require 'vendor/autoload.php';
            $signer = new HS256($this->config->item('HS256KEY'));
            $generator = new Generator($signer);
            $jwt = $generator->generate([
                'Info' => $query->result_array()[0],
                'IsLogged' => true ,
                'expire_time' =>time()+43200
            ]);
            return get_req_message('SuccessAction' , null , ['accessToken' => $jwt ] );
        }
        else{
            return get_req_message('ErrorAction' , "کد ورود صحیح نیست" );
        }
    }
    public function doSubmitNewPhone($inputs){
        $code = randomString('nozero',4);
        $url = 'http://api.kavenegar.com/v1/'.getSMSAPI().'/verify/lookup.json?receptor='.$inputs['inputPhone'].'&token='.$code.'&template=MobileVerification&type=sms';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_exec($curl);
        curl_close($curl);
        $this->doSetActivationCode($inputs['inputPersonId'] , $code);
        $arr = array(
            'type' => "green",
            'content' => "کد تایید ارسال شد",
            'success' => true
        );
        return $arr;

    }
    public function doVerifyNewPhone($inputs){
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(array(
            'ActivationCode' => $inputs['inputVerifyCode'],
            'PersonId' => $inputs['inputPersonId']
        ));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $userArray = array(
                'IsActive' => 1,
                'PersonPhone ' => $inputs['inputPhone']
            );
            $this->db->where('PersonId', $inputs['inputPersonId']);
            $this->db->update('person', $userArray);

            $this->db->select('*');
            $this->db->from('person');
            $this->db->where(array('PersonId' => $inputs['inputPersonId']));
            $query = $this->db->get();
            $this->session->set_userdata('LoginInfo' , $query->result_array()[0]);
            $this->session->set_userdata('IsLogged' , TRUE);
            $arr = array(
                'type' => "green",
                'personId' => $query->result_array()[0]['PersonId'],
                'content' => "ورود موفق...لطفا صبر کنید",
                'success' => true
            );
            return $arr;
        }
        else{
            $arr = array(
                'type' => "red",
                'content' => "کد ورود نامعتبر است",
                'success' => true
            );
            return $arr;
        }
    }
}

?>
