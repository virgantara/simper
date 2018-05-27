<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $this->load->view('welcome_message');
    }

    public function delete_cache() {
        $all_cache = $this->cache->cache_info();
        print_r($all_cache);
        foreach ($all_cache['cache_list'] as $cache_id => $cache) :
            $this->cache->delete($cache['info']);
        endforeach;
    }

    public function test_mail() {
        $this->load->library('email');
        $this->email->initialize();

        $this->email->from('noreply@karawangshop.com', 'KarawangShop.com');
        $this->email->to('rifkysyaripudin@gmail.com');
        $this->email->subject('Test Mail');
        $this->email->message('Test email');

        if ($this->email->send()) {
            echo 'Seems like your SMTP settings is set correctly. Check your email now.';
        } else {
            echo '<h1>Your SMTP settings are not set correctly here is the debug log.</h1><br />' . $this->email->print_debugger();
        }
    }

}
