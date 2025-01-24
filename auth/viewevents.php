<?php
// Database Connection
$host = 'localhost';
$dbname = 'neighborhoodhelper';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if user is logged in (this is just an example)
    $userID = 1; // This should be dynamic based on logged-in user, e.g. from session

    // Fetch events with user who posted the event
    $searchQuery = '';
    $events = [];

    if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
        $searchQuery = trim($_GET['search']);
        $stmt = $pdo->prepare("
            SELECT e.*, u.Name as PostedByName 
            FROM event e
            LEFT JOIN user u ON e.PostedBy = u.UserID
            WHERE e.Title LIKE :search OR e.Description LIKE :search OR e.Location LIKE :search
            ORDER BY e.EventDate ASC
        ");
        $stmt->execute([':search' => '%' . $searchQuery . '%']);
    } else {
        $stmt = $pdo->query("
            SELECT e.*, u.Name as PostedByName 
            FROM event e
            LEFT JOIN user u ON e.PostedBy = u.UserID
            ORDER BY e.EventDate ASC
        ");
    }

    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle 'Interested' button click
    if (isset($_POST['interested_event'])) {
        $eventID = $_POST['interested_event'];

        // Check if user has already shown interest (just for demonstration purposes)
        // In real applications, you would use a session to store user activity

        // For simplicity, we're assuming userID = 1 here.
        // You can add additional checks if you want to track user interest (this could be a simple session variable).

        // Insert into event's RSVP count
        $stmt = $pdo->prepare("UPDATE event SET RSVPCount = RSVPCount + 1 WHERE EventID = :eventID");
        $stmt->execute([':eventID' => $eventID]);
    }
} catch(PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upcoming Events - Neighborhood Helper</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-500 shadow-md">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="#" class="text-white text-xl font-bold">Neighborhood Helper</a>
            <form method="GET" action="" class="relative w-1/3">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search events..." 
                    class="w-full py-2 px-4 rounded-full text-gray-700 focus:outline-none shadow"
                    value="<?php echo htmlspecialchars($searchQuery); ?>"/>
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white text-blue-500 font-bold py-1 px-3 rounded-full">
                    Search
                </button>
            </form>
            <div class="text-white">
                <a href="#" class="hover:underline mx-2">Home</a>
                <a href="#" class="hover:underline mx-2">My Events</a>
                <a href="#" class="hover:underline mx-2">Profile</a>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-center">Upcoming Community Events</h1>
        
        <!-- Event Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($events)): ?>
                <div class="col-span-full text-center text-gray-600">
                    <?php if (!empty($searchQuery)): ?>
                        No results found for "<?php echo htmlspecialchars($searchQuery); ?>"
                    <?php else: ?>
                        No events found.
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold mb-2">
                                <?php echo htmlspecialchars($event['Title']); ?>
                            </h2>
                            <p class="text-gray-600 mb-2">
                                <strong>Date:</strong> 
                                <?php echo date('F d, Y h:i A', strtotime($event['EventDate'])); ?>
                            </p>
                            <p class="text-gray-600 mb-2">
                                <strong>Location:</strong> 
                                <?php echo htmlspecialchars($event['Location']); ?>
                            </p>
                            <p class="text-gray-600 mb-2">
                                <strong>Posted By:</strong> 
                                <?php echo htmlspecialchars($event['PostedByName']); ?>
                            </p>
                            <p class="text-gray-600 mb-4">
                                <?php echo htmlspecialchars(substr($event['Description'], 0, 100) . '...'); ?>
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">
                                    RSVP Count: <?php echo intval($event['RSVPCount']); ?>
                                </span>
                                <form method="POST" action="">
                                    <button type="submit" name="interested_event" value="<?php echo $event['EventID']; ?>"
                                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                        Interested
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
