<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Classification extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->ion_auth->is_admin() or show_404();
        
        $this->load->model('classification_model', 'classification');
        $this->data['menu'] = 'reference_classification';
    }

    public function index() {
        $this->template->_init();
        $this->template->table();
        $this->output->set_title(lang('reference') . ' ' . lang('classification'));
        $this->load->view('classification/list', $this->data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order')[0];
        $search = $this->input->post('search')['value'];
        $draw = intval($this->input->post('draw'));

        $output['data'] = array();
        $datas = $this->classification->get_all($start, $length, $search, $order);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $output['data'][] = array(
                    $data->code,
                    $data->name,
                    '<td class="text-center">
                    <ul class="icons-list">
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="' . site_url('reference/classification/form/' . encode($data->id)) . '">' . lang('button_edit') . '</a></li>
                    <li><a class="delete" href="' . site_url('reference/classification/delete/' . encode($data->id)) . '">' . lang('button_delete') . '</a></li>
                    </ul>
                    </li>
                    </ul>
                    </td>',
                );
            }
        }
        $output['draw'] = $draw++;
        $output['recordsTotal'] = $this->classification->count_all();
        $output['recordsFiltered'] = $this->classification->count_all($search);
        echo json_encode($output);
    }

    public function form($id = '') {
        $this->template->_init();
        $this->template->form();

        $this->data['data'] = array();
        if ($id) {
            $id = decode($id);
            $this->data['data'] = $this->main->get('reference',array('id'=>$id));
        }

        $this->output->set_title(($this->data['data'] ? lang('edit') : lang('add')) . ' ' . lang('reference') . ' ' . lang('classification'));
        $this->load->view('classification/form', $this->data);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('code', 'lang:code', 'trim|required');
        $this->form_validation->set_rules('name', 'lang:name', 'trim|required');

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);
            do {
                if (!$data['id']) {
                    $data['type'] = 'classification';
                    $data['user_added'] = $this->data['user']->id;
                    $save = $this->main->insert('reference', $data);
                } else {
                    $data['id'] = decode($data['id']);
                    $data['user_modified'] = $this->data['user']->id;
                    $save = $this->main->update('reference', $data, array('id' => $data['id']));
                }
                $return = array('message' => lang('save_success'), 'status' => 'success', 'redirect' => site_url('reference/classification'));
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'error');
        }
        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->main->get('reference', array('id' => $id));

        $delete = $this->main->update('reference', array('is_deleted' => 1, 'date_deleted' => date('Y-m-d H:i:s'), 'user_deleted' => $this->data['user']->id), array('id' => $id));
        if ($delete) {
            $return = array('message' => lang('delete_success'), 'status' => 'success');
        } else {
            $return = array('message' => lang('delete_error'), 'status' => 'error');
        }

        echo json_encode($return);
    }

}
