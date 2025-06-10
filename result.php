<?php
include 'db.php';
include 'exception.php';
include 'form.php';

// Define variables and initialize with empty values
$name = $email = $age = $gender = $comment = "";
$subjects = [];
$nameErr = $emailErr = $ageErr = $genderErr = $favsubErr = "";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values safely
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $age = (int)$_POST["age"];
    $gender = $_POST["gender"];
    $comment = htmlspecialchars($_POST["comment"]);
    $subjects = $_POST["subjects"] ?? [];

    // Convert subjects array to comma-separated string
    $subjects_str = implode(", ", $subjects);

    // Prepare SQL Insert Query
    $sql = "INSERT INTO info (name, email, age, gender, subjects, comment)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisss", $name, $email, $age, $gender, $subjects_str, $comment);

    try {
        if ($stmt->execute()) {
            // Refresh the page (or redirect)
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
    }
}
?>