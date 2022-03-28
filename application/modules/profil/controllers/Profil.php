<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('security/authenticate');
        $this->load->model('params/params_model', 'params');
    }

    public function index() {
        $user = $this->session->userdata('user');
        if($user['u_profilId'] != '1') {
            $title = "Profil";
            $data['services'] = $this->params->get_all_service();
            $content = $this->load->view('profil', $data, TRUE);
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

    // Update profil
    public function update_profil() {
        $sess_prev = $this->session->userdata('user');
        $data = array(
            'u_nom' => $this->input->post('u_nom'),
            'u_prenom' => $this->input->post('u_prenom'),
            'u_email' => $this->input->post('u_email'),
            'u_idService' => $this->input->post('u_service'),
            'u_reference' => $this->input->post('u_reference'),
            'u_idService' => $this->input->post('u_service'),
        );
        if(isset($_FILES['file']['name'])) {
            $lien = $_FILES['file']['name'];
            $temp = strtolower($this->input->post('u_pseudo')).'.'.pathinfo($lien, PATHINFO_EXTENSION);
            $target_directory = './assets/images/'.$temp;
            $data['u_avatar'] = $temp;
            move_uploaded_file($_FILES['file']['tmp_name'], $target_directory);
        }
        $this->params->update_user($this->input->post('id_user'), $data);
        $data['u_service'] = $this->auth_model->get_service($data['u_idService'])->s_label;
        $this->session->set_userdata('user', array_merge($sess_prev, $data));
    }

    public function _remap($method) {
        if ($this->authenticate->is_authenticate()) {
            $this->$method();
        } else {
            $this->authenticate->login();
        }
    }

}