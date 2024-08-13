<?php

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $conn = mysqli_connect("localhost", "root", "", "assignment_blog");

    if (!$conn) {
        die("Failed to establish connection: " . mysqli_connect_error());
    }

    $query = "SELECT * FROM posts WHERE id=$id";
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
    mysqli_close($conn);
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

    <h1 class="wrapper"><?php echo $title ?></h1>
    <br>
    <p class="wrapper"><?php echo $date ?></p>
    <br>
    <p class="wrapper"><?php echo $content ?></p>

</body>

</html>