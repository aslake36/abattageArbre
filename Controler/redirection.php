<?php
require_once 'Model/File.php';
require_once "Model/FileErrorException.php";

use master\File;
use master\FileErrorException;


function home(){
    $_GET['action'] = "home";
    require "Views/home.php";
}


function toJson(){

    $file = new File($_FILES['file']);
    try {
        $file->isCsv($file->getExtension());
        $file->uploadFile();
        $file->extractApplicants($file->getUploadedFilePath());
        $applicants = $file->getApplicants();
        $file->getTrees($file->getUploadedFilePath(), $applicants);
        $_GET['action'] = 'result';
        require "Views/result.php";
    }catch (FileErrorException $e){
        $_GET['error'] = $e->getMessage();
        $_GET['action'] = '';
        home();
    }
}


