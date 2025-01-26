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
} catch(PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $eventDate = $_POST['event_date'] . ' ' . $_POST['event_time'];
    $location = trim($_POST['location']);
    
    // Assuming user is logged in (replace with actual authentication)
    $postedBy = 1; // Example user ID
    $groupID = isset($_POST['group_id']) ? intval($_POST['group_id']) : NULL;

    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO event (GroupID, PostedBy, Title, Description, EventDate, Location, RSVPCount) 
        VALUES (:groupId, :postedBy, :title, :description, :eventDate, :location, 0)");

    try {
        // Execute the statement
        $stmt->execute([
            ':groupId' => $groupID,
            ':postedBy' => $postedBy,
            ':title' => $title,
            ':description' => $description,
            ':eventDate' => $eventDate,
            ':location' => $location
        ]);

        // Redirect or show success message
        $successMessage = "Event created successfully!";
    } catch(PDOException $e) {
        $errorMessage = "Error creating event: " . $e->getMessage();
    }
}

// Fetch groups for dropdown (optional)
$groups = $pdo->query("SELECT GroupID, GroupName FROM `group`")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Event - Neighborhood Helper</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        .navbar {
            background-color: #7297cf;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            width: 100%;
            position: fixed; 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        .navbar .menu-icon {
            font-size: 24px;
            color: white;
            cursor: pointer;
        }

        .navbar .menu-icon:hover {
            color: #d9d9d9;
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
    </style>
</head>
<body class="bg-gray-100">

    <!-- New Navbar -->
    <div class="navbar">
        <div class="logo">Neighborhood Helper</div>
        <a href="home.php">Home</a>
        <a href="help_portal.php">View Help</a>
        <a href="group.php">Group</a>
        <a href="createevents.php">Event</a>
        <a href="viewevents.php">View Events</a>
        <a href="review.php">Review</a>
        <a href="logout.php">Logout</a>
        <div class="search-bar">
            <form method="GET" action="search.php">
                <input type="text" name="query" placeholder="Search events or groups">
                <button type="submit">Search</button>
            </form>
        </div>
    </div>

    <!-- Event Creation Form -->
    <div class="container mx-auto px-4 py-8">
        <form method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-2xl mb-4 font-bold text-gray-800">Create New Event</h2>

            <?php if(isset($successMessage)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($errorMessage)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Event Title
                </label>
                <input required type="text" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="Enter event title">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" rows="4" placeholder="Enter event description"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="event_date">
                    Event Date
                </label>
                <input required type="date" name="event_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="event_time">
                    Event Time
                </label>
                <input required type="time" name="event_time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="location">
                    Location
                </label>
                <input required type="text" name="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" placeholder="Enter event location">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="group_id">
                    Group (Optional)
                </label>
                <select name="group_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                    <option value="">Select a Group</option>
                    <?php foreach($groups as $group): ?>
                        <option value="<?php echo $group['GroupID']; ?>">
                            <?php echo htmlspecialchars($group['GroupName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create Event
                </button>
            </div>
        </form>
    </div>
</body>
</html>
