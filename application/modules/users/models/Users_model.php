<?php

class Users_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->leave = "l_leave";
        $this->user = "l_user";
    }

    public function get_all_user() {
        $this->db->select('*');
        $this->db->from($this->user);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_username_by_id($id) {
        $this->db->where('id_user', $id);
        $this->db->select('u_nom, u_prenom');
        $this->db->from($this->user);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_user_disctinct() {
        $this->db->select('l_idUser');
        $this->db->distinct();
        $this->db->where('l_statut !=', 0);
        $this->db->from($this->leave);
        $query = $this->db->get();
        $temp = $query->result();
        foreach($temp as $key => $value) {
            $username = $this->get_username_by_id($value->l_idUser);
            $temp[$key]->username = $username != null ? $username->u_prenom." ".$username->u_nom : '';
        }
        return $temp;
    }

    public function get_all_leave() {
        $this->db->where('l_statut !=', 0);
        $this->db->where('l_archived', 0);
        $this->db->order_by('l_nbJdispo', 'DESC');
        $this->db->select('*');
        $this->db->from($this->leave);
        $query = $this->db->get();
        $temp = $query->result();
        foreach($temp as $key => $value) {
            $username = $this->get_username_by_id($value->l_idUser);
            $temp[$key]->l_idUser = $username != null ? $username->u_prenom." ".$username->u_nom : '';
        }
        return $temp;
    }

    public function get_all_leave_by_user($id) {
        $this->db->where('l_idUser', $id);
        $this->db->where('l_statut !=', 0);
        $this->db->where('l_archived', 0);
        $this->db->order_by('l_nbJdispo', 'DESC');
        $this->db->select('*');
        $this->db->from($this->leave);
        $query = $this->db->get();
        $temp = $query->result();
        foreach($temp as $key => $value) {
            $username = $this->get_username_by_id($value->l_idUser);
            $temp[$key]->l_idUser = $username != null ? $username->u_prenom." ".$username->u_nom : '';
        }
        return $temp;
    }

    public function get_nbpris_by_month($id, $month) {
        $this->db->where('l_idUser', $id);
        $this->db->where('l_statut', 1);
        $this->db->like('l_dateFin', $month);
        $this->db->select_sum('l_nbJpris');
        $this->db->from($this->leave);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function get_report($month) {
        $users = $this->get_all_user();
        foreach($users as $item) {
            $item->nbPris = $this->get_nbpris_by_month($item->id_user, $month)->l_nbJpris == null ? 0 : $this->get_nbpris_by_month($item->id_user, $month)->l_nbJpris;
        }
        return $users;
    }

    public function delete_leave_by_id($id) {
        $this->db->where('id_leave', $id);
        $this->db->delete($this->leave);
    }
}