<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->data['menu'] = 'home';
        $this->load->model('dashboard_model','dashboard');
    }

    public function index() {
        $this->template->_init();
        $this->data['total'] = $this->dashboard->total();
        $this->data['last_mail'] = $this->dashboard->last_mail();
        $this->data['outmail'] = $this->dashboard->last_outmail_without_file();
        $this->output->set_title('Home');
        $this->load->view('dashboard', $this->data);
    }

}
