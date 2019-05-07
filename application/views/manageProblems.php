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
                                <th scope="col" style="width:5%;">Remove</th>
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
                                    echo "<td scope='col' style='width:5%;'><span class='glyphicon glyphicon-remove document-remove remove-problem-glyph' data-toggle='modal' data-target='#removeProblemModal' data-problem='{&quot;problemName&quot;: &quot;".$problem."&quot; , &quot;value&quot; : &quot;remove&quot;}' aria-hidden='true'></span></td>";
                                    echo "</tr>";
                                    echo "<div class='information panel panel-default' >";
                                    echo "<td class='information information-td-".$problem."'  colspan='7'>";
                                    echo "<textarea class='panel-body information-textarea information-".$problem."' >";
                                    echo "</textarea>";
                                    echo "</td>";
                                    echo "</div>";
                                    $problem_number++;
                                }
                            ?>
                        </tbody>
                    </table>

                    <!-- Modal -->
                    <div class="modal fade" id="removeProblemModal" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><strong>Enter the problem name to confirm</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="text" id="delete-problem-name" class="form-control " placeholder="Problem Name">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" id="delete-problem-button"  class="btn btn-danger" >Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var problem = '';
    var value = '';

    function hide_data(element){
        $(".information").hide();
    };

    function show_data(data, problem){
        $(".information-textarea").hide();
        $(".information-"+problem).text(data);
        $(".information-"+problem).show();
        $(".information-td-"+problem).show();
        textAreaAdjust($(".information-"+problem));
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
                    console.log(data);
                    show_data(data, problem);
                },
                error: function(data) {
                    console.log("Failed to fetch the Problem data");
                }
            });
        }else{
            hide_data(element);
        }
    };

    function textAreaAdjust(element) {
        console.log(element[0].style);
        element[0].style.height = "1px";
        element[0].style.height = (2+element[0].scrollHeight+"px");
    }

    function capitalizeFirstLetter(string) {
       return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // to toggle the selected problem details
    $(".document").click(function(){
        show_document($(this));
    });

    // to trigger problem delete
    $(".document-remove").click(function(){
        problem = capitalizeFirstLetter($(this).data("problem").problemName);
        value = $(this).data("problem").value;
        $('#removeProblemModal').modal('show');
        
    });

    $(document).on('click', '#delete-problem-button', function(){
        var user_input = $("#delete-problem-name").val();
        if (problem == user_input) {
            // Validation successfull delete the problem
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
                    if (data) {
                        console.log("Success");
                        console.log(data);
                        location.reload();
                    } else {
                        console.log("Failed to delete the Problem data");
                    } 
                },
                error: function(data) {
                    console.log("Error Occurred in the controller");
                }
            });
        } else {
            $("#delete-problem-name").css("border-color", "red");                    
        }
    });


</script>
