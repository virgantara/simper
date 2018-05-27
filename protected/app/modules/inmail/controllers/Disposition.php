<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Disposition extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('disposition_model', 'disposition');
        $this->data['menu'] = 'inmail';
    }

    public function index($mail) {
        $this->template->_init();
        $this->template->table();
        $this->output->set_title(lang('disposition'));
        $this->data['id'] = $mail;
        $this->data['mail'] = $this->main->get('mail', array('id' => decode($mail)));
        $this->load->view('disposition/list', $this->data);
    }

    public function form($mail, $id = '') {
        $this->template->_init();
        $this->template->form();
        $this->data['id'] = $mail;
        $this->data['dispositions'] = $this->main->gets('reference', array('type' => 'disposition', 'is_deleted' => 0, 'status' => 1), 'code');
        $this->data['data'] = array();
        if ($id) {
            $id = decode($id);
            $this->data['data'] = $this->main->get('disposition', array('id' => $id, 'mail' => decode($mail)));
        }
        $this->output->set_title(($this->data['data'] ? lang('edit') : lang('add')) . ' ' . lang('disposition'));
        $this->load->view('disposition/form', $this->data);
    }

    public function get_list($mail) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order')[0];
        $search = $this->input->post('search')['value'];
        $draw = intval($this->input->post('draw'));

        $mail = decode($mail);
        $output['data'] = array();
        $datas = $this->disposition->get_all($mail, $start, $length, $search, $order);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $output['data'][] = array(
                    get_date($data->date),
                    $data->to,
                    $data->reference_code . '. ' . $data->reference_name,
                    $data->note,
                    $data->from,
                    ($this->ion_auth->is_admin() || $data->user_added == $this->data['user']->id) ? '<ul class="icons-list"><li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="' . site_url('inmail/disposition/form/' . encode($mail) . '/' . encode($data->id)) . '">' . lang('button_edit') . '</a></li>
                    <li><a href="' . site_url('inmail/disposition/delete/' . encode($data->id)) . '" class="delete">' . lang('button_delete') . '</a></li>
                    </ul>
                    </li></ul>' : '',
                );
            }
        }
        $output['draw'] = $draw++;
        $output['recordsTotal'] = $this->disposition->count_all($mail);
        $output['recordsFiltered'] = $this->disposition->count_all($mail, $search);
        echo json_encode($output);
    }

    public function save($mail) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('date', 'lang:date', 'trim|required');
        $this->form_validation->set_rules('reference', 'lang:disposition', 'trim|required');
        $this->form_validation->set_rules('from', 'lang:from', 'trim|required');
        $this->form_validation->set_rules('to', 'lang:to', 'trim|required');
        $this->form_validation->set_rules('note', 'lang:note', 'trim|required');

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            do {
                $data['date'] = $data['date_submit'];
                unset($data['date_submit']);
                $data['mail'] = decode($mail);
                $reference = $this->main->get('reference', array('id' => $data['reference']));
                $data['reference_code'] = $reference->code;
                $data['reference_name'] = $reference->name;
                if ($data['id']) {
                    $data['user_modified'] = $this->data['user']->id;
                    $data['id'] = decode($data['id']);
                    $this->main->update('disposition', $data, array('id' => $data['id']));
                } else {
                    $data['user_added'] = $this->data['user']->id;
                    $this->main->insert('disposition', $data);
                }

                $return = array('message' => lang('save_success'), 'status' => 'success', 'redirect' => site_url('inmail/disposition/index/' . $mail));
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'error');
        }

        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $delete = $this->main->update('disposition', array('is_deleted' => 1, 'date_deleted' => date('Y-m-d H:i:s'), 'user_deleted' => $this->data['user']->id), array('id' => $id));
        if ($delete) {
            $return = array('message' => lang('delete_success'), 'status' => 'success');
        } else {
            $return = array('message' => lang('delete_error'), 'status' => 'danger');
        }
        echo json_encode($return);
    }

}
