<?php include 'contribute.php' ?>
<div class="content">
    <div class="container">
        <?php
            $success_msg= $this->session->flashdata('Success');
            $message = $this->session->flashdata('message');
            $error_msg= $this->session->flashdata('Failed');
            if($success_msg){
            ?>
            <div class="alert alert-success">
                <?php echo $success_msg; ?>
                <?php echo $message; ?>
            </div>
            <?php
            }
            if($error_msg){
            ?>
            <div class="alert alert-danger">
                <?php echo $error_msg; ?>
            </div>
            <?php
            }
        ?>
        <div class="justify-content-center align-items-center">
            <form role="form" method="post" class="col-12 justify-content-center align-items-center" style="padding-top: 20px;">
                <div class="form-group">
                    <label for="problemName">Problem Name</label>
                    <input id="problemName" type="text" class="form-control" name="problemName" placeholder="Problem Name" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="problemDesc">Problem Description</label>
                    <textarea id="problemDesc" class="form-control" name="problemDesc" rows="12" placeholder="Problem Description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="problemDesc">Sample Input</label>
                    <textarea id="sampleInput" class="form-control" name="sampleInput" rows="3" placeholder="Enter the Sample Input Separated by space" required></textarea>
                </div>
                <div class="form-group">
                    <label for="problemDesc">Sample Output</label>
                    <textarea id="sampleOutput" class="form-control" name="sampleOutput" rows="2" placeholder="Enter the Sample Output" required></textarea>
                </div>
                
                <button id="submit-btn" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    function submit_problem(){
        console.log("Inside sub problem");
        var isvalid = validate_inputs();

        if (isvalid){
            console.log("valid");
            problemName  = document.getElementById("problemName").value;
            problemDesc  = document.getElementById("problemDesc").value;
            sampleInput  = document.getElementById("sampleInput").value;
            sampleOutput = document.getElementById("sampleOutput").value;
            console.log(problemName, problemDesc, sampleInput, sampleOutput);
            $.ajax({
                type: "POST",
                url: "<?=base_url('contribute/add_problem')?>",
                crossDomain: true,
                data: {
                    name: problemName,
                    desc: problemDesc,
                    input: sampleInput,
                    output: sampleOutput,
                },
                dataType: "json",
                success: function(data, status, xhr) {
                    console.log("hhtestoj ------------");
                    console.log(data);
                    console.log("Success");
                },
                error: function(data) {
                    console.log("Error");
                    console.log(data);
                }
            });
        }

    }
    
    function validate_inputs(){
        var input_fields = new Array("problemName", "problemDesc", "sampleInput", "sampleOutput");
        for (let index = 0; index < input_fields.length; index++) {
            const element = input_fields[index];
            if ($("#"+element).val() == "") {
                alert("Missing values for : "+element);
                return false;
            }
        }
        return true;
    };
    
    $("#submit-btn").click(submit_problem);
</script>