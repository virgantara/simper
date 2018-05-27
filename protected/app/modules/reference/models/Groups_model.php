<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Groups_model extends CI_Model {

    function get_all($start = 0, $length, $search = '', $order = array()) {
        $this->where_like($search);
        if ($order) {
            $order['column'] = $this->get_alias_key($order['column']);
            $this->db->order_by($order['column'], $order['dir']);
        }
        $this->db->select('mg.*, m.name branch')
                ->join('merchants m', 'm.id = mg.branch', 'left')
                ->limit($length, $start);

        return $this->db->get('merchant_groups mg');
    }

    function get_alias_key($key) {
        switch ($key) {
            case 0: $key = 'mg.name';
                break;
            case 1: $key = 'm.name';
                break;
        }
        return $key;
    }

    function count_all($search = '') {
        $this->where_like($search);
        $this->db->join('merchants m', 'm.id = mg.branch', 'left');
        return $this->db->count_all_results('merchant_groups mg');
    }

    function where_like($search = '') {
        $columns = array('mg.name', 'm.name');
        if ($search) {
            foreach ($columns as $column) {
                $this->db->like('IFNULL(' . $column . ',"")', $search);
            }
        }
    }

}
