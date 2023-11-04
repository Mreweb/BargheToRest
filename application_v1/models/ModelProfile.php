<?php

class ModelProfile extends CI_Model{

    /* Setting */
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
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person', $userArray);
        return get_req_message('SuccessAction');

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
        return get_req_message('SuccessAction');

    }
    /* End Setting */

    public function get_user_bill_list($inputs)
    {
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->join('person', 'person.PersonId = person_bill.BillPersonId');
        if ($inputs['inputBillTitle'] != '') {
            $this->db->group_start();
            $this->db->like('BillTitle', $inputs['inputBillTitle']);
            $this->db->group_end();
        }
        if ($inputs['inputBillNumberId'] != '') {
            $this->db->group_start();
            $this->db->like('BillNumberId', $inputs['inputBillNumberId']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonLastName'] != '') {
            $this->db->group_start();
            $this->db->like('PersonLastName', $inputs['inputPersonLastName']);
            $this->db->or_like('PersonFirstName', $inputs['inputPersonLastName']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonNationalCode'] != '') {
            $this->db->group_start();
            $this->db->like('PersonNationalCode', $inputs['inputPersonNationalCode']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonPhone'] != '') {
            $this->db->group_start();
            $this->db->like('PersonPhone', $inputs['inputPersonPhone']);
            $this->db->group_end();
        }
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $tempdb = clone $this->db; /* For Count Of Rows */

        $this->db->limit($end, $start);
        $this->db->order_by('person_bill.CreateDateTime', 'DESC');
        $this->db->group_by('person_bill.BillGUID');
        $query = $this->db->get()->result_array();
        $queryCount = $tempdb->count_all_results();
        $result['data']['content'] = $query;
        $result['data']['count'] = $queryCount;
        return $result;


    }

    public function do_add_bill($inputs){
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->where('BillNumberId', $inputs['inputBillNumberId']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'BillGUID' => $this->uuid->v4(),
            'BillTitle' => $inputs['inputBillTitle'],
            'BillNumberID' => $inputs['inputBillNumberId'],
            'BillPersonId' => $inputs['inputPersonId'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputPersonId']
        );
        $this->db->insert('person_bill', $userArray);
        return get_req_message('SuccessAction');
    }

    public function do_edit_bill($inputs){

        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->where('BillNumberId', $inputs['inputBillNumberId']);
        $this->db->where('BillGUID !=', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'BillTitle' => $inputs['inputBillTitle'],
            'BillNumberID' => $inputs['inputBillNumberId'],
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $this->db->update('person_bill', $userArray);
        return get_req_message('SuccessAction');
    }
    

}

?>