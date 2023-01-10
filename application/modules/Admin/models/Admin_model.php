<?php

class Admin_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->admin = "l_admin";
    }

    public function get_appId()
    {
        $this->db->select('*');
        $this->db->from($this->admin);
        $this->db->where('label', 'app_id');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_port()
    {
        $this->db->select('*');
        $this->db->from($this->admin);
        $this->db->where('label', 'port');
        $query = $this->db->get();
        return $query->row();
    }
}
