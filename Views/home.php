<?php

ob_start();
$title="Home";

?>
    <br>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Convertissez votre fichier .csv vers lien golux</h4>
            <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= $_GET['error'] ?></div>
            <?php endif; ?>
            <form method="POST" action="index.php?action=toJson" enctype="multipart/form-data">
                <label for="file" class="form-text text-muted" > Choissiez votre fichier .csv :</label>
                <input type="file" class="form-control" name="file" id="file" required>
                <br>
                <button type="submit" class="btn btn-danger">Enregister</button>
            </form>
        </div>
    </div>
<?php
$content = ob_get_clean();
require "Body.php";