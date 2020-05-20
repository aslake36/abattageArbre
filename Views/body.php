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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


</body>
</html>