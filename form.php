<?php
include 'db.php';
include 'exception.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Form</title>
</head>

<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

    <div class="container">
      <h1>Fillout the form</h1>
      <p><span class="error">* required field</span></p>

      Name: <input type="text" name="name" value="" required>
      <span class="error">* <?php echo $nameErr; ?></span>
      <br><br>

      E-mail: <input type="text" name="email" value="" required>
      <span class="error">* <?php echo $emailErr; ?></span>
      <br><br>

      Age: <input type="number" name="age" value="" required>
      <span class="error">* <?php echo $ageErr; ?></span>
      <br><br>

      Gender:
      <input type="radio" name="gender" value="female">Female
      <input type="radio" name="gender" value="male">Male
      <input type="radio" name="gender" value="other">Other
      <span class="error">* <?php echo $genderErr; ?></span>
      <br><br>

      Favorite Subjects:
      <input type="checkbox" name="subjects" value="math">Math
      <input type="checkbox" name="subjects" value="science">Science
      <input type="checkbox" name="subjects" value="history">History
      <input type="checkbox" name="subjects" value="english">English
      <span class="error" required>* <?php echo $favsubErr; ?></span>
      </span>
      <br><br>

      Comment: <textarea name="comment" rows="5" cols="40" required></textarea>
      <br><br>

      <input type="submit" name="submit" value="Submit">
    </div>
  </form>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "info";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO info (fname,email,age,gender,favsubject,comment)
VALUES ('$name', '$email', '$age','$gender','$favsub','$comment')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

  <?php
  echo "<h2>Your Input:</h2>";
  echo $name;
  echo "<br>";
  echo $email;
  echo "<br>";
  echo $age;
  echo "<br>";
  echo $gender;
  echo "<br>";
  echo $favsub;
  echo "<br>";
  echo $comment;
  ?>
</body>

</html>