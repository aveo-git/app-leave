<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper('url');
        $this->load->module('mail/mail');
        $this->load->library('email');
        $this->load->model('Cron_model', 'cron_model');
	}
	
	public function index(){}

    // This method is launched by the cron every 
    // morning at 8 am
    public function send_notif() {
        
        $date_now = new DateTime(date('Y-m-d'));
        $date_now->add(new DateInterval('P1D')); // 24h avant
        $date_24h = $date_now->format('Y-m-d');
        
        $collab = $this->cron_model->get_all_collab();
        $rh = $this->cron_model->get_rh();
        $all_rh = implode(",", $rh);
        foreach($collab as $item) {
            if($item->c_dateFin != NULL) {
                $collab_temp = array();
                $collab_temp = array(
                    'all_rh' => $all_rh,
                    'collab' => $item
                );
                // 2022-03-01 == 2022-02-28 && not archived
                if(strtotime($date_24h) == strtotime($this->get_date($item->c_dateFin)['date']) && $item->c_archived == 0) {
                    $this->mail->send_mail_notif($collab_temp);
                }
            }
        }
    }

    private function get_date($date) {
        $temp = explode(" ", $date);
        $heures = explode(":", $temp[1]);
        return array(
            "date" => $temp[0],
            "heure" => $heures[1].":".$heures[1]
        );
    }
}