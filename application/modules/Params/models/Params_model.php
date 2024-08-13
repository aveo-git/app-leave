<?php

class Params_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->params = 'l_params';
        $this->user = "l_user";
        $this->service = "l_service";
        $this->calendar = "l_calendar";
    }

    public function get_all($section)
    {
        $this->db->where('param_section', $section);
        $this->db->select('*');
        $this->db->from($this->params);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_one_by_code($code_param)
    {
        $query = $this->db->get_where($this->params, array('param_code' => $code_param));
        return $query->row();
    }

    public function get_all_user()
    {
        $this->db->select('*');
        $this->db->where('u_profilId !=', 3);
        $this->db->from($this->user);
        $query = $this->db->get();
        $temp = $query->result();
        foreach ($temp as $key => $value) {
            $temp[$key]->u_idService = $this->get_service_by('id_service', $value->u_idService)->s_label;
        }
        return $temp;
    }

    public function get_all_service()
    {
        $this->db->select('*');
        $this->db->from($this->service);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_data($data)
    {
        $this->db->insert($this->params, $data);
    }

    public function insert_user($data)
    {
        $this->db->insert($this->user, $data);
    }

    public function update_param($data, $id)
    {
        $this->db->where('param_code', $id);
        $this->db->update($this->params, $data);
    }

    public function delete_user_by_id($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete($this->user);
    }

    public function update_user($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update($this->user, $data);
    }

    // Create or Update user
    public function cu_user($data)
    {
        $test = $this->is_exist('u_pseudo', $data['u_pseudo'], $this->user);
        if ($test) {
            $this->db->where('u_pseudo', $data['u_pseudo']);
            $this->db->update($this->user, $data);
        } else {
            $this->db->insert($this->user, $data);
        }
    }

    public function insert_service($data)
    {
        $test = $this->is_exist('s_label', $data['s_label'], $this->service);
        if ($test) {
            $this->db->where('s_label', $data['s_label']);
            $this->db->update($this->service, $data);
        } else {
            $this->db->insert($this->service, $data);
        }
    }

    public function update_service($id, $data)
    {
        $this->db->where('id_service', $id);
        $this->db->update($this->service, $data);
    }

    public function get_service_by($s, $label)
    {
        $this->db->where($s, $label);
        $this->db->select('*');
        $this->db->from($this->service);
        $query = $this->db->get();
        return $query->row();
    }

    public function delete_service($id)
    {
        $this->db->where('id_service', $id);
        $this->db->delete($this->service);
    }

    public function toggle_status_user($id, $status)
    {
        $data = array('u_status' => $status);
        $this->db->where('id_user', $id);
        $this->db->update($this->user, $data);
    }

    public function add_calendar($id, $data)
    {
        if ($id == NULL) {
            $this->db->insert($this->calendar, $data);
        } else {
            $this->db->where('id_calendar', $id);
            $this->db->update($this->calendar, $data);
        }
    }

    public function remove_calendar($id)
    {
        $this->db->delete($this->calendar, array('id_calendar' => $id));
    }

    private function is_exist($attr, $data, $table)
    {
        $this->db->where($attr, $data);
        $this->db->select('*');
        $this->db->from($table);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? true : false;
    }
}
