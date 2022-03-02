<?php

class Params_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->params = 'rh_params';
        $this->maildiffusion = "rh_maildiffusion";
        $this->domaine = "rh_domaine";
        $this->userad = "rh_userad";
        $this->system = "rh_systeme";
        $this->service = "rh_service";
        $this->logiciel = "rh_logiciel";
        $this->collab = "rh_collaborateur";
    }

    public function get_all() {
        $this->db->select('*');
        $this->db->from($this->params);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_domain() {
        $this->db->where('param_lib', 'domaine');
        $this->db->select('param_value');
        $this->db->from($this->params);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_one_by_code($code_param) {
		$query = $this->db->get_where($this->params, array('param_code' => $code_param));
		return $query -> row();
	}

    public function get_all_logiciels() {
        $this->db->select('*');
        $this->db->from($this->logiciel);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_data($data) {
        $this->db->insert($this->params, $data);
    }

    public function update_param($data, $id) {
        $this->db->where('param_code', $id);
        $this->db->update($this->params, $data);
    }

    // Mail de diffusion
    public function get_all_md() {
        $this->db->select('*');
        $this->db->from($this->maildiffusion);
        $query = $this->db->get();
        return $query->result();
    }
    public function insert_maildiffusion($data) {
        $this->db->insert($this->maildiffusion, $data);
    }
    public function update_mailDiffusion($data, $id) {
        $this->db->where('id_mailDiffusion', $id);
        $this->db->update($this->maildiffusion, $data);
    }
    public function delete_maildiffusion($id) {
        $this->db->where('id_mailDiffusion', $id);
        $this->db->delete($this->maildiffusion);
    }

    // Domaine
    public function get_all_domains() {
        $this->db->select('*');
        $this->db->from($this->domaine);
        $query = $this->db->get();
        return $query->result();
    }
    public function insert_domaine($data) {
        $this->db->insert($this->domaine, $data);
    }
    public function update_domaine($data, $id) {
        $this->db->where('id_domaine', $id);
        $this->db->update($this->domaine, $data);
    }
    public function delete_domaine($id) {
        $this->db->where('id_domaine', $id);
        $this->db->delete($this->domaine);
    }

    public function insert_system($data) {
        $this->db->insert($this->system, $data);
    }

    public function delete_userad_by_id($id) {
        $this->db->where('id_userad', $id);
        $this->db->delete($this->userad);
    }

    public function update_userad($data, $id) {
        $this->db->where('id_userad', $id);
        $this->db->update($this->userad, $data);
    }

    public function update_collab($data, $username) {
        $temp = array(
            'c_nom' => $data['ua_nom'],
            'c_prenom' => $data['ua_prenom'],
            'c_email' => $data['ua_email'],
            'c_poste' => $data['ua_description']
        );
        $this->db->where('c_username', $username);
        $this->db->update($this->collab, $temp);
    }

    // Service
    public function get_all_services() {
        $this->db->select('*');
        $this->db->from($this->service);
        $query = $this->db->get();
        return $query->result();
    }
    public function insert_service($data) {
        $this->db->insert($this->service, $data);
    }
    public function update_service($data, $id) {
        $this->db->where('id_service', $id);
        $this->db->update($this->service, $data);
    }
    public function delete_service($id) {
        $this->db->where('id_service', $id);
        $this->db->delete($this->service);
    }

    // Logiciel
    public function insert_soft($data) {
        $this->db->insert($this->logiciel, $data);
    }
    public function update_soft($data, $id) {
        $this->db->where('id_logiciel', $id);
        $this->db->update($this->logiciel, $data);
    }
    public function delete_logiciel($id) {
        $this->db->where('id_logiciel', $id);
        $this->db->delete($this->logiciel);
    }

    public function toggle_statut($data, $id) {
        $this->db->where('id_userad', $id);
        $this->db->update($this->userad, $data);
    }
}
