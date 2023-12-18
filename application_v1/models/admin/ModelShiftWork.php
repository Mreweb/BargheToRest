<?php
class ModelShiftWork extends CI_Model
{

    public function get_shift_work_list($inputs)
    {
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select('*');
        $this->db->from('shift_work');
        $this->db->join('person_bill', 'person_bill.BillGUID = shift_work.ShiftWorkBillGUID');
        $this->db->join('person', 'person.PersonId = person_bill.BillPersonId');
        $this->db->where('person_bill.SoftDelete', 0);
        $this->db->where('shift_work.SoftDelete', 0);
        if ($inputs['inputShiftWorkTitle'] != '') {
            $this->db->group_start();
            $this->db->like('ShiftWorkTitle', $inputs['inputShiftWorkTitle']);
            $this->db->group_end();
        }
        if ($inputs['inputShiftWorkBillGUID'] != '') {
            $this->db->group_start();
            $this->db->where('ShiftWorkBillGUID', $inputs['inputShiftWorkBillGUID']);
            $this->db->group_end();
        }
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $tempdb = clone $this->db; /* For Count Of Rows */

        $this->db->limit($end, $start);
        $this->db->order_by('shift_work.CreateDateTime', 'DESC');
        $query = $this->db->get()->result_array();
        $queryCount = $tempdb->count_all_results();
        $result['data']['content'] = $query;
        $result['data']['count'] = $queryCount;
        return $result;


    }
    public function add_shift_work($inputs)
    {

        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->where('BillGUID', $inputs['inputShiftWorkBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return get_req_message('NOTFOUND', 'شناسه قبض یافت نشد');
        }
        $userArray = array(
            'ShiftWorkTitle' => $inputs['inputShiftWorkTitle'],
            'ShiftWorkFromDate' => makeTimeFromDate($inputs['inputShiftWorkFromDate']),
            'ShiftWorkToDate' => makeTimeFromDate($inputs['inputShiftWorkToDate']),
            'ShiftWorkBillGUID' => $inputs['inputShiftWorkBillGUID'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputPersonId']
        );
        $this->db->insert('shift_work', $userArray);
        $shift_work_id = $this->db->insert_id();
        foreach ($inputs['inputShiftWorkDays'] as $shiftDay) {
            $userArray = array(
                'ShiftWorkId' => $shift_work_id,
                'ShiftWorkDayTitle' => $shiftDay['DayTitle'],
                'ShiftWorkDayValue' => $shiftDay['DayValue'],
                'CreateDateTime' => time(),
                'CreatePersonId' => $inputs['inputPersonId']
            );
            $this->db->insert('shift_work_days', $userArray);
            $shoft_work_day_id = $this->db->insert_id();
            foreach ($shiftDay['Hour'] as $shiftHour) {
                $userArray = array(
                    'ShiftWorkId' => $shift_work_id,
                    'ShiftWorkDayId' => $shoft_work_day_id,
                    'FromHour' => $shiftHour['FromHour'],
                    'ToHour' => $shiftHour['ToHour'],
                    'CreateDateTime' => time(),
                    'CreatePersonId' => $inputs['inputPersonId']
                );
                $this->db->insert('shift_work_day_hours', $userArray);
            }
        }

        if ($shift_work_id > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }

    }

    public function do_delete_shift_work($inputs)
    {
        $userArray = array(
            'SoftDelete' => 1,
            'ModifyDateTime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('ShiftWorkBillGUID', $inputs['inputShiftWorkBillGUID']);
        $this->db->where('ShiftWorkId', $inputs['inputShiftWorkId']);
        $this->db->update('shift_work', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }

    public function get_shift_work($shiftWorkId, $shiftWorkGUID)
    {
        $this->db->select('*');
        $this->db->from('shift_work');
        $this->db->join('person_bill', 'person_bill.BillGUID = shift_work.ShiftWorkBillGUID');
        $this->db->join('person', 'person.PersonId = person_bill.BillPersonId');
        $this->db->where('person_bill.SoftDelete', 0);
        $this->db->where('shift_work.SoftDelete', 0);
        $this->db->where('ShiftWorkId', $shiftWorkId);
        $this->db->where('ShiftWorkBillGUID', $shiftWorkGUID);
        $query['data'] = $this->db->get()->result_array()[0];
        $this->db->reset_query();

        $this->db->select('*');
        $this->db->from('shift_work_days');
        $this->db->where('ShiftWorkId', $shiftWorkId);
        $query['data']['Days'] = $this->db->get()->result_array();
        $this->db->reset_query();

        $index = 0;
        foreach ($query['data']['Days'] as $row) {
            $this->db->select('*');
            $this->db->from('shift_work_day_hours');
            $this->db->where('ShiftWorkId', $shiftWorkId);
            $this->db->where('ShiftWorkDayId', $row['ShiftWorkDayId']);
            $query['data']['Days'][$index++]['Hours'] = $this->db->get()->result_array();
            $this->db->reset_query();
        }



        $result['data']['content'] = $query;
        return $result;


    }



}
?>