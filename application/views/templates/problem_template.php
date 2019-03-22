<!DOCTYPE html>
<html>
	<head>
		<title> CodeJudger </title>
	</head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.3.3/ace.js" type="text/javascript" charset="utf-8"></script>

	</head>
	<body>
		<nav class="navbar navbar-expand-sm bg-dark">
			<a class="navbar-brand" href="<?php echo base_url('home') ?>">CodeJudger</a>
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="#">Link 1</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Link 2</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Link 3</a>
				</li>
			</ul>
		</nav>
		<br>

		<div class="container">
			<p><?php echo $problem_name;?></p><br>
            <p><?php echo $desc;?></p><br>
            <p>Sample Input</p>
            <p><?php echo $sample_input;?></p><br>
            <p>Sample Output</p>
            <p><?php echo $sample_output;?></p><br>
        </div>
        <div class="container" style="padding-left: 0px;">
        	<select onchange="change_session()" id="select_language" >
        		<option value="javascript">javascript</option>
				<option value="python">python</option>
				<option value="java">java</option>
				<option value="c">c</option>
        	</select>	
        </div>
        
        
        <div id="editor" class="container" style="height: 300px; padding-right: 50px;"></div>

		<script>
			var editor = ace.edit("editor");
		    editor.setTheme("ace/theme/monokai");
		    document.getElementById('editor').style.fontSize='17px';
		    editor.insert("Hello World !!");
			var language = 'javascript';
			editor.session.setMode("ace/mode/"+language);
			function change_session(){
				var language = document.getElementById('select_language').value;
				editor.session.setMode("ace/mode/"+language);
			}
			console.log(language);
		</script>

        <div id="footer">
            Copy Right 2019 Hello World
        </div>

	</body>
</html>