<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Disposition_model extends CI_Model {

    function get_all($mail, $start = 0, $length, $search = '', $order = array()) {
        $this->_where_like($search);
        if ($order) {
            $order['column'] = $this->_get_alias_key($order['column']);
            $this->db->order_by($order['column'], $order['dir']);
        }
        $this->db->limit($length, $start)
                ->where('is_deleted', 0)
                ->where('mail', $mail);
        return $this->db->get('disposition');
    }

    private function _get_alias_key($key) {
        switch ($key) {
                case 0: $key = 'date';
                break;
            case 1: $key = 'to';
                break;
            case 2: $key = 'reference_name';
                break;
            case 3: $key = 'note';
                break;
            case 4: $key = 'from';
                break;
        }
        return $key;
    }

    function count_all($mail, $search = '') {
        $this->_where_like($search);
        $this->db->where(array('is_deleted' => 0,'mail'=>$mail));
        return $this->db->count_all_results('disposition');
    }

    private function _where_like($search = '') {
        $columns = array('to', 'date', 'reference_code', 'reference_name','note');
        if ($search) {
            $this->db->group_start();
            foreach ($columns as $column) {
                $this->db->or_like('IFNULL(`' . $column . '`,"")', $search);
            }
            $this->db->group_end();
        }
    }

}
