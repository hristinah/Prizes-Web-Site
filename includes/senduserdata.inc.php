<?php
if (isset($_SERVER['HTTP_ORIGIN'])) 
{
    //header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');    
    header("Access-Control-Allow-Methods: GET, POST"); 
    require 'dbh.inc.php'; 
    $arr=array();
    $sql="SELECT userNames, userFN,totalPxl FROM users"; 
    $stmt= mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) 
      {
          //fail
          echo  $arr;
          exit(); 
      }
      else
      {
         
          mysqli_stmt_execute($stmt);
          $result= mysqli_stmt_get_result($stmt);
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                $arr=json_encode($rows);
                echo $arr;
                exit(); 
    }
}