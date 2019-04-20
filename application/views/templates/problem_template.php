<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/problem.css">

<div class="container">

    <div class="problem-statement">
        <div class="header">
            <h2><?=ucfirst($problem_name)?></h2>
            <div>
                time limit per test: <?=$time_limit?> second
            </div>
        </div>
        <div>
            <pre><?=$desc?></pre>
        </div>

        <div class="sample-tests">
            <div class="sample-test">
                <div class="input">
                    <h4>Input</h4>
                    <pre><?=$sample_input?></pre>
                </div>
                <div class="output">
                    <h4>Output</h4>
                    <pre><?=$sample_output?></pre>
            </div>
        </div>
    </div>

    <?php 
        $content = array(
            'problem_name' => $problem_name,
            'type' => '',
            'code' => ''
        );
        $this->load->view('/templates/submit_code', $content);
    ?>

</div>
