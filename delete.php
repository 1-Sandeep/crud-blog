<?php
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Type conversion

    $conn = mysqli_connect("localhost", "root", "", "assignment_blog");

    // Check connection
    if (!$conn) {
        header('Location: index.php?message=' . urlencode('Connection failed: ' . mysqli_connect_error()));
        exit;
    }

    // Prepare the delete query
    $query = "DELETE FROM posts WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        mysqli_close($conn);

        header('Location: index.php');
        exit;
    } else {
        header('Location: index.php?message=');
        exit;
    }

    mysqli_close($conn);
} else {
    header('Location: index.php?message=');
    exit;
}
