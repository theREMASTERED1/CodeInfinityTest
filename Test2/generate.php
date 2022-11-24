
<?php
//defines number of users to generate
$number = $_POST['number'];

require_once 'vendor/autoload.php';
$faker = Faker\Factory::create();
//defines headers
$headers = array("id", "Name", "Surname", "Intials", "Age", "DateOfBirth");

//defines names and surnames
$name = array(
  'Peter',
  'Glenn',
  'Kerri',
  'Shannon',
  'Wilfredo',
  'Marcella',
  'Edgar',
  'Milford',
  'Nanette',
  'Barney',
  'Herschel',
  'Kim Young',
  'Mitchel',
  'Cleo',
  'Katherine',
  'Lawanda',
  'Bernadine',
  'Jill',
  'Jeannie',
  'Teddy'
);


$surname = array(
  'Griffin',
  'Quagmire',
  'Cameron',
  'Thompson',
  'Leblanc',
  'Kennedy',
  'Burnett',
  'Small',
  'Bauer',
  'Owen',
  'Webb',
  'Knox',
  'Flynn',
  'Johnson',
  'Ayala',
  'Franco',
  'Luna',
  'Buckley',
  'Peterson'
);


$file = fopen('output.csv', 'w');

fputcsv($file, $headers);
$UserData = array();


$n = 0;

//creates users based on defined number
while ($n < $number) {
  $n++;
  //mixes arrays
  shuffle($name);
  shuffle($surname);
  ini_set('memory_limit', '-1');

  $id = $n;

  //randomizes data as much as possible without chance of direct duplicates or empty values
  $firstname = $name[array_rand($name)];
  if ($firstname === $name[array_rand($name)] or $firstname === null) {
    $firstname = $name[array_rand($name)];
  };

  $surname1 = $surname[array_rand($surname)];
  if ($surname1 === $surname[array_rand($surname)] or $surname1 === null) {
    $firstname = $surname[array_rand($surname)];
  };

  //creates random birthday as well as calculating age
  $birthDay = $faker->dateTimeBetween('1975-01-01', '2004-12-31');
  $birthDayF = $birthDay->format('d/m/Y');
  $birthDayY = $birthDay->format("Y");
  $currentY = date('Y');
  $age = $currentY - $birthDayY;



  //gets user initials
  $words = explode(" ", $firstname);
  $initials = null;
  foreach ($words as $word) {
    $initials .= $word[0];
  }
  //pushes data into array
  array_push($UserData, array("id" => $id, "name" => $firstname, "surname" => $surname1, "initials" => $initials, "age" => $age, "DateOfBirth" => $birthDayF));
}
//pushes data into the csv
foreach ($UserData as $fields) {
  fputcsv($file, $fields, ",");
}
fclose($file);

?>