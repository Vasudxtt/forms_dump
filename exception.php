<?php

$nameErr = $emailErr = $ageErr = $genderErr = $favsubErr = $commentErr = "";
$name = $email = $age = $gender = $comment = $favsub = $comment = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);

    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

  if (empty($_POST["age"])) {
    $ageErr = "AGE is required";
  } else {
    $age = test_input($_POST["age"]);
    if (!preg_match("/^\d{2,}$/", $age)) {
      $ageErr = "AGE must be at least 2 digits";
    }
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }

  if (empty($_POST["subjects"])) {
    $favsubErr = "At least one subject is required";
  } else {
    $favsub = $_POST["subjects"];
  }


  if (empty($_POST["comment"])) {
    $commentErr = "fill the comment section";
  } else {
    $comment = test_input($_POST["comment"]);
  }


}

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>