<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('security/authenticate');
        $this->load->model('admin_model', 'admin');
        $this->load->module('mail/mail');
        $this->load->library('email');
    }

    public function index() {
        // redirect('/');
    }

    public function admin_principal() {
        $sess = $this->session->userdata('admin');
        $data['admins'] = $this->admin->get_all_admins() != NULL ? $this->admin->get_all_admins() : NULL;
        if($sess == NULL) {
            $this->authenticate->login();
        } else {
            $title = "Administration";
            // var_dump($data);
            $content = $this->load->view('admin', $data, TRUE);
            $this->display($content, FALSE, $title);
        }
    }
    
    // Top front
    public function display($content, $isNeedNav, $title) {
        $html['style'] = $this->load->view('elements/header_style', NULL, TRUE);
        $html['script'] = $this->load->view('elements/header_script', NULL, TRUE);
        $html['title'] = $title; // Titre de la page
        $html['isNeedNav'] = $isNeedNav; // Pour le nav : true or false
        $html['model'] = "admin"; // pour bouton active
        $html['session_userad'] = $this->session->userdata('logged_in');
        
        if (!is_null($content) && $content != '') {
            $html['content'] = $content;
        }
        $this->load->view('index', $html);
    }

    public function _remap($method) {
        if ($this->session->userdata('admin')) {
            $this->$method();
        } else {
            $this->authenticate->login();
        }
    }

}