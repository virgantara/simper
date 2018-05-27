<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');
if (!function_exists('menu_active')) {

    function menu_active($menu, $active) {
        if (substr($menu, 0, strlen($active)) == $active) {
            return 'active';
        } else {
            return FALSE;
        }
    }

}

if (!function_exists('encode')) {

    function encode($string) {
        return encrypt_decrypt('encrypt', $string);
    }

}

if (!function_exists('decode')) {

    function decode($string) {
        return encrypt_decrypt('decrypt', $string);
    }

}

if (!function_exists('encrypt_decrypt')) {

    function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'bogaLab';
        $secret_iv = 'rifkysyaripudin';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

}

if (!function_exists('get_date')) {

    function get_date($date) {
        $format = settings('date_format');
        $timestamp = strtotime($date);
        return date($format, $timestamp);
    }

}
if (!function_exists('get_date_time')) {

    function get_date_time($date) {
        $format = settings('date_format') . ' H:i';
        $timestamp = strtotime($date);
        return date($format, $timestamp);
    }

}

if (!function_exists('get_date_mysql')) {

    function get_date_mysql($date) {
        return date_format(date_create_from_format(settings('date_format'), $date), 'Y-m-d');
    }

}

if (!function_exists('get_month')) {

    function get_month($month) {
        $CI = get_instance();
        if (is_numeric($month)) {
            $month = date('F', strtotime('2017-' . $month . '-01 00:00:00'));
        }
        return $CI->lang->line($month);
    }

}

if (!function_exists('settings')) {

    function settings($key) {
        if ($key) {
            $CI = get_instance();
            $CI->load->database();
            $query = $CI->db->get_where('settings', array('key' => $key));
            if ($query->num_rows() > 0) {
                return $query->row()->value;
            } else {
                return false;
            }
        }
    }

}

if (!function_exists('remove_space')) {

    function remove_space($string) {
        return str_replace(' ', '', $string);
    }

}

if (!function_exists('send_mail')) {

    function send_mail($from, $to, $subject, $message) {
        $CI = get_instance();
        $CI->config->load('smtp');
        $CI->load->library('email');
        $CI->email->initialize(array(
            'protocol' => 'smtp',
            'smtp_host' => $CI->config->item('smtp_host'),
            'smtp_user' => $CI->config->item('smtp_user'),
            'smtp_pass' => $CI->config->item('smtp_password'),
            'smtp_port' => $CI->config->item('smtp_port'),
            'crlf' => "\r\n",
            'newline' => "\r\n",
            'mailtype' => 'html'
        ));
        $CI->email->from($from);
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);

        if ($CI->email->send())
            return true;
        else {
            log_message('error', $CI->email->print_debugger());
            return false;
        }
    }

}

/* End of file common_helper.php */
/* Location: ./system/helpers/common_helper.php */
