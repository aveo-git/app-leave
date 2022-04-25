<?php

class Main_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->leave = "l_leave";
        $this->calendar = 'l_calendar';
    }

    public function insert_leave($data) {
        $this->db->set('l_dateAjout', 'NOW()', FALSE);
        $this->db->insert($this->leave, $data);
    }

    public function get_all_calendar_date() {
        $this->db->where('c_flag', 0);
        $this->db->select('c_debut');
        $this->db->order_by('c_debut', 'ASC');
        $this->db->from($this->calendar);
        $query = $this->db->get();
        return $query->result();
    }
}