<?php

class Main_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->leave = "l_leave";
        $this->calendar = 'l_calendar';
        $this->user = 'l_user';
    }

    public function insert_leave($data)
    {
        if ($data['l_type'] === 'Congé compensé') {
            $data['l_dateDepart'] = date('Y-m-d H:i:s');
        }
        $this->db->set('l_dateAjout', 'NOW()', FALSE);
        $this->db->insert($this->leave, $data);
    }

    public function get_all_calendar_date()
    {
        $this->db->where('c_flag', 0);
        $this->db->select('c_debut');
        $this->db->order_by('c_debut', 'ASC');
        $this->db->from($this->calendar);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDayOff($start,$back)
    {
        $this->db->select('COUNT(c_debut) c');
        $this->db->where('c_flag', 0);
        $this->db->where('c_debut >=', $start);
        $this->db->where('c_debut <=', $back);
        $this->db->from($this->calendar);
        $query = $this->db->get();
        return $query->row()->c;
    }

    public function get_user_by_email($email)
    {
        $this->db->where('u_email', $email);
        $this->db->select('*');
        $this->db->from($this->user);
        $query = $this->db->get();
        return $query->row();
    }

    public function update_dispo($id, $dispo)
    {
        $this->db->where('id_user', $id);
        $this->db->update($this->user, array('u_dispo' => $dispo));
    }
}
