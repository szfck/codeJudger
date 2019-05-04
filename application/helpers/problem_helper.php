<?php 
function get_problem_list() {
    $path = getcwd().'/problems';
    $problems = array();
    $dir = new DirectoryIterator($path);
    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {
            array_push($problems, $fileinfo->getFilename());
        }
    }
    return $problems;
}

function get_problem_solution_list() {
    $path = getcwd().'/problems';
    $solutions = array();
    $dir = new DirectoryIterator($path);
    foreach ($dir as $fileinfo) {
        if ($fileinfo->isDir() && !$fileinfo->isDot()) {
            $sol = get_problem_solution($fileinfo->getFilename());
            if ($sol != null) {
                array_push($solutions, $sol);
            }
        }
    }
    return $solutions;
}

function get_problem_solution($problem) {
    $path = getcwd().'/problems';
    $solutions = array();
    $sol_path = $path.'/'.$problem.'/solution.json';
    if (file_exists($sol_path)) {
        return json_decode(file_get_contents($sol_path));
    }
    return null;
}

function fetch_problem_directory(){
    $path = getcwd().'/problems';
}

?>
