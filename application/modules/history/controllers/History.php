<?php

class History extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("history_model",'history');
    }

    public function index()
    {
        $user = $this->input->post('user');
        $date = $this->input->post('date');
        $data["data"] = $this->history->getHistory($user,$date,null);
        $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }
}