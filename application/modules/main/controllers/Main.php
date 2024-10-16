<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Main extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->module('security/authenticate');
        $this->load->module('admin/admin');
        $this->load->model('main_model', 'main');
        $this->load->model('params/params_model', 'params');
        $this->load->model('history/history_model','history');
        $this->load->module('mail/mail');
        $this->load->library('email');
    }

    public function index()
    {
        $user = $this->session->userdata('user');
        if ($user['u_profilId'] != '3') {
            $title = "Dashboard";
            $data['resp'] = $this->main->get_user_by_email($this->params->get_one_by_code("email_destinataire")->param_value);
            $data['publicholiday'] = $this->main->get_all_calendar_date();
            $data['dispo'] = $this->history->getDispo($user['id_user']);
            $content = $this->load->view('main', $data, TRUE);
            $this->display($content, TRUE, $title);
        } else {
            redirect('/list');
        }
    }

    // Top front
    public function display($content, $isNeedNav, $title)
    {

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
 
    public function add_leave()
    {
        $user = $this->session->userdata('user');
        $desc = $this->input->post('u_descr');
        $start = $this->input->post('l_dateDepart');
        $back = $this->input->post('l_dateFin');
        $hstart = $this->input->post('l_dateDepart-option');
        $hback = $this->input->post('l_dateFin-option');

        $pris = $this->calcul_nbJour($start,$back) - $this->main->getDayOff($start,$back);
        if($hstart === "12:00" && $hback === "12:00") {
            $pris = $pris - 1;
        } else if($hstart === "12:00" ||  $hback === "12:00") {$pris = $pris - 0.5;}
        $data = array(
            "l_type" => $this->input->post('l_type'),
            "l_dateDepart" => $desc != null ? date("Y-m-d H:i:s") : $start . " " . $hstart,
            "l_dateFin" => $desc != null ? null : $back . " " . $hback,
            "l_responsable" => $this->input->post('u_responsable'),
            "l_nbJpris" => $pris,
            "l_statut" => 0,
            "l_archived" => 0,
            "l_idUser" => $this->input->post('id_user'),
        );
        $this->main->insert_leave($data);
        $user['descr'] = $desc;
        $this->mail->send_deposite($user);

        $this->session->set_flashdata('alert', "NOTE : Demande de congé envoyée, vous recevrez un mail lorsque le responsable aura fini d'examiner votre demande.");
    }

    private function calcul_nbJour($d1,$d2)
    {
        $start = new DateTime($d1);
        $end = new DateTime($d2);
        $count = 0;
        while ($start <= $end) {
            if ($start->format('w') != 0) { 
                $count++;
            }
            $start->modify('+1 day');
        }

        return $count;
    }

    private function get_sunday($y, $m)
    {
        $data = array();
        $temp = new DatePeriod(
            new DateTime("first sunday of $y-$m"),
            DateInterval::createFromDateString('next sunday'),
            new DateTime("last day of $y-$m")
        );
        foreach ($temp as $sunday) {
            array_push($data, $sunday->format("d"));
        }
        return $data;
    }

    private function get_entire_date($date)
    {
        $mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        $d = explode("-", explode("T", $date)[0]);
        $heure = explode("T", $date)[1];
        $date_arrived = $d[2] . " " . $mois[intval($d[1])] . " " . $d[0];
        return $date_arrived . " à " . $heure;
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
