<?php

require_once "Model/upload.php";


function home(){
    $_GET['action'] = "home";
    require "Views/home.php";
}


function toJson(){
    $file = dlFile();
    $parsedFile = getTrees($file);
    $lien = convertToJson($parsedFile);
    require "Views/result.php";
}


