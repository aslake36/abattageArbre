<?php

ob_start();
$title="Téléchargez le/les fichier/s XML";

$baseLink = "https://golux.lausanne.ch/public/genereate_png_position_arbres.php?npixwidth=300&npixheight=300&symbsize=8&strjson=";
$strJson = '';
$copyLink = '';

?>
    <br>
    <?php foreach ($applicants as $k => $applicant): ?>
        <?php $strJson = '' ?>
        <?php $copyLink = '' ?>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?php echo $applicant->getCivity() . ' ' . $applicant->getFirstname() . ' ' . $applicant->getName() ?></h4>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo count($applicant->getTrees()) . ' arbre'; if (count($applicant->getTrees()) > 1) echo 's' ?></h6>
                <hr>
                <?php
                    foreach ($applicant->getTrees() as $tree){
                        $json = [
                            "coordx" => $tree['coordx'],
                            "coordy" => $tree['coordy'],
                            "type"   => $tree['type']
                        ];
                        $copyLink .= json_encode($json) . ',';
                        $strJson .= str_replace('"', "%22", json_encode($json)) . ',';
                    }
                ?>
                <a href="<?= $baseLink . "[" . substr($strJson, 0, -1) . "]" ?>" class="card-link">
                    Lien vers golux.lausanne.ch
                </a>
                <hr>
                <p>Lien pour copier/coller</p>
                <div class="alert alert-danger" id="$link<?= $k ?>">
                    <?= $baseLink . "[" . substr($copyLink, 0, -1) . "]" ?>
                </div>
                <a href="Files/Applicant_<?= $k ?>.xml" download>
                    <button class="btn btn-danger">
                        Télécharger fichier XML
                    </button>
                </a>
            </div>
        </div>
        <br>
    <?php endforeach; ?>

<?php
$content = ob_get_clean();
require "Body.php";