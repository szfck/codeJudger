<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.3/ace.js" type="text/javascript" charset="utf-8"></script>

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
                <div id="editor" style="height: 500px;"></div>
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
var editor = ace.edit("editor");
editor.setTheme("ace/theme/monokai");
document.getElementById('editor').style.fontSize = '17px';
code =
    "#include<iostream>\nusing namespace std;\nint main() {\n\tint a, b;\n\tcin >> a >> b;\n\tcout << a + b << endl;\n\treturn 0;\n}\n";
editor.insert(code);
var language = 'cpp';
editor.session.setMode("ace/mode/" + language);

function change_session() {
    var language = document.getElementById('select_language').value;
    editor.session.setMode("ace/mode/" + language);
    console.log(language);
    if (language == 'cpp') {
        code =
            "#include<iostream>\nusing namespace std;\nint main() {\n\tint a, b;\n\tcin >> a >> b;\n\tcout << a + b << endl;\n\treturn 0;\n}\n";
    } else if (language == 'python') {
        code =
            "def main():\n\tx = [int(x) for x in input().split(' ')]\n\tprint(x[0]+x[1])\n\treturn 0\nif __name__=='__main__':\n\tmain()";
    } else if (language == 'java') {
        code =
            "import java.io.*;\nimport java.util.*;\n\npublic class Main {\n\tpublic static void main(String[] args) throws IOException {\n\t\tBufferedReader br = new BufferedReader(new InputStreamReader(System.in));\n\t\tStringTokenizer st = new StringTokenizer(br.readLine());\n\t\tint a = Integer.parseInt(st.nextToken());\n\t\tint b = Integer.parseInt(st.nextToken());\n\t\t\n\t\tSystem.out.println(a+b);\n\t}\n}"
    }
    editor.setValue("");
    editor.insert(code);
}

function submit() {
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
        success: function(data) {
            $("#loader").hide();

            if (data == "Accepted") {
                $("#result").html("<div class=\"alert alert-success\" role=\"alert\">" + data + "</div>")
            } else if (data == "Compile Error") {
                $("#result").html("<div class=\"alert alert-warning\" role=\"alert\">" + data + "</div>")
            } else if (data == "Wrong Answer") {
                $("#result").html("<div class=\"alert alert-danger\" role=\"alert\">" + data + "</div>")
            } else if (data == "Time Limit Exceed") {
                $("#result").html("<div class=\"alert alert-secondary\" role=\"alert\">" + data + "</div>")
            } else {
                $("#result").html("<div class=\"alert alert-light\" role=\"alert\">" + data + "</div>")
            }
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