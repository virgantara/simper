<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Outmail_model extends CI_Model {

    function get_all($start = 0, $length, $search = '', $order = array()) {
        $this->_where_like($search);
        if ($order) {
            $order['column'] = $this->_get_alias_key($order['column']);
            $this->db->order_by($order['column'], $order['dir']);
        }
        $this->db->limit($length, $start)
                ->where('is_deleted', 0)
                ->where('type', 'out');
        return $this->db->get('mail');
    }

    private function _get_alias_key($key) {
        switch ($key) {
            case 0: $key = 'code';
                break;
            case 1: $key = 'date';
                break;
            case 2: $key = 'date_in';
                break;
            case 3: $key = 'from';
                break;
            case 4: $key = 'subject';
                break;
            case 5: $key = 'to';
                break;
            case 6: $key = 'information';
                break;
        }
        return $key;
    }

    function count_all($search = '') {
        $this->_where_like($search);
        $this->db->where(array('is_deleted' => 0,'type'=>'out'));
        return $this->db->count_all_results('mail');
    }

    private function _where_like($search = '') {
        $columns = array('code', 'date', 'date_in', 'from','subject','to','information');
        if ($search) {
            $this->db->group_start();
            foreach ($columns as $column) {
                $this->db->or_like('IFNULL(`' . $column . '`,"")', $search);
            }
            $this->db->group_end();
        }
    }
    
    function last_number($date){
        $year = substr($date,0,4);
        $this->db->select('IFNULL(MAX(SUBSTR(code,1,4)),0) last')
                ->where('YEAR(date)',$year)
                ->where('type','out')
                ->where('is_deleted',0);
        return $this->db->get('mail')->row()->last;
    }
    
    public function last_sequence($year){
        $this->db->select('IFNULL(MAX(sequence),0) last')
                ->where('is_deleted',0)
                ->where('type','out')
                ->where('YEAR(date)',$year);
        return $this->db->get('mail')->row()->last;
    }

}
