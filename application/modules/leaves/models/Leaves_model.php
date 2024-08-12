<?php

class Leaves_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->leave = "l_leave";
    }

    public function get_all_leave_by_id($id, $date) {
        $this->db->where('l_idUser', $id);
        $this->db->where('YEAR(l_dateAjout)', $date);
        $this->db->order_by('l_dateAjout', 'ASC');
        $this->db->select('*');
        $this->db->from($this->leave);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_planned_leave_by_id($id) {
        $date = new DateTime();
        $date = $date->modify('first day of this month');
        $date = $date->modify('+24 days');
        $date = $date->format('Y-m-d');
        $this->db->where('l_idUser', $id);
        $this->db->where('l_dateDepart >', $date);
        $this->db->order_by('l_dateAjout', 'ASC');
        $this->db->select('*');
        $this->db->from($this->leave);
        $query = $this->db->get();
        return $query->result();
    }

    
}