<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->lang->load('merchants/users', settings('language'));
        $this->load->model('users_model', 'users');

        $this->data['menu'] = array('menu' => 'merchant', 'submenu' => 'user');
    }

    public function index() {
        $this->template->_init();
        $this->template->table();

        $this->breadcrumbs->unshift(lang('menu_merchant'), '/');
        $this->breadcrumbs->push(lang('menu_user'), '/merchants/users');

        $this->data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->output->set_title(lang('user_heading'));
        $this->load->view('users/users', $this->data);
    }

    public function get_list() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $order = $this->input->post('order')[0];
        $search = $this->input->post('search')['value'];
        $draw = intval($this->input->post('draw'));

        $output['data'] = array();
        $datas = $this->users->get_all($start, $length, $search, $order);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $output['data'][] = array(
                    $data->fullname,
                    $data->email,
                    $data->telephone,
                    $data->merchant_name,
                    '<td class="text-center">
                    <ul class="icons-list">
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="' . site_url('merchants/users/form/' . encode($data->id)) . '">' . lang('button_edit') . '</a></li>
                    <li><a href="' . site_url('merchants/users/delete/' . encode($data->id)) . '" class="delete">' . lang('button_delete') . '</a></li>
                    </ul>
                    </li>
                    </ul>
                    </td>',
                );
            }
        }
        $output['draw'] = $draw++;
        $output['recordsTotal'] = $this->users->count_all();
        $output['recordsFiltered'] = $this->users->count_all($search);
        echo json_encode($output);
    }

    public function form($id = '') {
        $this->template->_init();
        $this->template->form();

//        $this->load->js('../assets/backend/js/modules/users/user_form.js');

        $this->data['data'] = array();
        if ($id) {
            $id = decode($id);
            $this->data['data'] = $this->ion_auth->user($id)->row();
        }

        $this->breadcrumbs->push(lang('menu_merchant'), '/merchants');
        $this->breadcrumbs->push(lang('menu_user'), '/merchants/users');
        $this->breadcrumbs->push(($this->data['data']) ? lang('user_edit_heading') : lang('user_add_heading'), '/');

        $this->data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->output->set_title(($this->data['data']) ? lang('user_edit_heading') : lang('user_add_heading'));
        $this->load->view('users/user_form', $this->data);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fullname', 'lang:user_form_name_label', 'trim|required');
        $this->form_validation->set_rules('telephone', 'lang:user_form_telephone_label', 'trim|required|numeric');
        if (!$this->input->post('id')) {
            $this->form_validation->set_rules('email', 'lang:user_form_email_label', 'trim|required|valid_email|callback_check_email');
            $this->form_validation->set_rules('password', 'lang:user_form_password_label', 'trim|required');
        } else {
            $this->form_validation->set_rules('password', 'lang:user_form_password_label', 'trim');
        }

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            if (!$data['id']) {
                $save = $this->ion_auth->register($data['email'], $data['password'], $data['email'], array('fullname' => $data['fullname'], 'telephone' => $data['telephone']), array(2, 3));
            } else {
                $data['id'] = decode($data['id']);
                unset($data['email']);
                $save = $this->ion_auth->update($data['id'], $data);
            }

            if ($save !== false) {
                $return = array('message' => sprintf(lang('user_save_success_message'), $data['fullname']), 'status' => 'success', 'redirect' => site_url('merchants/users'));
            } else {
                $return = array('message' => sprintf(lang('user_save_error_message'), $data['fullname']), 'status' => 'error');
            }
        } else {
            $return = array('message' => validation_errors(), 'status' => 'error');
        }
        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->ion_auth->user($id)->row();

        if ($this->main->get('merchants', array('auth' => $id))) {
            $return = array('message' => 'Pengguna tidak dapat dihapus karena masih terikat dengan merchant.', 'status' => 'error');
        } else {
            $delete = $this->ion_auth->delete_user($id);
            if ($delete) {
                $return = array('message' => sprintf(lang('user_delete_success_message'), $data->fullname), 'status' => 'success');
            } else {
                $return = array('message' => lang('user_delete_error_message'), 'status' => 'error');
            }
        }

        echo json_encode($return);
    }

    public function check_email($str) {
        if ($this->ion_auth->email_check($str)) {
            $this->form_validation->set_message('check_email', sprintf(lang('user_email_exist_message'), $str));
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
