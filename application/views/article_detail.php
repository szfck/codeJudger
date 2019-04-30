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
            <h2><?=$sol->title?></h2>
        </div>

        <div class="list-group">

            <?php for ($i = 0; $i < $sol->star; $i++) { ?>
            <span class="fa fa-star checked"></span>
            <?php } ?>

            <?php for ($i = $sol->star; $i < 5; $i++) { ?>
            <span class="fa fa-star"></span>
            <?php } ?>


            <pre><?=$sol->text?></pre>

        </div>

    </div>

</body>

</html>
