<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticate extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper("security");
        $this->load->model('main/main_model', 'main');
        $this->load->model('security/authenticate_model', 'auth_model');
    }

    public function index() {
        $this->login();
    }

    // Connexion rapide
    public function login() {
        $title = "Se connecter";
        if ($this->is_authenticate()) {
            redirect('/main');
        }
        Modules::load("main")->display($this->load->view("login", array(), TRUE), FALSE, $title);
    }

    public function authenticate() {
        $user = $this->auth_model->get_user($this->input->post('u_pseudo'));
        if($user != NULL) {
            if($user->u_archived == 0) {
                if($user->u_pseudo == $this->input->post('u_pseudo') && $user->u_mdp == $this->input->post('u_mdp')) {
                    $session_user = array(
                        "id_user" => $user->id_user,
                        "u_psuedo" => $user->u_pseudo,
                        "u_nom" => $user->u_nom,
                        "u_prenom" => $user->u_prenom,
                        "u_avatar" => $user->u_avatar,
                        "u_service" => $this->auth_model->get_service($user->u_idService)->s_label,
                        "u_reference" => $user->u_reference,
                        "u_dispo" => $user->u_dispo,
                        "u_dispoYear" => $user->u_dispoYear,
                        "u_archived" => $user->u_archived
                    );
                    $this->session->set_userdata("user", $session_user);
                } else {
                    $this->session->set_flashdata('error', "Mot de passe incorrect.");
                }
            } else {
                $this->session->set_flashdata('error', "Utilisateur archivé, veuillez contacter votre supérieur.");
            }
        } else {
            $this->session->set_flashdata('error', "Utilisateur inexistant.");
        }
    }

    // Déconnexion
    public function logout() {
        // var_dump($this->session->userdata('logged_in'));
        $this->session->sess_destroy();
        redirect('/');
    }

    public function is_authenticate() {
        if ($this->session->userdata("user") === NULL) {
            $this->session->sess_regenerate();
            return FALSE;
        }
        return TRUE;
    }
}