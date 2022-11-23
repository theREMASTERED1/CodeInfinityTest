<?php
//connects to database
$sql = mysqli_connect("localhost", "simeon", "", "users");
set_time_limit(0);

//gets file entered by user
$fileName = $_FILES['csvfile']['name'];
print_r($_FILES['csvfile']['name']);
$r = 0;
$handle = fopen('output.csv', 'r');

//creates table and uploads data to database
while (($cont = fgetcsv($handle, 10000000, ',')) !== false) {

    $table = "csv_import";
    if ($r == 0) {

        $idS = $cont[0];
        $nameS = $cont[1];
        $surnameS = $cont[2];
        $iniS = $cont[3];
        $ageS = $cont[4];
        $dobS = $cont[5];


        //creates table
        $query = "CREATE TABLE $table ($idS INT(255) PRIMARY KEY,$nameS VARCHAR(50),$surnameS VARCHAR(50),$iniS VARCHAR(50),$ageS INT(50),$dobS VARCHAR(50))";

        mysqli_query($sql, $query);
    } else {
        //inserts data into rows
        $query = "INSERT INTO $table($idS,$nameS,$surnameS,$iniS,$ageS,$dobS) VALUES('$cont[0]','$cont[1]','$cont[2]','$cont[3]','$cont[4]','$cont[5]')";
        //submits insert
        mysqli_query($sql, $query);
    }
    $r++;
}
