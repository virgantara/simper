<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Outmail extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('outmail_model', 'outmail');
        $this->data['menu'] = 'outmail';
    }

    public function index() {
        $this->template->_init();
        $this->template->table();
        $this->template->form();
        $this->load->js('assets/js/plugins/fancybox.min.js');
        $this->load->js('assets/js/modules/outmail.js');
        $this->output->set_title(lang('outmail'));
        $this->load->view('list', $this->data);
    }

    public function form($id = '') {
        $this->template->_init();
        $this->template->form();

        $this->data['data'] = array();
        if ($id) {
            $id = decode($id);
            $this->data['data'] = $this->main->get('mail', array('id' => $id));
        } else {
//            $this->data['destinations'] = $this->main->gets('reference', array('type' => 'destination', 'is_deleted' => 0, 'status' => 1), 'code');
            $this->data['classifications'] = $this->main->gets('reference', array('type' => 'classification', 'is_deleted' => 0, 'status' => 1), 'code');
        }
        $this->output->set_title(($this->data['data'] ? lang('edit') : lang('add')) . ' ' . lang('outmail'));
        $this->load->view('form', $this->data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order')[0];
        $search = $this->input->post('search')['value'];
        $draw = intval($this->input->post('draw'));

        $output['data'] = array();
        $datas = $this->outmail->get_all($start, $length, $search, $order);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $output['data'][] = array(
                    $data->code,
                    get_date($data->date),
                    $data->to,
                    $data->subject,
                    $data->from,
                    $data->information,
                    '<ul class="icons-list"><li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">' .
                    (($this->ion_auth->is_admin() || $data->user_added == $this->data['user']->id) ?
                    '<li><a href="javascript:upload(' . $data->id . ');"><i class="icon-upload position-left"></i> Upload</a></li>' : ''
                    ) .
                    '<li><a ' . (!$data->file ? 'style="display:none"' : '') . ' id="view-file-' . $data->id . '" href="javascript:view_file(' . $data->id . ')" data-file="' . base_url($data->file) . '">' . lang('button_view_file') . '</a></li>'.
                    (($this->ion_auth->is_admin() || $data->user_added == $this->data['user']->id) ? 
                    '<li><a href="' . site_url('outmail/form/' . encode($data->id)) . '">' . lang('button_edit') . '</a></li>
                    <li><a href="' . site_url('outmail/delete/' . encode($data->id)) . '" class="delete">' . lang('button_delete') . '</a></li>':'').
                    '</ul>
                    </li></ul>',
                );
            }
        }
        $output['draw'] = $draw++;
        $output['recordsTotal'] = $this->outmail->count_all();
        $output['recordsFiltered'] = $this->outmail->count_all($search);
        echo json_encode($output);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $this->load->library('form_validation');

        if (!$this->input->post('id')) {
//            $this->form_validation->set_rules('destination', 'lang:destination', 'trim|required');
            $this->form_validation->set_rules('classification', 'lang:classification', 'trim|required');
        }
        $this->form_validation->set_rules('date', 'lang:date', 'trim|required');
        $this->form_validation->set_rules('subject', 'lang:subject', 'trim|required');
        $this->form_validation->set_rules('from', 'lang:from', 'trim|required');
        $this->form_validation->set_rules('to', 'lang:to', 'trim|required');
        $this->form_validation->set_rules('information', 'lang:information', 'trim|required');

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            do {
                $data['date'] = $data['date_submit'];
                unset($data['date_submit']);

                $data['type'] = 'out';
                if ($data['id']) {
                    $data['id'] = decode($data['id']);
                    $data['user_modified'] = $this->data['user']->id;
                    $this->main->update('mail', $data, array('id' => $data['id']));
                } else {
                    $year_hijriah = $this->year_hijriah($data['date']);
                    $last_number = $this->outmail->last_number($data['date']) + 1;
                    if ($last_number < 10) {
                        $last_number = '000' . $last_number;
                    } elseif ($last_number < 100) {
                        $last_number = '00' . $last_number;
                    } elseif ($last_number < 1000) {
                        $last_number = '0' . $last_number;
                    }
                    $data['code'] = $last_number . '/UNIDA/FIKES-' . $data['classification'] . '/' . $this->roman(substr($data['date'], 5, 2)) . '/' . $year_hijriah;
                    unset($data['destination']);
                    unset($data['classification']);
                    $data['user_added'] = $this->data['user']->id;
                    $data['sequence'] = $this->outmail->last_sequence(substr($data['date'],0,4))+1;
                    $this->main->insert('mail', $data);
                }

                $return = array('message' => lang('save_success'), 'status' => 'success', 'redirect' => site_url('outmail'));
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'error');
        }

        echo json_encode($return);
    }

    public function upload_file() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $data = $this->input->post(null, true);

        do {
            if (!isset($_FILES['file']['name'])) {
                $return = array('message' => 'File surat harus di upload', 'status' => 'error');
                break;
            }
            $mail = $this->main->get('mail', array('id' => $data['id']));

            $year = substr($mail->date, 0, 4);
            $config['upload_path'] = './files/' . $year . '/';
            $config['allowed_types'] = "gif|jpeg|jpg|png";
            $config['max_size'] = 2048;
            $config['file_name'] = $mail->subject;
            if (!file_exists($config['upload_path'])) {
                mkdir($config['upload_path']);
            }
            $this->load->library('upload');
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')) {
                $return = array('message' => 'File gagal di upload.<br>' . $this->upload->display_errors(), 'status' => 'error');
                break;
            } else {
                $this->main->update('mail', array('file' => $config['upload_path'] . $this->upload->data('file_name'), 'user_modified' => $this->data['user']->id), array('id' => $data['id']));
            }

            $return = array('message' => lang('save_success'), 'status' => 'success', 'id' => $data['id'], 'file' => base_url($config['upload_path'] . $this->upload->data('file_name')));
        } while (0);

        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->main->get('mail', array('id' => $id));
        $delete = $this->main->update('mail', array('is_deleted' => 1), array('id' => $id));
        if ($delete) {
            $return = array('message' => lang('delete_success'), 'status' => 'success');
        } else {
            $return = array('message' => lang('delete_error'), 'status' => 'danger');
        }
        echo json_encode($return);
    }

    private function year_hijriah($date) {
        $y = substr($date, 0, 4);
        $m = substr($date, 5, 2);
        $d = substr($date, 8, 2);
        $jd = GregoriantoJD($m, $d, $y);
        $l = $jd - 1948440 + 10632;
        $n = (int) (( $l - 1 ) / 10631);
        $l = $l - 10631 * $n + 354;
        $j = ( (int) (( 10985 - $l ) / 5316)) * ( (int) (( 50 * $l) / 17719)) + (
                (int) ( $l / 5670 )) * ( (int) (( 43 * $l ) / 15238 ));
        $l = $l - ( (int) (( 30 - $j ) / 15 )) * ( (int) (( 17719 * $j ) / 50)) - (
                (int) ( $j / 16 )) * ( (int) (( 15238 * $j ) / 43 )) + 29;
        $m = (int) (( 24 * $l ) / 709 );
        $d = $l - (int) (( 709 * $m ) / 24);
        $y = 30 * $n + $j - 30;

        return $y;
    }

    private function roman($n) {
        $hasil = "";
        $iromawi = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", 20 => "XX", 30 => "XXX", 40 => "XL", 50 => "L",
            60 => "LX", 70 => "LXX", 80 => "LXXX", 90 => "XC", 100 => "C", 200 => "CC", 300 => "CCC", 400 => "CD", 500 => "D", 600 => "DC", 700 => "DCC",
            800 => "DCCC", 900 => "CM", 1000 => "M", 2000 => "MM", 3000 => "MMM");
        if (array_key_exists($n, $iromawi)) {
            $hasil = $iromawi[$n];
        } elseif ($n >= 11 && $n <= 99) {
            $i = $n % 10;
            $hasil = $iromawi[$n - $i] . $this->roman($n % 10);
        } elseif ($n >= 101 && $n <= 999) {
            $i = $n % 100;
            $hasil = $iromawi[$n - $i] . $this->roman($n % 100);
        } else {
            $i = $n % 1000;
            $hasil = $iromawi[$n - $i] . $this->roman($n % 1000);
        }
        return $hasil;
    }

}
