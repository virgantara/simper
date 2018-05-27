<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    function get_all($start = 0, $length, $search = '', $order = array()) {
        $this->where_like($search);
        if ($order) {
            $order['column'] = $this->get_alias_key($order['column']);
            $this->db->order_by($order['column'], $order['dir']);
        }
        $this->db->select('au.id, fullname, au.telephone, email, m.name merchant_name')
                ->join('auth_users_groups aug', 'aug.user = au.id', 'inner')
                ->join('merchants m', 'm.auth = au.id', 'left')
                ->where('aug.group', 2)
                ->limit($length, $start);

        return $this->db->get('auth_users au');
    }

    function get_alias_key($key) {
        switch ($key) {
            case 1: $key = 'fullname';
                break;
            case 2: $key = 'email';
                break;
            case 3: $key = 'telephone';
                break;
            case 4: $key = 'm.name';
                break;
        }
        return $key;
    }

    function count_all($search = '') {
        $this->where_like($search);
        $this->db->join('auth_users_groups aug', 'aug.user = au.id', 'inner')
                ->join('merchants m', 'm.auth = au.id', 'inner')
                ->where('aug.group', 2);
        return $this->db->count_all_results('auth_users au');
    }

    function where_like($search = '') {
        $columns = array('fullname', 'email', 'telephone', 'm.name');
        if ($search) {
            foreach ($columns as $column) {
                $this->db->like('IFNULL(' . $column . ',"")', $search);
            }
        }
    }

}
