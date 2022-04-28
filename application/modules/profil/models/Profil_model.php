<?php

class Profil_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->user = "l_user";
    }

    public function set_password($id, $data) {
        $this->db->where('id_user', $id);
        $this->db->update($this->user, $data);
    }
}