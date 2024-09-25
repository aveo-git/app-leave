<?php

class Certificate_Model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->table = "l_certificate";
    }

    function setKey($key){
        $this->db->from($this->table);
        $this->db->where("name","APP_KEY");
        $check = $this->db->get();
        if(count($check->result()) === 0){
            $this->db->insert($this->table,['name'=>'APP_KEY',"key"=>$key]);
        }else{
            $this->db->update($this->table,["key"=>$key]);
        }
    }


    function getKey(){
        $this->db->from($this->table);
        $this->db->where("name","APP_KEY");
        $this->db->limit(1);
        $query = $this->db->get();
        return count($query->result()) > 0 ? $query->result()[0]->key : "";
    }
}

?>