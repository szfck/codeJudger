<?php

class Problemdata_test extends TestCase
{
	public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->library('session');
        $this->CI->load->helper('file');
    }

	public function test_get_problem_desc()
	{   
        $problem_dir = FCPATH."/problems/";

        $dir = new DirectoryIterator($problem_dir);
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                $dummy_test_problem_name = $fileinfo->getFilename();
                break;
            }
        }
        
        if ($dummy_test_problem_name){
            $output = $this->request('GET', 'problemdata/get_problem_desc/'.$dummy_test_problem_name);
            $expected = read_file(FCPATH."/problems/".$dummy_test_problem_name."/desc.txt");
            $this->assertEquals($expected, json_decode($output));
        }
        
    }
    
    public function test_get_problem_sample_input()
	{   
        $problem_dir = FCPATH."/problems/";

        $dir = new DirectoryIterator($problem_dir);
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                $dummy_test_problem_name = $fileinfo->getFilename();
                break;
            }
        }
        
        if ($dummy_test_problem_name){
            $output = $this->request('GET', 'problemdata/get_problem_sample_input/'.$dummy_test_problem_name);
            $expected = read_file(FCPATH."/problems/".$dummy_test_problem_name."/sample-input.txt");
            $this->assertEquals($expected, json_decode($output));
        }
        
    }
    
    public function test_get_problem_sample_output()
	{   
        $problem_dir = FCPATH."/problems/";

        $dir = new DirectoryIterator($problem_dir);
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                $dummy_test_problem_name = $fileinfo->getFilename();
                break;
            }
        }
        
        if ($dummy_test_problem_name){
            $output = $this->request('GET', 'problemdata/get_problem_sample_output/'.$dummy_test_problem_name);
            $expected = read_file(FCPATH."/problems/".$dummy_test_problem_name."/sample-output.txt");
            $this->assertEquals($expected, json_decode($output));
        }
        
    }
    
    public function test_get_problem_config()
	{   
        $problem_dir = FCPATH."/problems/";

        $dir = new DirectoryIterator($problem_dir);
        foreach ($dir as $fileinfo) {
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                $dummy_test_problem_name = $fileinfo->getFilename();
                break;
            }
        }
        
        if ($dummy_test_problem_name){
            $output = $this->request('GET', 'problemdata/get_problem_config/'.$dummy_test_problem_name);
            $config_yml_path = FCPATH.'/problems/'.$dummy_test_problem_name."/config.yml";
            $expected = file_get_contents($config_yml_path);
            $this->assertEquals($expected, json_decode($output));
        }
        
    }
    
    // public function test_remove_problem()
	// {   
    //     $problem_dir = FCPATH."/problems/";

    //     $dir = new DirectoryIterator($problem_dir);
    //     foreach ($dir as $fileinfo) {
    //         if ($fileinfo->isDir() && !$fileinfo->isDot()) {
    //             $dummy_test_problem_name = $fileinfo->getFilename();
    //             break;
    //         }
    //     }
        
    //     if ($dummy_test_problem_name){
    //         $output = $this->request('GET', 'problemdata/remove_problem/'.$dummy_test_problem_name);
    //         $expected = TRUE;
    //         $this->assertEquals(($expected), json_decode($output));
    //     }
        
    // }

}