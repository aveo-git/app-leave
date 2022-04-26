<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('users_model', 'users');
        $this->load->module('security/authenticate');
    }

    public function index() {
        $user = $this->session->userdata('user');
        if($user['u_profilId'] == '1') {
            $title = "Liste des utilisateurs";
            $data['leaves'] = $this->users->get_all_leave();
            $data['users'] = $this->users->get_user_disctinct();
            $content = $this->load->view('users', $data, TRUE);
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
        $html['model'] = "users"; // pour bouton active
        
        if (!is_null($content) && $content != '') {
            $html['content'] = $content;
        }
        $this->load->view('index', $html);
    }

    public function select_leaves() {
        if($this->input->post('idUser') == 'all') {
            $data = $this->users->get_all_leave();
        } else {
            $data = $this->users->get_all_leave_by_user($this->input->post('idUser'));
        }
        echo json_encode($data);
    }

    // Get user
    public function list_leaves() {
        $data['data'] = $this->users->get_all_leave();
        $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public function _remap($method) {
        if ($this->authenticate->is_authenticate()) {
            $this->$method();
        } else {
            $this->authenticate->login();
        }
    }

}