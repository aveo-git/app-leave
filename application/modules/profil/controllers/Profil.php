<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('security/authenticate');
    }

    public function index() {
        $user = $this->session->userdata('user');
        if($user['u_profilId'] != '1') {
            $title = "Profil";
            $content = $this->load->view('profil', array(), TRUE);
            $this->display($content, TRUE, $title);
        } else {
            redirect('/main');
        }
    }
    
    // Top front
    public function display($content, $isNeedNav, $title) {

        $html['style'] = $this->load->view('elements/header_style', NULL, TRUE);
        $html['script'] = $this->load->view('elements/header_script', NULL, TRUE);
        $html['title'] = $title; // Titre de la page
        $html['isNeedNav'] = $isNeedNav; // Pour le nav : true or false
        
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