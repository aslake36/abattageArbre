<?php

ob_start();
$title="Resultat";

$baseLink = "https://golux.lausanne.ch/goeland/affaire2/specialisation/t274/genereate_png_position_arbres.php?npixwidth=300&npixheight=300&symbsize=8&strjson=";
$strJson = '';

?>
    <br>
    <?php foreach ($applicants as $k => $applicant): ?>
        <?php $strJson = '' ?>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $applicant->getCivity() . ' ' . $applicant->getFirstname() . ' ' . $applicant->getName() ?></h4>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo count($applicant->getTrees()) . ' arbre'; if (count($applicant->getTrees()) > 1) echo 's' ?></h6>
                <hr>
                <?php
                    foreach ($applicant->getTrees() as $tree){
                        $strJson .= str_replace('"', "%22", json_encode($tree, JSON_FORCE_OBJECT)) . ',';
                    }
                ?>
                <a href="<?= $baseLink . "[" . substr($strJson, 0, -1) . "]" ?>" class="card-link">
                    Lien vers golux.lausanne.ch
                </a>
            </div>
        </div>
        <br>
    <?php endforeach; ?>

<?php
$content = ob_get_clean();
require "Body.php";