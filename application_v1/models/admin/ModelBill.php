<?php
class ModelBill extends CI_Model
{


    /* For Single User */
    public function get_user_bill_list($inputs)
    {
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select('BillGUID , BillTitle , BillNumberId , PersonId');
        $this->db->select('PersonFirstName , PersonLastName , PersonNationalCode , PersonPhone');
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
    public function get_user_all_bill_list($inputs)
    {
        $this->db->select('BillGUID , BillTitle , BillNumberId , PersonId');
        $this->db->select('PersonFirstName , PersonLastName , PersonNationalCode , PersonPhone');
        $this->db->from('person_bill');
        $this->db->join('person', 'person.PersonId = person_bill.BillPersonId');
        $this->db->where('person_bill.SoftDelete', 0);
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->order_by('person_bill.CreateDateTime', 'DESC');
        $this->db->group_by('person_bill.BillGUID');
        $query = $this->db->get()->result_array();
        $result['data']['content'] = $query;
        return $result;


    }

    public function do_add_bill($inputs)
    {
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
    public function do_edit_bill($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->where('BillPersonId', $inputs['inputPersonId']);
        $this->db->where('BillNumberId', $inputs['inputBillNumberId']);
        $this->db->where('BillGUID !=', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return get_req_message('NOTFOUND', null);
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
    public function do_delete_bill($inputs)
    {
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
    public function do_active_bill($inputs)
    {
        $userArray = array(
            'SoftDelete' => 0,
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

    public function do_add_legal_info($inputs)
    {

        $this->db->select('*');
        $this->db->from('person_bill_legal_info');
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

        $this->db->insert('person_bill_legal_info', $userArray);
        return get_req_message('SuccessAction');
    }
    public function do_edit_legal_info($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill_legal_info');
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $userArray = array(
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
            $this->db->where('PersonId', $inputs['inputPersonId']);
            $this->db->update('person_bill_legal_info', $userArray);
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('NOTFOUND', null);
        }

    }


    public function set_factor_type($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill_legal_info');
        $this->db->where('BillGUID', $inputs['inputBillGUID']);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            if ($query->result_array()[0]['BillFactorPrintType'] == 'NotSetted') {
                $userArray = array(
                    'BillFactorPrintType' => $inputs['inputBillFactorPrintType'],
                    'CreatePersonId' => $inputs['inputPersonId'],
                    'CreateDateTime' => time()
                );
                $this->db->where('BillGUID', $inputs['inputBillGUID']);
                $this->db->update('person_bill_legal_info', $userArray);
                return get_req_message('SuccessAction');
            } else{
                return get_req_message('ErrorAction' , 'قبلا نحوه صدور فاکتور انتخاب شده است.جهت تغییر تیکت ثبت کنید');
            }
        } else {
            return get_req_message('NOTFOUND', null);
        }

    }

    /* End For Single User */


    /* For Admin */
    public function get_bill_list($inputs)
    {
        $limit = $inputs['page'];
        $start = ($limit - 1) * $this->config->item('defaultPageSize');
        $end = $this->config->item('defaultPageSize');
        $this->db->select('BillGUID,BillTitle,BillGUID,PersonId');
        $this->db->select('PersonFirstName,PersonLastName,PersonNationalCode');
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
    public function get_bill_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->where('BillNumberId', $id);
        $query = $this->db->get()->result_array()[0];

        $this->db->reset_query();
        $this->db->select('*');
        $this->db->from('person_bill_legal_info');
        $this->db->where('BillGUID', $query['BillGUID']);
        $query['legalInfo'] = $this->db->get()->result_array();

        $result['data']['content'] = $query;
        return $result;
    }
    public function get_bill_by_guid($guid)
    {
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->where('BillGUID', $guid);
        $query = $this->db->get()->result_array()[0];

        $this->db->reset_query();
        $this->db->select('*');
        $this->db->from('person_bill_legal_info');
        $this->db->where('BillGUID', $guid);
        $query['legalInfo'] = $this->db->get()->result_array();

        $result['data']['content'] = $query;
        return $result;
    }
    public function do_add_bill_by_admin($inputs)
    {
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
    public function do_edit_bill_by_admin($inputs)
    {
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
    public function do_delete_bill_by_admin($inputs)
    {
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
    public function do_add_legal_info_by_admin($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill_legal_info');
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
        $this->db->insert('person_bill_legal_info', $userArray);
        return get_req_message('SuccessAction');
    }
    public function do_edit_legal_info_by_admin($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill_legal_info');
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



    /* Public */
    public function get_bill_power_data($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->join('bill_power_data_detail', 'bill_power_data_detail.bill_identifier = person_bill.BillNumberId');
        $this->db->where('person_bill.SoftDelete', 0);
        $this->db->where('person_bill.BillGUID', $inputs['guid']);
        $this->db->where('person_bill.BillPersonId', $inputs['inputPersonId']);
        $query = $this->db->get()->result_array()[0];
        unset($query['company_phone']);
        unset($query['lat']);
        unset($query['long']);
        unset($query['total_bill_debt']);
        unset($query['payment_identifier']);
        $result['data']['content'] = $query;
        return $result;
    }
    public function get_bill_sale_data($inputs)
    {
        $this->db->select('*');
        $this->db->from('person_bill');
        $this->db->join('bill_sale_data_detail', 'bill_sale_data_detail.BillNumberId = person_bill.BillNumberId');
        $this->db->where('person_bill.SoftDelete', 0);
        $this->db->where('person_bill.BillGUID', $inputs['guid']);
        $this->db->where('person_bill.BillPersonId', $inputs['inputPersonId']);
        $query = $this->db->get()->result_array();
        $result['data']['content'] = $query;
        return $result;
    }

    public function get_bill_avg_cons($inputs)
    {

        $query['one_month_avg'] = $this->db->query("SELECT ( (SUM(low_cons)+SUM(normal_cons)+SUM(peak_cons)) / SUM(total_days) /24) AS TotalCons FROM (SELECT * FROM bill_sale_data_detail WHERE BillNumberId = '" . $inputs['inputBillNumberId'] . "'   order by issue_date DESC LIMIT 1) AS T")->result_array()[0]['TotalCons'];
        $this->db->reset_query();

        $query['three_month_avg'] = $this->db->query("SELECT ( (SUM(low_cons)+SUM(normal_cons)+SUM(peak_cons)) / SUM(total_days) /24) AS TotalCons FROM (SELECT * FROM bill_sale_data_detail WHERE BillNumberId = '" . $inputs['inputBillNumberId'] . "'   order by issue_date DESC LIMIT 3) AS T")->result_array()[0]['TotalCons'];
        $this->db->reset_query();
        $query['six_month_avg'] = $this->db->query("SELECT ((SUM(low_cons)+SUM(normal_cons)+SUM(peak_cons))/SUM(total_days)/24) AS TotalCons FROM (SELECT * FROM bill_sale_data_detail WHERE BillNumberId = '" . $inputs['inputBillNumberId'] . "'   order by issue_date DESC LIMIT 6) AS T")->result_array()[0]['TotalCons'];
        $this->db->reset_query();
        $query['twelve_month_avg'] = $this->db->query("SELECT ((SUM(low_cons)+SUM(normal_cons)+SUM(peak_cons))/SUM(total_days)/24) AS TotalCons FROM (SELECT * FROM bill_sale_data_detail WHERE BillNumberId = '" . $inputs['inputBillNumberId'] . "'   order by issue_date DESC LIMIT 12) AS T")->result_array()[0]['TotalCons'];
        $result['data']['content'] = $query;
        return $result;
    }

    public function get_bill_plans_with_print($inputs)
    {
        $bill = $this->get_bill_by_guid($inputs['guid']);
        $avgKWS = $this->db->query("SELECT ((SUM(low_cons)+SUM(normal_cons)+SUM(peak_cons))/SUM(total_days)/24) AS TotalCons FROM (SELECT * FROM bill_sale_data_detail WHERE BillNumberId = '" . $bill[0]['BillNumberId'] . "'   order by issue_date DESC LIMIT 12) AS T")->result_array()[0]['TotalCons'];
        $avgKWS = round($avgKWS, 2);


        $LowPrice = $inputs['electricity_price']['LowPrice'];
        $HighPrice = $inputs['electricity_price']['HighPrice'];
        $priceGap = $HighPrice - $LowPrice;

        $todayDate = $inputs['todayDate'];
        $todayDay = explode("/", $inputs['todayDate'])[2];

        $currentMonth = intval($inputs['currentMonth']);

        $prevMonth = $currentMonth - 1;
        if ($prevMonth < 1) {
            $prevMonth = 12;
        }

        $nextOneMonth = $currentMonth + 1;
        $nextTwoMonth = $currentMonth + 2;
        if ($nextOneMonth > 12) {
            $nextOneMonth = 1;
        }
        if ($nextTwoMonth > 12) {
            $nextTwoMonth = 1;
        }

        echo "BillNumberId " . ($bill[0]['BillNumberId']) . PHP_EOL;

        echo "current month " . ($currentMonth) . PHP_EOL;

        echo "current day " . ($todayDay) . PHP_EOL;


        $currentMonthTotalDays = 0;
        if ($currentMonth <= 6) {
            $currentMonthTotalDays = 31;
        } else if ($currentMonth > 6 && $currentMonth < 12) {
            $currentMonthTotalDays = 30;
        } else {
            $currentMonthTotalDays = 29;
        }


        $nextOneMonthDays = 0;

        if ($nextOneMonth <= 6) {
            $nextOneMonthDays = 31;
        } else if ($nextOneMonth > 6 && $nextOneMonth < 12) {
            $nextOneMonthDays = 30;
        } else {
            $nextOneMonthDays = 29;
        }

        $nextTwoMonthDays = 0;
        if ($nextTwoMonth <= 6) {
            $nextTwoMonthDays = 31;
        } else if ($nextTwoMonth > 6 && $nextTwoMonth < 12) {
            $nextTwoMonthDays = 30;
        } else {
            $nextTwoMonthDays = 29;
        }
        $nextTwoMonthDays = $nextTwoMonthDays + $nextOneMonthDays;


        echo "Next One Month " . $nextOneMonth . PHP_EOL;
        echo "Next One Month Days " . $nextOneMonthDays . PHP_EOL;

        echo "Next two Month " . $nextTwoMonth . PHP_EOL;
        echo "Next two Month Days " . $nextTwoMonthDays . PHP_EOL;



        $remainsDayToEndOfMonth = $currentMonthTotalDays - $todayDay;
        echo "remains day to end of month day " . $remainsDayToEndOfMonth . PHP_EOL;

        echo "avgKWS In Last 12 Month" . ($avgKWS) . PHP_EOL;

        echo "priceGap " . $priceGap . PHP_EOL;

        echo "HighPrice " . $HighPrice . PHP_EOL;

        echo "LowPrice " . $LowPrice . PHP_EOL;


        $userRequestedKw = 2000;
        $requestedKw = $userRequestedKw * 30 * 24;

        echo "========================================" . PHP_EOL;
        $thisMonthDiscount = round($priceGap / 60, 2);
        echo "Discount Per KW Per Day For Current Month " . $thisMonthDiscount . PHP_EOL;

        if (($remainsDayToEndOfMonth) > 60) {
            $thisMonthCalculatedPrice = $LowPrice;
        } else {
            $thisMonthCalculatedPrice = $HighPrice - ($remainsDayToEndOfMonth * $thisMonthDiscount);
        }
        $thisMonthCalculatedPrice = $HighPrice - ($remainsDayToEndOfMonth * $thisMonthDiscount);
        echo "CalCulatedPrice " . $thisMonthCalculatedPrice . PHP_EOL;

        $thisMonthPowerCost = $requestedKw * $thisMonthCalculatedPrice;
        echo "thisMonthPowerCost " . number_format($thisMonthPowerCost) . PHP_EOL;

        echo "========================================" . PHP_EOL;

        $nextMonthDiscount = round($priceGap / 60, 2);
        echo "Discount Per KW Per Day For Next Month " . $nextMonthDiscount . PHP_EOL;

        if (($nextOneMonthDays + $remainsDayToEndOfMonth) > 60) {
            $nextMonthCalculatedPrice = $LowPrice;
        } else {
            $nextMonthCalculatedPrice = $HighPrice - (($nextOneMonthDays + $remainsDayToEndOfMonth) * $thisMonthDiscount);
        }
        echo "CalCulatedPrice " . $nextMonthCalculatedPrice . PHP_EOL;

        $nextMonthPowerCost = $requestedKw * $nextMonthCalculatedPrice;
        echo "thisMonthPowerCost " . number_format($nextMonthPowerCost) . PHP_EOL;

        echo "========================================" . PHP_EOL;


        $nextTwoMonthDiscount = round($priceGap / 60, 2);
        echo "Discount Per KW Per Day For Next Two Month " . $nextTwoMonthDiscount . PHP_EOL;


        if (($nextTwoMonthDays + $nextOneMonthDays + $remainsDayToEndOfMonth) > 60) {
            $nextTwoMonthCalculatedPrice = $LowPrice;
        } else {
            $nextTwoMonthCalculatedPrice = $HighPrice - (($nextTwoMonthDays + $nextOneMonthDays + $remainsDayToEndOfMonth) * $thisMonthDiscount);
        }

        echo "CalCulatedPrice " . $nextTwoMonthCalculatedPrice . PHP_EOL;

        $nextTwoMonthPowerCost = $requestedKw * $nextTwoMonthCalculatedPrice;
        echo "thisMonthPowerCost " . number_format($nextTwoMonthPowerCost) . PHP_EOL;

        echo "========================================" . PHP_EOL;



        $plans[] = array(
            'PlanOrder' => 1,
            'RemainDays' => $remainsDayToEndOfMonth,
            'UserRequestedKw' => $userRequestedKw,
            'PowerCost' => number_format($thisMonthPowerCost),
            'PricePerKW' => $thisMonthCalculatedPrice
        );

        $plans[] = array(
            'PlanOrder' => 2,
            'RemainDays' => ($nextOneMonthDays + $remainsDayToEndOfMonth),
            'UserRequestedKw' => $userRequestedKw,
            'PowerCost' => number_format($thisMonthPowerCost),
            'PricePerKW' => $nextMonthCalculatedPrice
        );

        $plans[] = array(
            'PlanOrder' => 3,
            'RemainDays' => ($nextTwoMonthDays + $nextOneMonthDays + $remainsDayToEndOfMonth),
            'UserRequestedKw' => $userRequestedKw,
            'PowerCost' => number_format($nextTwoMonthPowerCost),
            'PricePerKW' => $nextTwoMonthCalculatedPrice
        );


        $result['data']['content'] = $plans;
        return $result;


    }

    public function get_bill_plans($inputs)
    {

        //get Bill NumberId
        $bill = $this->get_bill_by_guid($inputs['inputBillGUID'])['data']['content'];

        // Get Bill Last 1 Year Total AVG cons
        $avgKWS = $this->db->query("SELECT ((SUM(low_cons)+SUM(normal_cons)+SUM(peak_cons))/SUM(total_days)/24) AS TotalCons FROM (SELECT * FROM bill_sale_data_detail WHERE BillNumberId = '" . $bill[0]['BillNumberId'] . "'   order by issue_date DESC LIMIT 12) AS T")->result_array()[0]['TotalCons'];
        $avgKWS = round($avgKWS, 2);

        //user erquested KW
        $userRequestedKw = $inputs['inputTotalRequestKW'];

        //get Admin Electricity Price
        $LowPrice = $inputs['electricity_price']['LowPrice'];
        $HighPrice = $inputs['electricity_price']['HighPrice'];
        $priceGap = $HighPrice - $LowPrice;


        $todayDate = $inputs['todayDate'];
        $todayDay = explode("/", $inputs['todayDate'])[2];

        $currentMonth = intval($inputs['currentMonth']);
        $currentYear = intval(explode("/", $inputs['todayDate'])[0]);

        $prevMonth = $currentMonth - 1;
        if ($prevMonth < 1) {
            $prevMonth = 12;
        }

        $nextOneMonth = $currentMonth + 1;
        $nextTwoMonth = $currentMonth + 2;
        if ($nextOneMonth > 12) {
            $nextOneMonth = 1;
        }
        if ($nextTwoMonth > 12) {
            $nextTwoMonth = 1;
        }

        $currentMonthTotalDays = 0;
        if ($currentMonth <= 6) {
            $currentMonthTotalDays = 31;
        } else if ($currentMonth > 6 && $currentMonth < 12) {
            $currentMonthTotalDays = 30;
        } else {
            $currentMonthTotalDays = 29;
        }


        $nextOneMonthDays = 0;

        if ($nextOneMonth <= 6) {
            $nextOneMonthDays = 31;
        } else if ($nextOneMonth > 6 && $nextOneMonth < 12) {
            $nextOneMonthDays = 30;
        } else {
            $nextOneMonthDays = 29;
        }
        $nextOneMonthRealDays = $nextOneMonthDays;

        $nextTwoMonthDays = 0;
        $nextTwoMonthRealDays = 0;
        if ($nextTwoMonth <= 6) {
            $nextTwoMonthDays = 31;
        } else if ($nextTwoMonth > 6 && $nextTwoMonth < 12) {
            $nextTwoMonthDays = 30;
        } else {
            $nextTwoMonthDays = 29;
        }
        $nextTwoMonthRealDays = $nextTwoMonthDays;
        $nextTwoMonthDays = $nextTwoMonthDays + $nextOneMonthDays;

        $remainsDayToEndOfMonth = $currentMonthTotalDays - $todayDay;


        //User Requested KW is for one hour. we should mutiple in 30 days of month and erach day has 24 hour
        $requestedKw = $userRequestedKw * 30 * 24;

        // Gap Between hight price and low price is discount amount s
        $thisMonthDiscount = round($priceGap / 60, 2);


        if (($remainsDayToEndOfMonth) > 60) {
            $thisMonthCalculatedPrice = $LowPrice;
        } else {
            $thisMonthCalculatedPrice = $HighPrice - ($remainsDayToEndOfMonth * $thisMonthDiscount);
        }

        // if order added in current month last 7 days then there is no discount
        if ($todayDay > 23) {
            $thisMonthCalculatedPrice = $HighPrice;
        }
        $thisMonthPowerCost = $requestedKw * $thisMonthCalculatedPrice;


        if (($nextOneMonthDays + $remainsDayToEndOfMonth) > 60) {
            $nextMonthCalculatedPrice = $LowPrice;
        } else {
            $nextMonthCalculatedPrice = $HighPrice - (($nextOneMonthDays + $remainsDayToEndOfMonth) * $thisMonthDiscount);
        }
        $nextMonthPowerCost = $requestedKw * $nextMonthCalculatedPrice;


        if (($nextTwoMonthDays + $nextOneMonthDays + $remainsDayToEndOfMonth) > 60) {
            $nextTwoMonthCalculatedPrice = $LowPrice;
        } else {
            $nextTwoMonthCalculatedPrice = $HighPrice - (($nextTwoMonthDays + $nextOneMonthDays + $remainsDayToEndOfMonth) * $thisMonthDiscount);
        }
        $nextTwoMonthPowerCost = $requestedKw * $nextTwoMonthCalculatedPrice;



        //prevent duplicate buy bill
        $currentBillOrders = $this->db->select('*')->from('person_orders')->where('BillGUID', $inputs['inputBillGUID'])->where_in('Status', array('Done', 'Assigned'))->get();

        $currentMonthNormalHasPayed = false;
        $currentMonthGreenHasPayed = false;
        $nextMonthNormalHasPayed = false;
        $nextMonthGreenHasPayed = false;
        $nextTwoMonthNormalHasPayed = false;
        $nextTwoMonthGreenHasPayed = false;
        if ($currentBillOrders->num_rows() > 0) {
            $prevOrders = $currentBillOrders->result_array();
            foreach ($prevOrders as $prevOrder) {

                if ($prevOrder['FromDate'] == $currentYear . '/' . $currentMonth . '/1' && $prevOrder['ToDate'] == $currentYear . '/' . $currentMonth . '/' . $currentMonthTotalDays && $prevOrder['Type'] == 'Normal') {
                    $currentMonthNormalHasPayed = true;
                }
                if ($prevOrder['FromDate'] == $currentYear . '/' . $currentMonth . '/1' && $prevOrder['ToDate'] == $currentYear . '/' . $currentMonth . '/' . $currentMonthTotalDays && $prevOrder['Type'] == 'Green') {
                    $currentMonthGreenHasPayed = true;
                }

                if ($prevOrder['FromDate'] == $currentYear . '/' . $currentMonth . '/1' && $prevOrder['ToDate'] == $currentYear . '/' . $nextOneMonth . '/' . $nextOneMonthRealDays && $prevOrder['Type'] == 'Normal') {
                    $nextMonthNormalHasPayed = true;
                }
                if ($prevOrder['FromDate'] == $currentYear . '/' . $currentMonth . '/1' && $prevOrder['ToDate'] == $currentYear . '/' . $nextOneMonth . '/' . $nextOneMonthRealDays && $prevOrder['Type'] == 'Green') {
                    $nextMonthGreenHasPayed = true;
                }

                if ($prevOrder['FromDate'] == $currentYear . '/' . $currentMonth . '/1' && $prevOrder['ToDate'] == $currentYear . '/' . $nextTwoMonth . '/' . $nextTwoMonthRealDays && $prevOrder['Type'] == 'Normal') {
                    $nextTwoMonthNormalHasPayed = true;
                }
                if ($prevOrder['FromDate'] == $currentYear . '/' . $currentMonth . '/1' && $prevOrder['ToDate'] == $currentYear . '/' . $nextTwoMonth . '/' . $nextTwoMonthRealDays && $prevOrder['Type'] == 'Green') {
                    $nextTwoMonthGreenHasPayed = true;
                }
            }
        }
        //End prevent duplicate buy bill

        $plans[] = array(
            'PlanOrder' => 1,
            'RemainDays' => $remainsDayToEndOfMonth,
            'FromDate' => $currentYear . '/' . $currentMonth . '/1',
            'ToDate' => $currentYear . '/' . $currentMonth . '/' . $currentMonthTotalDays,
            'TotalDays' => $currentMonthTotalDays,
            'UserRequestedKw' => $userRequestedKw,
            'PowerCost' => ($thisMonthPowerCost),
            'PowerCostWithTax' => ($thisMonthPowerCost + taxPrice($thisMonthPowerCost)),
            'PricePerKW' => $thisMonthCalculatedPrice,
            'CurrentMonthNormalHasPayed' => $currentMonthNormalHasPayed,
            'CurrentMonthGreenHasPayed' => $currentMonthGreenHasPayed
        );

        $plans[] = array(
            'PlanOrder' => 2,
            'RemainDays' => ($nextOneMonthRealDays + $remainsDayToEndOfMonth),
            'FromDate' => $currentYear . '/' . $currentMonth . '/1',
            'ToDate' => $currentYear . '/' . $nextOneMonth . '/' . $nextOneMonthRealDays,
            'UserRequestedKw' => $userRequestedKw,
            'TotalDays' => $currentMonthTotalDays + $nextOneMonthRealDays,
            'PowerCost' => ($thisMonthPowerCost + $nextMonthPowerCost),
            'PowerCostWithTax' => ($nextMonthPowerCost + taxPrice($nextMonthPowerCost)),
            'PricePerKW' => $nextMonthCalculatedPrice,
            'NextMonthNormalHasPayed' => $nextMonthNormalHasPayed,
            'NextMonthGreenHasPayed' => $nextMonthGreenHasPayed
        );

        $plans[] = array(
            'PlanOrder' => 3,
            'RemainDays' => ($nextTwoMonthDays + $nextOneMonthDays + $remainsDayToEndOfMonth),
            'FromDate' => $currentYear . '/' . $currentMonth . '/1',
            'ToDate' => $currentYear . '/' . $nextTwoMonth . '/' . $nextTwoMonthRealDays,
            'UserRequestedKw' => $userRequestedKw,
            'TotalDays' => $currentMonthTotalDays + $nextOneMonthRealDays + $nextTwoMonthRealDays,
            'PowerCost' => ($thisMonthPowerCost + $nextMonthPowerCost + $nextTwoMonthPowerCost),
            'PowerCostWithTax' => ($thisMonthPowerCost + taxPrice($thisMonthPowerCost)) + ($nextMonthPowerCost + taxPrice($nextMonthPowerCost)) + ($nextTwoMonthPowerCost + taxPrice($nextTwoMonthPowerCost)),
            'PricePerKW' => $nextTwoMonthCalculatedPrice,
            'NextTwoMonthNormalHasPayed' => $nextTwoMonthNormalHasPayed,
            'NextTwoMonthGreenHasPayed' => $nextTwoMonthGreenHasPayed
        );


        $result['data']['content'] = $plans;
        return $result;


    }
    /* End Public */

    public function choose_plan($inputs)
    {
        $data = $this->get_bill_plans($inputs);

        $PersonId = $inputs['inputPersonId'];
        $BillGUID = $inputs['inputBillGUID'];
        $ShiftWorkId = $inputs['inputShiftWorkId'];
        $IssueDateTime = time();
        $CreateDateTime = time();
        $CreatePersonId = $PersonId;
        $Status = 'Pend';
        $TotalRequestKW = $inputs['inputTotalRequestKW'];
        $PlanOrder = $inputs['inputPlanOrder'];

        $selectedPlan = "";
        foreach ($data['data']['content'] as $item) {
            if ($item['PlanOrder'] == $PlanOrder) {
                $selectedPlan = $item;
            }
        }
        $TotalDays = $selectedPlan['TotalDays'];
        $PlanOrder = $inputs['inputPlanOrder'];



        $orderArray = array(
            'PersonId' => $PersonId,
            'BillGUID' => $BillGUID,
            'ShiftWorkId' => $ShiftWorkId,
            'IssueDateTime' => $IssueDateTime,
            'CreateDateTime' => $CreateDateTime,
            'CreatePersonId' => $CreatePersonId,
            'TotalRequestKW' => $TotalRequestKW,
            'Status' => $Status,
            'TotalDays' => $TotalDays,
            'PlanOrder' => $PlanOrder,
            'KWPerPrice' => $selectedPlan['PricePerKW'],
            'Type' => 'Normal',
            'TotalPrice' => $selectedPlan['PowerCost'],
            'FinalPrice' => $selectedPlan['PowerCostWithTax'],
            'FromDate' => $selectedPlan['FromDate'],
            'ToDate' => $selectedPlan['ToDate']
        );
        $this->db->insert('person_orders', $orderArray);
        $inserId = $this->db->insert_id();
        return array('orderId' => $inserId);

    }
    public function choose_plan_green($inputs)
    {

        $userRequestedKw = $inputs['inputTotalRequestKW'];

        $todayDate = $inputs['todayDate'];
        $todayDay = explode("/", $inputs['todayDate'])[2];
        $currentMonth = intval($inputs['currentMonth']);
        $currentYear = intval(explode("/", $inputs['todayDate'])[0]);

        $requestedKw = $userRequestedKw * 30 * 24;

        $currentMonthTotalDays = 0;
        if ($currentMonth <= 6) {
            $currentMonthTotalDays = 31;
        } else if ($currentMonth > 6 && $currentMonth < 12) {
            $currentMonthTotalDays = 30;
        } else {
            $currentMonthTotalDays = 29;
        }

        $remainsDayToEndOfMonth = $currentMonthTotalDays - $todayDay;

        $currentMonthGreenPrice = 0;
        foreach ($inputs['electricity_green_price'] as $row) {
            if ($currentMonth == $row['Month']) {
                $currentMonthGreenPrice = $row;
            }
        }

        $LowPrice = $currentMonthGreenPrice['GreenLowPrice'];
        $HighPrice = $currentMonthGreenPrice['GreenHighPrice'];
        $priceGap = $HighPrice - $LowPrice;

        $thisMonthDiscount = round($priceGap / 60, 2);


        if (($remainsDayToEndOfMonth) > 7) {
            $thisMonthCalculatedPrice = $LowPrice;
        } else {
            $thisMonthCalculatedPrice = $HighPrice - ($remainsDayToEndOfMonth * $thisMonthDiscount);
        }
        $thisMonthPowerCost = $requestedKw * $thisMonthCalculatedPrice;


        $PersonId = $inputs['inputPersonId'];
        $BillGUID = $inputs['inputBillGUID'];
        $ShiftWorkId = $inputs['inputShiftWorkId'];
        $IssueDateTime = time();
        $CreateDateTime = time();
        $CreatePersonId = $PersonId;
        $Status = 'Pend';
        $TotalRequestKW = $inputs['inputTotalRequestKW'];

        if ($currentMonthGreenPrice['GreenInventory'] < $userRequestedKw) {
            return 0;
        } else {
            $orderArray = array(
                'PersonId' => $PersonId,
                'BillGUID' => $BillGUID,
                'ShiftWorkId' => $ShiftWorkId,
                'IssueDateTime' => $IssueDateTime,
                'CreateDateTime' => $CreateDateTime,
                'CreatePersonId' => $CreatePersonId,
                'TotalRequestKW' => $TotalRequestKW,
                'Status' => $Status,
                'TotalDays' => $currentMonthTotalDays,
                'PlanOrder' => 0,
                'KWPerPrice' => $thisMonthCalculatedPrice,
                'Type' => 'Green',
                'TotalPrice' => $thisMonthCalculatedPrice * $userRequestedKw,
                'FinalPrice' => $thisMonthCalculatedPrice * $userRequestedKw + (taxPrice($thisMonthCalculatedPrice * $userRequestedKw)),
                'FromDate' => $currentYear . '/' . $currentMonth . '/1',
                'ToDate' => $currentYear . '/' . $currentMonth . '/' . $currentMonthTotalDays
            );
            $this->db->insert('person_orders', $orderArray);
            $inserId = $this->db->insert_id();
            return array('orderId' => $inserId);
        }

    }

}
?>