<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Inmail extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('inmail_model', 'inmail');
        $this->data['menu'] = 'inmail';
    }

    public function index() {
        $this->template->_init();
        $this->template->table();
        $this->load->js('assets/js/plugins/fancybox.min.js');
        $this->load->js('assets/js/modules/outmail.js');
        $this->output->set_title(lang('inmail'));
        $this->load->view('list', $this->data);
    }

    public function form($id = '') {
        $this->template->_init();
        $this->template->form();
        $this->data['data'] = array();
        $this->data['dispositions'] = $this->main->gets('reference', array('type' => 'disposition', 'is_deleted' => 0, 'status' => 1), 'code');
        $this->data['classifications'] = $this->main->gets('reference', array('type' => 'classification', 'is_deleted' => 0, 'status' => 1), 'code');
        if ($id) {
            $id = decode($id);
            $this->data['data'] = $this->main->get('mail', array('id' => $id));
        }
        $this->output->set_title(($this->data['data'] ? lang('edit') : lang('add')) . ' ' . lang('inmail'));
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
        $datas = $this->inmail->get_all($start, $length, $search, $order);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $output['data'][] = array(
                    $data->code,
                    get_date($data->date),
                    get_date($data->date_in),
                    $data->from,
                    $data->subject,
                    $data->to,
                    $data->information,
//                    $data->disposition_name.'<br>'.$data->disposition_note,
                    '<ul class="icons-list"><li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">' .
//                    '<li><a href="' . site_url('inmail/disposition/index/' . encode($data->id)) . '"><i class="icon-tree5 position-left"></i> ' . lang('disposition') . '</a></li>'.
                    '<li><a href="' . site_url('inmail/print_disposition/' . encode($data->id)) . '"><i class="icon-printer position-left"></i> ' . lang('disposition') . '</a></li>
                    <li><a id="view-file-' . $data->id . '" href="javascript:view_file(' . $data->id . ')" data-file="' . site_url($data->file) . '">' . lang('button_view_file') . '</a></li>' .
                    (($this->ion_auth->is_admin() || $data->user_added == $this->data['user']->id) ?
                    '<li><a href="' . site_url('inmail/form/' . encode($data->id)) . '">' . lang('button_edit') . '</a></li>
                    <li><a href="' . site_url('inmail/delete/' . encode($data->id)) . '" class="delete">' . lang('button_delete') . '</a></li>' : ''
                    ) .
                    '</ul>
                    </li></ul>',
                );
            }
        }
        $output['draw'] = $draw++;
        $output['recordsTotal'] = $this->inmail->count_all();
        $output['recordsFiltered'] = $this->inmail->count_all($search);
        echo json_encode($output);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('code', 'lang:number', 'trim|required');
        $this->form_validation->set_rules('date_in', 'lang:date_in', 'trim|required');
        $this->form_validation->set_rules('date', 'lang:date', 'trim|required');
        $this->form_validation->set_rules('subject', 'lang:subject', 'trim|required');
        $this->form_validation->set_rules('from', 'lang:from', 'trim|required');
        $this->form_validation->set_rules('to', 'lang:to', 'trim|required');
        $this->form_validation->set_rules('information', 'lang:information', 'trim|required');

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            do {
                if (!$data['id'] && (!isset($_FILES['file']['name']))) {
                    $return = array('message' => 'File surat harus di upload', 'status' => 'error');
                    break;
                }
                $data['date'] = $data['date_submit'];
                unset($data['date_submit']);
                $data['date_in'] = $data['date_in_submit'];
                unset($data['date_in_submit']);

                if (isset($_FILES['file']['name']) != NULL) {
                    $year = substr($data['date'], 0, 4);
                    $config['upload_path'] = './files/' . $year . '/';
                    $config['allowed_types'] = "gif|jpeg|jpg|png";
                    $config['max_size'] = 2048;
                    $config['file_name'] = $data['subject'];
                    if (!file_exists($config['upload_path'])) {
                        mkdir($config['upload_path']);
                    }
                    $this->load->library('upload');
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('file')) {
                        $return = array('message' => 'File gagal di upload.<br>' . $this->upload->display_errors(), 'status' => 'error');
                        break;
                    } else {
                        $data['file'] = $config['upload_path'] . $this->upload->data('file_name');
                    }
                } else {
                    unset($data['file']);
                }
                $data['type'] = 'in';
//                $disposition = $this->main->get('reference',array('id'=>$data['disposition_reference']));
//                $data['disposition_name'] = $disposition->name;
                $classification = $this->main->get('reference',array('id'=>$data['classification']));
                $data['classification_name'] = $classification->name;
                $data['classification_code'] = $classification->code;
                if ($data['id']) {
                    $data['user_modified'] = $this->data['user']->id;
                    $data['id'] = decode($data['id']);
                    $this->main->update('mail', $data, array('id' => $data['id']));
                } else {
                    $data['user_added'] = $this->data['user']->id;
                    $data['sequence'] = $this->inmail->last_sequence(substr($data['date'],0,4))+1;
                    $this->main->insert('mail', $data);
                }

                $return = array('message' => lang('save_success'), 'status' => 'success', 'redirect' => site_url('inmail'));
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'error');
        }

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
    
    public function print_disposition($id){
        $data['data'] = $this->main->get('mail',array('id'=> decode($id)));
        $this->load->view('print',$data);
    }

}
