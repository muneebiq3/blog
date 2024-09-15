<?php
include 'db.php';

$query = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Posts</title>
    <style>
        /* Basic styling */
        body { font-family: Arial, sans-serif; }
        .post { margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
        img { max-width: 150px; max-height: 150px; margin-top: 10px; display: block; }
    </style>
</head>
<body>
    <h1>All Blog Posts</h1>
    <a href="create.php">Create New Post</a>
    <hr>
    <?php while($post = $result->fetch_assoc()): ?>
        <div class="post">
            <h2><?php echo $post['title']; ?></h2>
            <p><?php echo substr($post['content'], 0, 100) . '...'; ?></p>

            <!-- Display the image if it exists -->
            <?php if (!empty($post['image'])): ?>
                <img src="data:image/jpeg;base64,<?php echo base64_encode($post['image']); ?>" alt="Post Image">
            <?php endif; ?>

            <a href="edit.php?id=<?php echo $post['id']; ?>">Edit</a> | 
            <a href="delete.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </div>
    <?php endwhile; ?>
</body>
</html>
