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

    public function parametre() {
        $mailDest = $this->set_mailDiffusion($this->params->get_one_by_code('email_destinataire')->param_value);
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

    public function parametre_for_admin() {
        $psettings = array( // Configuration de base de l'envoi de mail
            'mailtype' => "html",
            'protocol' => "smtp",
            'smtp_host' => "mail.iris.re",
            'smtp_user' => "aveolys@aveolys.com",
            'smtp_pass' => "@uthent974",
            'smtp_port' => "587",
            'smtp_crypto' => "tls",
            'priority' => "1",
            'charset' => "utf-8",
        );
        return $data = array(
            "mailsender" => "aveolys@aveolys.com",
            "mailappname" => $this->params->get_one_by_code('email_appname')->param_value,
            "psettings" => $psettings,
        );
    }

    private function get_entire_date($date) {
        $mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        $d = explode("-", explode(" ", $date)[0]);
        $heure = explode(" ", $date)[1];
        $date_arrived = $d[2]." ".$mois[intval($d[1])]." ".$d[0];
        return $date_arrived." à ".$heure;
    }
}