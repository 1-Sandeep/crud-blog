<?php

$table = "<table id='myTable'>
        <thead>
            <tr>
                <th>Title</th>
                <th>Summary</th>
                <th>Published Date</th>
                <th style='width:10%'>Actions</th>
            </tr>
        </thead>
    ";

$conn = mysqli_connect("localhost", "root", "", "assignment_blog");
if (!$conn) {
    die("Error in connecting");
}
$query = "SELECT * FROM posts";

$records = mysqli_query($conn, $query);

while ($record = mysqli_fetch_assoc($records)) {
    $table .= '<tr>';
    $table .= '<td>' . htmlspecialchars($record['title']) . '</td>';
    $table .= '<td>' . htmlspecialchars($record['summary']) . '</td>';
    $table .= '<td>' . htmlspecialchars($record['date']) . '</td>';
    $table .= '<td>
                <a href="edit.php?id=' . $record['id'] . '">Edit</a> | 
                <a href="delete.php?id=' . $record['id'] . '" onclick="return confirm(\'Are you sure you want to delete this post?\')">Delete</a>
              </td>';
    $table .= '</tr>';
}
$table .= '</table>';

mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simple Blog</title>
    <link rel="stylesheet" href="style.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />

</head>

<body>

    <?php
    include 'partials/navbar.php';
    ?>

    <h1 class="wrapper">Posts</h1>

    <!-- table with data -->
    <div class="wrapper">
        <?php echo $table; ?>
    </div>
    <!-- table with data -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src=" https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>


</body>


</html>