<?php

session_start();

if(isset($_POST['submit'],$_SESSION['userName'],$_SESSION['fn']))
{    
    require 'dbh.inc.php';  
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
          mysqli_stmt_bind_param($stmt,"s",$_SESSION['userName']);
          mysqli_stmt_execute($stmt);
          $result= mysqli_stmt_get_result($stmt);

          if($row=mysqli_fetch_assoc($result))
          {
            if($row['userFN']!==$_SESSION['fn'])
                { 
                    header("Location: ../prizes.php?error=Няма такъв потребител!");
                    exit();  
                }
                else 
                {
                    //session is of a valid user
                            $file=$_FILES['file'];
                            $fileName=$file["name"];
                            $fileTempName=$file["tmp_name"];
                            $fileError=$file["error"];
                            $fileSize=$file["size"];
                            $sizes=$_POST['sizes'];
                            $pos=$_POST['pos'];

                            $fileExp=explode(".",$fileName);
                            $fileExt=strtolower(end($fileExp));

                            $allowed = array("jpg","jpeg","png");


                            if(!in_array($fileExt,$allowed))
                                {
                                    //not an allowed file type
                                    header("Location: ../prizes.php?error=Не могат да се качват файлове от този вид!");
                                    exit();
                                }
                                else
                                {
                                    if($fileError!==0)
                                    {
                                        //there are file errors
                                        header("Location: ../prizes.php?error=Има грешка във файла!");
                                        exit();
                                    }
                                    else
                                    {
                                        if($fileSize>20000000)
                                        {
                                            //file is too big
                                            header("Location: ../prizes.php?error=Файлът е прекалено голям!");
                                            exit();
                                        }
                                        else
                                        {
                                            //everything up till now is correct
                                            $imageFullName=uniqid("",true).".".$fileExt;
                                            $fileDestination="../images/".$imageFullName;

                                            if(empty($sizes)||empty($pos))
                                            {
                                                //empty sizes or position
                                                header("Location: ../prizes.php?error=Празни полета във формата!");
                                                exit();
                                            }
                                            else
                                            {
                                                //check if data matches required type
                                                $regex = '/^[0-9]+x[0-9]+$/';

                                                if (preg_match($regex, $sizes)&&preg_match($regex, $pos)) 
                                                {
                                                    //chek if user has enough pxls left
                                                    $pxlleft=$row['pxlLeft'];
                                                    $sizesExp=explode("x",$sizes);
                                                    $pxlleft-=$sizesExp[0]*$sizesExp[1];
                                                    if($pxlleft>=0)
                                                    {
                                                    //everything up till now is ok
                                                            $sql= "INSERT INTO gallery(userNames,userFN,fileName,sizes,pos) VALUES(?,?,?,?,?);";
                                                            $stmt= mysqli_stmt_init($conn);
                                                            $sql2= "UPDATE users SET pxlLeft=? WHERE userNames=?;";
                                                            $stmt2= mysqli_stmt_init($conn);
                                                                if(!mysqli_stmt_prepare($stmt,$sql)||!mysqli_stmt_prepare($stmt2,$sql2)) 
                                                                {
                                                                    //fail
                                                                    header("Location: ../prizes.php?error=Грешка в SQL!");
                                                                    exit(); 
                                                                }
                                                                
                                                                else
                                                                {
                                                                    //insert file info in database and file in folder
                                                                    mysqli_stmt_bind_param($stmt,"sssss",$_SESSION['userName'],$_SESSION['fn'],$imageFullName,$sizes,$pos);
                                                                    mysqli_stmt_execute($stmt);
                                                                    mysqli_stmt_bind_param($stmt2,"is",$pxlleft,$_SESSION['userName']);
                                                                    mysqli_stmt_execute($stmt2);

                                                                    move_uploaded_file($fileTempName, $fileDestination);
                                                                    header("Location: ../prizes.php?upload=success");
                                                                    $_SESSION['pxlLeft']=$pxlleft;
                                                                }
                                                                $stmt->close();
                                                                $stmt2->close();
                                                                $conn->close();
                                                    }    
                                                } 
                                                else 
                                                {
                                                    //wrong data type for sizes and pos
                                                    header("Location: ../prizes.php?error=Грешен тип данни във формата");
                                                    exit();  
                                                }
                                            }

                                        

                                            
                                        }
                                    }

                                }

                    

                                
                                
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
 //invalid access
 header("Location: ../prizes.php?error=Невалиден достъп!");
 exit();    
}