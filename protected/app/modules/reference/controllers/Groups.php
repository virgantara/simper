<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Groups extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->lang->load('groups', settings('language'));
        $this->load->model('groups_model', 'groups');

        $this->data['menu'] = 'merchant_group';
    }

    public function index() {
        $this->template->_init();
        $this->template->table();

        $this->breadcrumbs->push(lang('menu_merchant'), '/merchants');
        $this->breadcrumbs->push(lang('menu_merchant_group'), '/merchants/groups');

        $this->data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->output->set_title(lang('group_heading'));
        $this->load->view('groups/list', $this->data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order')[0];
        $search = $this->input->post('search')['value'];
        $draw = intval($this->input->post('draw'));

        $output['data'] = array();
        $datas = $this->groups->get_all($start, $length, $search, $order);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $output['data'][] = array(
                    $data->name,
                    $data->branch,
                    '<td class="text-center">
                    <ul class="icons-list">
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="' . site_url('merchants/groups/form/' . encode($data->id)) . '">' . lang('button_edit') . '</a></li>
                    </ul>
                    </li>
                    </ul>
                    </td>',
                );
            }
        }
        $output['draw'] = $draw++;
        $output['recordsTotal'] = $this->groups->count_all();
        $output['recordsFiltered'] = $this->groups->count_all($search);
        echo json_encode($output);
    }

    public function form($id = '') {
        $this->template->_init();
        $this->template->form();

        $this->data['data'] = ($id) ? $this->main->get('merchant_groups', array('id' => decode($id))) : array();
        $this->data['branches'] = $this->main->gets('merchants', array('is_branch' => 1), 'name asc');

        $this->breadcrumbs->push(lang('menu_merchant'), '/merchants');
        $this->breadcrumbs->push(lang('menu_merchant_group'), '/merchants/groups');
        $this->breadcrumbs->push(($this->data['data']) ? lang('group_edit_heading') : lang('group_add_heading'), '/');

        $this->data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->output->set_title(($this->data['data']) ? lang('group_edit_heading') : lang('group_add_heading'));
        $this->load->view('groups/form', $this->data);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'lang:group_form_name_label', 'trim|required');
        $this->form_validation->set_rules('branch', 'lang:group_form_branch_label', 'trim|required');
        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            do {
                if (!$data['id']) {
                    $this->main->insert('merchant_groups', $data);
                } else {
                    $data['id'] = decode($data['id']);
                    $this->main->update('merchant_groups', $data, array('id' => $data['id']));
                }
                $return = array('message' => sprintf(lang('group_save_success_message'), $data['name']), 'status' => 'success', 'redirect' => site_url('merchants/groups'));
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'error');
        }
        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->main->get('groups', array('id' => $id));

        $delete = $this->main->delete('groups', array('id' => $id));
        if ($delete) {
            $return = array('message' => sprintf(lang('group_delete_success_message'), $data->name), 'status' => 'success');
        } else {
            $return = array('message' => lang('group_delete_error_message'), 'status' => 'error');
        }

        echo json_encode($return);
    }

}
