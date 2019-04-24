<?php
class User_model extends CI_model{
    
    public function register_user($user){
        $this->db->insert('user', $user);
    }

    public function login_user($name,$pass){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username',$name);
        $this->db->where('password',$pass);
        
        if($query=$this->db->get())
        {
            return $query->row_array();
        }
        else{
            return false;
        }

    }

    public function email_check($email){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('useremail',$email);
        $query=$this->db->get();

        if($query->num_rows()>0){
            return false;
        }else{
            return true;
        }

    }
    public function get_user_details($user){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username',$user);
        $query=$this->db->get();

        $user_array = $query->row_array();
        
        if(!$user_array){
            return false;
        }else{
            return $user_array;
        }
    }
}


?>