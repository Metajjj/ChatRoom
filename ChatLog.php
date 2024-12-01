<?php
function Clean($Dirty){
    $bread;        
    $Dirty = htmlspecialchars(trim($Dirty));

    //CLEAN APOSTRAPHES/quotes
    for ($i=0; $i<strlen($Dirty); $i++){
    if (substr($Dirty,$i,1)=="'" || substr($Dirty,$i,1)=='"'){
        echo "Comma found <br>";
        $bread .= "\\";
    }
    $bread .= substr($Dirty,$i,1);
    }
    
return $bread; //Returns clean
}
?>

<?php
session_start();

$Collect = (json_decode(file_get_contents('php://input'), true));

echo"<div>User</div><div>Message</div><div>Date/Time sent</div>";

error_reporting(0);
//print("INSERT INTO `Convo` (`Text`,`User`) VALUES ('is offline!','${_SESSION['Un']}');");

if ($_GET['Status'] === 'Off' || $_POST['Status'] === 'Off'/* || $Collect['Status']==='Off'*/){
    mysqli_query(mysqli_connect("Localhost","root","WBDB","ChatRoom"),
                        "INSERT INTO `Convo` (`Text`,`User`) VALUES ('is OFFLINE!','${_SESSION['Un']}');");
    
    echo "POST SENT!";
    }
else{

    if ($_POST['Stat']==='true'){
        
        $Abc = Clean($_POST['Msg']);
        
        mysqli_query(mysqli_connect("Localhost","root","WBDB","ChatRoom"),
                        "INSERT INTO `Convo` (`Text`,`User`) VALUES ('${Abc}','${_SESSION['Un']}');");
    }
    
error_reporting(E_ALL & ~E_NOTICE);

$Res = mysqli_query(mysqli_connect("Localhost","root","WBDB","ChatRoom"),
                        "SELECT * FROM Convo;");
            while ($i = mysqli_fetch_row($Res)){ //Turns table/results into array $rows
                $rows[] = $i;
            }
            
            foreach ($rows as $i){
                $Cnt=0; //ID PERSON MSG TIME
                $Cnt++;
                echo "<div style='text-align: right;white-space:pre;'>${i[$Cnt++]} <strong>:</strong>  </div> <div>${i[$Cnt++]}</div> <div style='text-align: right;'>- ${i[$Cnt++]}</div>";
                
            }
}
?>

