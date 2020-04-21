<?php

ob_start();
$title="Resultat";

?>
    <br>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Voici votre lien</h4>
            <p><a href="<?php echo $lien ?>"><?php echo $lien ?></a></p>
        </div>
    </div>
<?php
$content = ob_get_clean();
require "Body.php";