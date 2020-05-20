<?php

ob_start();
$title = "Téléchargez les fichiers.";

$baseLink = "https://golux.lausanne.ch/public/genereate_png_position_arbres.php?npixwidth=300&npixheight=300&symbsize=8&strjson=";
$docxBaseLink = 'http://ws-print-test.lausanne.ch/wsprint-v1.6/print/';
$strJson = '';
$copyLink = '';

?>

    <br>
    <table class="table table-striped table-bordered" style="width:100%">
        <thead>
        <tr>
            <th>Action</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Adresse</th>
            <th>Date</th>
            <th>Nb arbre(s)</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($applicants as $k => $applicant): ?>
            <?php
            $strJson = '';
            $copyLink = '';
            foreach ($applicant->getTrees() as $tree){
                $json = [
                    "coordx" => $tree['coordx'],
                    "coordy" => $tree['coordy'],
                    "type"   => $tree['type']
                ];
                $copyLink .= json_encode($json) . ',';
                $strJson .= str_replace('"', "%22", json_encode($json)) . ',';
            }
            $docX = file_get_contents('http://ws-print-test.lausanne.ch/wsprint-v1.6/print/post', false, stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header'  => "Content-type: application/x-www-form-urlencoded",
                    'content' => http_build_query([
                        'application' => 'ARBRE_ABATTAGE', 'document' => 'fusionDocument', 'format' => '10', 'fluxXML' => file_get_contents('Files/Applicant_' . $k . '.xml')
                    ])
                ]
            ]));
            file_put_contents('Files/Applicant_' . $k . '.docx', $docX);
            ?>
            <tr>
                <td>
                    <a href="<?= 'Files/Applicant_' . $k . '.docx' ?>" class="btn btn-sm btn-outline-danger" download>DOCX</a>
                    <a href="<?= $baseLink . "[" . substr($strJson, 0, -1) . "]" ?>" class="btn btn-sm btn-outline-danger" target="_blank">IMAGE</a>
                </td>
                <td><?php echo $applicant->getName() ?></td>
                <td><?php echo $applicant->getFirstname() ?></td>
                <td><?php echo strtoupper(substr($applicant->getAddress(), 0, 1)) . substr($applicant->getAddress(), 1) . ', ' . $applicant->getZipCode() . ' ' . $applicant->getCity() ?></td>
                <td><?php echo $applicant->getDate()->format('d-m-Y') ?></td>
                <td><?php echo count($applicant->getTrees()) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <th>Action</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Adresse</th>
            <th>Date</th>
            <th>Nb arbre(s)</th>
        </tr>
        </tfoot>
    </table>
    <br>

<?php
$content = ob_get_clean();
require "Body.php";