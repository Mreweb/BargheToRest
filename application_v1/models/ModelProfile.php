<?php

class ModelProfile extends CI_Model{

    /* Setting */
    public function do_change_info($inputs){
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
        return get_req_message('SuccessAction');

    }

    public function do_change_user_legal_info($inputs){
        
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
        return get_req_message('SuccessAction');

    }

    /* End Setting */
}

?>