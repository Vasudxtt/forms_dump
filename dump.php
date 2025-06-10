<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> - Student Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Light gray background */
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 0.75rem; /* Rounded corners */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .error {
            color: #ef4444; /* Red color for errors */
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .summary-box {
            background-color: #f0fdf4; /* Light green background for summary */
            border: 1px solid #dcfce7; /* Green border */
            padding: 1.5rem;
            border-radius: 0.75rem;
            margin-top: 2rem;
        }
        .summary-box h3 {
            color: #10b981; /* Green color for summary heading */
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="p-4">

<?php
// PHP Constants
define("SITE_NAME", "Student Hub");

// Initialize variables to store form data and errors
$fullName = "";
$email = "";
$age = "";
$gender = "";
$favoriteSubjects = [];
$comments = "";
$errors = [];
$formSubmittedSuccessfully = false;

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validation Functions
function validateName($name) {
    if (empty($name)) {
        return "Full Name is required.";
    }
    return ""; // No error
}

function validateEmail($email) {
    if (empty($email)) {
        return "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }
    return ""; // No error
}

function validateAge($age) {
    if (empty($age)) {
        return "Age is required.";
    } elseif (!is_numeric($age)) {
        return "Age must be a number.";
    } elseif ($age < 10 || $age > 100) {
        return "Age must be between 10 and 100.";
    }
    return ""; // No error
}

function validateSubjects($subjects) {
    if (empty($subjects)) {
        return "Please select at least one favorite subject.";
    }
    return ""; // No error
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect input data
    $fullName = sanitizeInput($_POST["full_name"]);
    $email = sanitizeInput($_POST["email"]);
    $age = sanitizeInput($_POST["age"]);
    $gender = isset($_POST["gender"]) ? sanitizeInput($_POST["gender"]) : "";
    $comments = sanitizeInput($_POST["comments"]);
    $favoriteSubjects = isset($_POST["favorite_subjects"]) && is_array($_POST["favorite_subjects"]) ? $_POST["favorite_subjects"] : [];

    // Validate inputs
    $nameError = validateName($fullName);
    if (!empty($nameError)) {
        $errors["full_name"] = $nameError;
    }

    $emailError = validateEmail($email);
    if (!empty($emailError)) {
        $errors["email"] = $emailError;
    }

    $ageError = validateAge($age);
    if (!empty($ageError)) {
        $errors["age"] = $ageError;
    }

    // Gender is not mandatory, so no validation for empty
    // But it's good practice to ensure it's one of the expected values if present.

    $subjectsError = validateSubjects($favoriteSubjects);
    if (!empty($subjectsError)) {
        $errors["favorite_subjects"] = $subjectsError;
    }

    // If there are no errors, process the form
    if (empty($errors)) {
        $formSubmittedSuccessfully = true;
        // In a real application, you would save this data to a database
        // For this example, we just set the flag to display the summary.
    }
}
?>

<div class="container">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center"><?php echo SITE_NAME; ?> Registration</h1>

    <?php if (!$formSubmittedSuccessfully): // Display the form if not successfully submitted ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="full_name" class="block text-gray-700 text-sm font-semibold mb-2">Full Name:</label>
                <input type="text" id="full_name" name="full_name"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="<?php echo htmlspecialchars($fullName); ?>">
                <?php if (isset($errors["full_name"])): ?>
                    <p class="error"><?php echo $errors["full_name"]; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Email:</label>
                <input type="text" id="email" name="email"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="<?php echo htmlspecialchars($email); ?>">
                <?php if (isset($errors["email"])): ?>
                    <p class="error"><?php echo $errors["email"]; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="age" class="block text-gray-700 text-sm font-semibold mb-2">Age:</label>
                <input type="number" id="age" name="age"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="<?php echo htmlspecialchars($age); ?>">
                <?php if (isset($errors["age"])): ?>
                    <p class="error"><?php echo $errors["age"]; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Gender:</label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="Male"
                               class="form-radio text-blue-600 rounded-full"
                               <?php echo ($gender == "Male") ? "checked" : ""; ?>>
                        <span class="ml-2 text-gray-700">Male</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="Female"
                               class="form-radio text-blue-600 rounded-full"
                               <?php echo ($gender == "Female") ? "checked" : ""; ?>>
                        <span class="ml-2 text-gray-700">Female</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="Other"
                               class="form-radio text-blue-600 rounded-full"
                               <?php echo ($gender == "Other") ? "checked" : ""; ?>>
                        <span class="ml-2 text-gray-700">Other</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Favorite Subjects:</label>
                <div class="space-y-2">
                    <?php
                    $subjectsOptions = ["PHP", "JavaScript", "HTML", "CSS"];
                    foreach ($subjectsOptions as $subject) {
                        $checked = in_array($subject, $favoriteSubjects) ? "checked" : "";
                        echo '<label class="inline-flex items-center mr-4">';
                        echo '<input type="checkbox" name="favorite_subjects[]" value="' . htmlspecialchars($subject) . '" class="form-checkbox text-blue-600 rounded" ' . $checked . '>';
                        echo '<span class="ml-2 text-gray-700">' . htmlspecialchars($subject) . '</span>';
                        echo '</label>';
                    }
                    ?>
                </div>
                <?php if (isset($errors["favorite_subjects"])): ?>
                    <p class="error"><?php echo $errors["favorite_subjects"]; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="comments" class="block text-gray-700 text-sm font-semibold mb-2">Comments:</label>
                <textarea id="comments" name="comments" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($comments); ?></textarea>
            </div>

            <div class="text-center">
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75 transition duration-300">
                    Register
                </button>
            </div>
        </form>
    <?php endif; ?>

    <?php if ($formSubmittedSuccessfully): // Display summary if successfully submitted ?>
        <div class="summary-box">
            <h3 class="text-2xl font-bold mb-4">Registration Summary</h3>
            <p><strong class="font-medium text-gray-700">Full Name:</strong> <?php echo htmlspecialchars($fullName); ?></p>
            <p><strong class="font-medium text-gray-700">Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong class="font-medium text-gray-700">Age:</strong> <?php echo htmlspecialchars($age); ?></p>
            <p><strong class="font-medium text-gray-700">Gender:</strong> <?php echo empty($gender) ? 'N/A' : htmlspecialchars($gender); ?></p>
            <p><strong class="font-medium text-gray-700">Favorite Subjects:</strong>
                <?php
                if (!empty($favoriteSubjects)) {
                    echo implode(", ", array_map('htmlspecialchars', $favoriteSubjects));
                } else {
                    echo "None selected.";
                }
                ?>
            </p>
            <p><strong class="font-medium text-gray-700">Comments:</strong> <?php echo empty($comments) ? 'N/A' : nl2br(htmlspecialchars($comments)); ?></p>

            <p class="mt-4 text-sm text-gray-500">
                Data processed by <?php echo __FILE__; ?> on line <?php echo __LINE__; ?>.
                (This shows a PHP Magic Constant example!)
            </p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
