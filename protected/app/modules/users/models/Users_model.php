<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    function get_all($start = 0, $length, $search = '', $order = array()) {
        $this->where_like($search);
        if ($order) {
            $order['column'] = $this->get_alias_key($order['column']);
            $this->db->order_by($order['column'], $order['dir']);
        }
        $this->db->select('au.id, fullname, email')
                ->join('auth_users_groups aug', 'aug.user = au.id', 'inner')
                ->where('aug.group', 2)
                ->limit($length, $start);

        return $this->db->get('auth_users au');
    }

    function get_alias_key($key) {
        switch ($key) {
            case 0: $key = 'fullname';
                break;
            case 1: $key = 'email';
                break;
        }
        return $key;
    }

    function count_all($search = '') {
        $this->where_like($search);
        $this->db->join('auth_users_groups aug', 'aug.user = au.id', 'inner')
                ->where('aug.group', 2);
        return $this->db->count_all_results('auth_users au');
    }

    function where_like($search = '') {
        $columns = array('fullname', 'email');
        if ($search) {
            foreach ($columns as $column) {
                $this->db->like('IFNULL(' . $column . ',"")', $search);
            }
        }
    }

}
