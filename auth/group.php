<?php
session_start();

// Database Connection
$host = 'localhost';
$dbname = 'neighborhoodhelper';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Hardcoded user ID (replace with actual authentication)
    $currentUserId = 1;

    // Handle Group Creation
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_group'])) {
        $groupName = trim($_POST['group_name']);
        $description = trim($_POST['description']);
        $location = trim($_POST['location']);

        $stmt = $pdo->prepare("
            INSERT INTO `group` (GroupName, Description, Location, CreatedBy) 
            VALUES (:groupName, :description, :location, :createdBy)
        ");
        $stmt->execute([
            ':groupName' => $groupName,
            ':description' => $description,
            ':location' => $location,
            ':createdBy' => $currentUserId
        ]);

        // Automatically add creator as first group member
        $groupId = $pdo->lastInsertId();
        $memberStmt = $pdo->prepare("
            INSERT INTO groupmember (GroupID, UserID) 
            VALUES (:groupId, :userId)
        ");
        $memberStmt->execute([
            ':groupId' => $groupId,
            ':userId' => $currentUserId
        ]);

        $successMessage = "Group created successfully!";
    }

    // Handle Group Joining
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['join_group'])) {
        $groupId = intval($_POST['group_id']);

        // Check if user is already a member
        $checkStmt = $pdo->prepare("
            SELECT COUNT(*) FROM groupmember 
            WHERE GroupID = :groupId AND UserID = :userId
        ");
        $checkStmt->execute([
            ':groupId' => $groupId,
            ':userId' => $currentUserId
        ]);

        if ($checkStmt->fetchColumn() == 0) {
            $joinStmt = $pdo->prepare("
                INSERT INTO groupmember (GroupID, UserID) 
                VALUES (:groupId, :userId)
            ");
            $joinStmt->execute([
                ':groupId' => $groupId,
                ':userId' => $currentUserId
            ]);
            $successMessage = "Successfully joined the group!";
        } else {
            $errorMessage = "You are already a member of this group.";
        }
    }

    // Handle Search
    $searchQuery = '';
    if (isset($_GET['search'])) {
        $searchQuery = trim($_GET['search']);
    }

    // Fetch groups with optional search filter
    $groupsStmt = $pdo->prepare("
        SELECT g.*, COUNT(gm.UserID) as MemberCount 
        FROM `group` g
        LEFT JOIN groupmember gm ON g.GroupID = gm.GroupID
        WHERE g.GroupName LIKE :searchQuery
        GROUP BY g.GroupID
        ORDER BY MemberCount DESC
    ");
    $groupsStmt->execute([
        ':searchQuery' => '%' . $searchQuery . '%'
    ]);
    $groups = $groupsStmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Groups - Neighborhood Helper</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Navbar Styling */
        .navbar {
            background-color: #7297cf; /* Blue background */
            display: flex;
            align-items: center;
            padding: 10px 20px;
        }

        .navbar .logo {
            color: white;
            font-size: 1.5em;
            font-weight: bold;
            margin-right: auto;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .navbar a:hover {
            background-color: #5a78a4; /* Slightly darker blue on hover */
        }

        .navbar .search-bar {
            display: flex;
            align-items: center;
            margin-left: auto;
            margin-right: 10px;
        }

        .navbar input[type="text"] {
            padding: 5px;
            border: none;
            border-radius: 5px;
            outline: none;
        }

        .navbar button {
            background-color: white;
            color: #5D3A9B;
            border: none;
            padding: 6px 12px;
            margin-left: 5px;
            border-radius: 5px;
            cursor: pointer;
        }

        .navbar button:hover {
            background-color: #E3E3E3;
        }

        .navbar .login {
            background-color: #7297cf;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            margin-left: 10px;
        }

        .navbar .login:hover {
            background-color: #5a78a4;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="logo">Neighborhood Helper</div>
        <a href="home.php">Home</a> 
        <a href="help_portal.php">View Help</a> 
        <a href="">Review</a>
        <a href="groups.php">Groups</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
        
        <!-- Search Form -->
        <form method="GET" action="groups.php" class="search-bar">
            <input 
                type="text" 
                name="search" 
                value="<?php echo htmlspecialchars($searchQuery); ?>" 
                placeholder="Search Groups" 
            />
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Group Creation Form -->
            <div>
                <h2 class="text-2xl font-bold mb-4">Create a New Group</h2>
                <?php if(isset($successMessage)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($successMessage); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Group Name</label>
                        <input required type="text" name="group_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" rows="4"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                        <input type="text" name="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    </div>
                    <button type="submit" name="create_group" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create Group
                    </button>
                </form>
            </div>

            <!-- Group Listing and Joining -->
            <div>
                <h2 class="text-2xl font-bold mb-4">Join Existing Groups</h2>
                <?php if(isset($errorMessage)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php echo htmlspecialchars($errorMessage); ?>
                    </div>
                <?php endif; ?>

                <div class="space-y-4">
                    <?php foreach($groups as $group): ?>
                        <div class="bg-white shadow-md rounded p-6">
                            <h3 class="text-xl font-semibold mb-2">
                                <?php echo htmlspecialchars($group['GroupName']); ?>
                            </h3>
                            <p class="text-gray-600 mb-2">
                                <?php echo htmlspecialchars($group['Description']); ?>
                            </p>
                            <p class="text-gray-600 mb-4">
                                Location: <?php echo htmlspecialchars($group['Location']); ?>
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">
                                    <?php echo intval($group['MemberCount']); ?> Members
                                </span>
                                <form method="POST" class="inline">
                                    <input type="hidden" name="group_id" value="<?php echo $group['GroupID']; ?>">
                                    <button type="submit" name="join_group" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                                        Join Group
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
