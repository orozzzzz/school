<?php
require_once 'functions.php';
$query = "SELECT id,shorttitle,cor1,cor2,startdate,enddate FROM school WHERE cor1 IS NOT NULL AND cor2 IS NOT NULL AND active = 'true'";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
if($result){
    $answer =array();
    $i = 0;
    while ($row = mysqli_fetch_row($result)) {
        $answer[$i]["id"]=$row[0];
        $answer[$i]["name"]=$row[1];
        $answer[$i]["cor1"]=$row[2];
        $answer[$i]["cor2"]=$row[3];
        $answer[$i]["startdate"]=substr(date('d.m.Y',strtotime($row[4])),0,5);
        $answer[$i]["enddate"]=substr(date('d.m.Y',strtotime($row[5])),0,5);
        $i++;
    }
    echo json_encode($answer);
    mysqli_free_result($result);
}
mysqli_close($link);
?>
