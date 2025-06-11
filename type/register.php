<?php
require_once "config.php";

$name = $email = $age = $gender = $comment = "";
$subjects = [];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Validation
  if (empty($_POST["name"])) {
    $errors[] = "Name is required.";
  } else {
    $name = htmlspecialchars($_POST["name"]);
  }

  if (empty($_POST["email"]) || !preg_match("/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/", $_POST["email"])) {
    $errors[] = "Valid email is required.";
  } else {
    $email = htmlspecialchars($_POST["email"]);
  }

  if (!is_numeric($_POST["age"]) || $_POST["age"] < 10 || $_POST["age"] > 100) {
    $errors[] = "Age must be between 10 and 100.";
  } else {
    $age = (int) $_POST["age"];
  }

  if (empty($_POST["gender"])) {
    $errors[] = "Gender is required.";
  } else {
    $gender = $_POST["gender"];
  }

  if (empty($_POST["subjects"])) {
    $errors[] = "Select at least one subject.";
  } else {
    $subjects = $_POST["subjects"];
  }

  $comment = htmlspecialchars($_POST["comment"]);

  // Insert if no errors
  if (empty($errors)) {
    $subject_str = implode(", ", $subjects);
    $stmt = $conn->prepare("INSERT INTO entries (fname, email, age, gender, favsubject, comment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $name, $email, $age, $gender, $subject_str, $comment);

    if ($stmt->execute()) {
      header("Location: success.php");
      exit();
    } else {
      $errors[] = "Something went wrong. Try again.";
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Student Registration</title>
</head>

<body>
  <h2>Student Registration Form</h2>

  <?php
  if (!empty($errors)) {
    echo "<ul style='color:red;'>";
    foreach ($errors as $err) {
      echo "<li>$err</li>";
    }
    echo "</ul>";
  }
  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Name: <input type="text" name="name" value="<?php echo $name; ?>"><br><br>
    Email: <input type="text" name="email" value="<?php echo $email; ?>"><br><br>
    Age: <input type="number" name="age" value="<?php echo $age; ?>"><br><br>
    Gender:
    <input type="radio" name="gender" value="Male" <?php if ($gender == "Male")
      echo "checked"; ?>> Male
    <input type="radio" name="gender" value="Female" <?php if ($gender == "Female")
      echo "checked"; ?>> Female<br><br>
    Subjects:<br>
    <input type="checkbox" name="subjects[]" value="PHP" <?php if (in_array("PHP", $subjects))
      echo "checked"; ?>>
    PHP<br>
    <input type="checkbox" name="subjects[]" value="JavaScript" <?php if (in_array("JavaScript", $subjects))
      echo "checked"; ?>> JavaScript<br>
    <input type="checkbox" name="subjects[]" value="HTML" <?php if (in_array("HTML", $subjects))
      echo "checked"; ?>>
    HTML<br>
    <input type="checkbox" name="subjects[]" value="CSS" <?php if (in_array("CSS", $subjects))
      echo "checked"; ?>>
    CSS<br><br>
    Comments:<br>
    <textarea name="comment"><?php echo $comment; ?></textarea><br><br>
    <input type="submit" value="Register">
  </form>
</body>

</html>