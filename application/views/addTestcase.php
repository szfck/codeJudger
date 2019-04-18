<div class="container">
    <div class="justify-content-center align-items-center">
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
        <form role="form" method="post" class="col-12 justify-content-center align-items-center" style="padding-top: 20px;">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Problem</label>
                </div>
                <select class="form-control" id="problem" name="problemName">
                    <option selected>Choose Problem ...</option>
                    <?php include 'problem_list_for_skeleon.php'; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="problemDesc">Problem Description</label>
                <textarea class="form-control" readonly="readonly" id="problemDesc" name="problemDesc" rows="6" placeholder="Problem Description"></textarea>
            </div>
            <div class="form-group">
                <label for="problemDesc">Sample Input</label>
                <textarea class="form-control" readonly="readonly" id="sampleInput" name="sampleInput" rows="2" placeholder="Enter the Sample Input Separated by space"></textarea>
            </div>
            <div class="form-group">
                <label for="problemDesc">Sample Output</label>
                <textarea class="form-control" readonly="readonly" id="sampleOutput" name="sampleOutput" rows="2" placeholder="Enter the Sample Output"></textarea>
            </div>
            <div class="form-group">
                <label for="problemDesc">Enter the Test Input</label>
                <textarea class="form-control" id="testInput" name="sampleInput" rows="2" placeholder="Enter the new Input Separated by space"></textarea>
            </div>
            <div class="form-group">
                <label for="problemDesc">Enter the Test Output</label>
                <textarea class="form-control" id="testOutput" name="sampleOutput" rows="2" placeholder="Enter the Output"></textarea>
            </div>
            <button id="submit-button" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<script>
    $( "#problem" ).change(function() {
        var problem_name = document.getElementById('problem').value;
        $.ajax({
            type: "POST",
            url: "<?=base_url('contribute/get_problem_details')?>",
            crossDomain: true,
            data: {
                problem: problem_name
            },
            dataType: "json",
            success: function(data, status, xhr) {
                desc = data["problem_desc"];
                input = data["problem_input"];
                output = data["problem_output"];
                document.getElementById("problemDesc").value = desc;
                document.getElementById("sampleInput").value = input;
                document.getElementById("sampleOutput").value = output;
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $("#submit-button").click(function() {
        problemName = document.getElementById("problem").value;
        input = document.getElementById("testInput").value;
        output = document.getElementById("testOutput").value;
        console.log(problemName);
        console.log(input);
        console.log(output);
        $.ajax({
            type: "POST",
            url: "<?=base_url('contribute/add_testcase')?>",
            crossDomain: true,
            data: {
                problem: problemName,
                input: input,
                output: output,
            },
            dataType: "json",
            success: function(data, status, xhr) {
                console.log(data);
                console.log("Success");
            },
            error: function(data) {
                console.log("Error");
                console.log(data);
            }
        });
    });
</script>