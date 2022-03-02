<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forgotten extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('forgotten_model', 'forgot');
        $this->load->module('mail/mail');
        $this->load->library('email');
    }

    public function index() {
        $title = "Se connecter";
        Modules::load("main")->display($this->load->view("forgot", array(), TRUE), FALSE, $title);
    }

    // Connexion rapide
    public function forgot() {
        $password = $this->random_password();
        $is_exist = $this->forgot->get_userad_by_email($this->input->post("ua_email"));
        if($is_exist) {
            $data = array(
                "ua_email" => $this->input->post("ua_email"),
                "ua_password" => $password
            );
            $this->forgot->update_password_userad($data);
            $this->mail->send_mail_forgotten($data);

            $this->session->set_flashdata('error', "Mot de passe réinitialisé, veuillez ouvrir votre mail.");
            // redirect('/main');
        } else {
            $this->session->set_flashdata('error', "Adresse email inexistant.");
        }
    }

    public function random_password() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 12; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}