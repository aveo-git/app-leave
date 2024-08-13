<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Leaves extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('security/authenticate');
        $this->load->model('leaves_model', 'leave');
        $this->load->model("history/history_model",'history');
        $this->year = date('Y');
    }

    public function index() {
        $year_sess = $this->session->userdata('year');
		$y = $year_sess != NULL ? $year_sess['date'] : $this->year;
        $user = $this->session->userdata('user');
        $data['leaves'] = $this->history->getHistory($user['id_user'],null,intval($y));
        $data['year'] = $y;
        if($user['u_profilId'] != '3') {
            $title = "Liste de congés";
            $content = $this->load->view('leaves', $data, TRUE);
            $this->display($content, TRUE, $title);
        } else {
            redirect('/list');
        }
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

    public function set_date() {
        $this->session->set_userdata('year', array('date' => $this->input->post('year')));
    }

    public function _remap($method) {
        if ($this->authenticate->is_authenticate()) {
            $this->$method();
        } else {
            $this->authenticate->login();
        }
    }

}