<?php

class Listing extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function addlisting($params) {
        $data = $params;
        isset($data['prop_id']) ? TRUE : $data['prop_id'] = uniqid();
        $meta['prop_id'] = $data['prop_id'];
        $meta['prop_name'] = isset($data['prop_name']) ? $data['prop_name'] : '';
        $continue = $this->db->replace('listings_meta', $meta) ? TRUE : FALSE;
        $query = "REPLACE INTO `listings` (`prop_id`,`prop_key`,`value`) VALUES";
        $count = 0;
        $uid = $data['prop_id'];
        foreach ($data as $key => $value) {
            $count++;
            if ($count == 1) {
                $query.=" ('$uid','$key','$value')";
            } else {
                $query.=", ('$uid','$key','$value')";
            }
        }
        //$status['query'] = $query;
        $status['success'] = $this->db->query($query);
        $response = json_encode($status);
        echo $response;
    }

    public function getlistings($params) {
        $this->db->from('listings');
        $this->db->where('prop_key="prop_id" OR prop_key="prop_name" OR prop_key="prop_img"');
        $data[] = '';
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $key = $row->prop_key;
            $prop_id = $row->prop_id;
            $data[$prop_id][$key] = $row->value;
        }
        echo json_encode($data);
    }

}
