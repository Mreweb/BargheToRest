<?php
class ModelNotification extends CI_Model
{

    public function get_list($inputs)
    {
        $this->db->select('notifications.NotificationId ,NotificationTitle,NotificationContent,media.MediaId,Source');
        $this->db->from('notifications');
        $this->db->join('notification_attachment', 'notification_attachment.NotificationId = notifications.NotificationId', 'left');
        $this->db->join('media', 'media.MediaId = notification_attachment.MediaId', 'left');
        if ($inputs['inputNotificationTitle'] != '') {
            $this->db->group_start();
            $this->db->like('NotificationTitle', $inputs['inputNotificationTitle']);
            $this->db->group_end();
        }
        $this->db->where('IsActive', 1);
        $this->db->order_by('notifications.NotificationId', 'DESC');
        $query = $this->db->get()->result_array();
        $result['data']['content'] = $query;
        $result['data']['count'] = 1;
        return $result;
    }
    public function add_notification($inputs)
    {
        $userArray = array(
            'NotificationTitle' => $inputs['inputNotificationTitle'],
            'NotificationContent' => $inputs['inputNotificationContent'],
            'CreateDateTime' => time(),
            'CreatePersonId' => $inputs['inputPersonId']
        );
        $inserId = $this->db->insert('notifications', $userArray);
        if ($inserId > 0) {
            if (isset($inputs['inputNotificationMediaId']) && $inputs['inputNotificationMediaId'] != '') {
                $userArray = array(
                    'NotificationId' => $inserId,
                    'MediaId' => $inputs['inputNotificationMediaId'],
                    'CreateDateTime' => time(),
                    'CreatePersonId' => $inputs['inputPersonId']
                );
                $inserId = $this->db->insert('notification_attachment', $userArray);
            }
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function edit_notification($inputs)
    {

        $userArray = array(
            'NotificationTitle' => $inputs['inputNotificationTitle'],
            'NotificationContent' => $inputs['inputNotificationContent'],
            'ModifyDatetime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('NotificationId', $inputs['inputNotificationId']);
        $this->db->update('notifications', $userArray);
        if ($this->db->affected_rows() > 0) {

            if (isset($inputs['inputNotificationMediaId']) && $inputs['inputNotificationMediaId'] != '') {
                $this->db->delete('notification_attachment', array('NotificationId' => $inputs['inputNotificationId']));
                $userArray = array(
                    'NotificationId' => $inputs['inputNotificationId'],
                    'MediaId' => $inputs['inputNotificationMediaId'],
                    'CreateDateTime' => time(),
                    'CreatePersonId' => $inputs['inputPersonId']
                );
                $inserId = $this->db->insert('notification_attachment', $userArray);
            }

            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }
    public function delete_notification($inputs)
    {

        $userArray = array(
            'IsActive' => 0,
            'ModifyDatetime' => time(),
            'ModifyPersonId' => $inputs['inputPersonId']
        );
        $this->db->where('NotificationId', $inputs['inputNotificationId']);
        $this->db->update('notifications', $userArray);
        if ($this->db->affected_rows() > 0) {
            return get_req_message('SuccessAction');
        } else {
            return get_req_message('ErrorAction');
        }
    }

    public function get_my_list($inputs)
    {
        $unviewedCount = 0;
        $this->db->select('notifications.NotificationId ,NotificationTitle,NotificationContent,media.MediaId,Source');
        $this->db->from('notifications');
        $this->db->join('notification_attachment', 'notification_attachment.NotificationId = notifications.NotificationId', 'left');
        $this->db->join('media', 'media.MediaId = notification_attachment.MediaId', 'left');
        $this->db->where('IsActive', 1);
        $this->db->order_by('notifications.NotificationId', 'DESC');
        $query = $this->db->get()->result_array();
        for ($i = 0; $i < sizeof($query); $i++) {
            $query[$i]['Viewed'] = $this->db->select('*')->from('person_notifications')->where(
                array(
                    'PersonId' => $inputs['inputPersonId'],
                    'NotificationId' => $query[$i]['NotificationId']
                )
            )->get()->num_rows();

            if($query[$i]['Viewed'] == 0){
                $unviewedCount+=1;
            }
        }
        $result['data']['content'] = $query;
        $result['data']['count'] = 1;
        $result['data']['unViewedCount'] = $unviewedCount;
        return $result;
    }


    public function set_my_notification_seen($inputs){

        if ($this->db
            ->select('*')->from('person_notifications')
            ->where(array( 'PersonId' => $inputs['inputPersonId'],  'NotificationId' => $inputs['inputNotificationId'] ))
            ->get()
            ->num_rows() <= 0 ) {
            $userArray = array(
                'NotificationId' => $inputs['inputNotificationId'],
                'CreateDateTime' => time(),
                'PersonId' => $inputs['inputPersonId']
            );
            $inserId = $this->db->insert('person_notifications', $userArray);
            if ($inserId > 0) {
                return get_req_message('SuccessAction');
            } else {
                return get_req_message('ErrorAction');
            }
        } else{
            return get_req_message('SuccessAction');
        }
    }




}
?>