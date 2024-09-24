<?php

class Cron_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->user = 'l_user';
        $this->calendar = "l_calendar";
        $this->load->model('history/history_model','history');
    }

    public function get_all_user()
    {
        $this->db->select('*');
        $this->db->from($this->user);
        $this->db->where("u_status",1);
        $this->db->where("u_profilId",1);
        $query = $this->db->get();
        return $query->result();
    }

    public function insert_quota()
    {
        $users = $this->get_all_user();
        foreach ($users as $item) {
            $data = [
                "user"=> $item->id_user,
                "nb" => floatval($this->history->getDispo($item->id_user) + 2.5),
                "date" => date('Y-m-d'),
            ];
            $this->db->insert("l_history",$data);
        }
    }

    public function update_calendar_year()
    {
        $currentYear = date('Y');
        $this->db->set('c_debut', "CONCAT('$currentYear-', SUBSTRING(c_debut, 6))", FALSE);
        $this->db->update($this->calendar);
    }
}
