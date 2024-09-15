<?php
include 'db.php';

// Get the blog ID from the URL
$id = $_GET['id'];

// Fetch the post details based on the ID
$query = "
    SELECT posts.*, users.name, users.email 
    FROM posts 
    LEFT JOIN users ON posts.user_id = users.id 
    WHERE posts.id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $post['title']; ?> - Blog</title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
        />
    </head>
    <body class="bg-dark text-white">
        <div class="container mt-5">
            <div class="card shadow-sm">
                <?php if (!empty($post['image'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($post['image']); ?>" class="card-img-top" alt="Post Image">
                <?php else: ?>
                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Placeholder Image">
                <?php endif; ?>

                <div class="card-body">
                    <h1 class="card-title"><?php echo $post['title']; ?></h1>
                    <p class="card-text"><?php echo nl2br($post['content']); ?></p>
                </div>
                
                <div class="card-footer text-muted d-flex justify-content-between">
                    <span class="small">By <?php echo htmlspecialchars($post['name']); ?></span>
                    <span class="small"><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                </div>
            </div>

            <a href="index.php" class="btn btn-secondary mt-4">Back to Blogs</a>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    </body>
</html>
