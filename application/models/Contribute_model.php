<?php
class Contribute_model extends CI_model{

    public function __construct(){
        parent::__construct();
        $this->load->helper('file');
    }
    
    public function validate($problemName, $problemDesc, $problemsampleInput, $problemsampleOutput){
        if (!$problemName || !$problemDesc || !$problemsampleInput || !$problemsampleOutput){
            return FALSE;
        }
        $dir = FCPATH."/problems/".trim($problemName)."/";
        if(is_dir($dir)){
           return FALSE; 
        }
        return TRUE;
    }

    public function add_skeleton_code($problemName, $skeletonCode, $language){
        $skeleton_file = FCPATH."/problems/".$problemName."/skeleton.".$language;
        if (!write_file($skeleton_file, $skeletonCode)) {
            return FALSE;
        }
        return TRUE;
    }
    
    public function add_problem($problemName, $problemDesc, $problemsampleInput, $problemsampleOutput) {
        $valid = $this->validate($problemName, $problemDesc, $problemsampleInput, $problemsampleOutput);
        $dir = FCPATH."/problems/".trim($problemName)."/";
        if($valid){
            if (!mkdir($dir, 0777, TRUE)){
                die ("Failed to make the problem directory");
            }
            if (!chmod($dir, 0777)){
                die ("Failed to change the permissions of ".$problemName." directory");
            }
        }else{
            return FALSE;
        }
        $desc_path = $dir."desc.txt";
        $sample_input_path = $dir."sample-input.txt";
        $sample_output_path = $dir."sample-output.txt";
        
        if (!write_file($desc_path, trim($problemDesc))) {
            return FALSE;
        }
        if (!write_file($sample_input_path, trim($problemsampleInput))) {
            return FALSE;
        }
        if (!write_file($sample_output_path, trim($problemsampleOutput))) {
            return FALSE;
        }
        return TRUE;
    }

    public function get_skeleton_code($problemName, $language){
        $skeleton_file = FCPATH."/problems/".$problemName."/skeleton.".$language;
        return read_file($skeleton_file);
    }
}
?>
