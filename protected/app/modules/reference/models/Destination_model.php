<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Destination_model extends CI_Model {

    function get_all($start = 0, $length, $search = '', $order = array()) {
        $this->where_like($search);
        if ($order) {
            $order['column'] = $this->get_alias_key($order['column']);
            $this->db->order_by($order['column'], $order['dir']);
        }
        $this->db->select('*')
                ->where('type', 'destination')
                ->where('is_deleted', 0)
                ->where('status', 1)
                ->limit($length, $start);

        return $this->db->get('reference');
    }

    function get_alias_key($key) {
        switch ($key) {
            case 0: $key = 'code';
                break;
            case 1: $key = 'name';
                break;
        }
        return $key;
    }

    function count_all($search = '') {
        $this->where_like($search);
        $this->db->where('type', 'destination')
                ->where('is_deleted', 0)
                ->where('status', 1);
        return $this->db->count_all_results('reference');
    }

    function where_like($search = '') {
        $columns = array('name', 'code');
        if ($search) {
            $this->db->group_start();
            foreach ($columns as $column) {
                $this->db->or_like('IFNULL(`' . $column . '`,"")', $search);
            }
            $this->db->group_end();
        }
    }

}
