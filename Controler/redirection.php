<?php
require_once 'Model/File.php';
require_once "Model/FileErrorException.php";

use master\File;
use master\FileErrorException;

/**
 * It will display the home page
 */
function home(){
    $_GET['action'] = "home";
    require "Views/home.php";
}

/**
 * It will handel to get links from the file and display Result or Home if error
 */
function toJson(){
    $file = new File($_FILES['file']);
    try {
        $file->isCsv($file->getExtension());
        $file->uploadFile();
        $file->extractApplicants($file->getUploadedFilePath());
        $applicants = $file->getApplicants();
        $file->getTrees($file->getUploadedFilePath(), $applicants);
        $file->deleteFile($file->getUploadedFilePath());
        foreach ($applicants as $key => $applicant) {
            $file->toXml($applicant, $key);
        }
        $_GET['action'] = 'result';
        require "Views/result.php";
    }catch (FileErrorException $e){
        $_GET['error'] = $e->getMessage();
        $_GET['action'] = '';
        home();
    } catch (Exception $e) {
        $_GET['error'] = $e->getMessage();
        $_GET['action'] = '';
        home();
    }
}


