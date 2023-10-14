<?php

class ModelProfile extends CI_Model
{
    /*Bank Cart */
    public function getBankCartByPersonId($personId)
    {
        $this->db->select('*');
        $this->db->from('person_bank_cart');
        $this->db->where(array('CartPersonId' => $personId));
        return $this->db->get()->result_array();
    }

    public function getBankCartByCartId($Id)
    {
        $this->db->select('*');
        $this->db->from('person_bank_cart');
        $this->db->where(array('CartId' => $Id));
        return $this->db->get()->result_array();
    }

    public function doAddBankCart($inputs)
    {

        $this->db->select('*');
        $this->db->from('person_bank_cart');
        $this->db->where(array('CartNumber' => $inputs['inputCartNumber']));
        $this->db->or_where(array('CartShaba' => $inputs['inputCartShaba']));
        $this->db->or_where(array('CartSerial' => $inputs['inputCartSerial']));
        $data = $this->db->get()->result_array();
        if (!empty($data)) {
            return $this->config->item('DBMessages')['DuplicateInfo'];
        } else {
            $userArray = array(
                'CartNumber' => $inputs['inputCartNumber'],
                'CartShaba' => $inputs['inputCartShaba'],
                'CartSerial' => $inputs['inputCartSerial'],
                'CartPersonId' => $inputs['inputCartPersonId'],
                'CreatePersonId' => $inputs['inputCreatePersonId'],
                'CreateDateTime' => time(),
                'ModifyPersonId' => $inputs['inputModifyPersonId'],
                'ModifyDateTime' => time()
            );
            $this->db->insert('person_bank_cart', $userArray);
            return $this->config->item('DBMessages')['SuccessAction'];
        }


    }

    public function doEditBankCart($inputs)
    {
        $userArray = array(
            'CartNumber' => $inputs['inputCartNumber'],
            'CartShaba' => $inputs['inputCartShaba'],
            'CartSerial' => $inputs['inputCartSerial'],
            'ModifyPersonId' => $inputs['inputModifyPersonId'],
            'ModifyDateTime' => time()
        );
        $this->db->where('CartId', $inputs['inputCartId']);
        $this->db->where('CartPersonId', $inputs['inputCartPersonId']);
        $this->db->update('person_bank_cart', $userArray);
        return $this->config->item('DBMessages')['SuccessAction'];

    }
    /* End Bank Cart */

    /* Notifications */
    public function getNotifications()
    {
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where('IsActive', 1);
        return $this->db->get()->result_array();
    }

    public function getUnWatchedNotificationCountByPersonId($personId)
    {
        $this->db->select('*');
        $this->db->from('notifications');
        $this->db->where('IsActive', 1);
        $allNotificationsCount = $this->db->get()->num_rows();

        $this->db->select('*');
        $this->db->from('person_notifications');
        $this->db->where('CreatePersonId', $personId);
        $watchedNotificationsCount = $this->db->get()->num_rows();

        return $allNotificationsCount - $watchedNotificationsCount;
    }

    public function getUnPaidPaymentsByPersonId($personId)
    {
        $this->db->select('*');
        $this->db->from('pre_payments');
        $this->db->where('PrePaymentPersonId', $personId);
        $this->db->group_start();
        $this->db->where('pre_payments.PrePaymentStatus', 'Pending');
        $this->db->or_where('pre_payments.PrePaymentStatus', 'OrganizationPay');
        $this->db->group_end();
        return $this->db->get()->num_rows();
    }

    public function getNotificationAttachment($notificationId)
    {
        $this->db->select('*');
        $this->db->from('notification_attachment');
        $this->db->where(array('NotificationId' => $notificationId));
        return $this->db->get()->result_array();
    }

    public function getWatchedNotificationsByPersonId($personId, $notificationId)
    {
        $this->db->select('*');
        $this->db->from('person_notifications');
        $this->db->where(array('CreatePersonId' => $personId));
        $this->db->where(array('NotificationId' => $notificationId));
        return $this->db->get()->result_array();
    }

    public function doWatchNotifications($inputs)
    {
        $this->db->delete('person_notifications', array(
            'NotificationId' => $inputs['inputNotificationId'],
            'CreatePersonId' => $inputs['inputNotificationPersonId'],
        ));
        $userArray = array(
            'NotificationId' => $inputs['inputNotificationId'],
            'CreatePersonId' => $inputs['inputNotificationPersonId'],
            'CreateDateTime' => time()
        );
        $this->db->insert('person_notifications', $userArray);
        return $this->config->item('DBMessages')['SuccessAction'];

    }
    /* End Notifications */

    /* Setting */
    public function doChangePassword($inputs)
    {
        $userArray = array(
            'Password' => md5($inputs['inputNewPassword']),
            'ModifyDatetime' => time(),
            'ModifyPersonId' => $inputs['inputModifyPersonId']
        );
        $this->db->where('PersonId', $inputs['inputModifyPersonId']);
        $this->db->update('person', $userArray);
        return $this->config->item('DBMessages')['SuccessAction'];

    }

    public function doChangeInfo($inputs)
    {
        if ($inputs['PersonNationalCode'] != '' && $inputs['PersonNationalCode'] != null) {
            $this->db->select('*');
            $this->db->from('person');
            $this->db->where(
                array(
                    'PersonId !=' => $inputs['inputModifyPersonId'],
                    'PersonNationalCode' => $inputs['inputPersonNationalCode'],
                )
            );
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                return $this->config->item('DBMessages')['DuplicateInfo'];
            }
        }

        if ($inputs['inputPersonProfileImage'] != '' && $inputs['inputPersonProfileImage'] != null) {
            $userArray = array(
                'PersonProfileImage' => $inputs['inputPersonProfileImage'],
                'PersonFirstName' => $inputs['inputPersonFirstName'],
                'PersonLastName' => $inputs['inputPersonLastName'],
                'PersonNationalCode' => $inputs['inputPersonNationalCode'],
                'PersonHomePhone' => $inputs['inputPersonHomePhone'],
                'PersonGender' => $inputs['inputPersonGender'],
                'PersonEmail' => $inputs['inputPersonEmail'],
                'ModifyDatetime' => time(),
                'ModifyPersonId' => $inputs['inputModifyPersonId']
            );
        } else {
            $userArray = array(
                'PersonFirstName' => $inputs['inputPersonFirstName'],
                'PersonLastName' => $inputs['inputPersonLastName'],
                'PersonHomePhone' => $inputs['inputPersonHomePhone'],
                'PersonNationalCode' => $inputs['inputPersonNationalCode'],
                'PersonGender' => $inputs['inputPersonGender'],
                'PersonEmail' => $inputs['inputPersonEmail'],
                'ModifyDatetime' => time(),
                'ModifyPersonId' => $inputs['inputModifyPersonId']
            );
        }
        if ($inputs['PersonNationalCode'] == '' || $inputs['PersonNationalCode'] == null) {
            unset($userArray["PersonNationalCode"]);
        }
        $this->db->where('PersonId', $inputs['inputModifyPersonId']);
        $this->db->update('person', $userArray);


        $this->db->select('*');
        $this->db->from('person');
        $this->db->where('PersonId', $inputs['inputModifyPersonId']);
        $query = $this->db->get();
        $this->session->set_userdata('LoginInfo', $query->result_array()[0]);
        $this->session->set_userdata('IsLogged', TRUE);

        return $this->config->item('DBMessages')['SuccessAction'];

    }

    public function doChangeCompanyInfo($inputs){
        $userArray = array(
            'LegalInvoiceCompanyName' => $inputs['inputLegalInvoiceCompanyName'],
            'LegalInvoiceCompanyId' => $inputs['inputLegalInvoiceCompanyId'],
            'LegalInvoiceCompanyFinanceCode' => $inputs['inputLegalInvoiceCompanyFinanceCode'],
            'LegalInvoiceCompanyPostalCode' => $inputs['inputLegalInvoiceCompanyPostalCode'],
            'LegalInvoiceCompanyAddress' => $inputs['inputLegalInvoiceCompanyAddress'],
            'ModifyDatetime' => time(),
            'ModifyPersonId' => $inputs['inputModifyPersonId']
        );
        $this->db->where('PersonId', $inputs['inputModifyPersonId']);
        $this->db->update('person_invoice_info', $userArray);
        return $this->config->item('DBMessages')['SuccessAction'];
    }

    /* End Setting */

    /* Tickets */
    public function getTicketDepartment()
    {
        $this->db->select('*');
        $this->db->from('ticket_department');
        return $this->db->get()->result_array();
    }

    public function getTicketsByPersonId($personId)
    {
        $this->db->select('*');
        $this->db->from('ticket');
        $this->db->from('ticket_department', 'ticket_department.TicketDepartmentId = ticket.TicketDepartmentId');
        $this->db->where(array('TicketPersonId' => $personId));
        $this->db->group_by('ticket.TicketId');
        $this->db->order_by('TicketId', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getUnClosedTicketsByPersonId($personId)
    {
        $this->db->select('*');
        $this->db->from('ticket');
        $this->db->where(array(
            'TicketPersonId' => $personId,
            'TicketStatus' => 'DepartmentAnswer'
        ));
        $this->db->group_by('ticket.TicketId');
        $this->db->order_by('TicketId', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getTicketByTicketId($ticketId)
    {
        $this->db->select('*');
        $this->db->from('ticket');
        $this->db->where(array('TicketId' => $ticketId));
        return $this->db->get()->result_array();
    }

    public function getTicketByTicketPersonId($ticketId, $personId)
    {
        $this->db->select('*');
        $this->db->from('ticket');
        $this->db->join('person', 'person.PersonId = ticket.CreatePersonId');
        $this->db->where(array('TicketId' => $ticketId));
        $this->db->where(array('TicketPersonId' => $personId));
        return $this->db->get()->result_array();
    }

    public function getTicketAnswerByTicketId($ticketId)
    {
        $this->db->select('*');
        $this->db->from('ticket_answer');
        $this->db->join('person', 'person.PersonId = ticket_answer.CreatePersonId');
        $this->db->where(array('TicketId' => $ticketId));
        return $this->db->get()->result_array();
    }

    public function getTicketAttahcmentByTicketId($ticketId)
    {
        $this->db->select('*');
        $this->db->from('ticket_attachment');
        $this->db->where(array('TicketId' => $ticketId));
        return $this->db->get()->result_array();
    }

    public function getTicketAnswerAttahcmentByAnswerId($AnswerId)
    {
        $this->db->select('*');
        $this->db->from('ticket_attachment');
        $this->db->where(array('TicketAnswerId' => $AnswerId));
        return $this->db->get()->result_array();
    }

    public function doSendTicket($inputs)
    {
        $userArray = array(
            'TicketTitle' => $inputs['inputTicketTitle'],
            'TicketPriority' => $inputs['inputTicketPriority'],
            'TicketContent' => $inputs['inputTicketContent'],
            'TicketPersonId' => $inputs['inputTicketPersonId'],
            'TicketDepartmentId' => $inputs['inputTicketDepartmentId'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputTicketPersonId']
        );
        $this->db->insert('ticket', $userArray);

        $ticketId = $this->db->insert_id();
        if ($inputs['inputAttachmentSource'] != '') {
            $userArray = array(
                'TicketId' => $ticketId,
                'TicketAnswerId' => NULL,
                'AttachmentSource' => $inputs['inputAttachmentSource'],
                'CreateDateTime' => time(),
                'CreatePersonId' => $inputs['inputTicketPersonId']
            );
            $this->db->insert('ticket_attachment', $userArray);
        }
        return $this->config->item('DBMessages')['SuccessAction'];
    }

    public function doAnswerTicket($inputs)
    {

        $userArray = array(
            'TicketStatus' => 'PersonAnswer'
        );
        $this->db->where('TicketId', $inputs['inputTicketId']);
        $this->db->update('ticket', $userArray);


        $userArray = array(
            'TicketId' => $inputs['inputTicketId'],
            'Answer' => $inputs['inputTicketContent'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputTicketPersonId']
        );
        $this->db->insert('ticket_answer', $userArray);
        $TicketAnswerId = $this->db->insert_id();

        if ($inputs['inputAttachmentSource'] != '') {
            $userArray = array(
                'TicketId' => NULL,
                'TicketAnswerId' => $TicketAnswerId,
                'AttachmentSource' => $inputs['inputAttachmentSource'],
                'CreateDateTime' => time(),
                'CreatePersonId' => $inputs['inputTicketPersonId']
            );
            $this->db->insert('ticket_attachment', $userArray);
        }
        return $this->config->item('DBMessages')['SuccessAction'];
    }

    public function doCloseTicket($inputs)
    {
        $userArray = array(
            'TicketStatus' => 'Closed',
            'ModifyDatetime' => time(),
            'ModifyPersonId' => $inputs['inputTicketPersonId']
        );
        $this->db->where('TicketId', $inputs['inputTicketId']);
        $this->db->where('TicketPersonId', $inputs['inputTicketPersonId']);
        $this->db->update('ticket', $userArray);
        return $this->config->item('DBMessages')['SuccessAction'];
    }
    /* End Tickets */

    /* Change Mobile */
    public function doVerifyPhone($inputs)
    {
        $userArray = array(
            'PersonPhone' => $inputs['inputPhone'],
            'ModifyDatetime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person', $userArray);
        return $this->config->item('DBMessages')['SuccessAction'];

    }
    /* End Change Mobile */

    /* Address */
    public function getAddressByPersonId($personId)
    {
        $this->db->select('*');
        $this->db->from('person_address');
        $this->db->join('state' , 'person_address.StateId = state.StateId');
        $this->db->join('city' , 'person_address.CityId = city.CityId');
        $this->db->where(array('PersonId' => $personId));
        $this->db->order_by('AddressId', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getAddressByAddressPersonId($addressId, $personId)
    {
        $this->db->select('*');
        $this->db->from('person_address');
        $this->db->where(array('AddressId' => $addressId));
        $this->db->where(array('PersonId' => $personId));
        return $this->db->get()->result_array();
    }

    public function doAddAddress($inputs)
    {
        $userArray = array(
            'PersonId' => $inputs['inputPersonId'],
            'DeliveryPlace' => $inputs['inputDeliveryPlace'],
            'StateId' => $inputs['inputStateId'],
            'CityId' => $inputs['inputCityId'],
            'PostalCode' => $inputs['inputPostalCode'],
            'Address' => $inputs['inputAddress'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputPersonId']
        );
        $this->db->insert('person_address', $userArray);


        $userArray = array(
            'PersonFirstName' => $inputs['inputPersonFirstName'],
            'PersonLastName' => $inputs['inputPersonLastName']
        );
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person', $userArray);

        $this->db->select('*');
        $this->db->from('person');
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $query = $this->db->get();
        $this->session->set_userdata('LoginInfo' , $query->result_array()[0]);
        $this->session->set_userdata('IsLogged' , TRUE);

        return $this->config->item('DBMessages')['SuccessAction'];

    }

    public function doEditAddress($inputs)
    {
        $userArray = array(
            'DeliveryPlace' => $inputs['inputDeliveryPlace'],
            'StateId' => $inputs['inputStateId'],
            'CityId' => $inputs['inputCityId'],
            'PostalCode' => $inputs['inputPostalCode'],
            'Address' => $inputs['inputAddress'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputPersonId']
        );
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->where('AddressId', $inputs['inputAddressId']);
        $this->db->update('person_address', $userArray);
        return $this->config->item('DBMessages')['SuccessAction'];

    }

    public function doDeleteAddress($inputs)
    {
        $this->db->delete('person_address', array(
            'PersonId' => $inputs['inputPersonId'],
            'AddressId' => $inputs['inputAddressId'],
        ));
        return $this->config->item('DBMessages')['SuccessAction'];
    }
    /* End Address */

    /* Credit */
    public function getBalanceByPersonId($personId)
    {
        $this->db->select('*');
        $this->db->from('person_account_balance');
        $this->db->where(array('PersonId' => $personId));
        return $this->db->get()->result_array();
    }

    public function getBalancePaymentsByPersonId($personId)
    {
        $this->db->select('*');
        $this->db->from('person_account_balance_payment');
        $this->db->where(array('BalancePersonId' => $personId));
        $this->db->order_by('BalancePaymentId', 'DESC');
        return $this->db->get()->result_array();
    }

    public function doReadyIncreaseBalance($inputs)
    {
        $userArray = array(
            'BalanceAmount' => $inputs['inputBalance'],
            'BalancePersonId' => $inputs['inputPersonId'],
            'GateWay' => 'ZarinPal',
            'CreateDateTime' => time()
        );
        $this->db->insert('person_account_balance_payment', $userArray);

        $BalancePaymentId = $this->db->insert_id();
        $arr = $this->config->item('DBMessages')['SuccessAction'];
        $arr['BalanceId'] = $BalancePaymentId;
        $arr['Balance'] = $inputs['inputBalance'];

        $BalancePaymentInfo = array(
            'BalanceId' => $BalancePaymentId,
            'Balance' => $inputs['inputBalance'],
            'BalancePersonId' => $inputs['inputPersonId']
        );
        $this->session->set_userdata('BalancePaymentInfo', $BalancePaymentInfo);
        return $arr;
    }

    public function setPaymentPaid($inputs)
    {
        $userArray = array(
            'Status' => 'Done',
            'Authority' => $inputs['BalanceAuthority'],
            'PayDateTime' => time()
        );
        $this->db->where('BalancePaymentId', $inputs['BalanceId']);
        $this->db->where('BalanceAmount', $inputs['Balance']);
        $this->db->update('person_account_balance_payment', $userArray);

        $this->session->set_flashdata('Message', 'پرداخت با موفقیت انجام شد');
        return $this->config->item('DBMessages')['SuccessAction'];

    }

    public function IncreaseBalance($inputs)
    {
        $this->db->set('AccountBalance', 'AccountBalance + ' . (float)$inputs['Balance'], FALSE);
        $this->db->set('ModifyDatetime', time(), FALSE);
        $this->db->set('ModifyPersonId', $inputs['inputPersonId'], FALSE);
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person_account_balance');
        return $this->config->item('DBMessages')['SuccessAction'];

    }

    public function DecreaseBalance($inputs)
    {
        $this->db->set('AccountBalance', 'AccountBalance - ' . (float)$inputs['Balance'], FALSE);
        $this->db->set('ModifyDatetime', time(), FALSE);
        $this->db->set('ModifyPersonId', $inputs['inputPersonId'], FALSE);
        $this->db->where('PersonId', $inputs['inputPersonId']);
        $this->db->update('person_account_balance');
        return $this->config->item('DBMessages')['SuccessAction'];

    }

    public function setPaymentFailed($inputs)
    {
        $userArray = array(
            'Status' => 'Failed',
            'Authority' => $inputs['BalanceAuthority'],
            'PayDateTime' => time(),
        );
        $this->db->where('BalancePaymentId', $inputs['BalanceId']);
        $this->db->where('BalanceAmount', $inputs['Balance']);
        $this->db->update('person_account_balance_payment', $userArray);
        $this->session->set_flashdata('Message', 'پرداخت ناموفق');
        return $this->config->item('DBMessages')['SuccessAction'];
    }

    public function getBalanceClearRequestsByPersonId($personId)
    {
        $this->db->select('*');
        $this->db->from('person_account_balance_clear');
        $this->db->where(array('ClearRequestPersonId' => $personId));
        $this->db->order_by('ClearRequestId', 'DESC');
        return $this->db->get()->result_array();
    }

    public function doReadyClearBalance($inputs)
    {
        $userArray = array(
            'ClearRequestAmount' => $inputs['inputClearBalance'],
            'ClearRequestPersonId' => $inputs['inputPersonId'],
            'ClearRequestCartId' => $inputs['inputCartId'],
            'CreateDateTime' => time()
        );
        $this->db->insert('person_account_balance_clear', $userArray);
        return $this->config->item('DBMessages')['SuccessAction'];
    }
    /* End Credit */

    /* For Orders */
    public function getOrdersByPersonId($inputs)
    {
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where(array('OrderPersonId' => $inputs['inputPersonId']));
        $this->db->order_by('OrderId', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getOrdersByStepByPersonId($orderStep, $personId)
    {
        $this->db->select('*');
        $this->db->from('orders');
        $this->db->where(array(
            'OrderPersonId' => $personId,
            'OrderStep' => $orderStep
        ));
        $this->db->order_by('OrderId', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getOrdersDevicesByPersonId($inputs)
    {
        $this->db->select('* , order_device.CreateDateTime as CDT');
        $this->db->from('order_device');
        $this->db->join('device', 'device.DeviceId = order_device.DeviceId', 'left');
        $this->db->join('device_part', 'device_part.DevicePartId  = order_device.DevicePartId', 'left');
        $this->db->where(
            array(
                'OrderId' => $inputs['inputOrderId'],
                'OrderPersonId' => $inputs['inputPersonId']
            )
        );
        $this->db->order_by('OrderDeviceUUID ', 'DESC');
        return $this->db->get()->result_array();
    }

    public function getOrderPostInfoByOrderId($inputs)
    {
        $this->db->select('*');
        $this->db->from('order_post_info');
        $this->db->where(array('PostOrderId' => $inputs['inputOrderId']));
        $this->db->order_by('PostId  ', 'DESC');
        return $this->db->get()->result_array();
    }

    public function doSendOrderDevicesToHolding($inputs)
    {


        $userArray = array(
            'OrderStep' => 'SendByClient',
            'ModifyDateTime' => time()
        );
        $this->db->where('OrderId ', $inputs['inputPostOrderId']);
        $this->db->update('orders', $userArray);
        $this->db->reset_query();

        $userArray = array(
            'PostOrderId' => $inputs['inputPostOrderId'],
            'PostSendMethod' => $inputs['inputPostSendMethod'],
            'PostSendDate' => makeTime($inputs['inputPostSendDate']),
            'PostTrackNumber' => $inputs['inputPostTrackNumber'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputCreatePersonId']
        );
        $this->db->insert('order_post_info', $userArray);
        return $this->config->item('DBMessages')['SuccessAction'];
    }

    public function doRevertOrderDevicesToHolding($inputs)
    {
        $userArray = array(
            'PostOrderId' => $inputs['inputPostOrderId'],
            'PostSendMethod' => $inputs['inputPostSendMethod'],
            'PostSendDate' => makeTime($inputs['inputPostSendDate']),
            'PostTrackNumber' => $inputs['inputPostTrackNumber'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputCreatePersonId']
        );
        $this->db->insert('order_post_info', $userArray);


        $userArray = array(
            'OrderStep' => 'Reverted',
            'ModifyDateTime' => time()
        );
        $this->db->where('OrderId ', $inputs['inputPostOrderId']);
        $this->db->update('orders', $userArray);
        $this->db->reset_query();


        foreach ($inputs['inputOrderDeviceUUID'] as $item) {
            $userArray = array(
                'DeviceOrderStep' => 'BrokenDevice',
                'ModifyPersonId' => $inputs['inputCreatePersonId'],
                'ModifyDateTime' => time(),
            );
            $this->db->where('OrderDeviceUUID', $item);
            $this->db->update('order_device', $userArray);
            $this->db->reset_query();
        }


        return $this->config->item('DBMessages')['SuccessAction'];
    }

    public function getPrePaymentsByPersonId($personId)
    {
        $this->db->select('*');
        $this->db->from('pre_payments');
        $this->db->where(
            array(
                'PrePaymentPersonId' => $personId,
                'PrePaymentStatus' => 'Done'
            )
        );
        $this->db->order_by('PrePaymentId', 'DESC');
        return $this->db->get()->result_array();
    }
    /* End For Orders */

}

?>