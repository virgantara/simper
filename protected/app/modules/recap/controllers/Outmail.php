<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Outmail extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('outmail_model', 'outmail');
        $this->data['menu'] = 'recap_outmail';
    }

    public function index() {
        $this->template->_init();
        $this->template->form();
        $this->template->table();
        $this->load->js('assets/js/modules/recap.js');
        $this->output->set_title(lang('recap') . ' ' . lang('outmail'));
        $this->load->view('outmail/list', $this->data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order')[0];
        $draw = intval($this->input->post('draw'));
        $date_start = ($this->input->post('date_start'))?get_date_mysql($this->input->post('date_start')):date('Y-m-d');
        $date_end = ($this->input->post('date_end'))?get_date_mysql($this->input->post('date_end')):date('Y-m-d');

        $output['data'] = array();
        $datas = $this->outmail->get_all($date_start, $date_end,$start, $length, $order);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $output['data'][] = array(
                    number_format($data->sequence, 0, ',', '.'),
                    get_date($data->date),
                    $data->code,
                    $data->to,
                    $data->subject,
                    $data->from,
                    $data->information
                );
            }
        }
        $output['draw'] = $draw++;
        $output['recordsTotal'] = $this->outmail->count_all($date_start, $date_end);
        $output['recordsFiltered'] = $output['recordsTotal'];
        echo json_encode($output);
    }

    public function prints() {
        $date_start = ($this->input->get('start'))?get_date_mysql($this->input->get('start')):date('Y-m-d');
        $date_end = ($this->input->get('end'))?get_date_mysql($this->input->get('end')):date('Y-m-d');
        $data['mails'] = $this->outmail->get_all($date_start, $date_end,'', '', false);
        $this->load->view('outmail/print', $data);
    }

}
