<?php

class Authenticate_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->user = "l_user";
        $this->service = "l_service";
    }

    public function get_user($pseudo) {
        $this->db->where('u_pseudo', $pseudo);
        $this->db->select('*');
        $this->db->from($this->user);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_service($id) {
        $this->db->where('id_service', $id);
        $this->db->select('*');
        $this->db->from($this->service);
        $query = $this->db->get();
        return $query->row();
    }

}