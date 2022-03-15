<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Params extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('security/authenticate');
        $this->load->module('mail/mail');
        $this->load->model('params_model', 'params');
        $this->load->model('main/main_model', 'main');
        $this->load->library('email');
    }

    public function index() {
        $sess = $this->session->userdata('user');
        if($sess['u_profilId'] != "1") {
            redirect('/main');
        } else {
            $title = "Paramètre";
            $params['params_ldap'] = $this->params->get_all(1);
            $params['params_email'] = $this->params->get_all(2);
            $data['general'] = $this->load->view('navs/general', $params, TRUE);
            $content = $this->load->view('params', $data, TRUE);
            $this->display($content, TRUE, $title);
        }
    }
    
    // Top front
    public function display($content, $isNeedNav, $title) {
        $html['style'] = $this->load->view('elements/header_style', NULL, TRUE);
        $html['script'] = $this->load->view('elements/header_script', NULL, TRUE);
        $html['title'] = $title; // Titre de la page
        $html['isNeedNav'] = $isNeedNav; // Pour le nav : true or false
        $html['model'] = "params"; // pour bouton active
        
        if (!is_null($content) && $content != '') {
            $html['content'] = $content;
        }
        $this->load->view('index', $html);
    }

    // Update params
    public function update_params() {
        $data = array(
            "param_code" => $this->input->post('param_code'),
            "param_lib" => $this->input->post('param_lib'),
            "param_value" => $this->input->post('param_value'),
        );
        // var_dump($this->input->post('code_params'));
        $this->params->update_param($data, $this->input->post('code_params'));
    }

    public function _remap($method) {
        if ($this->authenticate->is_authenticate()) {
            $this->$method();
        } else {
            $this->authenticate->login();
        }
    }

}