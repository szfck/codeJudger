<table class="table table-striped">
<tr>
    <th>submisson id</th>
    <th>time</th>
    <th>problem</th>
    <th>user id</th>
    <th>type</th>
    <th>result</th>
</tr>
<?php 
    $this->load->model('submission_model');
    $submissions = $this->submission_model->get_user_submission_list();
    foreach ($submissions as $sub) {
        echo 
        "<tr>".
            "<td>".anchor("submission/detail/".$sub->subid.".".$sub->type, $sub->subid)."</td>".
            "<td>".date("Y-m-d H:i:s", $sub->time)."</td>".
            "<td>".anchor("problem/get_problem/".$sub->problem, ucfirst($sub->problem))."</td>".
            "<td>".$sub->userid."</td>".
            "<td>".$sub->type."</td>".
            "<td>".$sub->result."</td>".
        "</tr>";
    }
?>
</table>
