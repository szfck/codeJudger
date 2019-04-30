<div class="content">
    <div class=container>
        <table id="submission-table" class=" table table-striped">
            <tr>
                <th onclick="sortTable(0)">Submisson id</th>
                <th onclick="sortTable(1)">Time</th>
                <th onclick="sortTable(2)">Problem</th>
                <th onclick="sortTable(3)">User id</th>
                <th onclick="sortTable(4)">Type</th>
                <th onclick="sortTable(5)">Result</th>
            </tr>
        <?php 
            foreach ($submissions as $sub) {
                echo 
                "<tr>".
                    "<td>".anchor("submission/detail/".$sub->subid.".".$sub->type, $sub->subid)."</td>".
                    "<td>".date("Y-m-d H:i:s", $sub->time)."</td>".
                    "<td>".anchor("problem/".$sub->problem, ucfirst($sub->problem))."</td>".
                    "<td>".$sub->userid."</td>".
                    "<td>".$sub->type."</td>".
                    "<td>".$sub->result."</td>".
                "</tr>";
            }
        ?>
        </table>
        <p><?php echo $links; ?></p>

    </div>
</div>
<script>
//Source -  https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_sort_table_desc
function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("submission-table");
    switching = true;
    //Set the sorting direction to ascending:
    dir = "asc";
    /*Make a loop that will continue until
    no switching has been done:*/
    while (switching) {
        //start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /*Loop through all table rows (except the
        first, which contains table headers):*/
        for (i = 1; i < (rows.length - 1); i++) {
            //start by saying there should be no switching:
            shouldSwitch = false;
            /*Get the two elements you want to compare,
            one from current row and one from the next:*/
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            /*check if the two rows should switch place,
            based on the direction, asc or desc:*/
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    //if so, mark as a switch and break the loop:
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            /*If a switch has been marked, make the switch
            and mark that a switch has been done:*/
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            //Each time a switch is done, increase this count by 1:
            switchcount++;
        } else {
            /*If no switching has been done AND the direction is "asc",
            set the direction to "desc" and run the while loop again.*/
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}
</script>
