<?php

class Dashboard_model extends CI_Model{
    function total(){
        $this->db->select("SUM(CASE WHEN type = 'in' AND is_deleted = 0 THEN 1 ELSE 0 END) inmail, SUM(CASE WHEN type = 'out' AND is_deleted = 0 THEN 1 ELSE 0 END) outmail",false);
        return $this->db->get('mail')->row();
    }
    
    function last_mail(){
        $this->db->select('m.type, m.code, m.date, m.subject, au.fullname creator')
                ->join('auth_users au','m.user_added = au.id','left')
                ->where('m.is_deleted',0)
                ->limit(10)
                ->order_by('m.id','desc');
        return $this->db->get('mail m');
    }
    function last_outmail_without_file(){
        $this->db->select('m.type, m.code, m.date, m.subject, m.to, au.fullname creator')
                ->join('auth_users au','m.user_added = au.id','left')
                ->where('m.is_deleted',0)
                ->where('m.type','out')
                ->where('(m.file IS NULL OR m.file = "")')
                ->order_by('m.id','desc');
        return $this->db->get('mail m');
    }
}