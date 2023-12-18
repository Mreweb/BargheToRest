<?php
class ModelManualBill extends CI_Model
{

    
    public function get_manual_bill_list($inputs)
    {
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

    public function do_add_manual_bill($inputs)
    {
        $this->db->select('*');
        $this->db->from('bill_raw');
        $this->db->where('BillNumberId', $inputs['inputBillNumberId']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('DuplicateInfo', null);
        }
        $userArray = array(
            'Name' => $inputs['inputBillName'],
            'Company' => $inputs['inputBillNumberCompany'],
            'NationalCode' => $inputs['inputNationalCode'],
            'PersonIdNumber' => $inputs['inputPersonIdNumber'],
            'BillNumberId' => $inputs['inputBillNumberId'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputAdminPersonId']
        );
        $this->db->insert('bill_raw', $userArray);
        return get_req_message('SuccessAction');
    }
    public function do_edit_manual_bill($inputs)
    {
        $userArray = array(
            'Name' => $inputs['inputBillName'],
            'Company' => $inputs['inputBillNumberCompany'],
            'NationalCode' => $inputs['inputNationalCode'],
            'PersonIdNumber' => $inputs['inputPersonIdNumber'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputAdminPersonId']
        );
        $this->db->where('BillNumberId', $inputs['inputBillNumberId']);
        $this->db->update('bill_raw', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function do_delete_manual_bill($inputs)
    {
        $this->db->delete('bill_raw',array(
            'BillNumberId'=> $inputs['inputBillNumberId']
        ));
        return get_req_message('SuccessAction');
    }

    public function do_recalculate_power_data($inputs)
    {
        $userArray = array(
            'HasPowerData' => 0,
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputAdminPersonId']
        );
        $this->db->where('BillNumberId', $inputs['inputBillNumberId']);
        $this->db->update('bill_raw', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }

    public function do_recalculate_sale_data($inputs)
    {
        $userArray = array(
            'HasSaleData' => 0,
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputAdminPersonId']
        );
        $this->db->where('BillNumberId', $inputs['inputBillNumberId']);
        $this->db->update('bill_raw', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }


}
?>