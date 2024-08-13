<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$title = '';
$summary = '';
$content = '';
$date = '';

$errors = [];

if (isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $summary = trim($_POST['summary']);
    $content = trim($_POST['content']);
    $date = trim($_POST['date']);

    // Validate title
    if (!isset($_POST['title']) || empty($_POST['title'])) {
        $errors[] = "Title is required.";
    } elseif (strlen($title) > 255) {
        $errors[] = "Title should not exceed 255 characters.";
    }

    // Validate summary
    if (!isset($_POST['summary']) || empty($_POST['summary'])) {
        $errors[] = "Summary is required.";
    } elseif (strlen($summary) > 500) {
        $errors[] = "Summary should not exceed 500 characters.";
    }

    // Validate content
    if (!isset($_POST['content']) || empty($_POST['content'])) {
        $errors[] = "Content is required.";
    }

    // Validate date
    if (!isset($_POST['date']) || empty($_POST['date'])) {
        $errors[] = "Date is required.";
    } elseif (!DateTime::createFromFormat('Y-m-d', $date)) {
        $errors[] = "Invalid date format.";
    }

    if (empty($errors)) {
        // Database connection
        $conn = mysqli_connect("localhost", "root", "", "assignment_blog");

        // Check connection
        if (!$conn) {
            die("Failed to establish connection: " . mysqli_connect_error());
        }

        // Sanitize input
        $title = mysqli_real_escape_string($conn, $title);
        $summary = mysqli_real_escape_string($conn, $summary);
        $content = mysqli_real_escape_string($conn, $content);
        $date = mysqli_real_escape_string($conn, $date);

        // Insert query
        $query = "INSERT INTO posts (title, summary, content, date) VALUES ('$title', '$summary', '$content', '$date')";

        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Data Stored.")</script>';
        } else {
            echo '<script>alert("Failed to Store Data: ' . mysqli_error($conn) . '")</script>';
        }

        // Close the connection
        mysqli_close($conn);
    } else {
        // Concatenate errors into a single string
        $errorMessages = implode("\\n \\n", $errors);
        echo '<script>alert("' . $errorMessages . '")</script>';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simple Blog</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

    <?php
    include 'partials/navbar.php';
    ?>


    <h1 class="wrapper">Create</h1>

    <!-- form -->
    <div class="form wrapper">
        <form action="create.php" method="post">
            <label for="title">Title <span> * </span></label>
            <input type="text" id="title" name="title" value="" maxlength="255" />

            <label for="summary">Summary <span> * </span></label>
            <input type="text" id="summary" name="summary" value="" maxlength="255" />

            <label for="content">Content <span> * </span></label>
            <textarea name="content" id="content" rows="10"></textarea>

            <label for="date">Date <span> * </span></label>
            <input type="date" name="date" id="date" value="" />

            <div class="button">
                <a href="index.php" class="cancel">Cancel</a>
                <input type="submit" name="submit" class="submit" value="Submit">
            </div>
        </form>
    </div>
    <!-- form -->
</body>

</html>