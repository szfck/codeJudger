<?php
class Submission_model extends CI_model{
    
    public function create_submission($problem_name, $user_id, $code, $type) {
        $query = $this->db->query('SELECT * FROM submission');
        $subid = $query->num_rows() + 1;
        $submission = array(
            'time' => time(),
            'problem' => $problem_name,
            'userid' =>  $user_id,
            'type' => $type,
            'result' => 'pending'
        );
        $this->db->insert('submission', $submission);

        $this->load->helper('file');        
        $dir = FCPATH."/submissions/".$user_id."/";
        if(!is_dir($dir)){
            mkdir($dir, 0777, true);
            chmod($dir, 0777);
        }
        $path = $dir.$subid.".".$type;
        
        if (!write_file($path, $code)) {
            die('Unable to write the file');
        }
        return $subid;
    }

    function get_user_submission_list() {
        $user_id = $_SESSION['user_id'];
        $this->db->select('*');
        $this->db->from('submission');
        $this->db->where('userid',$user_id);
        $this->db->order_by('subid', 'desc');
        
        if($query=$this->db->get()) {
            return $query->result();
        } else{
            return [];
        }
    }

}
?>
