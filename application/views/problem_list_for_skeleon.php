<?php 
    $this->load->helper('problem_helper');
    $problem_number = 1;
    foreach (get_problem_list() as $problem ) {
        echo "<option value=".$problem.">".ucfirst($problem)."</th>";
        $problem_number++;
    }
?>

