
<table class="table table-striped">
<thead>
 <tr>
  <button type="button" class="btn btn-info">Problems</button>
 </tr>
</thead>
<tbody>         
    <?php 
        $this->load->helper('problem_helper');
        foreach (get_problem_list() as $problem ) {
            echo "<tr> <td>$problem</td> </tr>";
        }
    ?>
</tbody>
</table>
