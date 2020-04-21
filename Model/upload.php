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

function parseFile($fileName){
    $lines = file('Uploaded_file' . DIRECTORY_SEPARATOR . $fileName);
    foreach ($lines as $k => $line) {
        $lines[$k] = explode(";", trim($line));
    }
    return $lines;
}

function convertToJson($parsedFile){
    
}
