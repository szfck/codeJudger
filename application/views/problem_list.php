
<table class="table table-striped">
<thead>
 <tr>
  <th>Problems</th>
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
