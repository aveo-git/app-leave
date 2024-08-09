<?php

class History_model extends CI_Model
{
 
    public function __construct()
    {
        parent::__construct();
        $this->table = "l_history";
    }

    public function getHistory($user,$date)
    {
        $this->db->select("u.id_user, u.u_nom, u.u_prenom, h.date, h.nb");
        $this->db->from($this->table . " h");
        if($user){
            $this->db->where("h.user",$user);
        }
        if($date){
            $month = date('m', strtotime($date));
            $year = date('Y', strtotime($date));
            $this->db->where('MONTH(h.date)', $month);
            $this->db->where('YEAR(h.date)', $year);
        }
        $this->db->join('l_user u', 'u.id_user = h.user');
        $this->db->order_by('h.date',"DESC");
        $query = $this->db->get();
        $result = $query->result();
        foreach ($result as $key => $value) {
            $leaves = $this->getLeave($value->id_user,$value->date);
            $nbPris = $this->getNbPris($value->id_user,$value->date);
            $result[$key]->pris = $nbPris;
            $result[$key]->leaves = $leaves;
            
        }
        return $result;
    }

    public function getLeave($user,$date)
    {
        $date1 = $this->getLastExerciseDate($date);
        $this->db->select("*");
        $this->db->from("l_leave l");
        $this->db->where('l.l_idUser', $user);
        $this->db->where('l.l_dateDepart >=', $date);
        $this->db->where('l.l_dateDepart <=', $date1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getNbPris($user,$date)
    {
        $date1 = $this->getLastExerciseDate($date);
        $this->db->select("SUM(l.l_nbJpris) p");
        $this->db->from("l_leave l");
        $this->db->where('l.l_idUser', $user);
        $this->db->where('l.l_statut', 1);
        $this->db->where('l.l_dateDepart >=', $date);
        $this->db->where('l.l_dateDepart <=', $date1);
        $query = $this->db->get();
        return $query->result()[0]->p;
    }

    public function getLastExerciseDate($date)
    {
        $d = date_create($date);
        $d = date_modify($d,'first day of next month');
        $d = date_modify($d,'+23 days');
        return date_format($d,'Y-m-d');
    }
}