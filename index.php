<?php
session_start();
error_reporting(0);
if ($_SESSION['Time']==1){
    $_SESSION['Time']==0;
}else if ($_SESSION['Time']>=2){
    
}else{$_SESSION['Time'] = 0;}
error_reporting(E_ALL & ~E_NOTICE);
?>
<html>
    <head>
        <title>CHATTY</title>
        <style>
            
            
            body{background-image: repeating-linear-gradient(orange, yellow, red)}
            
            .Frm{border:red dotted 2px;
            /*height: 80%;*/ width: 90%;
            margin: 40px auto;}
            
            form{
            /*border: black 2px solid;*/
            width: 80%; margin: 50px auto;}
            
            form input{width: 100%; /*height: 80px;*/
                margin: 5 0; text-align: center; 
                /*border:  blue 1px dashed;*/
                background:repeating-linear-gradient(yellow, yellow, orange, orange, orange, red)
            }
            form input:hover{
                background:repeating-linear-gradient(red, yellow, orange);
                box-shadow: 0px 0px 3px 3px;
            }
            
            
        </style>

    </head>
    <body>
        <div class="Frm">
        <form method="" action="Chat.php">
            <input name="Dname" type="text" placeholder="Display name" class='Inpt'>
            <input type="submit" value="GET Login" formmethod="GET" style='Width:49%'>
            <input type="submit" value="POST Login" formmethod="POST" style='Width:50%'>
        </form>
        </div>
        
    </body>
    
    <script>
        let Div = document.getElementsByTagName("input"); //Returns a list of Class names
//        console.log(Div);
        
        //console.log(Div.length);
        for (let i=0; i<document.getElementsByTagName("input").length; i++){
            //console.log(i);
//            console.log(document.getElementsByTagName("input")[i]);
            document.getElementsByTagName("input")[i].style.fontSize = 60;
//            console.log(`Input height:\n${document.getElementsByTagName("input")[i].clientHeight}`)
            //input height = font-size + 11 (px)
        }
        //Font-size affects input height
//        console.log(`Results:\n ${document.getElementsByTagName("form")[0].style.clientHeight}`)
        

    </script>
        
</html>