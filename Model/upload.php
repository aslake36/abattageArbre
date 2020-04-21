<?php

function dlFile(){
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));



        $allowedfileExtensions = array('csv');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = 'Uploaded_file/';

            $dest_path = $uploadFileDir . basename($fileName);

            if(move_uploaded_file($fileTmpPath, $dest_path))
            {
                $message ='File is successfully uploaded.';
            }
            else
            {
                $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
            }
        }

        return $fileName;
    }
}

function getTrees($fileName){
    $result = [];
    $trees = [];
    $lines = file('Uploaded_file' . DIRECTORY_SEPARATOR . $fileName);
    foreach ($lines as $k => $line) {
        $uLine = utf8_encode($line);
        $lines[$k] = explode(";", trim($uLine));
    }
    unset($lines[0]);
    for ($j = 1; $j <= count($lines); $j++){
        for ($i = 22; $i <= 111; $i++){
            $result[$j][$i] = $lines[$j][$i];
        }
    }
    foreach ($result as $k => $data){
        foreach ($data as $datum) {
            if ($datum != ''){
                $trees[$k][] = $datum;
            }
        }
    }
    return $trees;
}

function convertToJson($parsedFile){
    // lien : https://golux.lausanne.ch/goeland/affaire2/specialisation/t274/genereate_png_position_arbres.php?npixwidth=300&npixheight=300&symbsize=8&strjson=
    // Ex strjson : [{"type":"abattage","coordx":"539346.1","coordy":"152831.7"},{"type":"elagage","coordx":"539331.6","coordy":"152806.0"}]
    // line 22 to 111 -> Arbres
    $strJson = "https://golux.lausanne.ch/goeland/affaire2/specialisation/t274/genereate_png_position_arbres.php?npixwidth=300&npixheight=300&symbsize=8&strjson=[";
    foreach ($parsedFile as $item) {
        $strJson .= '{"type":"' . $item[6] . '",';
        $strJson .= '"coordx":"' . str_replace(',','.',$item[0]) . '",';
        $strJson .= '"coordy":"' . str_replace(',','.',$item[1]) . '"},';
    }
    return $strJson;
}
