<table class="table">
    <thead class="thead-light">
        <!-- <h1>Category <span class="badge badge-secondary"></span></h1>
    <tr>
    <a href="#" class="badge badge-primary">Array</a>
    <a href="#" class="badge badge-secondary">Sort</a>
    <a href="#" class="badge badge-success">Tree</a>
    <a href="#" class="badge badge-danger">Heap</a>
    <a href="#" class="badge badge-warning">Stack</a>
    <a href="#" class="badge badge-info">Queue</a>
    <a href="#" class="badge badge-light">Graph</a>
    <a href="#" class="badge badge-dark">Recursion</a>
    </tr> -->

        <tr>
            <th scope="col" style="width:5%;">#</th>
            <th scope="col">Problem</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $this->load->helper('problem_helper');
            $problem_number = 1;
            foreach (get_problem_list() as $problem ) {
                echo "<tr>";
                echo "<th scope='row'>".$problem_number."</th>";
                echo "<td> ".anchor("problem/".$problem, ucfirst($problem), array('class' => 'problem-list'))."</td>";
                echo "</tr>";
                $problem_number++;
            }
        ?>
    </tbody>
</table>