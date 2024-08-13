<?php
$title = '';
$summary = '';
$content = '';
$date = '';
$id = 0;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // type conversion

    $conn = mysqli_connect("localhost", "root", "", "assignment_blog");

    if (!$conn) {
        die("Failed to establish connection: " . mysqli_connect_error());
    }

    // prepare the select query
    $query = "SELECT * FROM posts WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $post = mysqli_fetch_assoc($result);
        if ($post) {
            $title = $post['title'];
            $summary = $post['summary'];
            $content = $post['content'];
            $date = $post['date'];
        } else {
            echo '<script>alert("Post not found.")</script>';
            exit;
        }
    } else {
        echo '<script>alert("Failed to fetch post: ' . mysqli_error($conn) . '")</script>';
        exit;
    }

    // close the connection
    mysqli_close($conn);
}

if (isset($_POST['submit'])) {
    $newTitle = $_POST['title'];
    $newSummary = $_POST['summary'];
    $newContent = $_POST['content'];
    $newDate = $_POST['date'];

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
        // db connection
        $conn = mysqli_connect("localhost", "root", "", "assignment_blog");

        // check connection
        if (!$conn) {
            die("Failed to establish connection: " . mysqli_connect_error());
        }

        // sanitize input
        $newTitle = mysqli_real_escape_string($conn, $newTitle);
        $newSummary = mysqli_real_escape_string($conn, $newSummary);
        $newContent = mysqli_real_escape_string($conn, $newContent);
        $newDate = mysqli_real_escape_string($conn, $newDate);

        // prepare the update query
        $query = "UPDATE posts SET 
        title = IF('$newTitle' = '', title, '$newTitle'),
        summary = IF('$newSummary' = '', summary, '$newSummary'),
        content = IF('$newContent' = '', content, '$newContent'),
        date = IF('$newDate' = '', date, '$newDate')
        WHERE id = $id";

        if (mysqli_query($conn, $query)) {
            echo '<script>alert("Data has been updated.")</script>';
            echo '<script>window.location.href="index.php"</script>'; // Redirect to list page after update
        } else {
            echo '<script>alert("Failed to update data: ' . mysqli_error($conn) . '")</script>';
        }

        // close the connection
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
    <title>Edit Post</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    include 'partials/navbar.php';
    ?>


    <h1 class="wrapper">Edit Post</h1>

    <!-- form -->
    <div class="form wrapper">
        <form action="edit.php?id=<?php echo $id; ?>" method="post">
            <label for="title">Title <span> * </span> </label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" />

            <label for="summary">Summary <span> * </span> </label>
            <input type="text" id="summary" name="summary" value="<?php echo htmlspecialchars($summary); ?>" />

            <label for="content">Content <span> * </span> </label>
            <textarea name="content" id="content" rows="10"><?php echo htmlspecialchars($content); ?></textarea>

            <label for="date">Date <span> * </span> </label>
            <input type="date" name="date" id="date" value="<?php echo htmlspecialchars($date); ?>" />

            <div class="button">
                <a href="index.php" class="cancel">Cancel</a>
                <input type="submit" name="submit" class="submit" value="Update">
            </div>
        </form>
    </div>
    <!-- form -->
</body>

</html>