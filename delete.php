<?php
header('Content-Type: application/json');

// Check the ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Type conversion

    // DB connection
    $conn = mysqli_connect("localhost", "root", "", "assignment_blog");

    // Check connection
    if (!$conn) {
        echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . mysqli_connect_error()]);
        exit;
    }

    // Prepare the delete query
    $query = "DELETE FROM posts WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Post has been deleted.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error deleting post: ' . mysqli_error($conn)]);
    }

    // Close connection
    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID not provided.']);
}
