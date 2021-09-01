<?php

session_start();

if(isset($_POST['subpxl'],$_SESSION['userName'])&&$_SESSION['userName']=="Admin")
{ 
    
    require 'dbh.inc.php';  
    $sql="SELECT * FROM users WHERE userNames=?;";
    $stmt= mysqli_stmt_init($conn);
    $sql2= "UPDATE users SET totalPxl=?,pxlLeft=? WHERE userNames=?;";
    $stmt2= mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)||!mysqli_stmt_prepare($stmt2,$sql2)) 
                                                                {
                                                                    //fail
                                                                    header("Location: ../prizes_admin.php?error=Грешка в SQL!");
                                                                    exit(); 
                                                                }
                                                                
                                                                else
                                                                {
                                                                    //update the data base
                                                                    mysqli_stmt_bind_param($stmt,"s",$_POST['student']);
                                                                    mysqli_stmt_execute($stmt);
                                                                    $result= mysqli_stmt_get_result($stmt);
                                                                    if($row=mysqli_fetch_assoc($result))
                                                                    {
                                                                        mysqli_stmt_bind_param($stmt2,"iis",$_POST['pxlfn'],$_POST['pxlfn'],$_POST['student']);
                                                                        mysqli_stmt_execute($stmt2);
                                                                        header("Location: ../prizes_admin.php?upload=success");
                                                                    }
                                                                   else
                                                                    {
                                                                        //no such user
                                                                        header("Location: ../prizes_admin.php?error=Няма такъв потребител!");
                                                                        exit();  
                                                                    }
                                                                    
                                                                }
                                                                $stmt->close();
                                                                $stmt2->close();
                                                                $conn->close();
}