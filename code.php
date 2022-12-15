<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'school');
if (isset($_POST['export_excel_btn'])) {

    $sql = "SELECT ID  FROM `EXCEL` where ID='1'";
    $query_run1 = mysqli_query($con, $sql) or die("bad query");
    while ($row = $query_run1->fetch_object()) {
        $T = $row->ID;
    }
    if ($T == '1') {
        $query = "SELECT ID,substring(Code_enregistrement,2,2),substring(Code_banque,1,5),substring(Code_interne,1,4), substring(Code_guichet,1,5), substring(Devise,1,3),substring(Indice_d_exaunération,1,1),substring(RIB,1,11),substring(CIB,1,2),date_format(Date_opération,'%d%m%y') as 'Date_operation' ,date_format(Date_de_valeur,'%d%m%y') as 'Date_devaleur',substring(Libellé,1,31),substring(Référence,1,11),substring(Montant,1,30),SENS FROM `EXCEL` ORDER BY substring(Code_enregistrement,1,2) ASC";
        $query_run = mysqli_query($con, $query) or die("bad query");
        if ($query_run) {

            while ($row1 = $query_run->fetch_assoc()) {

                $ff = str_pad($row1['substring(Code_enregistrement,2,2)'], 2, " ", STR_PAD_RIGHT) . "" . str_pad($row1['substring(Code_banque,1,5)'], 5, " ", STR_PAD_RIGHT) . "" . str_pad($row1['substring(Code_interne,1,4)'], 4, " ", STR_PAD_RIGHT) . "" . str_pad($row1['substring(Code_guichet,1,5)'], 5, " ", STR_PAD_RIGHT) . "" . str_pad($row1['substring(Devise,1,3)'], 3, " ", STR_PAD_RIGHT) . "" . str_pad($row1['substring(Indice_d_exaunération,1,1)'], 1, " ", STR_PAD_RIGHT) . " " . str_pad($row1['substring(RIB,1,11)'], 11, " ", STR_PAD_RIGHT) . "" . str_pad($row1['substring(CIB,1,2)'], 2, " ", STR_PAD_RIGHT) . "" . str_pad($row1['Date_operation'], 6, " ", STR_PAD_RIGHT) . "  " . str_pad($row1['Date_devaleur'], 6, " ", STR_PAD_RIGHT) . "" . str_pad($row1['substring(Libellé,1,31)'], 31, " ", STR_PAD_RIGHT) . "" . str_pad($row1['substring(Référence,1,11)'], 11, " ", STR_PAD_RIGHT) . "" . $row1['substring(Montant,1,30)'] . "000402016" . str_pad($row1['SENS'], 7, " ", STR_PAD_RIGHT) . "\n";


                header("Content-Type: text/plain");
                header('Content-Disposition: attachement; filename="data.txt"');

                print($ff);
            }
        } else {
            $_SESSION['message'] = "Invalid ";
            header('Location: index.php');
            exit;
        }
    } else {
        $_SESSION['message'] = "Invalid File";
        header('Location: index.php');
        exit;
    }
}
