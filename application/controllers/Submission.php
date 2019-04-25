<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submission extends CI_Controller {

    public function __construct(){
    
        parent::__construct();
        $this->load->helper('url', 'file');
        $this->load->model('submission_model');
        $this->load->library('session');
        $this->load->library("pagination");
    
    }

	public function index()
	{
		// $content = array('content'=> array(
        //     'view' => 'submission',
        // ));
        // $this->load->model('submission_model');
        // $this->load->view('/templates/default_layout', $content);
    }

    public function my_submission_list() {
        return $this->_submission_list(false);
    }

    public function all_submission_list() {
        return $this->_submission_list(true);
    }

    function _submission_list($is_all) {
        if (!$_SESSION['user_id']){
            redirect('login');
        }
        $config = array();
        if ($is_all) {
            $user_id = 'all';
            $config["base_url"] = base_url() . "all_submission";
            $config["total_rows"] = $this->submission_model->get_count('all');
        } else {
            $user_id = $_SESSION['user_id'];
            $config["base_url"] = base_url() . "my_submission";
            $config["total_rows"] = $this->submission_model->get_count($user_id);
        }

        $config["per_page"] = 20;
        $config["uri_segment"] = 2;

        /* This Application Must Be Used With BootStrap 3 *  */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] ="</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $data["links"] = $this->pagination->create_links();
        
        $data['submissions'] = $this->submission_model->get_submissions($user_id, $config["per_page"], $page);

        $content = array('content'=> array(
            'view' => 'submission',
            'data' => $data
        ));

        $this->load->view('/templates/default_layout', $content);
    }

    public function detail($sub_id) {
        if (!$_SESSION['user_id']) {
            echo "no user id";
			redirect('login');
        }
        if (!$_SESSION['role']) {
            echo "no role";
			redirect('login');
        }
        $session_user_id = $_SESSION['user_id'];

        $sub = $this->submission_model->get_submission($sub_id);
        $user_id = $sub->userid;
        $file_name = $sub->filename;
        $problem = $sub->problem;

		if ($_SESSION['role'] != 'admin' && $user_id != $session_user_id){
            echo "You have no access to this submission!";
            return;
		}

        $user_path = FCPATH.'/submissions/'.$user_id."/";
        $code_path = $user_path.$file_name;

        // parse problem config.yml file
        $config_yml_path = FCPATH.'/problems/'.$problem."/config.yml";
        $config_yml = file_get_contents($config_yml_path);
        $array = explode("\n", $config_yml);
        foreach ($array as $item) {
            $string = str_replace(' ', '', $item);
            if (strcmp($string, '') == 0) continue;
            $key_value = explode(":", $string);
            if ($key_value[0] == 'timelimit') $timelimit = $key_value[1];
            if ($key_value[0] == 'testcase') $testcase = $key_value[1];
        }

        // fetch code
        $code = htmlspecialchars(file_get_contents($code_path));

        $content = array('content'=> array(
            'view' => 'detail',
            'data' => array(
                'code' => $code,
                'sub' => $sub,
                'timelimit' => $timelimit,
                'testcase' => $testcase
            )
        ));

        $this->load->view('/templates/default_layout', $content);
    }

    public function submit() {
        $problem = $_POST['problem'];
        $code = $this->input->post('code');
        $type = $this->input->post('type');

        $user_id = $_SESSION['user_id'];

        $sub_id = $this->submission_model->create_submission($problem, $user_id, $code, $type);

        echo $sub_id;
    }

}
