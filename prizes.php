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

  ready=false;

    

        function main()
        {
          
//add possible sizes
          var left = document.getElementById('left').innerHTML;
          var sizes_a=[];
          if(left>=15000)
          {
            sizes_a.push("150x100");
            sizes_a.push("100x150");
          }
          if(left>=10000)
          {
            sizes_a.push("100x100");
          }
          if(left>=7000)
          {
            sizes_a.push("100x70");
            sizes_a.push("70x100");
          }
          if(left>=5000)
          {
            sizes_a.push("100x50");
            sizes_a.push("50x100");
            sizes_a.push("70x70");
          }
          if(left>=3500)
          {
            sizes_a.push("70x50");
            sizes_a.push("50x70");
          }
          if(left>=2500)
          {
            sizes_a.push("50x50");
          }
          if(left>=900)
          {
            sizes_a.push("30x30");
          }
          if(left>=400)
          {
            sizes_a.push("20x20");
          }

          //diable submit img button
          document.getElementById("subimg").disabled = true;
          document.getElementById("subimg").style.cursor = "not-allowed";
          var p = document.createElement("p");
         
          fetch('includes/sendimgdata.inc.php', {
                                      method: 'POST'
                                  }).then(function(response) {
                              response.json().then(function(data) {
                                //p.innerHTML+=JSON.stringify(data);
                              var l=data.length;
                             
                                var element = document.getElementById("frame");
                                var time=0;
                                  var timeline = setInterval(frame, 100); //showing images in their order from the data base, with slight delay between each
                                    function frame() 
                                    {
                                      if (time==l) {clearInterval(timeline);}
                                      else 
                                        {
                                          if(data[time].approved==1)
                                          {
                                            var t = document.createElement("img");
                                            t.src="images/"+data[time].fileName;
                                            var npos = data[time].pos.search("x");
                                            var top = data[time].pos.slice(0,npos);
                                            var left = data[time].pos.slice(npos+1);
                                            t.style.position="absolute";
                                            t.style.top= top+"px";
                                            t.style.left=left+"px";
                                            var nsizes = data[time].sizes.search("x");
                                            var width = data[time].sizes.slice(0,nsizes);
                                            var height = data[time].sizes.slice(nsizes+1);
                                            t.style.width= width+"px";
                                            t.style.height= height+"px";
                                            t.title = data[time].userNames+" - "+data[time].userFN;
                                            element.appendChild(t);
                                          }
                                            time++;
                                        }
                                    }
                              var i;
                              array=Array(100).fill().map(() => Array(100).fill(0));
                              
//illustrate already taken space
                              for (i = 0; i < l; i++) 
                                {
                                  
                                  var npos = data[i].pos.search("x");
                                  var top = data[i].pos.slice(0,npos);
                                  var left = data[i].pos.slice(npos+1);
                                  var nsizes = data[i].sizes.search("x");
                                  var width = data[i].sizes.slice(0,nsizes);
                                  var height = data[i].sizes.slice(nsizes+1);
                                  var t=top/10;
                                  var le=left/10;
                                  var w=le+(width/10);
                                  var h=t+height/10;
                                  var y;
                                  var x;
                                  for(y=t;y<h;y++)
                                    for(x=le;x<w;x++)
                                    {
                                      array[y][x]=1;
                                    }
                                  
                                  
                                }
                                ready=true;
                                

                        //add options to select size
                                  var sizes=document.getElementById("sizes");
                                  for(j=0;j<sizes_a.length;j++)
                                  {
                                    var option = document.createElement("option");
                                    option.text = sizes_a[j];
                                    option.value= sizes_a[j];
                                    sizes.add(option);
                                  }

                                  var element = document.getElementById("frame");
        

            

                      //create a selection square, to mark where the img will be on the frame
                                  var selection = document.createElement("div");
                                  selection.setAttribute("id", "selection");
                                  var nsizes = sizes.value.search("x");  
                                  var width = sizes.value.slice(0,nsizes);
                                  var height = sizes.value.slice(nsizes+1);
                                  selection.style.width= width+"px";
                                  selection.style.height= height+"px";
                                  selection.style.position="absolute";
                                  selection.style.top= 0+"px";
                                  selection.style.left=0+"px";
                                  selection.style.boxShadow="0px 0px 0px 3px #CEB3F2 inset";
                                  selection.style.transitionDuration = "0.25s";
                                  selection.style.display = "none";
                                  element.appendChild(selection);
                                  var atime=0;
                                  var attentiont = setInterval(attention, 250);
                                    function attention() 
                                    {
                                      if(atime%2==0)
                                        {
                                          selection.style.boxShadow="0px 0px 0px 4px #CEB3F2 inset";
                                        }
                                        else
                                        {
                                          selection.style.boxShadow="0px 0px 0px 3px #846AA6 inset";
                                        }
                                      atime++;
                                    }

                      //make changes to select value affect the selection size, and modify the pos options
                                  sizes.onchange =  function (event)
                                    {
                                      var str=event.target.value;
                                      var n = str.search("x");
                                      var width = str.slice(0, n);
                                      var height = str.slice(n+1);
                                      selection.style.width=width+ "px";
                                      selection.style.height=height+ "px";
                                      //remove prev position 
                                      var parent = document.getElementById("pos");
                                      pos.value="";
                                    
                                      selection.style.top= 0+"px";
                                      selection.style.left=0+"px";
                                    }  

                                    var pos=document.getElementById("pos");
                                    pos.onchange=function (event)
                                    {
                                      var str=event.target.value;
                                      
                                      if(/^[0-9]+x[0-9]+$/.test(str))
                                      {
                                      var sizes=document.getElementById("sizes").value;
                                      var n = str.search("x");
                                      var top = parseInt(str.slice(0, n)/10); 
                                      var left = parseInt(str.slice(n+1)/10);
                                      var str=event.target.value;
                                      n = sizes.search("x");
                                      var width = parseInt(sizes.slice(0, n)/10);
                                      var height = parseInt(sizes.slice(n+1)/10);
                                          if((top+height)<=100&&(left+width)<=100)
                                          {
                                            selection.style.top= top*10+"px";
                                            selection.style.left=left*10+"px";

                                            n=0;
                                            var x;
                                            var y;
                                            for(x=left;x<(left+width);x++)
                                              for(y=top;y<(top+height);y++)
                                              {
                                                n+=array[y][x];
                                              }
                                              if(n!=0)
                                              {
                                                window.alert("Вече има студент,заел или изявяващ желание за тези координати!");
                                                event.target.value="";
                                                imgformcheck();
                                              }
                                            
                                          }
                                          else
                                          {
                                            window.alert("С тези координати излизаш извън рамката!");
                                            event.target.value="";
                                            imgformcheck();
                                          }
                                      }
                                      else
                                      {
                                        window.alert("Моля, спази формата на полето Позиция!");
                                        event.target.value="";
                                        imgformcheck();
                                      }
                                    }

                                })
                            });
           
                         
            




//make sure that img submit button cannot be pressed unless all input fields are filled
              var file = document.getElementById("file"); 
              sizes.addEventListener("change", imgformcheck);
              pos.addEventListener("change", imgformcheck);
              file.addEventListener("change", imgformcheck);
              

        }
             
        function reg_show()
        {
          event.preventDefault();
          var element = document.getElementById("reg_form");
          element.style.display="block";
        }

        function imgformcheck() 
        {
          var selection = document.getElementById("selection");
          selection.style.display = "block";
          selection.style.zIndex ="10";

          var button=document.getElementById("subimg");

          var empty=0;

          var file = document.getElementById("file"); 
          if(file.files.length == 0 ){empty++;}

          var size = document.getElementById("sizes");
          if (size !== null && size.value === ""){empty++;}

          var pos = document.getElementById("pos");
          if (pos !== null && pos.value === ""){empty++;}
          console.log(empty);
          if(empty>0||ready==false)
          {
            
          button.disabled = true;
          button.style.cursor = "not-allowed";
          }
          else
          {
            button.disabled = false;
            button.style.cursor = "pointer";
          }
        }


          function attentionmsg() 
        {
          var elem = document.getElementById("message"); //взимаме елемента, който ще движим
          elem.style.display="block";
          var t=0;
          var it = setInterval(frame, 500);
          function frame() 
          {
            if (t >= 10) {clearInterval(it);} 
            else 
            {
              if(t%2==0) elem.style.borderColor="white";
              else elem.style.borderColor="#9B8CBD";
              t++;
            }
          }
        }
         
    </script>
</head>


<body onload="main()">
  <p id="available" title="За да получиш пиксели, се регистрирай,&#010; и изчакай администратора да те одобри за 'награда'.">Твоите пиксели:<br><b id="totalpxl"></b></p>
  <div id="separator1"></div>
  <div id="separator2"></div>
  <header>
    <h1>Награди</h1>
  </header>
  
  <div id="top_right">
    <form id="log_reg" action="includes/login.inc.php" method="post">
          <label>Потребителско име: <br><input type="text" name="user"   ></label> <br>
          <label>Парола:  <br>  <input type="password" name="pwd"   ></label> <br>            
          <button type="submit" id="log" name="login-submit">Вход</button>
          <button id="reg" onclick="reg_show()">Регистрация</button>
    </form >

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

  <div id="user_input">

      
    <p id="message">Съобщение:</p>
    <form id="reg_form" action="includes/signup.inc.php" method="post">
      <h1>Регистрация</h1>
      <label>Потребителско име: <br><input type="text" name="userreg"   ></label> <br>
      <label>Факултетен номер: <br><input type="text" name="fn"   ></label> <br>
      <label>Парола:  <br>  <input type="password" name="pwd1"   ></label> <br> 
      <label>Повтори паролата:  <br>  <input type="password" name="pwd2"   ></label> <br>             
      <button type="submit"name="signup-submit" onclick="subm()">Регистрирай ме</button>
    </form>
    <form id="img_form" action="includes/upload.inc.php" method="post" enctype="multipart/form-data">
      <h1>Добави <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;картина</h1>
      <p id="free">Имаш още <b id="left"></b> свободни пиксела.</p>
      <label title="Какви ще са размерите &#010; на изображението в рамката:&#010;Ширина х Височина">Размери:<br> <select id="sizes" name="sizes"></select> </label> <br> 
      <label title="На каква позиция е горния ляв ъгъл на изображението,&#010;спрямо горния ляв ъгъл на рамката:&#010;Надолу х Надясно  от ъгъла &#010;(от 0 до 1000)">Позиция:<br> <input type="text" id="pos" name="pos"></input> </label> <br>     
      <label>Избери изображение:<input type="file" name="file" id="file" accept=".jpg, .jpeg, .png" ></label><br> <br>
      <button type="submit"  name="submit" id="subimg" title="Всички полета трябва да са попълнени!">Добави</button>
    </form>
  </div>


  <div id="frame"></div> 

 <?php
  if(isset($_GET['upload']))
  {
    echo " <script type=\"text/javascript\">
    window.alert('Файлът е изпратен успешно! Моля, изчакай администраторът да одобри съдържанието му!');
    </script>
    ";
  }
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

            if($_SESSION['userName']!="Admin")
            {
                  echo "var tot = document.getElementById('totalpxl');
                      tot.innerHTML+='".$_SESSION['totalPxl']."';

                      var left = document.getElementById('left');
                      left.innerHTML+='".$_SESSION['pxlLeft']."';

                      var imgForm = document.getElementById('img_form');
                      imgForm.style.display='block';";
            }

    echo "</script>";
    if($_SESSION['userName']==="Admin")
    {echo "<form id='adminonly'action='prizes_admin.php' method='post'>
      <button id='admin' type='submit'>За одобрение</button>
      </form>";
    }
       
  }
  else
  {
    //show login form
   echo " <script type=\"text/javascript\">
          var element = document.getElementById('log_reg');
          element.style.display='block';
          </script>
        ";
  }
 ?>
  
    

                    <script>
                      function subm()
                      {
                        event.preventDefault();
                        var errors=0; //if  its 0 then the inputs are valid 
                        var e; //error for specific field
                        var msg = document.getElementById("message");
                        msg.innerHTML="Съобщение:<br>"
                        var us = document.getElementsByName("userreg")[0];
                        e=checkun(us.value,msg); 
                        errors+=e;
                        if(e>0)us.value ="";
                        var fn = document.getElementsByName("fn")[0];
                        e=checkfn(fn.value,msg); 
                        errors+=e;
                        if(e>0) fn.value ="";
                        var p = document.getElementsByName("pwd1")[0];
                        var p2 = document.getElementsByName("pwd2")[0];
                        e=checkpwd(p.value,msg);
                        errors+=e;
                        if(e>0)
                        {
                        p.value ="";
                        p2.value ="";
                        }
                        if(!p2.value || 0 === p2.value.length) {msg.innerHTML+="Моля, повтори паролата.<br>";  errors++;}
                        else
                        if(0 != p.value.length && p2.value.localeCompare(p.value)!=0) 
                        {
                          msg.innerHTML+="Двете пароли трябва да са еднакви.<br>";  
                          errors++;
                          p.value ="";
                          p2.value ="";
                        }
                        

                        if(errors==0)
                        {
                          let data = {
                              'user': us.value,
                              'fn': fn.value,
                              'pwd': p.value
                                      };

                          fetch('includes/signup.inc.php', {
                                      method: 'POST',
                                      body: JSON.stringify(data),
                                  }).then(function(response) {
                              response.text().then(function(text) {
                              msg.innerHTML+=text;
                              var n = text.search("успешно");
                              if(n!=-1)
                                {
                                  //hide login form
                                  var element = document.getElementById("reg_form");
                                  element.style.display="none";
                                }
                              });
                            });

                         
                        }
                        attentionmsg();
                        
                      }

                      function checkun(s,msg)//checks if a string is a valid username and returns 0 if true,and 1 or more, if not.It also adds to the message paragraph msg what whent wrong
                      {
                        var e=0;
                        if(!s || 0 === s.length) {msg.innerHTML+="Моля, попълни Потребителско име.<br>";  e++;}
                        else
                        {
                            if(s.length<3)
                            {  msg.innerHTML+="Потребителско име трабва да е с поне 3 символа.<br>";  e++;}
                            if(s.length>10)
                            {  msg.innerHTML+="Потребителско име трабва да с не повече от 10 символа.<br>";  e++;}

                            var n=0; //how many of the symbols are letters, numb or underscore
                            var i;
                            for(i=0;i<s.length;i++)
                            {
                              var c = s.charCodeAt(i);
                              if((c >= 48 && c < 58)||(c >= 65 && c < 91) || (c >= 97 && c < 123)||(c==95)) n++;
                            }
                            if(n!=s.length)
                            {msg.innerHTML+="Потребителско име може да съдържа само латински букви,цифри, или _ .<br>";  e++;}
                        }
                        return e;
                      }

                      function checkfn(s,msg)
                      {
                        var e=0;
                        if(!s || 0 === s.length) {msg.innerHTML+="Моля, попълни Факултетен номер.<br>";  e++;}
                        else
                        {
                          if(s.length<5||s.length>7) e++;
                            var n=0; //how many of the symbols are numbers
                            var i;
                            for(i=0;i<s.length;i++)
                            {
                              var c = s.charCodeAt(i);
                              if(c >= 48 && c < 58) n++;
                            }
                            if(n!=s.length)e++;
                            if(e>0) msg.innerHTML+="Невалиден факултетен номер.<br>";  
                        
                        }
                        return e;
                      }

                      function checkpwd(s,msg)//checks if a string is a valid password and returns 0 if true,and 1 or more, if not.It also adds to the message paragraph msg what whent wrong
                      {
                        var e=0;
                        if(!s || 0 === s.length) {msg.innerHTML+="Моля, попълни Парола.<br>";  e++;}
                        else
                        {
                          if(s.length<6)
                            {  msg.innerHTML+="Паролата трябва да има поне 6 символа.<br>";  e++;}
                          
                          var ulcount=0; //count upper letters
                          var llcount=0; //count lower letters
                          var ncount=0; //count numbers

                          for(i=0;i<s.length;i++)
                          {
                            var c = s.charCodeAt(i);
                            if(c >= 48 && c < 58) {ncount++;}
                            if(c >= 65 && c < 91) {ulcount++;}
                            if(c >= 97 && c < 123) {llcount++;}
                          }
                          
                          if(ncount==0||ulcount==0||llcount==0)
                          {  msg.innerHTML+="Паролата трябва да има поне по 1 от следните: малка,главна буква,цифра.<br>";  e++;}
                        }
                        return e;
                      }
                      
                    </script>


</body>
</html>