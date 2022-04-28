<?php

class List_leaves_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->leave = "l_leave";
        $this->user = "l_user";
        $this->service = "l_service";
    }

    public function get_all_leave_waiting() {
        $this->db->where('l_statut', 0);
        $this->db->select('*');
        $this->db->from($this->leave);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_user_by_id($id) {
        $this->db->where('id_user', $id);
        $this->db->select('*');
        $this->db->from($this->user);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_leave_by_id($id) {
        $this->db->where('id_leave', $id);
        $this->db->select('*');
        $this->db->from($this->leave);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_service_by_id($id) {
        $this->db->where('id_service', $id);
        $this->db->select('*');
        $this->db->from($this->service);
        $query = $this->db->get();
        return $query->row();
    }

    public function set_status_leave($id, $data) {
        $this->db->where('id_leave', $id);
        $this->db->update($this->leave, $data);
    }

}