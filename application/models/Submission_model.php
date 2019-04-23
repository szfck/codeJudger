<?php
class Submission_model extends CI_model{

    protected $table = 'submission';
    
    public function create_submission($problem_name, $user_id, $code, $type) {
        $query = $this->db->query('SELECT * FROM submission');
        $subid = $query->num_rows() + 1;
        $file_extension = $type;
        if ($type == 'py3' || $type == 'py2') {
            $file_extension = 'py';
        }
        $filename = $subid.'.'.$file_extension;
        $submission = array(
            'time' => time(),
            'problem' => $problem_name,
            'userid' =>  $user_id,
            'filename' => $filename, 
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
        $path = $dir.$filename;
        
        if (!write_file($path, $code)) {
            die('Unable to write the file');
        }
        return $subid;
    }

    public function get_count($user_id) {
        if ($user_id != 'all') {
            $this->db->where('userid', $user_id);
        }
        return $this->db->count_all_results($this->table);
    }

    public function get_submissions($user_id, $limit, $start) {
        if ($user_id != 'all') {
            $this->db->where('userid', $user_id);
        }

        $this->db->select('*');
        $this->db->limit($limit, $start);
        $this->db->order_by('subid', 'desc');

        $query = $this->db->get($this->table);

        return $query->result();
    }

    function get_submission($sub_id) {
        $this->db->select('*');
        $this->db->from('submission');
        $this->db->where('subid', $sub_id);
        
        if($query=$this->db->get()) {
            return $query->row();
        } else{
            return [];
        }
    }

}
?>
