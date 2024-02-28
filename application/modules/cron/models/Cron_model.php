<?php

class Cron_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->user = 'l_user';
        $this->calendar = "l_calendar";
    }

    public function get_all_user()
    {
        $this->db->select('*');
        $this->db->from($this->user);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_quota()
    {
        $users = $this->get_all_user();
        foreach ($users as $item) {
            $this->db->where('id_user', $item->id_user);
            $this->db->update($this->user, array('u_dispo' => floatval($item->u_dispo) + 2.5));
        }
    }

    public function update_calendar_year()
    {
        $currentYear = date('Y');
        $this->db->set('c_debut', "CONCAT('$currentYear-', SUBSTRING(c_debut, 6))", FALSE);
        $this->db->update($this->calendar);
    }
}
