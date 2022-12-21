<?php

defined('BASEPATH') or exit('No direct script access allowed');

class List_leaves extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->module('security/authenticate');
        $this->load->model('list_leaves_model', 'l_leaves');
        $this->load->model('main_model', 'main');
        $this->load->module('mail/mail');
        $this->load->library('email');
    }

    public function index()
    {
        $user = $this->session->userdata('user');
        if ($user['u_profilId'] == '3') {
            $title = "Liste des congés en attentes";
            $leaves = $this->l_leaves->get_all_leave_waiting();
            foreach ($leaves as $key => $value) {
                $leaves[$key]->l_idUser = $this->l_leaves->get_user_by_id($value->l_idUser);
                $leaves[$key]->l_idUser->u_idService = $this->l_leaves->get_service_by_id($leaves[$key]->l_idUser->u_idService);
            }
            $data['leaves'] = $leaves;
            $content = $this->load->view('list_leaves', $data, TRUE);
            $this->display($content, TRUE, $title);
        } else {
            redirect('/main');
        }
    }

    // Top front
    public function display($content, $isNeedNav, $title)
    {

        $html['style'] = $this->load->view('elements/header_style', NULL, TRUE);
        $html['script'] = $this->load->view('elements/header_script', NULL, TRUE);
        $html['title'] = $title; // Titre de la page
        $html['isNeedNav'] = $isNeedNav; // Pour le nav : true or false
        $html['model'] = 'list';

        if (!is_null($content) && $content != '') {
            $html['content'] = $content;
        }
        $this->load->view('index', $html);
    }

    public function valid_conge()
    {
        $data = array(
            'l_statut' => $this->input->post('l_statut'),
            'l_nbJrest' => $this->input->post('l_nbRest')
        );
        if ($this->input->post('l_statut') == '2' && $this->input->post('lv_type') != "Autorisation d'absence") {
            $dispo = $this->input->post('l_nbJpris') + $this->input->post('l_nbRest');
            $this->l_leaves->set_nbdispo_user($this->input->post('id_user'), $dispo);
            $data['l_nbJrest'] = $this->input->post('l_nbDispo');
        }
        $this->l_leaves->set_status_leave($this->input->post('id_leave'), $data);

        $leave = $this->l_leaves->get_leave_by_id($this->input->post('id_leave'));
        $user = $this->l_leaves->get_user_by_id($leave->l_idUser);
        $user->l_statut = $this->input->post('l_statut');
        $arr['user'] = $user;
        $arr['leave'] = $leave;
        $this->mail->send_status_leave($arr);

        $session_notif = count($this->l_leaves->get_all_leave_waiting());
        $this->session->set_userdata("notif", $session_notif);
    }

    public function _remap($method)
    {
        if ($this->authenticate->is_authenticate()) {
            $this->$method();
        } else {
            $this->authenticate->login();
        }
    }
}
