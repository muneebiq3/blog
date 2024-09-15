<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image'];

    // Set the maximum file size (5MB)
    $maxFileSize = 5 * 1024 * 1024; // 5MB

    // Check if all fields are filled and image is uploaded
    if (!empty($title) && !empty($content) && !empty($image['name'])) {
        if ($image['size'] > $maxFileSize) {

            $error = "File size must be less than 5MB.";
            
        } else {
            
            // Read the image file content and escape it for insertion
            $imageData = file_get_contents($image['tmp_name']);

            // Prepare the SQL query
            $stmt = $conn->prepare("INSERT INTO posts (title, content, image) VALUES (?, ?, ?)");
            $stmt->bind_param("ssb", $title, $content, $imageData);
            $stmt->send_long_data(2, $imageData); // For large binary data
            $stmt->execute();
            $stmt->close();

            // Redirect after successful insert
            header('Location: index.php');
        }
    } else {
        $error = "All fields are required, and an image must be uploaded.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
</head>
<body>
    <h1>Create a New Post</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Title:</label><br>
        <input type="text" name="title"><br><br>

        <label>Content:</label><br>
        <textarea name="content"></textarea><br><br>

        <label>Upload Image (max 5MB):</label><br>
        <input type="file" name="image" accept="image/*"><br><br>

        <button type="submit">Create</button>
    </form>
</body>
</html>
