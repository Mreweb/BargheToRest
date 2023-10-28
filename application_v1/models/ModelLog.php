<?php

class ModelLog extends CI_Model
{
    public function getByPagination($inputs)
    {

        $limit = $inputs['pageIndex'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select('*');
        $this->db->from('logs');
        $this->db->join('person' , 'person.PersonId = logs.CreatePersonId');

        if ($inputs['inputPersonFirstName'] != '') {
            $this->db->like('PersonFirstName', $inputs['inputPersonFirstName']);
        }
        if ($inputs['inputPersonLastName'] != '') {
            $this->db->like('PersonLastName', $inputs['inputPersonLastName']);
        }
        if ($inputs['inputPersonNationalCode'] != '') {
            $this->db->like('PersonNationalCode ', $inputs['inputPersonNationalCode']);
        }
        if ($inputs['inputPersonPhone'] != '') {
            $this->db->like('PersonPhone ', $inputs['inputPersonPhone']);
        }
        $this->db->order_by('LogId' , 'DESC');

        $tempdb = clone $this->db; /* For Count Of Rows */

        $this->db->limit($end, $start);
        $query = $this->db->get()->result_array();
        $queryCount = $tempdb->count_all_results();
        if (count($query) > 0) {
            $result['data'] = $query;
            $result['count'] = $queryCount;
            return $result;
        } else {
            $result['data'] = array();
            $result['count'] = 0;
            return $result;
        }

    }

    public function getLogByLogId($id){
        $this->db->select('*');
        $this->db->from('logs');
        $this->db->join('person' , 'person.PersonId = logs.CreatePersonId');
        $this->db->where(array('LogId' => $id));
        return $this->db->get()->result_array();
    }

    public function doAdd($inputs)
    {
        $userArray = array(
            'Action' => $inputs['Action'],
            'Description' => $inputs['Description'],
            'IpAddress' => $inputs['IpAddress'],
            'Browser' => $inputs['Browser'],
            'BrowserVersion' => $inputs['BrowserVersion'],
            'Platform' => $inputs['Platform'],
            'CreatePersonId' => $inputs['LogPersonId'],
            'CreateDateTime' => time()
        );
        $this->db->insert('logs', $userArray);
        return $this->db->insert_id();

    }
}

?>