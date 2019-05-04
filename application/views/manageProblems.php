<?php include 'contribute.php' ?>
<div class="content">
    <div class="container">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Problems
                </div>
                <div class="panel-body">
                    <table class='table'>
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width:5%;">#</th>
                                <th scope="col">Problem</th>
                                <th scope="col">Description</th>
                                <th scope="col">Sample Input</th>
                                <th scope="col">Sample Output</th>
                                <th scope="col">Configuration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $this->load->helper('problem_helper');
                                $problem_number = 1;
                                foreach (get_problem_list() as $problem ) {
                                    echo "<tr>";
                                    echo "<td scope='row'>".$problem_number."</th>";
                                    echo "<td> ".anchor("problem/".$problem, ucfirst($problem), array('class' => 'problem-list'))."</td>";
                                    echo "<td> <span class='glyphicon glyphicon-file document' data-problem='{&quot;problemName&quot;: &quot;".$problem."&quot; , &quot;value&quot; : &quot;description&quot;}' aria-hidden='true'></span></td>";
                                    echo "<td> <span class='glyphicon glyphicon-file document' data-problem='{&quot;problemName&quot;: &quot;".$problem."&quot; , &quot;value&quot; : &quot;input&quot;}' aria-hidden='true'></span></td>";
                                    echo "<td> <span class='glyphicon glyphicon-file document' data-problem='{&quot;problemName&quot;: &quot;".$problem."&quot; , &quot;value&quot; : &quot;output&quot;}' aria-hidden='true'></span></td>";
                                    echo "<td> <span class='glyphicon glyphicon-file document' data-problem='{&quot;problemName&quot;: &quot;".$problem."&quot; , &quot;value&quot; : &quot;config&quot;}' aria-hidden='true'></span></td>";
                                    echo "</tr>";
                                    echo "<td class='information information-".$problem."' style='display : none' colspan='6'></td>";
                                    $problem_number++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function show_data(element, data, problem){
        $(".information").hide();
        $(".information-"+problem).html(data);
        $(".information-"+problem).show();
    };

    function show_document(element){
        if (element.hasClass("clicked")) {
            element.removeClass("clicked");
        }else{
            $(".document").removeClass('clicked');
            element.addClass('clicked');
        }
        problem = element.data("problem").problemName;
        value = element.data("problem").value;

        if (element.hasClass("clicked")){
            $.ajax({
                type: "POST",
                url: "<?=base_url('problemdata/get_problem_details')?>",
                crossDomain: true,
                data: {
                    problem: problem,
                    value: value,
                },
                dataType: "json",
                success: function(data, status, xhr) {
                    show_data(element, data, problem);
                },
                error: function(data) {
                    console.log("Failed to fetch the Problem data");
                }
            });
        }
    };

    $(".document").click(function(){
        show_document($(this));
    });
</script>
