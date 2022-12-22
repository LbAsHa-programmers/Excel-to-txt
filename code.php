<?php
session_start();
include('dbconfig.php');
if (isset($_POST['export_excel_btn'])) {

    $sql = "SELECT ID  FROM `EXCEL` where ID='1'";
    $query_run1 = mysqli_query($conn, $sql) or die("bad query");
    while ($row = $query_run1->fetch_object()) {
        $T = $row->ID;
    }
    $sql2 = "SELECT SUM(MONTT) as D FROM `EXCEL` WHERE DC ='D' AND `Code_enregistrement` NOT LIKE '%7%';";
    $query_run3 = mysqli_query($conn, $sql2) or die("bad query");
    while ($sumD = $query_run3->fetch_object()) {
        $D = $sumD->D;
    }

    $sql3 = "SELECT SUM(MONTT) as C FROM `EXCEL` WHERE DC ='C' AND `Code_enregistrement` NOT LIKE '%7%';";
    $query_run4 = mysqli_query($conn, $sql3) or die("bad query");
    while ($sumC = $query_run4->fetch_object()) {
        $C = $sumC->C;
    }
    $sql4 = "SELECT MONTT as M FROM `EXCEL` WHERE Code_enregistrement LIKE '%7%';";
    $query_run5 = mysqli_query($conn, $sql4) or die("bad query");
    while ($TT = $query_run5->fetch_object()) {
        $MT = $TT->M;
    }

    $q = $C - $D;


    if ($T == '1') {
        if (abs($MT) == abs($q)) {
            $query = "SELECT substring(Code_enregistrement,2,2),substring(Code_banque,1,5),substring(Code_interne,1,4), substring(Code_guichet,1,5), substring(Devise,1,3),substring(Indice_d_exaunération,1,1),substring(RIB,1,11),substring(CIB,1,2),date_format(Date_opération,'%d%m%y') as 'Date_operation' ,date_format(Date_de_valeur,'%d%m%y') as 'Date_devaleur',substring(Libellé,1,31),substring(Référence,1,11),substring(Montant,1,30),SENS FROM `EXCEL` ORDER BY substring(Code_enregistrement,1,2) ASC";
            $query_run = mysqli_query($conn, $query) or die("bad query");
            if ($query_run) {

                while ($row1 = $query_run->fetch_assoc()) {

                    $ff = str_pad($row1['substring(Code_enregistrement,2,2)'], 2, "0", STR_PAD_LEFT) . "" . str_pad($row1['substring(Code_banque,1,5)'], 5, "0", STR_PAD_LEFT) . "" . str_replace('0000', '    ', str_pad($row1['substring(Code_interne,1,4)'], 4, "0", STR_PAD_LEFT)) . "" . str_replace('00000', '     ', str_pad($row1['substring(Code_guichet,1,5)'], 5, "0", STR_PAD_LEFT)) . "" . str_pad($row1['substring(Devise,1,3)'], 3, " ", STR_PAD_RIGHT) . "" . str_pad($row1['substring(Indice_d_exaunération,1,1)'], 1, " ", STR_PAD_RIGHT) . " " . str_pad($row1['substring(RIB,1,11)'], 11, " ", STR_PAD_RIGHT) . "" . str_pad($row1['substring(CIB,1,2)'], 2, " ", STR_PAD_RIGHT) . "" . str_pad($row1['Date_operation'], 6, " ", STR_PAD_RIGHT) . "  " . str_replace('010170', '      ', str_pad($row1['Date_devaleur'], 6, " ", STR_PAD_RIGHT)) . "" . str_pad($row1['substring(Libellé,1,31)'], 31, " ", STR_PAD_RIGHT) . "" . str_pad($row1['substring(Référence,1,11)'], 11, " ", STR_PAD_RIGHT) . "" . $row1['substring(Montant,1,30)'] . "000402016" . str_pad($row1['SENS'], 7, " ", STR_PAD_RIGHT) . "\n";


                    header("Content-Type: text/plain");
                    header('Content-Disposition: attachement; filename="data.txt"');

                    print($ff);
                }
            }
        } else {
            $_SESSION['message'] = " Invalid Amount'($MT)' Upload The Correct file ";
            header('Location: index.php');
            $sql6 = "TRUNCATE TABLE `EXCEL`";
            $query_run6 = mysqli_query($conn, $sql6) or die("bad query");
            exit;
        }
    } else {
        $_SESSION['message'] = "No Data Imported";
        header('Location: index.php');
        exit;
    }
}
