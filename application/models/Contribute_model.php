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
            if (!mkdir($dir."secret/", 0777, TRUE)){
                die ("Failed to make the secret directory in ".$problemName);
            }
            if (!chmod($dir."secret/", 0777)){
                die ("Failed to change the permissions of ".$problemName."/secret directory");
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
        $config_file_path = $dir."config.yml";

        if (!write_file($config_file_path, "timelimit: 10\ntestcase: 0\n")) {
            return FALSE;
        }
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

    public function add_testcase($problemName, $testInput, $testOutput) {
        $dir = FCPATH."/problems/".trim($problemName)."/secret/";
        if(!$dir){
            if (!mkdir($dir, 0775, TRUE)){
                die ("Failed to make the secret directory for ".$problemName);
            }
            if (!chmod($dir, 0775)){
                die ("Failed to change the permissions of ".$problemName." directory");
            }
        }
        
        $file_array = get_filenames($dir);
        $config_file_path = FCPATH."/problems/".trim($problemName)."/config.yml";
        // Update the config.yml
        if (!write_file($config_file_path, "timelimit: 10\ntestcase: ".(string)(count($file_array)/2 + 1)."\n")) {
            return FALSE;
        }

        $temp = array();
        foreach ($file_array as $file) {
            $str_arr = explode (".", $file)[0];
            array_push($temp, $str_arr);
        }
        rsort($temp);
        $next_available = $temp[0] + 1;

        if (!write_file($dir.$next_available.".in", trim($testInput))) {
            return FALSE;
        }
        if (!write_file($dir.$next_available.".out", trim($testOutput))) {
            return FALSE;
        }
        return TRUE;
    }
}
?>
