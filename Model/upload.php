<?php

/**
 * We store the file in our server
 * @return mixed -> fileName
 */
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

/**
 * We extract data that concerns trees
 * @param $fileName -> file name
 * @return array -> Only trees
 */
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

/**
 * @param $parsedFile
 * @return string ->
 */
function convertToJson($parsedFile){
    // lien : https://golux.lausanne.ch/goeland/affaire2/specialisation/t274/genereate_png_position_arbres.php?npixwidth=300&npixheight=300&symbsize=8&strjson=
    // Ex strjson : [{"type":"abattage","coordx":"539346.1","coordy":"152831.7"},{"type":"elagage","coordx":"539331.6","coordy":"152806.0"}]
    // line 22 to 111 -> Arbres
    $strJson = "";
    foreach ($parsedFile as $item) {
        $strJson .= "{%22type%22:%22" . $item[6] . "%22,";
        $strJson .= "%22coordx%22:%22" . str_replace(',','.',$item[0]) . "%22,";
        $strJson .= "%22coordy%22:%22" . str_replace(',','.',$item[1]) . "%22},";
        if (isset($item[15])){
            $strJson .= "{%22type%22:%22" . $item[15] . "%22,";
            $strJson .= "%22coordx%22:%22" . str_replace(',','.',$item[9]) . "%22,";
            $strJson .= "%22coordy%22:%22" . str_replace(',','.',$item[10]) . "%22},";
            if (isset($item[24])){
                $strJson .= "{%22type%22:%22" . $item[24] . "%22,";
                $strJson .= "%22coordx%22:%22" . str_replace(',','.',$item[18]) . "%22,";
                $strJson .= "%22coordy%22:%22" . str_replace(',','.',$item[19]) . "%22},";
                if (isset($item[33])){
                    $strJson .= "{%22type%22:%22" . $item[33] . "%22,";
                    $strJson .= "%22coordx%22:%22" . str_replace(',','.',$item[27]) . "%22,";
                    $strJson .= "%22coordy%22:%22" . str_replace(',','.',$item[28]) . "%22},";
                    if (isset($item[42])){
                        $strJson .= "{%22type%22:%22" . $item[42] . "%22,";
                        $strJson .= "%22coordx%22:%22" . str_replace(',','.',$item[36]) . "%22,";
                        $strJson .= "%22coordy%22:%22" . str_replace(',','.',$item[37]) . "%22},";
                        if (isset($item[51])){
                            $strJson .= "{%22type%22:%22" . $item[51] . "%22,";
                            $strJson .= "%22coordx%22:%22" . str_replace(',','.',$item[45]) . "%22,";
                            $strJson .= "%22coordy%22:%22" . str_replace(',','.',$item[46]) . "%22},";
                            if (isset($item[60])){
                                $strJson .= "{%22type%22:%22" . $item[60] . "%22,";
                                $strJson .= "%22coordx%22:%22" . str_replace(',','.',$item[54]) . "%22,";
                                $strJson .= "%22coordy%22:%22" . str_replace(',','.',$item[55]) . "%22},";
                                if (isset($item[69])){
                                    $strJson .= "{%22type%22:%22" . $item[69] . "%22,";
                                    $strJson .= "%22coordx%22:%22" . str_replace(',','.',$item[63]) . "%22,";
                                    $strJson .= "%22coordy%22:%22" . str_replace(',','.',$item[64]) . "%22},";
                                    if (isset($item[78])) {
                                        $strJson .= "{%22type%22:%22" . $item[78] . "%22,";
                                        $strJson .= "%22coordx%22:%22" . str_replace(',', '.', $item[72]) . "%22,";
                                        $strJson .= "%22coordy%22:%22" . str_replace(',', '.', $item[73]) . "%22},";
                                        if (isset($item[87])) {
                                            $strJson .= "{%22type%22:%22" . $item[87] . "%22,";
                                            $strJson .= "%22coordx%22:%22" . str_replace(',', '.', $item[81]) . "%22,";
                                            $strJson .= "%22coordy%22:%22" . str_replace(',', '.', $item[82]) . "%22},";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $strJson = substr($strJson, 0, -1);
    return $strJson;
}
