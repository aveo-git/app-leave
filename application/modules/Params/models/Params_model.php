<?php

class Params_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->params = 'l_params';
        $this->user = "l_user";
    }

    public function get_all($section) {
        $this->db->where('param_section', $section);
        $this->db->select('*');
        $this->db->from($this->params);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_one_by_code($code_param) {
		$query = $this->db->get_where($this->params, array('param_code' => $code_param));
		return $query -> row();
	}

    public function insert_data($data) {
        $this->db->insert($this->params, $data);
    }

    public function update_param($data, $id) {
        $this->db->where('param_code', $id);
        $this->db->update($this->params, $data);
    }

    public function delete_user_by_id($id) {
        $this->db->where('id_user', $id);
        $this->db->delete($this->user);
    }

    public function update_user($data, $id) {
        $this->db->where('id_user', $id);
        $this->db->update($this->user, $data);
    }

}
