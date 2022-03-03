<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leaves extends MX_Controller {

    function __construct() {
        parent::__construct();
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

}