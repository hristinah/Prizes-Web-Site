<?php
//for registration
if (isset($_SERVER['HTTP_ORIGIN'])) 
{
    //header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Credentials: true');    
    header("Access-Control-Allow-Methods: GET, POST"); 

    require 'dbh.inc.php';

    $rawData = file_get_contents("php://input");
    $formData = json_decode($rawData, true);
    if (!isset($formData['user'], $formData['fn'],$formData['pwd'])) {
        echo " Не се регистрира успешно!Моля, опитай пак!";
        exit(); 
    }
    else
    {
        $username=$formData['user']; 
        $fn= $formData['fn']; 
        $password=$formData['pwd'];

//check if there is a user with the same username  in the data base
        $sqlus="SELECT userNames FROM users WHERE userNames=?";
        $stmt1= mysqli_stmt_init($conn);
          if(!mysqli_stmt_prepare($stmt1,$sqlus)) 
            {
                //fail
                echo "Има проблем с базата данни!Моля, опитай пак!";
                exit(); 
            }
            else
            {
                mysqli_stmt_bind_param($stmt1,"s",$username);
                mysqli_stmt_execute($stmt1);
                mysqli_stmt_store_result($stmt1);
                $resultCheck= mysqli_stmt_num_rows($stmt1);

                if($resultCheck>0)
                {
                    echo "Вече има потребител с това име!";
                    exit();
                }
            }
            
//check if there is a user with the same fn in the data base
        $sqlfn="SELECT userFN FROM users WHERE userFN=?";
        $stmt2= mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt2,$sqlfn)) 
          {
              //fail
              echo "Има проблем с базата данни!Моля, опитай пак!";
              exit(); 
          }
          else
          {
              mysqli_stmt_bind_param($stmt2,"s",$fn);
              mysqli_stmt_execute($stmt2);
              mysqli_stmt_store_result($stmt2);
              $resultCheck= mysqli_stmt_num_rows($stmt2);

              if($resultCheck>0)
              {
                  echo "Вече има потребител с този Факултетен номер!";
                  exit();
              }
          }
//if we are here, then everything should be fine, so we insert the user info in the table
        $sqlins="INSERT INTO users (userNames,userFN,pwdUsers) VALUE (?,?,?)"; 
        $stmtins= mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmtins,$sqlins)) 
            {
                //fail
                echo "Има проблем с базата данни!Моля, опитай пак!";
                exit(); 
            }
            else
            {
                $hashedPwd=password_hash($password,PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmtins,"sss",$username,$fn,$hashedPwd);
                mysqli_stmt_execute($stmtins);
                
                echo  "Потребител ".$username;
                echo " е регистрин успешно!";
                   
            }
     mysqli_stmt_close($stmt1);
     mysqli_stmt_close($stmt2); 
     mysqli_stmt_close($stmtins); 
     mysqli_close($conn) ;      
    exit(); 
    }
	


}

