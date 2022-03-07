<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('security/authenticate');
        $this->load->module('admin/admin');
        $this->load->model('main_model', 'main');
        $this->load->module('mail/mail');
        $this->load->library('email');
    }

    public function index() {
        $title = "Dashboard";
        $content = $this->load->view('main', array(), TRUE);
        $this->display($content, TRUE, $title);
    }
    
    // Top front
    public function display($content, $isNeedNav, $title) {

        $html['style'] = $this->load->view('elements/header_style', NULL, TRUE);
        $html['script'] = $this->load->view('elements/header_script', NULL, TRUE);
        $html['title'] = $title; // Titre de la page
        $html['isNeedNav'] = $isNeedNav; // Pour le nav : true or false
        $html['model'] = 'home';
        
        if (!is_null($content) && $content != '') {
            $html['content'] = $content;
        }
        $this->load->view('index', $html);
    }

    private function get_entire_date($date) {
        $mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        $d = explode("-", explode("T", $date)[0]);
        $heure = explode("T", $date)[1];
        $date_arrived = $d[2]." ".$mois[intval($d[1])]." ".$d[0];
        return $date_arrived." à ".$heure;
    }

    public function _remap($method) {
        if ($this->authenticate->is_authenticate()) {
            $this->$method();
        } else {
            $this->authenticate->login();
        }
    }

}