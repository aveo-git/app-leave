<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate extends MX_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Certificate_model', 'crtmodel');
        $this->load->library('session');
    } 

    function index(){
        $content =  $this->load->view('certificate');
        $this->display($content,FALSE,'certificate');

    }


    function expire(){
        $content =  $this->load->view('expire');
        $this->display($content,FALSE,'certificate expiré');

    }


    function setkey(){
        $key = $this->input->post('key');
        $this->crtmodel->setkey($key);
        $this->session->set_flashdata('saved',TRUE);
        redirect('/certificate');
    }

    public function display($content, $isNeedNav, $title) {

        $html['style'] = $this->load->view('elements/header_style', NULL, TRUE);
        $html['script'] = $this->load->view('elements/header_script', NULL, TRUE);
        $html['title'] = $title; // Titre de la page
        $html['isNeedNav'] = $isNeedNav; // Pour le nav : true or false
        $html['model'] = 'leaves';
        
        if (!is_null($content) && $content != '') {
            $html['content'] = $content;
        }
        $this->load->view('index', $html);
    }

}

?>