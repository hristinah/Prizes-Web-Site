<?php

session_start();

if(isset($_POST['approveimg'],$_SESSION['userName'])&&$_SESSION['userName']=="Admin")
{ 
    require 'dbh.inc.php';  
    $sql2= "UPDATE gallery SET approved=? WHERE fileName=?;";
    $stmt2= mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt2,$sql2)) 
            {
                //fail
                header("Location: ../prizes_admin.php?error=Грешка в SQL!");
                exit(); 
            }
            
            else
            {
                //update the data base
                $newval=1;
                    mysqli_stmt_bind_param($stmt2,"is",$newval,$_POST['imgfn']);
                    mysqli_stmt_execute($stmt2);
                    header("Location: ../prizes_admin.php?upload=success");
                
                
            }
            
            $stmt2->close();
            $conn->close();
}