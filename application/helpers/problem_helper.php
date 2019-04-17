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

?>
