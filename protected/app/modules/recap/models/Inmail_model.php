<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inmail_model extends CI_Model {

    function get_all($date_start, $date_end,$start = 0, $length, $order = array()) {
        if ($order) {
            $order['column'] = $this->_get_alias_key($order['column']);
            $this->db->order_by($order['column'], $order['dir']);
        }
        $this->db->limit($length, $start)
                ->where("date BETWEEN '$date_start' AND '$date_end'")
                ->where('is_deleted', 0)
                ->where('type', 'in');
        return $this->db->get('mail');
    }

    private function _get_alias_key($key) {
        switch ($key) {
            case 0: $key = 'sequence';
                break;
            case 1: $key = 'date_in';
                break;
            case 2: $key = 'date';
                break;
            case 3: $key = 'code';
                break;
            case 4: $key = 'to';
                break;
            case 5: $key = 'subject';
                break;
            case 6: $key = 'from';
                break;
            case 7: $key = 'information';
                break;
        }
        return $key;
    }

    function count_all($date_start, $date_end) {
        $this->db->where("date BETWEEN '$date_start' AND '$date_end'")
                ->where(array('is_deleted' => 0,'type'=>'in'));
        return $this->db->count_all_results('mail');
    }
    
}
