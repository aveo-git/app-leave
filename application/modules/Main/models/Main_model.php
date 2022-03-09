<?php

class Main_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->leave = "l_leave";
    }

    public function insert_leave($data) {
        $this->db->set('l_dateAjout', 'NOW()', FALSE);
        $this->db->insert($this->leave, $data);
    }
}