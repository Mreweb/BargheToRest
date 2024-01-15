<?php
class ModelFinance extends CI_Model
{

    /* For Single User */
    public function get_user_order_list($inputs) {
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select('OrderId ,  person_orders.BillGUID ,BillNumberId  , IssueDateTime , PayDateTime , TotalRequestKW , TotalPrice');
        $this->db->select('TaxPercent , FinalPrice , KWPerPrice , Status , Type');
        $this->db->select('FromDate , ToDate , PlanOrder , TotalDays');
        $this->db->select('PersonFirstName , PersonLastName , PersonNationalCode , PersonPhone');
        $this->db->from('person_orders');
        $this->db->join('person_bill', 'person_bill.BillGUID = person_orders.BillGUID');
        $this->db->join('person', 'person.PersonId = person_orders.PersonId'); 
        if ($inputs['inputBillTitle'] != '') {
            $this->db->group_start();
            $this->db->like('person_bill.BillTitle', $inputs['inputBillTitle']);
            $this->db->group_end();
        }
        if ($inputs['inputBillNumberId'] != '') {
            $this->db->group_start();
            $this->db->like('person_bill.BillNumberId', $inputs['inputBillNumberId']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonLastName'] != '') {
            $this->db->group_start();
            $this->db->like('person.PersonLastName', $inputs['inputPersonLastName']);
            $this->db->or_like('person.PersonFirstName', $inputs['inputPersonLastName']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonNationalCode'] != '') {
            $this->db->group_start();
            $this->db->like('person.PersonNationalCode', $inputs['inputPersonNationalCode']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonPhone'] != '') {
            $this->db->group_start();
            $this->db->like('person.PersonPhone', $inputs['inputPersonPhone']);
            $this->db->group_end();
        } 
        if ($inputs['inputStatus'] != '') {
            $this->db->group_start();
            $this->db->where('Status', $inputs['inputStatus']);
            $this->db->group_end();
        } 
        if ($inputs['inputPersonId'] != '') {
            $this->db->group_start();
            $this->db->where('person_orders.PersonId', $inputs['inputPersonId']);
            $this->db->group_end();
        }
        $tempdb = clone $this->db; /* For Count Of Rows */

        $this->db->limit($end, $start);
        $this->db->order_by('person_orders.CreateDateTime', 'DESC');
        $this->db->group_by('person_orders.OrderId');
        $query = $this->db->get()->result_array();
        $queryCount = $tempdb->count_all_results();
        $result['data']['content'] = $query;
        $result['data']['count'] = $queryCount;
        return $result;
    }

    public function get_order_by_order_id($order_id) {
        $this->db->select(' OrderId , person_orders.BillGUID ,BillNumberId  , IssueDateTime , PayDateTime , TotalRequestKW , TotalPrice');
        $this->db->select('TaxPercent , FinalPrice , KWPerPrice , Status , Type');
        $this->db->select('FromDate , ToDate , PlanOrder , TotalDays');
        $this->db->select('PersonFirstName , PersonLastName , PersonNationalCode , PersonPhone');
        $this->db->from('person_orders');
        $this->db->join('person_bill', 'person_bill.BillGUID = person_orders.BillGUID');
        $this->db->join('person', 'person.PersonId = person_orders.PersonId'); 
        $this->db->where('person_orders.OrderId', $order_id); 
        $this->db->group_by('person_orders.OrderId');
        $query = $this->db->get()->result_array();
        $result['data']['content'] = $query;
        return $result;
    }

    /* Admin Panel */
    public function get_user_all_orders($inputs) {
        $this->db->select(' person_orders.BillGUID ,BillNumberId  , IssueDateTime , PayDateTime , TotalRequestKW , TotalPrice');
        $this->db->select('TaxPercent , FinalPrice , KWPerPrice , Status , Type');
        $this->db->select('FromDate , ToDate , PlanOrder , TotalDays');
        $this->db->select('PersonFirstName , PersonLastName , PersonNationalCode , PersonPhone');
        $this->db->from('person_orders');
        $this->db->join('person_bill', 'person_bill.BillGUID = person_orders.BillGUID');
        $this->db->join('person', 'person.PersonId = person_orders.PersonId'); 
        $this->db->where('person_orders.PersonId', $inputs['inputPersonId']);
        $this->db->order_by('person_orders.CreateDateTime', 'DESC');
        $this->db->group_by('person_orders.OrderId');
        $query = $this->db->get()->result_array();
        $result['data']['content'] = $query;
        return $result;
    }

    public function get_orders_list($inputs) {
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select(' OrderId , person_orders.BillGUID ,BillNumberId  , IssueDateTime , PayDateTime , TotalRequestKW , TotalPrice');
        $this->db->select('TaxPercent , FinalPrice , KWPerPrice , Status , Type');
        $this->db->select('FromDate , ToDate , PlanOrder , TotalDays');
        $this->db->select('PersonFirstName , PersonLastName , PersonNationalCode , PersonPhone');
        $this->db->from('person_orders');
        $this->db->join('person_bill', 'person_bill.BillGUID = person_orders.BillGUID');
        $this->db->join('person', 'person.PersonId = person_orders.PersonId'); 
        if ($inputs['inputBillTitle'] != '') {
            $this->db->group_start();
            $this->db->like('person_bill.BillTitle', $inputs['inputBillTitle']);
            $this->db->group_end();
        }
        if ($inputs['inputBillNumberId'] != '') {
            $this->db->group_start();
            $this->db->like('person_bill.BillNumberId', $inputs['inputBillNumberId']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonLastName'] != '') {
            $this->db->group_start();
            $this->db->like('person.PersonLastName', $inputs['inputPersonLastName']);
            $this->db->or_like('person.PersonFirstName', $inputs['inputPersonLastName']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonNationalCode'] != '') {
            $this->db->group_start();
            $this->db->like('person.PersonNationalCode', $inputs['inputPersonNationalCode']);
            $this->db->group_end();
        }
        if ($inputs['inputPersonPhone'] != '') {
            $this->db->group_start();
            $this->db->like('person.PersonPhone', $inputs['inputPersonPhone']);
            $this->db->group_end();
        } 
        if ($inputs['inputStatus'] != '') {
            $this->db->group_start();
            $this->db->where('Status', $inputs['inputStatus']);
            $this->db->group_end();
        } 
        $tempdb = clone $this->db; /* For Count Of Rows */

        $this->db->limit($end, $start);
        $this->db->order_by('person_orders.CreateDateTime', 'DESC');
        $this->db->group_by('person_orders.OrderId');
        $query = $this->db->get()->result_array();
        $queryCount = $tempdb->count_all_results();
        $result['data']['content'] = $query;
        $result['data']['count'] = $queryCount;
        return $result;
    }
    public function do_edit_order($inputs)
    {
         
        $userArray = array( 
            'Status' => $inputs['inputStatus'],    
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputAdminPersonId']
        );
        $inserId = $this->db->where('OrderId', $inputs['inputOrderId']);
        $inserId = $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $inserId = $this->db->where('PersonId', $inputs['inputPersonId']);
        $inserId = $this->db->update('person_orders', $userArray);
        if ($inserId > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }

    }
    

    

}
?>