<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Calendar extends MX_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->module('security/authenticate');
    $this->load->model('users/users_model', 'users');
    $this->year = date('Y');
  }

  public function index()
  {
    $year_sess = $this->session->userdata('year');
    $y = $year_sess != NULL ? $year_sess['date'] : $this->year;
    $user = $this->session->userdata('user');
    $data['year'] = $y;
    $data['leaves'] = json_encode((array)$this->users->get_all_leave(TRUE));
    $title = "Calendrier";
    $content = $this->load->view('calendar', $data, TRUE);
    $this->display($content, TRUE, $title);
  }

  // Top front
  public function display($content, $isNeedNav, $title)
  {
    $html['style'] = $this->load->view('elements/header_style', NULL, TRUE);
    $html['script'] = $this->load->view('elements/header_script', NULL, TRUE);
    $html['title'] = $title; // Titre de la page
    $html['isNeedNav'] = $isNeedNav; // Pour le nav : true or false
    $html['isCalendarRightDisplay'] = FALSE;
    $html['model'] = 'calendar';

    if (!is_null($content) && $content != '') {
      $html['content'] = $content;
    }
    $this->load->view('index', $html);
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
