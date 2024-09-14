<?php
include 'db.php';

$id = $_GET['id'];
$query = "SELECT * FROM posts WHERE id = $id";
$post = $conn->query($query)->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $content, $id);
        $stmt->execute();
        $stmt->close();
        header('Location: index.php');
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Post</h1>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo $post['title']; ?>"><br><br>
        <label>Content:</label><br>
        <textarea name="content"><?php echo $post['content']; ?></textarea><br><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
