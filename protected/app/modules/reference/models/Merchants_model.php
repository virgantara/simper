<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Merchants_model extends CI_Model {

    function get($id) {
        $this->db->select('m.*, au.fullname, au.email')
                ->join('auth_users au', 'm.auth = au.id', 'left')
                ->where('is_branch', 0)
                ->where('m.id', $id);
        $query = $this->db->get('merchants m');
        return ($query->num_rows() > 0) ? $query->row() : false;
    }

    function get_all($start = 0, $length, $search = '', $order = array()) {
        $this->where_like($search);
        if ($order) {
            $order['column'] = $this->get_alias_key($order['column']);
            $this->db->order_by($order['column'], $order['dir']);
        }
        $this->db->select('m.*, mg.name group')
                ->limit($length, $start)
                ->join('merchant_groups mg', 'mg.id = m.group', 'left')
                ->where('is_branch', 0);

        return $this->db->get('merchants m');
    }

    function get_alias_key($key) {
        switch ($key) {
            case 0: $key = 'm.name';
                break;
            case 1: $key = 'username';
                break;
            case 2: $key = 'mg.name';
                break;
            case 3: $key = 'cash_balance';
                break;
        }
        return $key;
    }

    function count_all($search = '') {
        $this->where_like($search);
        $this->db->join('merchant_groups mg', 'mg.id = m.group', 'left')
                ->where('is_branch', 0);
        return $this->db->count_all_results('merchants m');
    }

    function where_like($search = '') {
        $columns = array('m.name', 'username', 'mg.name');
        if ($search) {
            foreach ($columns as $column) {
                $this->db->like('IFNULL(' . $column . ',"")', $search);
            }
        }
    }

    function get_admins() {
        $this->ion_auth_model->_ion_select = array('auth_users.id, fullname');
        $this->ion_auth_model->_ion_where = array('auth_users.id NOT IN (SELECT auth FROM merchants)');
        return $this->ion_auth->users(array(3));
    }

}
