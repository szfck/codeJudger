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
            $sol_path = $path.'/'.$fileinfo->getFilename().'/solution.json';
            if (file_exists($sol_path)) {
                array_push($solutions, json_decode(file_get_contents($sol_path)));
            }
        }
    }
    return $solutions;
}

?>
