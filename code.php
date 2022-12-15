<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'school');
if (isset($_POST['export_excel_btn'])) {


    $query = "SELECT substring(Code_enregistrement,2,2),substring(Code_banque,1,5),substring(Code_interne,1,4), substring(Code_guichet,1,5), substring(Devise,1,3),substring(Indice_d_exaunération,1,1),substring(RIB,1,11),substring(CIB,1,2),date_format(Date_opération,'%d%m%y') as 'Date_operation' ,date_format(Date_de_valeur,'%d%m%y') as 'Date_devaleur',substring(Libellé,1,31),substring(Référence,1,11),substring(Montant,1,30),SENS FROM `EXCEL` ORDER BY substring(Code_enregistrement,1,2) ASC";
    $query_run = mysqli_query($con, $query) or die("bad query");

    if ($query_run) {

        while ($row = $query_run->fetch_assoc()) {

            $ff = str_pad($row['substring(Code_enregistrement,2,2)'], 2, " ", STR_PAD_RIGHT) . "" . str_pad($row['substring(Code_banque,1,5)'], 5, " ", STR_PAD_RIGHT) . "" . str_pad($row['substring(Code_interne,1,4)'], 4, " ", STR_PAD_RIGHT) . "" . str_pad($row['substring(Code_guichet,1,5)'], 5, " ", STR_PAD_RIGHT) . "" . str_pad($row['substring(Devise,1,3)'], 3, " ", STR_PAD_RIGHT) . "" . str_pad($row['substring(Indice_d_exaunération,1,1)'], 1, " ", STR_PAD_RIGHT) . " " . str_pad($row['substring(RIB,1,11)'], 11, " ", STR_PAD_RIGHT) . "" . str_pad($row['substring(CIB,1,2)'], 2, " ", STR_PAD_RIGHT) . "" . str_pad($row['Date_operation'], 6, " ", STR_PAD_RIGHT) . "  " . str_pad($row['Date_devaleur'], 6, " ", STR_PAD_RIGHT) . "" . str_pad($row['substring(Libellé,1,31)'], 31, " ", STR_PAD_RIGHT) . "" . str_pad($row['substring(Référence,1,11)'], 11, " ", STR_PAD_RIGHT) . "" . $row['substring(Montant,1,30)'] . "000402016" . str_pad($row['SENS'], 7, " ", STR_PAD_RIGHT)  . "\n";


            header("Content-Type: text/plain");
            header('Content-Disposition: attachement; filename="data.txt"');

            print($ff);
        }
    }
} else {
    $_SESSION['message'] = "Invalid File";
    header('Location: index.php');
    exit(0);
}
