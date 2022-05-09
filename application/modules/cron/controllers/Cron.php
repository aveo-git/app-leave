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
    public function add_quota_month() {
        $this->cron_model->insert_quota();
    }
}
