
<table class="table table-striped">
<thead>
 <tr>
  <a href="#" class="badge badge-primary">Array</a>
  <a href="#" class="badge badge-secondary">Sort</a>
  <a href="#" class="badge badge-success">Tree</a>
  <a href="#" class="badge badge-danger">Heap</a>
  <a href="#" class="badge badge-warning">Stack</a>
  <a href="#" class="badge badge-info">Queue</a>
  <a href="#" class="badge badge-light">Graph</a>
  <a href="#" class="badge badge-dark">Recursion</a>
 </tr>
</thead>
<tbody>         
    <?php 
        $this->load->helper('problem_helper');
        $problem_number = 1;
        foreach (get_problem_list() as $problem ) {
            echo "<tr> <td>$problem_number."." ".anchor("problem/get_problem/".$problem."/".$problem_number, ucfirst($problem), array('class' => 'problems'))."</td> </tr>";
            $problem_number++;
        }
    ?>
</tbody>
</table>
