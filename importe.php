<?php
// session_start();
// include('dbconfig.php');

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

if(isset($_POST['save_excel_data']))
{
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls','csv','xlsx'];

    if(in_array($file_ext, $allowed_ext))
    {
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        $count = "0";
        foreach($data as $row)
        {
            if($count > 0)
            {
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
                $Montant = $row['12'];

                $studentQuery = "INSERT INTO students (fullname,email,phone,course) VALUES ('$Code_enregistrement','$Code_banque','$Code_interne','$Code_guichet','$Devise','$Indice_d_exaunération','$RIB','$CIB','$Date_opération','$Date_de_valeur','$Libellé','$Référence','$Montant')";
                $result = mysqli_query($conn, $studentQuery);
                $msg = true;
            }
            else
            {
                $count = "1";
            }
        }

        if(isset($msg))
        {
            $_SESSION['message'] = "Successfully Imported";
            header('Location: index.php');
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "Not Imported";
            header('Location: index.php');
            exit(0);
        }
    }
    else
    {
        $_SESSION['message'] = "Invalid File";
        header('Location: index.php');
        exit(0);
    }
}
?>
