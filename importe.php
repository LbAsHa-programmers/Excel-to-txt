<?php
session_start();
include('dbconfig.php');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

if (isset($_POST['save_excel_data'])) {
   $fileName = $_FILES['import_file']['name'];
   $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

   $allowed_ext = ['xls', 'csv', 'xlsx'];

   if (in_array($file_ext, $allowed_ext)) {
      $inputFileNamePath = $_FILES['import_file']['tmp_name'];
      $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
      $data = $spreadsheet->getActiveSheet()->toArray();

      $count = "0";
      foreach ($data as $row) {
         if ($count > 0) {
            $SUM = array_sum($row);
            $Code_enregistrement = $row['0'];
            $Code_banque = $row['1'];
            $Code_interne = $row['2'];
            $Code_guichet = $row['3'];
            $Devise = $row['4'];
            $Indice_d_exaunération = $row['5'];
            $RIB = $row['6'];
            $CIB = $row['7'];
            $Date_opération = $row['8'];
            $Date_de_valeur = $row['9'];
            $Libellé = $row['10'];
            $Référence = $row['11'];
            $montotal = str_replace(',', '.', $row['12']);
            $Montant = str_replace(',', '', $row['12']);
            $Montant2 = str_pad($Montant, 14, "0", STR_PAD_LEFT);
            $SENS = $row['13'];


            if (str_ends_with($Montant2, '0')) {
               if ($SENS == 'D') {
                  $Montant3 = substr_replace($Montant2, '}', 13);
               } else {
                  $Montant3 = substr_replace($Montant2, '{', 13);
               }
            }
            if (str_ends_with($Montant2, '1')) {
               if ($SENS == 'D') {
                  $Montant3 = substr_replace($Montant2, 'J', 13);
               } else {
                  $Montant3 = substr_replace($Montant2, 'A', 13);
               }
            }
            if (str_ends_with($Montant2, '2')) {
               if ($SENS == 'D') {
                  $Montant3 = substr_replace($Montant2, 'K', 13);
               } else {
                  $Montant3 = substr_replace($Montant2, 'B', 13);
               }
            }
            if (str_ends_with($Montant2, '3')) {
               if ($SENS == 'D') {
                  $Montant3 = substr_replace($Montant2, 'L', 13);
               } else {
                  $Montant3 = substr_replace($Montant2, 'C', 13);
               }
            }
            if (str_ends_with($Montant2, '4')) {
               if ($SENS == 'D') {
                  $Montant3 = substr_replace($Montant2, 'M', 13);
               } else {
                  $Montant3 = substr_replace($Montant2, 'D', 13);
               }
            }
            if (str_ends_with($Montant2, '5')) {
               if ($SENS == 'D') {
                  $Montant3 = substr_replace($Montant2, 'N', 13);
               } else {
                  $Montant3 = substr_replace($Montant2, 'E', 13);
               }
            }
            if (str_ends_with($Montant2, '6')) {
               if ($SENS == 'D') {
                  $Montant3 = substr_replace($Montant2, 'O', 13);
               } else {
                  $Montant3 = substr_replace($Montant2, 'F', 13);
               }
            }
            if (str_ends_with($Montant2, '7')) {
               if ($SENS == 'D') {
                  $Montant3 = substr_replace($Montant2, 'P', 13);
               } else {
                  $Montant3 = substr_replace($Montant2, 'G', 13);
               }
            }
            if (str_ends_with($Montant2, '8')) {
               if ($SENS == 'D') {
                  $Montant3 = substr_replace($Montant2, 'Q', 13);
               } else {
                  $Montant3 = substr_replace($Montant2, 'H', 13);
               }
            }
            if (str_ends_with($Montant2, '9')) {
               if ($SENS == 'D') {
                  $Montant3 = substr_replace($Montant2, 'R', 13);
               } else {
                  $Montant3 = substr_replace($Montant2, 'I', 13);
               }
            }
            $query1 = "SELECT COUNT(substring(Code_enregistrement,2,2)) as saze FROM `EXCEL` ";
            $query_run = mysqli_query($conn, $query1) or die("bad query");
            while ($row1 = $query_run->fetch_object()) {
               $T = $row1->saze;
            }
            for (
               $x = 1;
               $x <= $T;
               $x++
            ) {
               $W = str_pad($x, 7, "0", STR_PAD_LEFT);
            }

            $Query = "INSERT INTO EXCEL (Code_enregistrement,Code_banque,
                Code_interne,Code_guichet,Devise,
                Indice_d_exaunération,RIB,CIB,
                Date_opération,Date_de_valeur,
                Libellé,Référence,Montant,SENS,MONTT,DC)
                 VALUES ('$Code_enregistrement','$Code_banque',
                 '$Code_interne','$Code_guichet','$Devise',
                 '$Indice_d_exaunération','$RIB','$CIB',
                 '$Date_opération','$Date_de_valeur',
                 '$Libellé','$Référence','$Montant3',
                 '$W','$montotal','$SENS')";
            $result = mysqli_query($conn, $Query) or die("bad query");
            $sql = "UPDATE `excel` SET `SENS`= '' WHERE `Code_enregistrement` LIKE '%7'";
            $query_run = mysqli_query($conn, $sql) or die("bad query");



            $msg = true;
         } else {
            $count = "1";
         }
      }

      if (isset($msg)) {
         $_SESSION['message'] = "Successfully Imported";
         header('Location: index.php');
         exit;
      } else {
         $_SESSION['message'] = "Not Imported";
         header('Location: index.php');
         exit;
      }
   } else {
      $_SESSION['message'] = "No File selected";
      header('Location: index.php');
      exit;
   }
}
