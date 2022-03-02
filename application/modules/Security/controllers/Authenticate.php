<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authenticate extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper("security");
        $this->load->module('admin/admin');
        $this->load->model('main/main_model', 'main');
        $this->load->model('params/params_model', 'params');
    }

    public function index() {
        $this->login();
    }

    // Connexion rapide
    public function login() {
        $title = "Se connecter";
        Modules::load("main")->display($this->load->view("login", array(), TRUE), FALSE, $title);
    }
}