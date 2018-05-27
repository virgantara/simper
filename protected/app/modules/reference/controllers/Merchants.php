<?php

defined('BASEPATH') or exit('No direct script access allowed!');

class Merchants extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->lang->load('merchants', settings('language'));
        $this->load->model('merchants_model', 'merchants');

        $this->data['menu'] = 'merchant_list';
    }

    public function index() {
        $this->template->_init();
        $this->template->table();

        $this->breadcrumbs->unshift(lang('menu_merchant'), '/');
        $this->breadcrumbs->push(lang('menu_merchant'), '/merchants');

        $this->data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->output->set_title(lang('merchant_heading'));
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
        $datas = $this->merchants->get_all($start, $length, $search, $order);
        if ($datas) {
            foreach ($datas->result() as $data) {
                $output['data'][] = array(
                    $data->name,
                    $data->username,
                    $data->group,
                    rupiah($data->cash_balance),
                    '<td class="text-center">
                    <ul class="icons-list">
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="' . site_url('merchants/form/' . encode($data->id)) . '">' . lang('button_edit') . '</a></li>
                    </ul>
                    </li>
                    </ul>
                    </td>',
                );
            }
        }
        $output['draw'] = $draw++;
        $output['recordsTotal'] = $this->merchants->count_all();
        $output['recordsFiltered'] = $this->merchants->count_all($search);
        echo json_encode($output);
    }

    public function form($id = '') {
        $this->load->library('googlemaps');
        $this->template->_init();
        $this->template->form();
        $this->load->js('../assets/backend/js/modules/merchants/form.js');

        $this->data['provinces'] = $this->main->gets('provincies', array(), 'name asc');
        $this->data['groups'] = $this->main->gets('merchant_groups', array(), 'name asc');
        $this->data['cities'] = array();
        $this->data['districts'] = array();
        $this->data['data'] = array();
        $config['center'] = 'auto';
        if ($id) {
            $id = decode($id);
            $this->data['data'] = $this->merchants->get($id);
            if ($this->data['data']->province)
                $this->data['cities'] = $this->main->gets('cities', array('province' => $this->data['data']->province), 'name asc');
            if ($this->data['data']->city)
                $this->data['districts'] = $this->main->gets('districts', array('city' => $this->data['data']->city), 'name asc');
            if($this->data['data']->lat && $this->data['data']->lng){
                $config['center'] = $this->data['data']->lat.','.$this->data['data']->lng;
            }
        }

        $config['loadAsynchronously'] = TRUE;
        $config['map_height'] = '500px';
        $config['onboundschanged'] = 'if (!centreGot) {
                var mapCentre = map.getCenter();
                marker_0.setOptions({
                        position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng()) 
                });
                setLocation(mapCentre.lat(), mapCentre.lng());
            }centreGot = true;';
        $config['disableFullscreenControl'] = TRUE;
        $config['disableMapTypeControl'] = TRUE;
        $config['disableStreetViewControl'] = TRUE;
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'search-location';
        $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
        $config['placesAutocompleteOnChange'] = 'map.setCenter(this.getPlace().geometry.location); 
            marker_0.setOptions({
                        position: new google.maps.LatLng(this.getPlace().geometry.location.lat(), this.getPlace().geometry.location.lng()) 
                });
                setLocation(this.getPlace().geometry.location.lat(), this.getPlace().geometry.location.lng());';
        $this->googlemaps->initialize($config);
        $marker = array();
        $marker['draggable'] = true;
        $marker['ondragend'] = 'setLocation(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->add_marker($marker);
        $this->data['map'] = $this->googlemaps->create_map();

        $this->breadcrumbs->push(lang('menu_merchant'), '/merchants');
        $this->breadcrumbs->push(($this->data['data']) ? lang('merchant_edit_heading') : lang('merchant_add_heading'), '/');

        $this->data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->output->set_title(($this->data['data']) ? lang('merchant_edit_heading') : lang('merchant_add_heading'));
        $this->load->view('form', $this->data);
    }

    public function save() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'lang:merchant_form_name_label', 'trim|required');
        $this->form_validation->set_rules('province', 'lang:merchant_form_province_label', 'trim|required');
        $this->form_validation->set_rules('city', 'lang:merchant_form_city_label', 'trim|required');
        $this->form_validation->set_rules('district', 'lang:merchant_form_district_label', 'trim|required');
        $this->form_validation->set_rules('fullname', 'lang:merchant_form_fullname_label', 'trim|required');
        $this->form_validation->set_rules('group', 'lang:merchant_form_group_label', 'trim|required');
        if (!$this->input->post('id')) {
            $this->form_validation->set_rules('username', 'lang:merchant_form_username_label', 'trim|required|alpha_dash|callback_check_username');
            $this->form_validation->set_rules('email', 'lang:merchant_form_email_label', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'lang:merchant_form_password_label', 'trim|required');
        }

        if ($this->form_validation->run() === true) {
            $data = $this->input->post(null, true);

            do {
                if (!$data['id']) {
                    $user = $this->ion_auth->register($data['email'], $data['password'], $data['email'], array('fullname' => $data['fullname'], 'telephone' => $data['telephone']), array(3));
                    if ($user) {
                        unset($data['email']);
                        unset($data['password']);
                        unset($data['fullname']);
                        $data['auth'] = $user;
                        $data['shipping'] = json_encode(array('jne', 'tiki', 'pos'));
                        $save = $this->main->insert('merchants', $data);
                        $this->main->insert('seo_url', array('keyword' => $data['username'], 'query' => 'merchants/view/' . $this->db->insert_id()));
                    } else {
                        $return = array('message' => sprintf(lang('merchant_save_error_message'), $data['name']), 'status' => 'error');
                    }
                } else {
                    $data['id'] = decode($data['id']);
                    $merchant = $this->main->get('merchants', array('id' => $data['id']));
                    $auth = $merchant->auth;
                    $data_auth = array('fullname' => $data['fullname']);
                    if (isset($data['password'])) {
                        $data_auth['password'] = $data['password'];
                        unset($data['password']);
                    }
                    $this->ion_auth->update($auth, $data_auth);
                    unset($data['fullname']);
                    $save = $this->main->update('merchants', $data, array('id' => $data['id']));
                }
                $return = array('message' => sprintf(lang('merchant_save_success_message'), $data['name']), 'status' => 'success', 'redirect' => site_url('merchants'));
            } while (0);
        } else {
            $return = array('message' => validation_errors(), 'status' => 'error');
        }
        echo json_encode($return);
    }

    public function delete($id) {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $id = decode($id);
        $data = $this->main->get('merchants', array('id' => $id));

        $delete = $this->main->delete('merchants', array('id' => $id));
        if ($delete) {
            $this->main->delete('seo_url', array('query' => 'merchants/view/' . $data->id));
            $return = array('message' => sprintf(lang('merchant_delete_success_message'), $data->name), 'status' => 'success');
        } else {
            $return = array('message' => lang('merchant_delete_error_message'), 'status' => 'error');
        }

        echo json_encode($return);
    }

    public function check_username($str) {
        if ($this->main->get('merchants', array('username' => $str)) && $this->main->get('seo_url', array('keyword' => $str))) {
            $this->form_validation->set_message('check_username', sprintf(lang('merchant_username_exist_message'), $str));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_cities() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $output = '<option value=""></option>';
        if ($province = $this->input->post('id')) {
            $cities = $this->main->gets('cities', array('province' => $province), 'name asc');
            if ($cities)
                foreach ($cities->result() as $city) {
                    $output .= '<option value="' . $city->id . '">' . $city->name . '</option>';
                }
        }
        echo $output;
    }

    public function get_districts() {
        $this->input->is_ajax_request() or exit('No direct post submit allowed!');

        $output = '<option value=""></option>';
        if ($city = $this->input->post('id')) {
            $districts = $this->main->gets('districts', array('city' => $city), 'name asc');
            if ($districts)
                foreach ($districts->result() as $district) {
                    $output .= '<option value="' . $district->id . '">' . $district->name . '</option>';
                }
        }
        echo $output;
    }

}
