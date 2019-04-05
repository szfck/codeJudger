
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.3/ace.js" type="text/javascript" charset="utf-8"></script>

<div class="container"><br>
	<p class="problem problem-name"><?php ucfirst($problem_name);?></p><br>
    <p ><strong>Problem Description</strong></p>
    <p class="problem problem-desc"><?php echo $desc;?></p><br>
    <p ><strong>Sample Input</strong></p>
    <p class="problem problem-sample_input"><?php echo $sample_input;?></p><br>
    <p ><strong>Sample Output</strong> </p>
    <p class="problem problem-sample_output"><?php echo $sample_output;?></p><br>
</div>
<div class="container language-select">
	<select onchange="change_session()" id="select_language" class="styled-select semi-square gray">
		<option value="cpp">Cpp</option>
		<option value="c">C</option>
		<option value="javascript">Javascript</option>
		<option value="python">Python</option>
		<option value="java">Java</option>
	</select>	
</div><br>

<div class="container">
    <div id="editor" class="container" style="height: 300px; padding-right: 50px;"></div>
    <button type="button" class="btn btn-primary" style="margin-top: 20px;" onclick=submit()>Submit</button>
</div>

<script>
	var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    document.getElementById('editor').style.fontSize='17px';
    code = "#include<iostream>\nusing namespace std;\nint main() {\n\tint a, b;\n\tcin >> a >> b;\n\tcout << a + b << endl;\n\treturn 0;\n}\n";  
    editor.insert(code);
	var language = 'cpp';
	editor.session.setMode("ace/mode/"+language);
	function change_session(){
		var language = document.getElementById('select_language').value;
		editor.session.setMode("ace/mode/"+language);
        console.log(language);
        if (language == 'cpp') {
            code = "#include<iostream>\nusing namespace std;\nint main() {\n\tint a, b;\n\tcin >> a >> b;\n\tcout << a + b << endl;\n\treturn 0;\n}\n";
        } else if (language == 'python') {
            code = "def solution(a, b):\n\treturn a + b";
        } else if (language == 'java') {
            code = "import java.io.*;\nimport java.util.*;\n\npublic class Main {\n\tpublic static void main(String[] args) throws IOException {\n\t\tBufferedReader br = new BufferedReader(new InputStreamReader(System.in));\n\t\tStringTokenizer st = new StringTokenizer(br.readLine());\n\t\tint a = Integer.parseInt(st.nextToken());\n\t\tint b = Integer.parseInt(st.nextToken());\n\t\t\n\t\tSystem.out.println(a+b);\n\t}\n}"
        }
        editor.setValue("");
        editor.insert(code);
	}

    function submit() {
        var language = document.getElementById('select_language').value;
        var code = editor.getValue();
        $.ajax({
            type: "POST",
            url: "<?=base_url('submission/submit')?>",
            data: {
                problem: "<?=$problem_name?>",
                code: code,
                type: language
            },
            success: function(){  
                window.location='/submission';
                // $("form#updatejob").hide(function(){$("div.success").fadeIn();});  
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                alert("Status: " + textStatus); alert("Error: " + errorThrown); 
            } 
        });
    }
</script>

