<?php


namespace master;

require_once 'FileErrorException.php';
require_once 'Applicant.php';
require_once 'Tree.php';

use DateInterval;
use DateTime;
use Exception;


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

    /**
     * File constructor.
     * @param array $file -> Uploaded file by the user
     */
    public function __construct(array $file)
    {
        $this->file = $file;
        $this->fileTmpPath = $file['tmp_name'];
        $this->fileName = $file['name'];
        $this->fileSize = $file['size'];
        $this->fileType = $file['type'];
        $this->extension = substr($this->fileName, -3);
    }

    /**
     * @return string
     */
    public function getUploadedFilePath(): string
    {
        return $this->uploadedFilePath;
    }

    /**
     * @return false|string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @return array
     */
    public function getApplicants(): array
    {
        return $this->applicants;
    }

    /**
     * This will check if file is CSV
     * @param string $extension -> Extension of the file
     * @throws FileErrorException -> Error if file is other than .CSV
     */
    public function isCsv(string $extension)
    {
        if ($extension != 'csv'){
            throw new FileErrorException('Erreur du format du fichier');
        }
    }

    /**
     * it will upload the file to the server
     * @throws FileErrorException -> Erro if file didn't get uploaded
     */
    public function uploadFile()
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

    /**
     * It will etract applicants from file and create new instence of Applicant object
     * @param $filePath -> Path to file
     * @throws FileErrorException -> Error if file can't be read
     * @throws Exception
     */
    public function extractApplicants($filePath)
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
                $remarque = utf8_encode($data[113]);
                $date = new DateTime($data[114]);
                $this->applicants[] = new Applicant($id, $civity, $firstname, $name, $society, $address, $city, $zipCode, $phone, $email, $constructPermit, $remarque, $date);
            }
            fclose($handel);
        }
        else
        {
            throw new FileErrorException('Problème avec le fichier depuis le serveur, veuillez contacter le support.');
        }
    }

    /**
     * It will extract trees from the file and insert into Applicant object as Tree object
     * @param $filePath -> Path to file
     * @param array $applicants -> Array of Applicant object
     * @throws FileErrorException -> Error if file can't be opened
     */
    public function getTrees($filePath, array $applicants)
    {
        if (($handel = fopen($filePath, "r")) !== FALSE){
            fgetcsv($handel); //To skip first line.
            while (($data = fgetcsv($handel, 100000, ';')) !== FALSE)
            {
                foreach ($applicants as $k => $applicant){
                    if ($applicant->getId() == $data[0]){
                        for ($i = 22; $i <= 103; $i += 9){
                            if ($data[$i] != ''){
                                $coordX = str_replace(',','.',$data[$i]);
                                $coordY = str_replace(',','.',$data[$i+1]);
                                $name = $data[$i+2];
                                $type = $data[$i+6];
                                $tree = new Tree((float)$coordX, (float)$coordY, $name, $type);
                                $trees = $tree->get_object_as_array();
                                $applicant->setTrees($trees);
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

    /**
     * It will delete the file after we used it
     * @param $file -> Path to file
     */
    public function deleteFile($file): void
    {
        unlink($file);
    }


    /**
     * @param Applicant $applicant
     * @param int $key
     * @throws Exception
     */
    public function toXml(Applicant $applicant, int $key): void
    {
        $baseLink = "https://golux.lausanne.ch/public/genereate_png_position_arbres.php?npixwidth=300&npixheight=300&symbsize=8&strjson=";
        $strJson = '';
        $link = '';
        $xml = array();
        $json = array();
        $startDate = $applicant->getDate();
        $endDate = $applicant->getDate();
        $endDate->add(new DateInterval('P1M'));
        $xml = [
            "PersonneDeContact" => $applicant->getFirstname() . ' ' . $applicant->getName() ,
            "AdresseContact" => $applicant->getAddress() . ', ' . $applicant->getZipCode() . ' ' . $applicant->getCity(),
            "Telephone" => $applicant->getPhone(),
            "Remarques" => $applicant->getRemarque(),
            "AdressePropriete" => $applicant->getAddress(),
            "Proprietaire" => $applicant->getFirstname() . ' ' . $applicant->getName() ,
            "Observations" => $applicant->getRemarque(),
            "DateFin" => $endDate->format("d-m-Y"),
            "DateDuJour" => $startDate->format("d-m-Y")
        ];
        foreach ($applicant->getTrees() as $k => $tree)
        {
            $xml["NomArbre" . ($k+1)] = $tree['name'];
            $xml["MotifArbre" . ($k+1)] = $tree['type'];
            $json[] = [
                "type" => $tree["type"],
                "coordx" => $tree["coordx"],
                "coordy" => $tree["coordy"]
            ];
            $strJson .= json_encode($json) . ',';
            $strJson = str_replace('[', '', $strJson);
            $strJson = str_replace(']', '', $strJson);
        }
        $link = str_replace('&', '&amp;', $baseLink) . '[' . substr($strJson, 0, -1) . ']';

        // We decide which template to use according to the number of trees that are present in the data array
        //$docx = 'Files/Template_' . count($applicant->getTrees()) . '.docx';
        $docx = 'Files/Template.docx';
        // We creat the path to the new XML file
        $xmlFilePath = 'Files/Applicant_' . $key . '.xml';
        // Generating XML file with metadata

        $fh = fopen($xmlFilePath, 'w');

        //Preparing the XML string
        $xml_text = "";
        $xml_text .= '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL;
        $xml_text .= "<document xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\">".PHP_EOL;
        $xml_text .= "<docB64><![CDATA[" . $this->toB64($docx) . "]]></docB64>" . PHP_EOL;
        $xml_text .= '<metadatas>' . PHP_EOL;
        foreach ($xml as $key => $xmlDatum) {
            $xml_text .= "\t" . '<metadata name="' . $key . '">' . utf8_encode($xmlDatum) . '</metadata>' . PHP_EOL;
        }
        $xml_text .= "\t" . '<metadata name="LienImage">' . $link . '</metadata>' . PHP_EOL;
        $xml_text .= '</metadatas>' . PHP_EOL;
        $xml_text .= '</document>';

        // Writing into file
        fwrite($fh, $xml_text);
        fclose($fh);
    }

    /**
     * Will encode documents to Base64
     * @param string $pathToFile Path to the file we need
     * @return string Docx document encoded to Base64
     */
    private function toB64(string $pathToFile): string {
        $file = file_get_contents($pathToFile);
        return chunk_split(base64_encode($file));
    }


}