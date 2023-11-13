<?php
class ModelBill extends CI_Model{
    /* For Single User */
    public function get_user_bill_list($inputs){
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->join('person', 'person.PersonId = person_bill.BillPersonId');
        $this->db->where('person_bill.SoftDelete', 0);
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
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function do_delete_bill($inputs){
        $userArray = array(
            'SoftDelete' => 1,
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $this->db->update('person_bill', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function do_add_legal_info($inputs){

        $this->db->select('*');
        $this->db->from('persnon_bill_legal_info');
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'PersonId' => $inputs['inputPersonId'],
            'BillGUID' => $inputs['inputBillGUID'],
            'RealName' => $inputs['inputRealName'],
            'RealLastName' => $inputs['inputRealLastName'],
            'RealNationalCode' => $inputs['inputRealNationalCode'],
            'RealPhone' => $inputs['inputRealPhone'],
            'RealProvinceId' => $inputs['inputRealProvinceId'],
            'RealCityId' => $inputs['inputRealCityId'],
            'RealAddress' => $inputs['inputRealAddress'],
            'LegalOrganizationName' => $inputs['inputLegalOrganizationName'],
            'LegalFinanceCode' => $inputs['inputLegalFinanceCode'],
            'LegalCompanyId' => $inputs['inputLegalCompanyId'],
            'LegalRegisterNumber' => $inputs['inputLegalRegisterNumber'],
            'LegalPhone' => $inputs['inputLegalPhone'],
            'LegalProvinceId' => $inputs['inputLegalProvinceId'],
            'LegalCityId' => $inputs['inputLegalCityId'],
            'LegalAddress' => $inputs['inputLegalAddress'],
            'CreatePersonId' => $inputs['inputPersonId'],
            'CreateDateTime' => time()
        );

        $this->db->insert('persnon_bill_legal_info', $userArray);
        return get_req_message('SuccessAction');
    }
    /* End For Single User */


    /* For Admin */
    public function get_bill_list($inputs){
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->join('person', 'person.PersonId = person_bill.BillPersonId');
        
        if ($inputs['inputShowDeleted'] != '') {
            $this->db->where('person_bill.SoftDelete', $inputs['inputShowDeleted']);
        }
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
        if ($inputs['inputPersonId'] != '') {
            $this->db->group_start();
            $this->db->where('BillPersonId', $inputs['inputPersonId']);
            $this->db->group_end();
        }
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
    public function do_add_bill_by_admin($inputs){
        $this->db->select('*');
        $this->db->from('person');
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return get_req_message('NotFound', 'فردی با این مشخصات یافت نشد');
        }
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
            'CreatePersonId' => $inputs['inputAdminPersonId']
        );
        $this->db->insert('person_bill', $userArray);
        return get_req_message('SuccessAction');
    }
    public function do_edit_bill_by_admin($inputs){
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
            'ModifyPersonId' => $inputs['inputAdminPersonId']
        );
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->update('person_bill', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function do_delete_bill_by_admin($inputs){
        $userArray = array(
            'SoftDelete' => 1,
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputAdminPersonId']
        );
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->update('person_bill', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function do_add_legal_info_by_admin($inputs){
        $this->db->select('*');
        $this->db->from('persnon_bill_legal_info');
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'PersonId' => $inputs['inputPersonId'],
            'BillGUID' => $inputs['inputBillGUID'],
            'RealName' => $inputs['inputRealName'],
            'RealLastName' => $inputs['inputRealLastName'],
            'RealNationalCode' => $inputs['inputRealNationalCode'],
            'RealPhone' => $inputs['inputRealPhone'],
            'RealProvinceId' => $inputs['inputRealProvinceId'],
            'RealCityId' => $inputs['inputRealCityId'],
            'RealAddress' => $inputs['inputRealAddress'],
            'LegalOrganizationName' => $inputs['inputLegalOrganizationName'],
            'LegalFinanceCode' => $inputs['inputLegalFinanceCode'],
            'LegalCompanyId' => $inputs['inputLegalCompanyId'],
            'LegalRegisterNumber' => $inputs['inputLegalRegisterNumber'],
            'LegalPhone' => $inputs['inputLegalPhone'],
            'LegalProvinceId' => $inputs['inputLegalProvinceId'],
            'LegalCityId' => $inputs['inputLegalCityId'],
            'LegalAddress' => $inputs['inputLegalAddress'],
            'CreatePersonId' => $inputs['inputAdminPersonId'],
            'CreateDateTime' => time()
        );
        $this->db->insert('persnon_bill_legal_info', $userArray);
        return get_req_message('SuccessAction');
    }
    public function do_edit_legal_info_by_admin($inputs){
        $this->db->select('*');
        $this->db->from('persnon_bill_legal_info');
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return get_req_message('NotFound', null);
        }
        $userArray = array(
            'PersonId' => $inputs['inputPersonId'],
            'BillGUID' => $inputs['inputBillGUID'],
            'RealName' => $inputs['inputRealName'],
            'RealLastName' => $inputs['inputRealLastName'],
            'RealNationalCode' => $inputs['inputRealNationalCode'],
            'RealPhone' => $inputs['inputRealPhone'],
            'RealProvinceId' => $inputs['inputRealProvinceId'],
            'RealCityId' => $inputs['inputRealCityId'],
            'RealAddress' => $inputs['inputRealAddress'],
            'LegalOrganizationName' => $inputs['inputLegalOrganizationName'],
            'LegalFinanceCode' => $inputs['inputLegalFinanceCode'],
            'LegalCompanyId' => $inputs['inputLegalCompanyId'],
            'LegalRegisterNumber' => $inputs['inputLegalRegisterNumber'],
            'LegalPhone' => $inputs['inputLegalPhone'],
            'LegalProvinceId' => $inputs['inputLegalProvinceId'],
            'LegalCityId' => $inputs['inputLegalCityId'],
            'LegalAddress' => $inputs['inputLegalAddress'],
            'CreatePersonId' => $inputs['inputAdminPersonId'],
            'CreateDateTime' => time()
        );
        $this->db->insert('persnon_bill_legal_info', $userArray);
        return get_req_message('SuccessAction');
    }
    /* End For Admin */


}
?>