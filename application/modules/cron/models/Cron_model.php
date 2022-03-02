<?php

class Cron_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->collabs = 'rh_collaborateur';
        $this->userad = 'rh_userad';
    }

    public function get_all_collab() {
        $this->db->select('*');
        $this->db->from($this->collabs);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_rh() {
        $this->db->where('ua_groupId', 4);
        $this->db->where('ua_active', 1);
        $this->db->select('ua_email');
        $this->db->from($this->userad);
        $query = $this->db->get();
        $data = array();
        foreach ($query->result() as $item) {
            array_push($data, $item->ua_email);
        }
        return $data;
    }

}
