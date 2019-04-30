<?php
    if(!isset($_SESSION['user_id'])){
        redirect('home');
    }
?>

<div class="container">
    <div class="card-container" >
        <div class="card user-card">
            <div class="username">
                <label class="col-form-label">
                    <a id="user" href="<?php echo base_url('user');?>"><?=$_SESSION['user_name']?></a>
                </label>
            </div>
            <div class="user-details"></div>
        </div>

        <div class="card submission-card">
        “Our greatest glory is not in never failing, but in rising up every time we fail.”
        Yar Pirate Ipsum
        Prow scuttle parrel provost Sail ho shrouds spirits boom mizzenmast yardarm. Pinnace holystone mizzenmast quarter crow's nest nipperkin grog yardarm hempen halter furl. Swab barque interloper chantey doubloon starboard grog black jack gangway rutters.
        Deadlights jack lad schooner scallywag dance the hempen jig carouser broadside cable strike colors. Bring a spring upon her cable holystone blow the man down spanker Shiver me timbers to go on account lookout wherry doubloon chase. Belay yo-ho-ho keelhaul squiffy black spot yardarm spyglass sheet transom heave to.
        Trysail Sail ho Corsair red ensign hulk smartly boom jib rum gangway. Case shot Shiver me timbers gangplank crack Jennys tea cup ballast Blimey lee snow crow's nest rutters. Fluke jib scourge of the seven seas boatswain schooner gaff booty Jack Tar transom spirits.
        </div>
    </div>
</div>

<script>
    function show_user_details(username, useremail, role) {
        $(".user-details").html('<div> \
                                <div> \
                                    <label class="col-form-label">'+useremail+'</label> \
                                </div> \
                                <div> \
                                    <label class="col-form-label">'+role+'</label> \
                                </div> <br>\
                                    <a class="btn btn-primary btn-sm" href="<?php echo base_url('user/user_logout');?>">Logout</a> \
                                </div> \ ');
    }

    function get_user_details(){
        user = $("#user").text();
        console.log(user);
        $.ajax({
            type: "POST",
            url: "<?=base_url('user/get_user_details')?>",
            crossDomain: true,
            data: {
                user: user,
            },
            dataType: "json",
            success: function(data, status, xhr) {
                username = data['username'];
                useremail = data['useremail'];
                role = data['role'];
                show_user_details(username, useremail, role);
                console.log("Success");
            },
            error: function(data) {
                console.log("Error");
            }
        });
    }

    $( document ).ready(get_user_details);
</script>