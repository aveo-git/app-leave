<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model', 'admin');
    }

    public function index()
    {
        $id = $this->admin->get_appId()->value;
        $port = $this->admin->get_port()->value;

        // check if app is not inactif
        $file = '';
        $status = '200';
        try {
            $url = 'http://localhost:' . $port . '/operation/status/id_key=' . $id;
            $file = json_decode(@file_get_contents($url));
            if (!$file) {
                throw new Exception(504);
            }
        } catch (Exception $e) {
            $status = $e->getMessage();
        }

        $data['keyStatus'] = null;

        if ($status === '504') {
            $data['message'] = 'Server introuvable';
            $this->load->view('admin', $data, false);
        } else {
            $data['keyStatus'] = $file->data[0]->keyStatus;
            if ($data['keyStatus'] === 0 && $data['keyStatus'] !== NULL) {
                $data['message'] = 'test';
                $this->load->view('admin', $data, false);
            } else {
                $this->session->set_userdata('token', $id);
                redirect('/main');
            }
        }
    }
}
