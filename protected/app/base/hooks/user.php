<?php

function get_user() {
    $CI = & get_instance();
    if ($CI->ion_auth->logged_in()) {
        if (uri_string() == 'auth/login') {
            redirect('');
        }
        $CI->data['user'] = $CI->ion_auth->user()->row();
    } else {
        if (uri_string() !== 'auth/login') {
            redirect('auth/login?back=' . uri_string());
        }
    }
}
