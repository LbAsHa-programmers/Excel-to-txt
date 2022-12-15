<?php
session_start();
 $con = mysqli_connect('localhost','root','','school');
// session_start();
// include('dbconfig.php');

if(isset($_POST['export_excel_btn']))
{
   
     $student = "SELECT substring(Code_enregistrement,1,2),substring(Code_banque,1,5),substring(Code_interne,1,4), substring(Code_guichet,1,5), substring(Devise,1,3),substring(Indice_d_exaunération,1,1),substring(RIB,1,11),substring(CIB,1,2),Date_opération,Date_de_valeur,substring(Libellé,1,31),substring(Référence,1,11),substring(Montant,1,30)FROM `EXCEL` ORDER BY substring(Code_enregistrement,1,2) ASC";
    $query_run = mysqli_query($con, $student) or die ("bad query");

    if($query_run)
    {
    
        while($row = $query_run ->fetch_assoc()){
            
            header("Content-Type: text/plain");
            header('Content-Disposition: attachement; filename="data.txt"');
                
          $ff = $row['substring(Code_enregistrement,1,2)'] ." ". $row['substring(Code_banque,1,5)'] ." ". $row['substring(Code_interne,1,4)'] ." ". $row['substring(Code_guichet,1,5)'] ." ". $row['substring(Devise,1,3)']." ". $row['substring(Indice_d_exaunération,1,1)']." ". $row['substring(RIB,1,11)']." ". $row['substring(CIB,1,2)']." ". date("dmy",strtotime($row['Date_opération']))."  ". date("dmy",strtotime($row['Date_de_valeur']))."   ". $row['substring(Libellé,1,31)']." ". $row['substring(Référence,1,11)']." ". $row['substring(Montant,1,30)']." " .  "\n";
      
         printf ($ff) ;

             }
        

    }
    else
    {
        $_SESSION['message'] = "No Record Found";
        header('Location: index.php');
        exit(0);
    }

}
?>

