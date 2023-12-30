<?php

class ModelProfile extends CI_Model
{


    
    public function get_person_info($peronsId)
    {
        if ($inputs['inputNationalCode'] != '' && $inputs['inputNationalCode'] != null) {
            $this->db->select('*');
            $this->db->from('person');
            $this->db->where(
                array(
                    'PersonId !=' => $inputs['inputPersonId'],
                    'PersonNationalCode' => $inputs['inputNationalCode'],
                )
            );
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return get_req_message('DuplicateInfo', null);
            }
        }
        $userArray = array(
            'PersonFirstName' => $inputs['inputFirstName'],
            'PersonLastName' => $inputs['inputLastName'],
            'PersonNationalCode' => $inputs['inputNationalCode'],
            'PersonAddress' => $inputs['inputAddress'],
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }

    }

    public function do_change_info($inputs)
    {
        if ($inputs['inputNationalCode'] != '' && $inputs['inputNationalCode'] != null) {
            $this->db->select('*');
            $this->db->from('person');
            $this->db->where(
                array(
                    'PersonId !=' => $inputs['inputPersonId'],
                    'PersonNationalCode' => $inputs['inputNationalCode'],
                )
            );
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return get_req_message('DuplicateInfo', null);
            }
        }
          
        $userArray = array(
            'PersonFirstName' => $inputs['inputFirstName'],
            'PersonLastName' => $inputs['inputLastName'],
            'PersonNationalCode' => $inputs['inputNationalCode'],
            'PersonAddress' => $inputs['inputAddress'],
            'PersonProvinceId' => $inputs['inputPersonProvinceId'],
            'PersonCityId' => $inputs['inputPersonCityId'],
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }

    }

    
    public function do_change_user_legal_info($inputs)
    {

        $userArray = array(
            'LegalOrganizationName' => $inputs['inputLegalOrganizationName'],
            'LegalFinanceCode' => $inputs['inputLegalFinanceCode'],
            'LegalCompanyId' => $inputs['inputLegalCompanyId'],
            'LegalRegisterNumber' => $inputs['inputLegalRegisterNumber'],
            'LegalPhone' => $inputs['inputLegalPhone'],
            'LegalProvinceId' => $inputs['inputLegalProvinceId'],
            'LegalCityId' => $inputs['inputLegalCityId'],
            'LegalAddress' => $inputs['inputLegalAddress'],
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person_legal_info', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }

    }

    public function do_submit_new_phone($inputs){
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(
            array(
                'PersonId !=' => $inputs['inputPersonId'],
                'PersonPhone' => $inputs['inputPhone'],
            )
        );
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }

        $code = randomString('nozero',4);
        $url = 'https://api.kavenegar.com/v1/'.getSMSAPI().'/verify/lookup.json?receptor='.$inputs['inputPhone'].'&token='.$code.'&template=MobileVerification&type=sms';      
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_exec($curl);
        curl_close($curl);


        $userArray = array( 'ActivationCode' => $code );
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction' , 'کد تایید به تلفن همراه ارسال شد');
        } else {
            return get_req_message('ErrorAction');
        }

    }

    public function do_verify_new_phone($inputs){

        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(
            array(
                'PersonId !=' => $inputs['inputPersonId'],
                'PersonPhone' => $inputs['inputPhone'],
            )
        );
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }

        $this->db->select('*');
        $this->db->from('person');
        $this->db->where(
            array(
                'PersonId' => $inputs['inputPersonId'],
                'ActivationCode' => $inputs['inputVerifyCode'],
            )
        );
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return get_req_message('ErrorAction', 'کد تایید نامعتبر است');
        }
        $code = randomString('nozero',4);
        $userArray = array(
             'PersonPhone' => $inputs['inputPhone'],
             'ActivationCode' => $code 
        );
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction' , 'تلفن همراه با موفقیت تغییر یافت');
        } else {
            return get_req_message('ErrorAction');
        }

    }
    


}

?>