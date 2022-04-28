<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends MX_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        // $this->test($this->load->view('mail_adminlocal', array(), TRUE));
        return;
    }

    public function send_test() {
        $params = $this->parametre();
        $dest = $params['mailDest'];
        $html = $this->load->view('mail_test', null, TRUE); // Récuperation des données
        $this->email->initialize($params['psettings']);
        $this->email->to($dest);
        $this->email->from($params['mailsender'], $params['mailappname']);
        $this->email->subject($params['mailsubject']);
        $this->email->message($html); // chargement du template
        $this->email->send();
    }

    public function send_deposite($data) {
        $params = $this->parametre();
        $dest = $params['mailDest'];
        $html = $this->load->view('mail_deposite', $data, TRUE); // Récuperation des données
        $this->email->initialize($params['psettings']);
        $this->email->to($dest);
        $this->email->from($params['mailsender'], $params['mailappname']);
        $this->email->subject($params['mailsubject']);
        $this->email->message($html); // chargement du template
        $this->email->send();
    }

    public function send_status_leave($data) {
        $params = $this->parametre();
        $dest = $data['user']->u_email;
        $html = $this->load->view('mail_decision', $data, TRUE); // Récuperation des données
        $this->email->initialize($params['psettings']);
        $this->email->to($dest);
        $this->email->from($params['mailsender'], $params['mailappname']);
        $this->email->subject('Validation congé');
        $this->email->message($html); // chargement du template
        $this->email->send();
    }

    public function send_mail_newuser($data) {
        $params = $this->parametre();
        $dest = $data['u_email'];

        $html = $this->load->view('mail_newuser', $data, TRUE); // Récuperation des données
        $this->email->initialize($params['psettings']);
        $this->email->to($dest);
        $this->email->from($params['mailsender'], $params['mailappname']);
        $this->email->subject("Information sur votre compte");
        $this->email->message($html); // chargement du template
        $this->email->send();
    }

    public function parametre() {
        $mailDest = $this->set_mailDest($this->params->get_one_by_code('email_destinataire')->param_value);
        $mailsender = $this->params->get_one_by_code('email_sender')->param_value; // Mail qui va envoyer les mail par défaut
        $mailappname = $this->params->get_one_by_code('email_appname')->param_value; // Nom de l'application
        $mailsubject = $this->params->get_one_by_code('email_subject')->param_value; // Nom de l'application
        $psettings = array( // Configuration de base de l'envoi de mail
            'mailtype' => $this->params->get_one_by_code('email_type')->param_value,
            'protocol' => $this->params->get_one_by_code('email_protocol')->param_value,
            'smtp_host' => $this->params->get_one_by_code('email_host')->param_value,
            'smtp_user' => $this->params->get_one_by_code('email_user')->param_value,
            'smtp_pass' => $this->params->get_one_by_code('email_password')->param_value,
            'smtp_port' => $this->params->get_one_by_code('email_port')->param_value,
            'smtp_crypto' => "tls",
            'priority' => "1",
            'charset' => "utf-8",
        );
        return $data = array(
            "mailDest" => $mailDest,
            "mailsender" => $mailsender,
            "mailappname" => $mailappname,
            "mailsubject" => $mailsubject,
            "psettings" => $psettings,
        );
    }

    // S'il existe plusieurs mails de destination
    private function set_mailDest($mails) {
        $data = explode(";", $mails);
        return implode(', ', $data);
    }

    private function get_entire_date($date) {
        $mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        $d = explode("-", explode(" ", $date)[0]);
        $heure = explode(" ", $date)[1];
        $date_arrived = $d[2]." ".$mois[intval($d[1])]." ".$d[0];
        return $date_arrived." à ".$heure;
    }
}