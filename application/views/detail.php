<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/socket.io/1.3.6/socket.io.min.js"></script>

<script type="text/javascript" charset="utf-8">
    var socket = io.connect('http://' + document.domain + ':3000');
    socket.on('connect', function() {
        console.log('connected');
        socket.emit('judge', "<?=$subid?>");
    });
    socket.on('judge', function(data) {
        console.log('recv from judge');
        console.log(data);
        // socket.emit('my event', {data: 'I\'m connected!'});
    });
</script>

<!-- <script>
function judge() {
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
            console.log(data);
            sub_id = data;
            location.href = '/submission/detail/' + sub_id;

            // res = data["status"];
            // totalcase = data["total_case"];
            // correctcase = data["correct_case"];
            // input = data["input"];
            // output = data["user_output"];
            // expected_output = data["correct_output"];
            // error = data["error"];

            // if (res == "Accepted") {
            //     html_to_append("success", data);
            // } else if (res == "Compile Error") {
            //     html_to_append("warning", data);
            // } else if (res == "Wrong Answer") {
            //     html_to_append("danger", data);
            // } else if (res == "Time Limit Exceed") {
            //     html_to_append("secondary", data);
            // } else if (res == "Runtime Error") {
            //     html_to_append("danger", data);
            // } else {
            //     html_to_append("light", data);
            // }
        },
        error: function(data) {
            console.log(data);
        }
    });
} -->
<!-- </script> -->

<div class="border p-3">
    <pre><code><?=$code?></code></pre>
</div>
