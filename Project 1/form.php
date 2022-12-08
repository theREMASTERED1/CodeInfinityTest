<html>

<head>
  <!-- <link rel="stylesheet"  type="text/css"   href="style.css.php"> -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">

  <title>PHP Test</title>

</head>

<body>
  <div>


    <form action="form.php" method="post">
      <div>
        <label for="text">Name:</label>
        <input required type="text" id="name" pattern="[A-Za-z]+" name="name" title="No numbers/special characters are alowed" value="<?php if (isset($_POST['name'])) {
                                                                                                                                        echo htmlentities($_POST['name']);
                                                                                                                                      } ?>" />
        <br /> <br />


        <label for="text">Surname:</label>
        <input required type="text" id="surname" name="surname" pattern="[A-Za-z]+" title="No numbers/special characters are alowed" value="<?php if (isset($_POST['surname'])) {
                                                                                                                                              echo htmlentities($_POST['surname']);
                                                                                                                                            } ?>" />
        <br /><br />

        <label for="number">ID number:</label>
        <input required type="number" id="id" placeholder="should be 13 numbers" name="id" />
        <br /><br />

        <label for="Date">Date of birth:</label>
        <input required type="date" placeholder="dd/mm/yyyy" id="birth" name="birth" value="<?php if (isset($_POST['birth'])) {
                                                                                              echo htmlentities($_POST['birth']);
                                                                                            } ?>" />
        <!-- is to return previous value when data is incorrect -->
        <br /><br />


      </div>
      <br />
      <button type="submit">Submit</button>
      <input type="reset" name="Cancel" value="cancel" />
    </form>
  </div>


  <?php

  if ($_POST) {
    //makes connection to mongoDB
    require "vendor/autoload.php";
    $client = new MongoDB\Client("mongodb://localhost:27017"); //connects to the localhost database,can be changed to online database
    $db = $client->selectDatabase("UserExports");
    $collection = $db->UserResults;

    //stores the input values
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $id = $_POST['id'];
    $birth = $_POST['birth'];


    $orgDate = $birth;
    $newBirth = date("d-m-Y", strtotime($orgDate));

    //stores the input into a array
    $UserData = [
      'name' => $name,
      'surname' => $surname,
      'id_number' => $id,
      'birthDay' => $newBirth
    ];

    //finds the corrospoding data from my database
    $UserRes = $collection->findOne(
      ['id_number' => $id]
    );

    if (strlen($_POST['id']) !== 13) {
      echo "The ID field is incorrect,please make sure it is the correct length";
    } else {
      // Length does not match


      //if no existing data can be retrieved.Its given a placeholder based on whats being checked
      if ($UserRes === null) {
        $UserRes = [
          'id_number' => '0',
        ];
      }

      //checks if database data is the same as user input
      if ($UserRes['id_number'] === $id) {

        //lets the user know they are already on the system
        echo ("Hi please login instead");
        http_response_code(401);
      } else {


        //saves the user to the database
        if ($collection->insertOne($UserData)) {

          echo "<h1>user uploaded</h1>";
        } else {
          echo "some Issue occured with the connection";
          http_response_code(401);
        }
      }
    }
  }
  ?>

</body>

</html>