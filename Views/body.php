<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="Views/css/bootstrap.css">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Refresh</a>
    </div>
</nav>

<div class="container">
    <?= $content ?>
</div>
<div class="container">
    <hr>
</div>


<script src="Views/js/jQuery.js"></script>
<script src="Views/js/popper.js"></script>
<script src="Views/js/bootstrap.js"></script>
</body>
</html>