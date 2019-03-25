<?php
class Submission_model extends CI_model{
    
    public function create_submission($problem_name, $user_id, $code, $type) {
        $query = $this->db->query('SELECT * FROM submission');
        $sid = $query->num_rows() + 1;
        $submission = array(
            'time' => time(),
            'problem' => $problem_name,
            'userid' =>  $user_id,
            'type' => $type,
            'result' => 'pending'
        );
        $this->db->insert('submission', $submission);

        $path = FCPATH."/submissions/".$sid.".".$type;
        
        $this->load->helper('file');
        if (!write_file($path, $code)) {
            die('Unable to write the file');
        }
    }

    function get_user_submission_list() {
        $user_id = $_SESSION['user_id'];
        $this->db->select('*');
        $this->db->from('submission');
        $this->db->where('userid',$user_id);
        
        if($query=$this->db->get()) {
            return $query->result();
        } else{
            return [];
        }
    }

}
?>
