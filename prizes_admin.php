<?php
 session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Награди</title>
    <link rel="icon" href="logo.jpg" type="image/jpg">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css?<?php echo time(); ?>">

    <script>
      function main()
      {
        approvebutton=document.getElementById("approveimg");
        approvebutton.disabled = true;
        approvebutton.style.cursor = "not-allowed";

        subpxlbutton=document.getElementById("subpxl");
        subpxlbutton.disabled = true;
        subpxlbutton.style.cursor = "not-allowed";

        //add unaproved images to imgfn
        fetch('includes/sendimgdata.inc.php', {
                                      method: 'POST'
                                  }).then(function(response) {
                              response.json().then(function(data) {
                              var l=data.length;
                              var imgfn=document.getElementById("imgfn");
                              
                              for (i = 0; i < l; i++) 
                                {
                                  if(data[i].approved==0)  
                                  {
                                    var option = document.createElement("option");
                                    option.text=data[i].userNames+" - "+data[i].userFN+" - "+data[i].fileName;
                                    
                                    option.value=data[i].fileName;
                                    imgfn.add(option);
                                  }
                               
                                }
                                var optionlen = imgfn.options.length;
                                if(optionlen>0)
                                  {
                                    imgfn.getElementsByTagName('option')[0].selected = 'selected';
                                    approvebutton.disabled = false;
                                    approvebutton.style.cursor = "pointer";
                                    
                                  }
                                  
                                imgfn.onmouseover=imgfn.onchange=function (event)
                                {
                                  var str=event.target.value;
                                  var img=document.getElementById("img");
                                  img.src="images/"+str;
                                }

                                imgfn.onmouseout=function (event)
                                {
                                  var str=event.currentTarget.value;
                                  var img=document.getElementById("img");
                                  img.src="images/"+str;
                                }
                              })
                            });

        //add users without pxls to studentfn and calculate how many pxls are left
        fetch('includes/senduserdata.inc.php', {
                                      method: 'POST'
                                  }).then(function(response) {
                              response.json().then(function(data) {
                              var n=1000000;
                              var l=data.length;
                              var studentfn=document.getElementById("student");
                              for (i = 0; i < l; i++) 
                                {
                                  if(data[i].totalPxl==0)  
                                  {
                                    var option = document.createElement("option");
                                    option.text=data[i].userNames+" - "+data[i].userFN;
                                    
                                    option.value=data[i].userNames;
                                    studentfn.add(option);
                                  }
                                  n-=data[i].totalPxl;
                               
                                }
                              var left = document.getElementById('left');
                              left.innerHTML+=n;



                              //add options to select pxlfn

                                  var sizes_a=[];
                                  if(n>=15000)
                                  {
                                    sizes_a.push(15000);
                                  }
                                  if(n>=10000)
                                  {
                                    sizes_a.push(10000);
                                  }
                                  if(n>=7000)
                                  {
                                    sizes_a.push(7000);
                                  }
                                  if(n>=5000)
                                  {
                                    sizes_a.push(5000);
                                  }
                                  if(n>=3500)
                                  {
                                    sizes_a.push(3500);
                                  }
                                  if(n>=2500)
                                  {
                                    sizes_a.push(2500);
                                  }
                                  if(n>=900)
                                  {
                                    sizes_a.push(900);
                                  }
                                  if(n>=400)
                                  {
                                    sizes_a.push(400);
                                  }

                                  var pxlfn=document.getElementById("pxlfn");
                                  for(j=0;j<sizes_a.length;j++)
                                  {
                                    var option = document.createElement("option");
                                    option.text = sizes_a[j]+"px";
                                    option.value= sizes_a[j];
                                    pxlfn.add(option);
                                  }

                                  if(pxlfn.value!="" && studentfn.value!="")
                                  {
                                    subpxlbutton.disabled = false;
                                    subpxlbutton.style.cursor = "pointer";
                                    
                                  }
                                  
                              
                              })
                            });



      }


      </script>
</head>


<body onload="main()">
  <div id="separator1"></div>
  
  <header>
    <h1>Награди</h1>
  </header>
  <div id="top_right">
    <section id="user_info">
      <p>Потребител:</p><br>
      <p id="user"></p><br>
      <p>ФН:</p>
      <p id="fn"></p><br>
      <form action="includes/logout.inc.php" method="post">
      <button id="log_out" type="submit">Отпиши ме</button>
      </form>
    </section>
  </div>


  <section id="admin_input">
      <h1 id="free" style="text-align:center; font-size:30px;">Имаш още <b id="left"></b> свободни пиксела.</h1>
      <form id="pxlgive" action="includes/updateuser.inc.php" method="post">
        <h2>Добави пиксели на:</h2>
        <label>Студенти:<br> <select id="student" name="student"></select> </label> <br> 
        <label>Пиксели:<br> <select id="pxlfn" name="pxlfn"></select> </label> <br> 
        <button type="submit"  name="subpxl" id="subpxl" >Добави</button>
      </form>

      <form id="imgapp" action="includes/updategallery.inc.php" method="post">
        <h2>Одобри картина:</h2>
        <label>ФН - Картина:<br> <select id="imgfn" name="imgfn" size="10"></select> </label> <br> 
        <button type="submit"  name="approveimg" id="approveimg" >Одобри</button>
      </form>

      <img id="img" >
  </section>

  

 <?php
  if(isset($_GET['error']))
  {
    echo " <script type=\"text/javascript\">
    window.alert('".$_GET['error']."');
    </script>
    ";
  }
  if(isset($_SESSION['userName'],$_SESSION['fn']))
  {
    //show user info and options for input
    echo " <script type=\"text/javascript\">
          var usInfo = document.getElementById('user_info');
          usInfo.style.display='block';
           
          var user = document.getElementById('user');
          user.innerHTML+='".$_SESSION['userName']."';

          var fn = document.getElementById('fn');
          fn.innerHTML+='".$_SESSION['fn']."';"; 

    echo "</script>";
    if($_SESSION['userName']==="Admin")
            {
              echo " <script type=\"text/javascript\">
              var adm = document.getElementById('admin_input');
              adm.style.display='block';
              </script>";
            }
                  
            
       
  }
  
 ?>
  
    

                    
</body>
</html>