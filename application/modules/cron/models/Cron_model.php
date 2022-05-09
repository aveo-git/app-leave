<?php

class Cron_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->user = 'l_user';
    }

    public function get_all_user() {
        $this->db->select('*');
        $this->db->from($this->user);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_quota() {
        $users = $this->get_all_user();
        foreach ($users as $item) {
            $this->db->where('id_user', $item->id_user);
            $this->db->update($this->user, array('u_dispo' => floatval($item->u_dispo)+2.5));
        }
    }

}
