<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/loader.css">

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <p class="problem problem-name"><?php ucfirst($problem_name);?></p><br>
            <p><strong>Problem Description</strong></p>
            <p class="problem problem-desc"><?php echo $desc;?></p><br>
            <p><strong>Sample Input</strong></p>
            <p class="problem problem-sample_input"><?php echo $sample_input;?></p><br>
            <p><strong>Sample Output</strong> </p>
            <p class="problem problem-sample_output"><?php echo $sample_output;?></p><br>
        </div>
        <div class="col-sm-6">
            <div class="language-select" style="margin: 10px">
                <select onchange="change_session()" id="select_language" class="styled-select semi-square gray">
                    <option value="cpp">Cpp</option>
                    <option value="python">Python</option>
                    <option value="java">Java</option>
                </select>
            </div>
            <div>
                <pre id="code" class="ace_editor" style="min-height:500px"><textarea class="ace_text-input">
                </textarea></pre>

                <script>
                editor = ace.edit("code");

                theme = "monokai";
                language = "c_cpp";
                editor.setTheme("ace/theme/" + theme);
                editor.session.setMode("ace/mode/" + language);

                editor.setFontSize(18);

                editor.setReadOnly(false);

                editor.setOption("wrap", "free")

                ace.require("ace/ext/language_tools");
                editor.setOptions({
                    enableBasicAutocompletion: true,
                    enableSnippets: true,
                    enableLiveAutocompletion: true
                });
                </script>
                <button type="button" class="btn btn-primary" style="margin-top: 20px;" onclick=submit()>Submit</button>
            </div>

            <div class="spinner" id="loader">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
            <div class="mt-5" id="result"></div>

        </div>
    </div>
</div>

<script>
window.onload=change_session;
function change_session() {
    var language = document.getElementById('select_language').value;
    var lan_mode = language;

    if (language == 'cpp') lan_mode = 'c_cpp';

    editor.session.setMode("ace/mode/" + lan_mode);
    console.log("<?=$problem_name?>", language);
    var code;
    $.ajax({
        type: "POST",
        url: "<?=base_url('skeleton/get_skeleton_code')?>",
        crossDomain: true,
        data: {
            problem: "<?=$problem_name?>",
            type: language
        },
        success: function(skeleton_code) {                 
            code = skeleton_code;
            editor.setValue("");
            editor.insert(code);
            console.log(skeleton_code);
        },
        error: function(data) {
            $("#loader").hide();
            console.log(data);
        }
    });
    
}

function submit() {
    $("#result").hide();
    var language = document.getElementById('select_language').value;
    var code = editor.getValue();
    $("#loader").show();
    $.ajax({
        type: "POST",
        url: "<?=base_url('submission/submit')?>",
        crossDomain: true,
        data: {
            problem: "<?=$problem_name?>",
            code: code,
            type: language
        },
        dataType: "json",
        success: function(data, status, xhr) {                 
            $("#loader").hide();
            res = data["res"];
            output = data["output"];
            error = data["error"];
            if (res == "Accepted") {
                $("#result").html("<div class=\"alert alert-success\"  role=\"alert\">\
                    <p >"+res+"<p>\
                    <pre>"+"stdout : "+output+"</pre>\
                    <pre>"+"stderr : "+error+"</pre>\
                    </div>\
                    ")
            } else if (res == "Compile Error") {
                $("#result").html("<div class=\"alert alert-warning\"  role=\"alert\">\
                    <p >"+res+"<p>\
                    <pre>"+"stdout : "+output+"</pre>\
                    <pre>"+"stderr : "+error+"</pre>\
                    </div>\
                    ")
            } else if (res == "Wrong Answer") {
                $("#result").html("<div class=\"alert alert-danger\"  role=\"alert\">\
                    <p >"+res+"<p>\
                    <pre>"+"stdout : "+output+"</pre>\
                    <pre>"+"stderr : "+error+"</pre>\
                    </div>\
                    ")
            } else if (res == "Time Limit Exceed") {
                $("#result").html("<div class=\"alert alert-secondary\"  role=\"alert\">\
                    <p >"+res+"<p>\
                    <pre >"+"stdout : "+output+"</pre>\
                    <pre>"+"stderr : "+error+"</pre>\
                    </div>\
                    ")
            } else {
                $("#result").html("<div class=\"alert alert-light\"  role=\"alert\">\
                    <p >"+res+"<p>\
                    <pre>"+"stdout : "+output+"</pre>\
                    <pre>"+"stderr : "+error+"</pre>\
                    </div>\
                    ")
            }
            $("#result").show();
        },
        error: function(data) {
            $("#loader").hide();
            console.log(data);
        }
    });
}
</script>

<script>
// Show an element
var show = function(elem) {
    elem.css.display = 'block';
};

// Hide an element
var hide = function(elem) {
    elem.css.display = 'none';
};

$("#loader").hide();
</script>
