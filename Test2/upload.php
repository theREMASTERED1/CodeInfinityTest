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

        $id = $cont[0];
        $name = $cont[1];
        $surname = $cont[2];
        $ini = $cont[3];
        $age = $cont[4];
        $dob = $cont[5];


        //creates table
        $query = "CREATE TABLE $table ($id INT(255) PRIMARY KEY,$name VARCHAR(50),$surname VARCHAR(50),$ini VARCHAR(50),$age INT(50),$dob VARCHAR(50))";

        mysqli_query($sql, $query);
    } else {
        //inserts data into rows
        $query = "INSERT INTO $table($id,$name,$surname,$ini,$age,$dob) VALUES('$cont[0]','$cont[1]','$cont[2]','$cont[3]','$cont[4]','$cont[5]')";
        //submits insert
        mysqli_query($sql, $query);
    }
    $r++;
}
