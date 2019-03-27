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

        $path = FCPATH."/submissions/".$subid.".".$type;
        
        $this->load->helper('file');
        if (!write_file($path, $code)) {
            die('Unable to write the file');
        }

        // Create map with request parameters
        $params = array ('submission_id' => $subid);

        // Build Http query using params
        $query = http_build_query ($params);

        // Create Http context details
        $contextData = array (
                    'method' => 'POST',
                    'header' => "Connection: close\r\n".
                                "Content-Length: ".strlen($query)."\r\n".
                                "Content-Type: "."application/x-www-form-urlencoded",
                    'content'=> $query );

        // Create context resource for our request
        $context = stream_context_create (array ( 'http' => $contextData ));

        // Read page rendered as result of your POST request
        $result =  file_get_contents (
                    'http://judger-judge:3000/judge',  // page url
                    false,
                    $context);


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
