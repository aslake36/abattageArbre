<?php
require_once 'Model/File.php';
require_once "Model/upload.php";

use master\File;


function home(){
    $_GET['action'] = "home";
    require "Views/home.php";
}


function toJson(){
    $file = new File($_FILES['file']);
    $file = dlFile();
    $parsedFile = getTrees($file);
    $_GET['action'] = 'result';
    $link = convertToJson($parsedFile);
    require "Views/result.php";
}


