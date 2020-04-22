<?php


namespace master;

require_once 'FileErrorException.php';
require_once 'Applicant.php';
require_once 'Tree.php';

use master\FileErrorException;
use master\Applicant;
use master\Tree;

class File
{
    private array $file;
    private array $applicants;
    private string $uploadedFilePath;
    private string $fileTmpPath;
    private string $fileName;
    private string $fileSize;
    private string $fileType;
    private string $extension;

    public function __construct(array $file)
    {
        $this->file = $file;
        $this->fileTmpPath = $file['tmp_name'];
        $this->fileName = $file['name'];
        $this->fileSize = $file['size'];
        $this->fileType = $file['type'];
        $this->extension = substr($this->fileName, -3);
        $this->init();
    }

    private function init()
    {
        try {
            $this->isCsv($this->extension);
            $this->uploadFile();
            $this->getApplicants($this->uploadedFilePath);
            $this->getTrees($this->uploadedFilePath, $this->applicants);
        } catch (FileErrorException $e) {
            $_GET['error'] = $e->getMessage();
        }
    }

    private function isCsv(string $extension)
    {
        if ($extension != 'csv'){
            throw new FileErrorException('Erreur du format du fichier');
        }
    }


    private function uploadFile()
    {
        $uploadFileDir = 'Uploaded_file/';
        $dest_path = $uploadFileDir . basename($this->fileName);

        if(move_uploaded_file($this->fileTmpPath, $dest_path))
        {
            $this->uploadedFilePath = $dest_path;
        }
        else
        {
            throw new FileErrorException('Problème avec le téléchargement du fichier vers le serveur');
        }
    }

    public function getApplicants($filePath)
    {
        if (($handel = fopen($filePath, "r")) !== FALSE){
            fgetcsv($handel); //To skip first line.
            while (($data = fgetcsv($handel, 100000, ';')) !== FALSE)
            {
                $id = (int)$data[0];
                $civity = utf8_encode($data[1]);
                $firstname = utf8_encode($data[2]);
                $name = utf8_encode($data[3]);
                $society = utf8_encode($data[4]);
                $address = utf8_encode($data[5]);
                $city = utf8_encode($data[6]);
                $zipCode = utf8_encode($data[7]);
                $phone = utf8_encode($data[8]);
                $email = utf8_encode($data[9]);
                $constructPermit = utf8_encode($data[112]);
                $this->applicants[] = new Applicant($id, $civity, $firstname, $name, $society, $address, $city, $zipCode, $phone, $email, $constructPermit);
            }
            fclose($handel);
        }
        else
        {
            throw new FileErrorException('Problème avec le fichier depuis le serveur, veuillez contacter le support.');
        }
    }

    private function getTrees($filePath, array $applicants)
    {
        $trees = [];
        if (($handel = fopen($filePath, "r")) !== FALSE){
            fgetcsv($handel); //To skip first line.
            while (($data = fgetcsv($handel, 100000, ';')) !== FALSE)
            {
                foreach ($applicants as $k => $applicant){
                    if ($applicant->getId() == $data[0]){
                        $coordX = str_replace(',','.',$data[22]);
                        $coordY = str_replace(',','.',$data[23]);
                        $tree = new Tree((float)$coordX, (float)$coordY, $data[28]);
                        $trees = $tree->get_object_as_array();
                        $applicant->setTrees($trees);
                        if ($data[31] != ''){
                            $coordX = str_replace(',','.',$data[31]);
                            $coordY = str_replace(',','.',$data[32]);
                            $tree = new Tree((float)$coordX, (float)$coordY, $data[37]);
                            $trees = $tree->get_object_as_array();
                            $applicant->setTrees($trees);if ($data[40] != '')
                            if ($data[40] != ''){
                                $coordX = str_replace(',','.',$data[40]);
                                $coordY = str_replace(',','.',$data[41]);
                                $tree = new Tree((float)$coordX, (float)$coordY, $data[46]);
                                $trees = $tree->get_object_as_array();
                                $applicant->setTrees($trees);
                                if ($data[49] != ''){
                                    $coordX = str_replace(',','.',$data[49]);
                                    $coordY = str_replace(',','.',$data[50]);
                                    $tree = new Tree((float)$coordX, (float)$coordY, $data[55]);
                                    $trees = $tree->get_object_as_array();
                                    $applicant->setTrees($trees);
                                    if ($data[58] != ''){
                                        $coordX = str_replace(',','.',$data[58]);
                                        $coordY = str_replace(',','.',$data[59]);
                                        $tree = new Tree((float)$coordX, (float)$coordY, $data[64]);
                                        $trees = $tree->get_object_as_array();
                                        $applicant->setTrees($trees);
                                        if ($data[67] != ''){
                                            $coordX = str_replace(',','.',$data[67]);
                                            $coordY = str_replace(',','.',$data[68]);
                                            $tree = new Tree((float)$coordX, (float)$coordY, $data[73]);
                                            $trees = $tree->get_object_as_array();
                                            $applicant->setTrees($trees);
                                            if ($data[76] != ''){
                                                $coordX = str_replace(',','.',$data[76]);
                                                $coordY = str_replace(',','.',$data[78]);
                                                $tree = new Tree((float)$coordX, (float)$coordY, $data[82]);
                                                $trees = $tree->get_object_as_array();
                                                $applicant->setTrees($trees);
                                                if ($data[85] != ''){
                                                    $coordX = str_replace(',','.',$data[85]);
                                                    $coordY = str_replace(',','.',$data[86]);
                                                    $tree = new Tree((float)$coordX, (float)$coordY, $data[91]);
                                                    $trees = $tree->get_object_as_array();
                                                    $applicant->setTrees($trees);
                                                    if ($data[94] != ''){
                                                        $coordX = str_replace(',','.',$data[94]);
                                                        $coordY = str_replace(',','.',$data[95]);
                                                        $tree = new Tree((float)$coordX, (float)$coordY, $data[100]);
                                                        $trees = $tree->get_object_as_array();
                                                        $applicant->setTrees($trees);
                                                        if ($data[103] != ''){
                                                            $coordX = str_replace(',','.',$data[103]);
                                                            $coordY = str_replace(',','.',$data[104]);
                                                            $tree = new Tree((float)$coordX, (float)$coordY, $data[109]);
                                                            $trees = $tree->get_object_as_array();
                                                            $applicant->setTrees($trees);
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
                }
            }
            fclose($handel);
        }
        else
        {
            throw new FileErrorException('Problème avec le fichier depuis le serveur, veuillez contacter le support.');
        }
    }
}