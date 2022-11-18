<?php
session_start();
 $con = mysqli_connect('localhost','root','','school');
// session_start();
// include('dbconfig.php');

if(isset($_POST['export_excel_btn']))
{
   
     $student = "SELECT * FROM students";
    $query_run = mysqli_query($con, $student);

    if($query_run)
    {
    
        while($row = $query_run ->fetch_assoc()){
            
            header("Content-Type: text/plain");
            header('Content-Disposition: attachement; filename="data.txt"');
           
          $ff = $row['id'] ." ". $row['fullname'] ." ". $row['email'] ." ". $row['phone'] ." ". $row['course'] ." " .  "\n";
        //    $a =fopen('data&.txt','w');
        //    $write=  fwrite($a,$ff);
        //    $final_filename = $fileName.'.txt';
        //     
        //  echo ($ff);
         printf ($ff) ;

        // $writer->save($final_filename);
        // header('Content-Disposition: attactment; filename="'.urlencode($final_filename).'"');
        // $writer->save('php://output');
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

