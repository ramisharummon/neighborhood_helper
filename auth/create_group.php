<?php
//session_start();
include('../db.php');

// Ensure only logged-in users can access this page
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch groups from the database
$stmt = $pdo->prepare("SELECT * FROM groups");
$stmt->execute();
$groups = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neighborhood Groups</title>
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">Neighborhood Helper</div>
        <a href="home.php">Home</a>
        <a href="help_portal.php">View Help</a>
        <a href="groups.php">Groups</a> <!-- Active link for Groups -->
        <a href="logout.php">Logout</a>
    </div>

    <!-- Groups List -->
    <div class="content">
        <h2>Available Neighborhood Groups</h2>
        <?php if ($groups): ?>
            <ul>
                <?php foreach ($groups as $group): ?>
                    <li><?php echo htmlspecialchars($group['name']); ?> - <?php echo htmlspecialchars($group['description']); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No groups available at the moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
