<?php

(defined('BASEPATH')) or exit('No direct script access allowed');

class Template {

    public function __construct() {
        $this->ci = & get_instance();
    }

    public function _init($template = 'default') {
        $this->ci->output->set_template($template);

        $this->ci->load->css('https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900');
        $this->ci->load->css('assets/css/icons/icomoon/styles.css');
        $this->ci->load->css('assets/css/bootstrap.css');
        $this->ci->load->css('assets/css/core.css');
        $this->ci->load->css('assets/css/components.css');
        $this->ci->load->css('assets/css/colors.css');
        $this->ci->load->css('assets/css/custom.css');
//        $this->ci->load->css('assets/css/admin.css');

        $this->ci->load->js('assets/js/plugins/loaders/pace.min.js');
        $this->ci->load->js('assets/js/core/libraries/jquery.min.js');
        $this->ci->load->js('assets/js/core/libraries/bootstrap.min.js');
        $this->ci->load->js('assets/js/plugins/loaders/blockui.min.js');
        $this->ci->load->js('assets/js/plugins/sweet_alert.min.js');
        $this->ci->load->js('assets/js/language/indonesian.js');
        $this->ci->load->js('assets/js/core/app.js');
    }

    public function table() {
        $this->ci->load->js('assets/js/plugins/tables/datatables/datatables.min.js');
        $this->ci->load->js('assets/js/plugins/tables/table.js');
    }

    public function form() {
        $this->ci->load->js('assets/js/plugins/forms/styling/uniform.min.js');
        $this->ci->load->js('assets/js/plugins/forms/bootstrap_select.min.js');
        $this->ci->load->js('assets/js/plugins/forms/styling/switch.min.js');
        $this->ci->load->js('assets/js/plugins/forms/pickadate/picker.js');
        $this->ci->load->js('assets/js/plugins/forms/pickadate/picker.date.js');
        $this->ci->load->js('assets/js/plugins/forms/pickadate/legacy.js');
        $this->ci->load->js('assets/js/plugins/forms/pickadate/translations/indonesian.js');
        $this->ci->load->js('assets/js/plugins/forms/validation/validate.min.js');
        $this->ci->load->js('assets/js/plugins/forms/validation/localization/messages_indonesian.js');
        $this->ci->load->js('assets/js/plugins/forms/jquery.form.min.js');
        $this->ci->load->js('assets/js/plugins/forms/form.js');
    }

}
