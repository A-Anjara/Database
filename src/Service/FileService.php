<?php


namespace App\Service;

// use App\Entity\Parrainage;
// use App\Entity\Portefeuille;
// use App\Entity\Sikla0;
// use App\Entity\Transaction;
// use App\Entity\TypeTransaction;
// use App\Entity\Utilisateur;
// use App\Repository\UtilisateurRepository;
// use DateTime;
// use DateTimeZone;
// use Doctrine\ORM\EntityManagerInterface;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLSXGen;

final class FileService
{
    public $COLUMN = [
        "id" => 0,
        "nom" => 1,
        "email" => 2,
        "code" => 3,
        "parent" => 4,
        "adresse" => 5,
        "telephone" => 6,
        "fokontany" => 7,
        "activite" => 8,
        "nif" => 9,
        "personne" => 10,
        "payer" => 11,
        "montant" => 12
    ];

    public function parseExcel(string $path)
    {



        try {
            $rows = SimpleXLSX::parse($path);
            $rows = $rows->rows();
            foreach ($rows as &$row) {
                foreach ($row as &$cell) { /// NOT AN ERROR 
                    if ($cell === '') {
                        $cell = null;
                    }
                }
            }


            // PHP SPREADSHEET
            // $spreadsheet = IOFactory::load($path);
            // $worksheet = $spreadsheet->getActiveSheet();
            // $result = $worksheet->toArray();
            array_shift($rows);


            return $rows;
        } catch (Exception $e) {
            throw new Exception("Fichier Excel invalide !");
        }
    }






    public function exportUserData(array $datas)
    {

        // SIMPLE XLSX
        
        $xlsx = SimpleXLSXGen::fromArray([array_keys($datas[0]),...$datas]);
        return $xlsx;
        

        /// PHP spreadsheet

        // $spreadsheet = new Spreadsheet();
        // $sheet = $spreadsheet->getActiveSheet();
        // sleep(1);

        // // Header Texts
        // $headers = array_keys($datas[0] ?? []);
        // $columnindex = 1;
        // foreach ($headers as $key => $value) {
        //     $sheet->setCellValue([$key + 1, 1], $value);
        // }

        // // Populating the excel file
        // foreach ($datas as $row => $data) {
        //     foreach ($data as $column) {
        //         $sheet->setCellValue([$columnindex++, $row + 2], $column);
        //     }
        //     $columnindex = 1;
        // }

        // return $spreadsheet;
    }
}
