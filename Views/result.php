<?php

ob_start();
$title="Resultat";

?>
    <br>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Voici votre lien</h4>
            <p>
                <a href="https://golux.lausanne.ch/goeland/affaire2/specialisation/t274/genereate_png_position_arbres.php?npixwidth=300&npixheight=300&symbsize=8&strjson=[<?= $link ?>]">
                    Votre image
                </a>
            </p>
        </div>
    </div>
<?php
$content = ob_get_clean();
require "Body.php";