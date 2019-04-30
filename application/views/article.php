<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    .checked {
        color: orange;
    }
    </style>
</head>

<body>

    <div class="container">
        <div class="welcome-banner">
            <h1>CodeJudger Articles</h1>
        </div>
        <div>
            <p class="thicker">Welcome to Code Judger Articles</p>
        </div>
        <div class="list-group">

            <?php foreach ($sols as $sol) { ?>
            <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?=$sol->title?></h5>
                    <small>March 21, 2019</small>
                </div>
                <p class="mb-1"><?=$sol->abstract?></p>

                <?php for ($i = 0; $i < $sol->star; $i++) { ?>
                    <span class="fa fa-star checked"></span>
                <?php } ?>

                <?php for ($i = $sol->star; $i < 5; $i++) { ?>
                    <span class="fa fa-star"></span>
                <?php } ?>

            </a>

            <?php } ?>
        </div>

    </div>

</body>

</html>
