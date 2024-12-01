<!DOCTYPE php>
<?php ;/* Admin U: -jTAB@e`96mOmh8msYQP
import random
a=""
for i in range(20):
    a+= chr(random.randint(32,126))
    
print(f"\n{a}\n{len(a)}")
*/?>
<?php
session_start();
$_SESSION['Time']++;
//echo "<hr>".$_SESSION['Time']."<hr>";

if($_SESSION['Time']>=2){
    echo"<script> window.close(); </script>";
}
?>

<?php ;/* echo"<pre>"; print_r($_GET);print_r($_POST);print_r($_SESSION); echo"</pre>"*/?>

<?php
    //print_r($_SERVER);
    if (isset($_POST["Dname"])){
        //echo "POST Dname exists!";
        $Dname = $_POST['Dname'];
    } elseif(isset($_GET['Dname'])) {
        //echo "GET Dname exists!";    
        $Dname = $_GET['Dname'];
    }

    $_SESSION['Un'] = $Dname;
?>

<?php
error_reporting(0);
    if ($Dname===''){
        echo"EMPTY<hr>";
        echo"NO";
        header("Location: index.php"); //Redirects if not post method
    }
error_reporting(E_ALL & ~E_NOTICE);
?>

<?php
    //Cookie set to avoid offline dups
    if (isset($_COOKIE['User']) && $_COOKIE['User']!=$_SESSION['Un']){
        mysqli_query(mysqli_connect("localhost",'root','WBDB','ChatRoom'),
        "INSERT INTO `Convo`(`Text`,`User`) VALUES ('is OFFLINE!','${_COOKIE['User']}');");
    }

    setcookie("User",$_SESSION['Un'],time()+ (3600*24*10),"/",)
?>

<?php 

    if ($Dname === '-jTAB@e`96mOmh8msYQP'){
        $Dname = 'ADMIN';
    }

    //Creates if doesnt exist
    mysqli_query(mysqli_connect("localhost",'root','WBDB','ChatRoom'),
        "CREATE TABLE `Convo`(
            `ID` INT AUTO_INCREMENT,
            `User` TEXT,
            `Text` TEXT,
            `UPDATE` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(`ID`)
        );" /*UPDATE only updates to current time/date when its row is changed*/
    );
    mysqli_query(mysqli_connect("localhost",'root','WBDB','ChatRoom'),
        "INSERT INTO `Convo`(`Text`,`User`) VALUES ('is ONLINE!','${Dname}');");

?>

<?php
//Clears redirect logs
mysqli_query(mysqli_connect("localhost",'root','WBDB','ChatRoom'),
        "DELETE FROM `convo` WHERE `User` IS NULL OR `User` = '';");
?>


<html>
    <head>
        <title>CHATTY</title>
        <style>
            *{color: aliceblue; font-family: sans-serif; overflow: hidden;}
            
            body{background-image: repeating-linear-gradient(darkblue, #4ae29b, purple);
            }
            
            .Frm{
                max-height: 50%; overflow-y:hidden;
                
                display: grid;
                grid-template: "Person" "Msg" "Time";
                
                grid-template-columns: minmax(10px,1fr) minmax(20px,3fr) minmax(10px,1fr); /*minmax(10px 20px 10px,1fr 3fr 1fr);*/
                grid-template-rows: 20px;
                
                grid-gap: 10px 0px;
                grid-auto-flow: row;
                
                background-color: rgba(0,0,0, 0.2);
                background-image: repeating-linear-gradient(purple, #4ae29b,#4ae29b, darkblue);
                background-blend-mode: darken;
                
            }
            
            .Frm, #Segs{
                width: 80%; margin: 0 auto; padding:2px;
            }
            
            .Frm::-webkit-scrollbar{
                width:1px;
            } 
            .Frm::-webkit-scrollbar-thumb{
                background-image:  linear-gradient(red, yellow, orange);
                height: 10px;
                border-radius: 1000px;
                
            
            }
            
            .Bird{
                background-color: rgba(237, 155, 43, 0.3);
                color:rgba(237, 155, 43, 0.2);
                font-weight:900;
                margin:5px;
                padding:2px;
                text-align:center;
                width:10%;
                margin:auto;
                
                position: absolute;
                /*bottom: 100px;*/
                
                left: 600px;
                
            }
            .Bird:hover{
                background-color:  rgba(237, 155, 43, 0.4);
                box-shadow: black 0px 0px 50px 1px;                    
            }
            
            button{background-image: linear-gradient(grey, black);
            }
            
            input{
                background-color: darkslateblue; color:darkorange;
                border:none;
            }
            input:active{
                border:none;
            }
            input:focus{
                border: none;
            }
            
            #Msg{
                width: 82%;
                box-shadow: none;
            }
            
            #Msg, #Send{
                font-size: 40px; height: 50px;
            }
            #Segs{margin: auto; background-color: black;}
            
        </style>

    </head>


    <body onload="Attempt()">
    
        <?php
        error_reporting(0);
        if ($_SESSION['Un'] === '-jTAB@e`96mOmh8msYQP'){
         echo'<button id=But style="width:120px;height:100px;background-color:black;color:orange" onclick="FetchTest()">DELETE</button>';
        } else{
                $a="";
                while (strlen($a) != 6){
                    $b = rand(32,126);
                    //$b = 90;
                    if ($b != 60){$a .= chr($b);}
                }
            echo '<button id=But style="width:120px;height:100px;background-color:black;color:orange">'.$a.'</button>';
        }
        error_reporting(E_ALL & ~E_NOTICE);
        if ($_SESSION['Un'] === '-jTAB@e`96mOmh8msYQP'){
            $_SESSION['Un'] = 'ADMIN';
        }
        ?>
        
        <div class=Frm onclick="Attempt()">

        </div>
        
        <div id='Segs'>
            <input id="Msg" placeholder="Msg">
            <button id="Send" value="Send" onclick="MsgSend()">Send</button>
        </div>
        
        <div class='Bird' onclick="Top()">
            Bottom Jump
        </div>
        
    </body>
    
    <script>
        let MsgSend = async()=>{
            try{
                let formData = new FormData();
                formData.append('Stat','true');
                formData.append('Msg',document.getElementById('Msg').value);
                document.getElementById('Msg').value = ""; //Resets whether true or false
                
                const response = await fetch(`Chatlog.php`, {
                    method: "POST",
                    body: formData
                });
            
                if (response.ok){
                    //console.log("Response is successful");
                    const text = await response.text();
                    //console.log(text);
                
                }
                else{ throw new Error("Request Failed"); }
            } catch(error){console.log(error);}
        }
            /*console.log(document.getElementById('Msg').value);
            document.getElementById('Msg').value="";*/
        
    </script>
    
     <script>
        //SQL grabber/always update
        /*
        document.addEventListener("mouseover", A=>{
            //console.log("mouse over TRUE");
            Attempt();
        });*/
                  
        
        const Attempt = async ()=>{ //Convert json to Text since its html/code
            //console.log("Fetching");
            
        try{
            const response = await fetch("ChatLog.php?");
            
            if (response.ok){
                //console.log("Response is successful");
                
                const textResponse = await response.text(); 
                
                //console.log(`${textResponse}`); //textResponce is entire html page code
                
                //console.log(document.getElementsByClassName("Frm")[0]);
                document.getElementsByClassName("Frm")[0].innerHTML = textResponse;
                
            }
            else{ throw new Error("Request Failed"); }
        } catch(error){console.log(error);}
            
        setInterval(Mo=>{Attempt()},10000);
            
        //Adding scrollbar etc
            ////Must be after the inner.html is replaced
               
        //Making max height based on body..
        /*console.log(document.getElementsByTagName("body")[0].clientHeight)
        console.log(document.getElementsByTagName("body")[0].scrollHeight)*/ //975
        document.getElementsByClassName("Frm")[0].style.maxHeight = (document.getElementsByTagName("body")[0].scrollHeight * 0.8); //80% body height
            ///// Actual result is few pixels more 
        
        //console.log(`${document.getElementsByTagName("body")[0].scrollHeight} | ${document.getElementsByClassName("Frm")[0].clientHeight} | ${document.getElementsByClassName("Frm")[0].style.maxHeight}`)
        
        /*console.log(document.getElementsByClassName("Frm")[0].scrollHeight); //Includes hidden items
        console.log(document.getElementsByClassName("Frm")[0].clientHeight);*/ //Only visible items
        if (document.getElementsByClassName("Frm")[0].scrollHeight > document.getElementsByClassName("Frm")[0].clientHeight){
            document.getElementsByClassName("Frm")[0].style.overflowY = "Scroll"; //Adds scrollbar if scrollable
            //document.getElementsByTagName("p")[1].style.color = "inherit";
        }
            
        }
    </script>
    
    
    <script>
        //scrollbar pos
            //console.log(document.getElementsByClassName("Frm")[0].scrollHeight, document.getElementsByClassName("Frm")[0].clientHeight);
         let Top =()=>{   
             //console.log(`${document.getElementsByClassName("Frm")[0].scrollHeight} | ${document.getElementsByClassName("Frm")[0].clientHeight}`);
            if (document.getElementsByClassName("Frm")[0].scrollHeight > document.getElementsByClassName("Frm")[0].clientHeight){
                document.getElementsByClassName("Frm")[0].scrollTop = document.getElementsByClassName("Frm")[0].scrollHeight;
            }
             
         }
                  
    </script>
    
    <script>
        //document.getElementsByClassName("Bird")[0].style.bottom = (document.getElementsByClassName("Bird")[0].getBoundingClientRect().top - document.getElementsByClassName("Frm")[0].getBoundingClientRect().top);
        
         setInterval(Mo=>{
             if (document.getElementsByClassName("Frm")[0].scrollHeight /*>*/!= (document.getElementsByClassName("Frm")[0].clientHeight + document.getElementsByClassName("Frm")[0].scrollTop)){
                 //console.log(`${document.getElementsByClassName("Frm")[0].scrollHeight - (document.getElementsByClassName("Frm")[0].clientHeight + document.getElementsByClassName("Frm")[0].scrollTop)} pixels away from bottom!`)
                 
                 //Jump positioning
        
                Reve(true);
               } else{Reve(false);}
         },5000); //every 5s check pos of scrollbar
        
        Reve =async (Mo)=>{
            
            //console.log(`${document.getElementsByClassName("Frm")[0].scrollHeight} | (${document.getElementsByClassName("Frm")[0].clientHeight} + ${document.getElementsByClassName("Frm")[0].scrollTop})`)
            
            document.getElementsByClassName("Bird")[0].style.left = (parseInt(getComputedStyle(document.querySelector("body"))["width"].slice(0,-2)) /2) - (parseInt(getComputedStyle(document.getElementsByClassName("Bird")[0])["width"].slice(0,-2)) /2 ); //Doesnt work
//            console.log(`Bird left = ${parseInt(getComputedStyle(document.querySelector("body"))["width"].slice(0,-2)) /2} - ${parseInt(getComputedStyle(document.getElementsByClassName("Bird")[0])["width"].slice(0,-2)) /2}`)
            
//            console.log(`Table: ${document.getElementsByClassName("Frm")[0].getBoundingClientRect().top}`)
//            console.log(`Bird Rect.top: ${document.getElementsByClassName("Bird")[0].getBoundingClientRect().top} - ${document.getElementsByClassName("Frm")[0].getBoundingClientRect().top}`)
            
            if (document.getElementsByClassName("Bird")[0].getBoundingClientRect().top != document.getElementsByClassName("Frm")[0].getBoundingClientRect().top){
                    document.getElementsByClassName("Bird")[0].style.top = document.getElementsByClassName("Frm")[0].getBoundingClientRect().top +5;
                }
            
            if (Mo){
//                console.log("Not at bottom");
                document.getElementsByClassName("Bird")[0].style.zIndex = 20;
                
            } else{
//                console.log("At bottom");
                
                document.getElementsByClassName("Bird")[0].style.zIndex = -20;
            }
        }  
        
                
            
    </script>

    
    <script>
        //console.log(`USER NAME: ${document.getElementById("Welcme").innerHTML}`) //double check user
        
        const Offl1ne = async ()=>{ //Convert json to Text since its html/code
            //console.log("Fetching");
            
        try{
            /*const response = await fetch(`ChatLog.php?`, {
                method: "POST",
                body: JSON.stringify({ //stringify POST values instead of adding to url like GET ?
                    Status: "Off"
                })
            });*/ //Works! Collection['Status']
            
            let formData = new FormData();
            formData.append('Status','Off');
            /*
            for (let i of Ab.entries()){
                console.log(`${i[0]} | ${i[1]}`) //Rips open the key-value pairs
                }
            */
            const response = await fetch(`Chatlog.php`, {
                method: "POST",
                body: formData
            });
            
            if (response.ok){
                //console.log("Response is successful");
                const text = await response.text();
                //console.log(text);
                
            }
            else{ throw new Error("Request Failed"); }
        } catch(error){console.log(error);}
            
            <?php header("Location: index.php");
            ?>
        }
        
        document.addEventListener("mouseout",Mo=>{
            //document.getElementById("Test").innerHTML = "MouseOut";
            
            //Offl1ne();
        });
        document.addEventListener("mouseover",Mo=>{
            //document.getElementById("Test").innerHTML = "MouseOver";
            
//            Attempt();
            
        });
        window.addEventListener("beforeunload", Mo => {
	        //document.getElementById("Test").innerHTML = "Closed page";
            
            Offl1ne();
        });
        //window.addEventListener("pagehide", Mo =(event)=> {Offl1ne();});
    </script>
    
     
    <script>
        //Fetchtest
        const FetchTest = async ()=>{

        try{
            const response = await fetch("Chat.php?Dname=-jTAB@e`96mOmh8msYQP&Del=DELETE");
            if (response.ok){
                const jsonResponse = await response.json();
                console.log(jsonResponse);
            }
            throw new Error("Request Failed");
        }
        catch(error){console.log(error);}

        window.location.reload(false); //cached
        }
     </script>
 
    
    <?php 
    if (isset($_GET['Del'])){
        echo "<hr> POST Del exists";
        if ($_GET['Del'] === 'DELETE'){
            echo "Delly deleetey<hr>";
            mysqli_query(mysqli_connect('localhost','root','WBDB','ChatRoom'),
                           "DELETE FROM `convo` WHERE TRUE;");
            mysqli_query(mysqli_connect('localhost','root','WBDB','ChatRoom'),
                           "ALTER TABLE `Convo` AUTO_INCREMENT = 0;"
                          );
            echo "<hr>Del is DELETE";
            
            unset($_POST['Del']);
        };
    };
    ?>
        
</html>