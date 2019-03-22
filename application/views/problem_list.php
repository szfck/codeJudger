
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
        foreach (get_problem_list() as $problem ) {
            echo "<tr> <td>".anchor("problem/get_problem/".$problem, $problem, array('class' => 'problem'))."</td> </tr>";
        }
    ?>
</tbody>
</table>
