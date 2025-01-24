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
        .navbar {
            background-color: #7297cf;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="navbar p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold">Neighborhood Helper</a>
            <div class="flex items-center space-x-4">
                <input type="text" placeholder="Search events or groups" class="p-2 rounded border border-gray-300">
                <button class="bg-white text-blue-500 font-semibold py-2 px-4 rounded">Search</button>
                <a href="#" class="text-white">Home</a>
                <a href="#" class="text-white">My Events</a>
                <a href="#" class="text-white">Profile</a>
            </div>
        </div>
    </nav>

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
