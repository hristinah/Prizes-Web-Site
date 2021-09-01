<?php
//for loggin in

if(isset($_POST['login-submit']))
{
    require 'dbh.inc.php';
    $user=$_POST['user'];
    $password=$_POST['pwd'];

    $sql="SELECT * FROM users WHERE userNames=?";
    $stmt= mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)) 
      {
          //fail
          header("Location: ../prizes.php?error=Грешка в SQL!");
          exit(); 
      }
      else
      {
          mysqli_stmt_bind_param($stmt,"s",$user);
          mysqli_stmt_execute($stmt);
          $result= mysqli_stmt_get_result($stmt);

          if($row=mysqli_fetch_assoc($result))
          {
            $pwdCheck = password_verify($password,$row['pwdUsers']);
            if($pwdCheck==false)
                { 
                    header("Location: ../prizes.php?error=Грешна парола!");
                    exit();  
                }
                else if($pwdCheck==true)
                {
                 session_start();
                    $_SESSION['userId']=$row['idUsers'];
                    $_SESSION['userName']=$row['userNames'];
                    $_SESSION['fn']=$row['userFN'];
                    $_SESSION['totalPxl']=$row['totalPxl'];
                    $_SESSION['pxlLeft']=$row['pxlLeft'];

                    header("Location: ../prizes.php?login=success");
                    exit();
                }
          }
          else
          {
            //no such user
            header("Location: ../prizes.php?error=Няма такъв потребител!");
            exit();  
          }

         
      }
}
else
{
exit();
}