<?php

class Leaves_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->leave = "l_leave";
    }

    public function get_all_leave_by_id($id, $date) {
        $this->db->where('l_idUser', $id);
        $this->db->where('l_statut !=', 0);
        $this->db->where('YEAR(l_dateAjout)', $date);
        $this->db->order_by('l_dateAjout', 'ASC');
        $this->db->select('*');
        $this->db->from($this->leave);
        $query = $this->db->get();
        return $query->result();
    }
}