<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->ion_auth->is_admin() or show_404();
        $this->load->model('users_model', 'users');
        $this->data['menu'] = 'user';
    }

    public function index() {
        $this->template->_init();
        $this->template->table();

        $this->output->set_title('User');
        $this->load->view('list', $this->data);
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
                    '<td class="text-center">
                    <ul class="icons-list">
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="' . site_url('users/form/' . encode($data->id)) . '">' . lang('button_edit') . '</a></li>
                    <li><a href="' . site_url('users/delete/' . encode($data->id)) . '" class="delete">' . lang('button_delete') . '</a></li>
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

        $this->data['data'] = array();
        if ($id) {
            $id = decode($id);
            $this->data['data'] = $this->ion_auth->user($id)->row();
        }

        $this->output->set_title(($this->data['data'] ? lang('edit') : lang('add')) . ' User');
        $this->load->view('form', $this->data);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fullname', 'Nama', 'trim|required');
        if (!$this->input->post('id')) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email');
            $this->form_validation->set_rules('password', 'password', 'trim|required');
        } else {
            $this->form_validation->set_rules('password', 'password', 'trim');
        }

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            if (!$data['id']) {
                $save = $this->ion_auth->register($data['email'], $data['password'], $data['email'], array('fullname' => $data['fullname']), array(2));
            } else {
                $data['id'] = decode($data['id']);
                unset($data['email']);
                $save = $this->ion_auth->update($data['id'], $data);
            }

            if ($save !== false) {
                $return = array('message' => lang('save_success'), 'status' => 'success', 'redirect' => site_url('users'));
            } else {
                $return = array('message' => lang('save_error'), 'status' => 'error');
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

        $delete = $this->ion_auth->delete_user($id);
        if ($delete) {
            $return = array('message' => lang('delete_success'), 'status' => 'success');
        } else {
            $return = array('message' => lang('delete_error'), 'status' => 'error');
        }
        echo json_encode($return);
    }

    public function check_email($str) {
        if ($this->ion_auth->email_check($str)) {
            $this->form_validation->set_message('check_email', 'Email sudah digunakan');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
