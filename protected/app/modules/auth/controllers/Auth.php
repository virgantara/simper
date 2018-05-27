<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang->load('ion_auth');
        $this->lang->load('auth');
    }

    public function login() {
        if ($this->ion_auth->logged_in())
            redirect();

        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('identity', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() == true) {
                $remember = (bool) $this->input->post('remember');
                if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
                    $user = $this->ion_auth->user()->row();
                    $return = array('message' => lang('login_successful'), 'status' => 'success', 'redirect' => site_url($this->input->post('back')));
                } else {
                    $return = array('message' => lang('login_unsuccessful'), 'status' => 'error');
                }
            } else {
                $return = array('message' => validation_errors(), 'status' => 'error');
            }
            echo json_encode($return);
        } else {
            $this->output->set_title('Sistem Informasi Persuratan - ' . settings('company_name'));
            $this->template->_init('auth');
            $this->template->form();
            $this->load->js('assets/js/modules/auth/login.js');
        }
    }

    public function logout() {
        $this->ion_auth->logout();
        redirect('auth/login', 'refresh');
    }

    public function account() {
        $this->template->_init();
        $this->template->form();
        $this->data['menu'] = 'account';
        $this->output->set_title('Pengaturan Akun');
        $this->load->view('profile', $this->data);
    }

    public function update_account() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('fullname', 'Nama', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|max_length[6]');

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);
            $email = $this->data['user']->email;

            do {
                if ($data['password']) {
                    if (!$data['password_old']) {
                        $return = array('message' => 'Password lama harus diisi', 'status' => 'error');
                        break;
                    } else {
                        if (!$this->ion_auth->change_password($email, $data['password_old'], $data['password'])) {
                            $return = array('message' => 'Akun gagal diperbaharui', 'status' => 'error');
                            break;
                        }
                    }
                }
                unset($data['password']);
                unset($data['password_old']);
                $this->main->update('auth_users', array('fullname' => $data['fullname']), array('id' => $this->ion_auth->get_user_id()));
                $this->data['user']->fullname = $data['fullname'];
                $return = array('message' => 'Akun berhasil disimpan', 'status' => 'success', 'redirect' => site_url('auth/account'));
            } while (0);
        } else {
            
        }

        echo json_encode($return);
    }

    public function forgot_password() {
        if ($this->ion_auth->logged_in())
            redirect();

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('email', 'Alamat Email', 'required|valid_email');
            if ($this->form_validation->run() == true) {
                $forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));
                if ($forgotten) {
                    $return = array('message' => 'Permintaan reset password telah diterima. Silahkan cek email Anda untuk langkah selanjutnya.', 'status' => 'success');
                } else {
                    $return = array('message' => 'Email yang Anda masukkan tidak terdaftar.', 'status' => 'error');
                }
            } else {
                $return = array('message' => validation_errors(), 'status' => 'error');
            }
            echo json_encode($return);
        } else {
            $this->template->_auth();
            $this->load->js('assets/js/modules/auth/forgot_password.min.js');

            $this->output->set_title('Lupa Password Bogatoko');
            $this->load->view('forgot_password');
        }
    }

    public function reset_password($code) {
        if ($this->ion_auth->logged_in())
            redirect();

        $reset = $this->ion_auth->forgotten_password_complete($code);
        $this->template->_auth();

        $this->output->set_title('Reset Password Bogatoko');
        if ($reset) {
            $this->load->view('forgot_password_complete');
        } else {
            $this->load->view('forgot_password_failed');
        }
    }

}
