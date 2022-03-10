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
            // var_dump($data);
            $content = $this->load->view('params', array(), TRUE);
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

    public function _remap($method) {
        if ($this->authenticate->is_authenticate()) {
            $this->$method();
        } else {
            $this->authenticate->login();
        }
    }

}