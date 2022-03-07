<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leaves extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('security/authenticate');
    }

    public function index() {
        $title = "Liste de congés";
        $content = $this->load->view('list', array(), TRUE);
        $this->display($content, TRUE, $title);
    }
    
    // Top front
    public function display($content, $isNeedNav, $title) {

        $html['style'] = $this->load->view('elements/header_style', NULL, TRUE);
        $html['script'] = $this->load->view('elements/header_script', NULL, TRUE);
        $html['title'] = $title; // Titre de la page
        $html['isNeedNav'] = $isNeedNav; // Pour le nav : true or false
        $html['model'] = 'leaves';
        
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